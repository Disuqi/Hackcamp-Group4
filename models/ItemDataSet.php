<?php

require_once ('Database.php');
require_once ('ItemData.php');

class ItemDataSet {
    protected ?Database $_dbInstance;
    protected PDO $_dbHandle;
    protected array $attributes;

    public function __construct() {
        $this->attributes = ['appid', 'release_date', 'english', 'developer', 'publisher', 'status', 'platforms', 'required_age', 'categories', 'genres', 'tags', 'achievements', 'positive_ratings', 'negative_ratings', 'average_playtime', 'median_playtime', 'physical', 'units_available', 'units_sold', 'price'];
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
        if(session_id() == ''){
            session_start();
        }
    }

    public function fetchAllItems(): array
    {
        $sqlQuery = 'SELECT * FROM gamesales LIMIT 200';
        return $this->getObjectsFromQuery($sqlQuery);
    }

    public function fetchItemsByValue($value): array
    {
        $sqlQuery = 'SELECT * FROM gamesales WHERE instr(appid, ?) > 0 OR instr(release_date, ?) > 0  OR instr(english, ?) > 0  OR instr(developer, ?) > 0 ';
        //necessary values are put into an array to later be bound to the query
        $array = [$value];
        return $this->getObjectsFromQuery($sqlQuery, $array);
    }

    function fetchItemsByAttributeAndValue($attribute, $value): array
    {
        //query that checks all the users and returns the users that have the attribute = to the value
        $sqlQuery = "SELECT * FROM gamesales WHERE ".$attribute."= ?";
        //adding the value to an array, so it can be bound to the query
        $array = [$value];
        //checks if any user was returned, if a user was returned then the attribute does exist.
        return $this->getObjectsFromQuery($sqlQuery, $array);
    }

    function getObjectsFromQuery($sqlQuery, $values = null): array
    {
        //preparing the PDO statement
        $statement = $this->executeQuery($sqlQuery, $values);
        //creating an empty array
        $dataset = [];
        //filling up the array with the result gotten from executing the query
        while($row = $statement->fetch()){
            $dataset[] = new ItemData($row);
        }
        //returning a list of users that match the query
        return $dataset;
    }

    function getDbRowsFromQuery($sqlQuery, $values = null): array{
        //preparing the PDO statement
        $statement = $this->executeQuery($sqlQuery, $values);
        //creating an empty array
        $dataset = [];
        //filling up the array with the result gotten from executing the query
        while($row = $statement->fetch()){
            $dataset[] = $row;
        }
        //returning a list of users that match the query
        return $dataset;
    }

    /**
     * @var $data string the data typed by the user. It should follow this format "column name: value, anotherColumn name: value".
     * If it is only looking for one column there is no need for the ","
     * and there is no limit to how many columns you can look into.
     * If column name does not exist it will simply return everything in the table.
     * @return array of ItemData Objects
     * This function takes the input splits it makes the necessary changes and checks, it then makes a sql statement and returns all the data that match the statement.
     */
    function search(string $data, bool $secondSearch = false): array
    {
        if($secondSearch){
            $sqlQuery = $_SESSION['lastSqlQuery'];
            $values = $_SESSION['lastValues'];
        }else{
            $sqlQuery = 'SELECT * FROM gamesales';
            $values = [];
        }
        if(strpos($data, ',')) {
            $separatedData = explode(',', $data);
            for ($i = 0; $i < sizeof($separatedData); $i++) {
                //dealing with extra ',' as some items might have them in their name/value
                $item = $separatedData[$i];
                $separatedData[$i] = trim($item);
                $noProblem = false;
                foreach ($this->attributes as $attribute) {
                    if (str_starts_with(strtolower($separatedData[$i]), $attribute)) {
                        $noProblem = true;
                        break;
                    }
                }
                if (!$noProblem && $i > 0) {
                    $separatedData[$i - 1] .= ',' . $item;
                    unset($separatedData[$i]);
                    $separatedData = array_values($separatedData);
                    $i--;
                }
            }
        }else{
            $separatedData = [$data];
        }
        for($i=0; $i< sizeof($separatedData); $i++){
            //separating attribute from value and dealing with extra : as some items might have them in their name/value
            $attributeAndValue = explode(':', $separatedData[$i]);
            if(sizeof($attributeAndValue) > 2){
                for($e = 2; $e < sizeof($attributeAndValue); $e++){
                    $attributeAndValue[$e-1] .= ':' . $attributeAndValue[$e];
                    unset($attributeAndValue[$e]);
                    $attributeAndValue = array_values($attributeAndValue);
                }
            }
            if(sizeof($attributeAndValue) == 2){
                if(strpos($attributeAndValue[0], ' ')){
                    $attributeAndValue[0] = str_replace(' ', '_', $attributeAndValue[0]);
                }
                foreach($this->attributes as $attribute){
                    $attributeAndValue[0] = trim($attributeAndValue[0]);
                    if(strtolower($attributeAndValue[0]) == $attribute){
                        if(str_ends_with($sqlQuery, 'gamesales')){
                            $sqlQuery .= ' WHERE';
                        }else{
                            $sqlQuery .= ' AND';
                        }
                        switch($attribute){
                            case 'physical':
                            case 'required_age':
                            case 'english':
                            case 'appid':
                                $sqlQuery .= ' ' . $attribute . ' = ? ';
                                break;
                            case 'achievements':
                            case 'positive_ratings':
                            case 'negative_ratings':
                            case 'average_playtime':
                            case 'median_playtime':
                            case 'units_available':
                            case 'units_sold':
                            case 'price':
                                $sqlQuery .= ' ' . $attribute . ' >= ? ';
                                break;
                            case 'release_date':
                                $sqlQuery .= ' ' . $attribute . ' = STR_TO_DATE(?, "%d/%m/%Y")';
                                break;
                            default:
                                $sqlQuery .= ' instr('.$attribute.', ?) > 0 ';
                                break;
                        }
                        array_push($values, trim($attributeAndValue[1]));
                        break;
                    }
                }
        } else if (sizeof($attributeAndValue) < 2){
            foreach($this->attributes as $attribute){
                if($attribute == 'appid'){
                    $sqlQuery .= ' WHERE';
                }else{
                    $sqlQuery .= ' OR';
                }
                $sqlQuery.= ' instr(' . $attribute . ', ?) > 0 ';
                array_push($values, trim($data));
            }
        }}
        $sqlQuery.= ' LIMIT 200';

        return $this->getDbRowsFromQuery($sqlQuery, $values);
    }

    function executeQuery(string $sqlQuery, array $values = null): bool|PDOStatement
    {
        //preparing the PDO statement
        $statement = $this->_dbHandle->prepare($sqlQuery);
        //executing query
        $statement->execute($values);

        //saving the query and values in session variables
        $_SESSION['lastSqlQuery'] = $sqlQuery;
        $_SESSION['lastValues'] = $values != null? $values : [] ;

        return $statement;
    }

}

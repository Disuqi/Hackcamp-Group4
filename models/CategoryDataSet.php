<?php

/**CategoryData Data set - used to retrieve a set of categories held within the database. Focused only on textual values.
 * Useful for listing categories on the left side panel (category browser) of the web-app.
 * @author Michal Brenda
 *

 @author Michal Brenda
 */

require_once ('Database.php');
require_once('CategoryData.php');

class CategoryDataSet
{
    protected ?Database $_dbInstance;
    protected PDO $_dbHandle;

    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    //Returns up to 10 most popular categories in attribute - works on single tag attributes, for example status:Restrcted
    //Code incomplete - variable $categoryName inside queries must be replaced with bindParam method to prevent SQL injection.
    public function fetchSingleCategories($categoryName) : array
    {
        $sqlQuery = "SELECT tablename.$categoryName AS '$categoryName'
                    FROM(SELECT temp.$categoryName, COUNT(*) AS count
                         FROM (
                                SELECT $categoryName
                                FROM gamesales)AS temp
                         GROUP BY temp.$categoryName
                         ORDER BY count DESC) AS tablename
                    LIMIT 100;";
        $statement = $this->_dbHandle->prepare($sqlQuery); //Prepares the PDO statement

        //var_dump($mainStatement);
        //var_dump($secondaryStatement);

        //$statement->bindParam(':category',$categoryName);
        $statement->execute();



        $dataSet = [];
        while($row = $statement->fetch()){
            $dataSet[] = new CategoryData($row);
        }


        return $dataSet;
    }

    //Returns up to 10 most popular values in attribute - works on multi-tag attributes, for example genres: Action;Free To Play;Strategy is split into 3 individual values
    //Incomplete code: requires removal of variable references and replacement with bindParam or bindValue method
    public function fetchMultiCategories($categoryName) : array
    {
       $sqlQuery = "SELECT tablename.categories AS $categoryName
                    FROM(
                        SELECT temp.categories, COUNT(*) as count
                        FROM (
                                SELECT SUBSTRING_INDEX(SUBSTRING_INDEX($categoryName, ';', 2), ';', -1) AS categories
                                FROM gamesales
                                UNION ALL SELECT SUBSTRING_INDEX(SUBSTRING_INDEX($categoryName, ';', 3), ';', -1) AS categories
                                FROM gamesales
                                UNION ALL SELECT SUBSTRING_INDEX(SUBSTRING_INDEX($categoryName, ';', 4), ';', -1) AS categories
                                FROM gamesales
                                UNION ALL SELECT SUBSTRING_INDEX(SUBSTRING_INDEX($categoryName, ';', 5), ';', -1) AS categories
                                FROM gamesales)AS temp
                        GROUP BY temp.categories
                        ORDER BY count DESC) AS tablename
                    WHERE categories != '????' AND tablename.categories <> '?????' AND tablename.categories <> '??????' AND tablename.categories <> '???' AND tablename.categories <> '????????????'
                    LIMIT  100;";
        $statement = $this->_dbHandle->prepare($sqlQuery); //Prepares the PDO statement
        /**$statement->bindParam(1, $categoryName);
        $statement->bindParam(2, $categoryName);
        $statement->bindParam(3, $categoryName);
        $statement->bindParam(4, $categoryName);**/
        $statement->execute();

        $dataSet = [];

        while($row = $statement->fetch()){
            $dataSet[] = new CategoryData($row);
        }
        return $dataSet;

    }
    public function fetchItemsByRange($categoryName, $rangeLow, $rangeHigh) : array
    {
        $sqlQuery = "SELECT appid AS $categoryName
                     FROM gamesales
                     WHERE $categoryName > $rangeLow AND $categoryName < $rangeHigh
                     ORDER BY $categoryName DESC;";
        $statement = $this->_dbHandle->prepare($sqlQuery); //Prepares the PDO statement

        //This code below does not work and I don't know why, I give up.
        /**$statement->bindValue(':categoryName', $categoryName, PDO::PARAM_STR);
        $statement->bindValue(':rangeLow', $rangeLow, PDO::PARAM_STR);
        $statement->bindValue('rangeHigh', $rangeHigh, PDO::PARAM_STR);
        $statement->bindValue(':categoryName', $categoryName, PDO::PARAM_STR);**/


        $statement->execute();

        $dataSet = [];

        while($row = $statement->fetch()){
            $dataSet[] = new CategoryData($row);
        }

        return $dataSet;

    }
    //Check the state of given value in favourites table - returns true if item set as favourite
    public function checkFavourite($value, $categoryName) : bool
    {
        $valueFixed = str_replace("'", "\'", $value);
        $sqlQuery = "SELECT favourite
                     FROM favourites
                     WHERE catValues='$valueFixed' AND category_name='$categoryName';";
        $statement = $this->_dbHandle->prepare($sqlQuery); //Prepares the PDO statement
        $statement->execute();

        $check = $statement->fetch();
        if($check == 0){
            return 0;
        }
        else return 1;
    }
    /*
     * Method that changes the Favourite attribute of given item in favourites table.
     * @param $category - attribute name, $value - attribute value, $state - favourite state - 0 for false, 1 for true
     */
    public function updateFavourite($value, $categoryName, $state)
    {
        $valueFixed = str_replace("'", "\'", $value);
        $sqlQuery = "";
        $check = $this->checkFavourite($value, $categoryName);
        if($state == 0 || $check == 0){
            $sqlQuery = "UPDATE favourites
                     SET favourite = 1
                     WHERE catValues='$valueFixed' AND category_name='$categoryName';";
        }
        else{
            $sqlQuery = "UPDATE favourites
                     SET favourite = 0
                     WHERE catValues='$valueFixed' AND category_name='$categoryName';";
        }
        $statement = $this->_dbHandle->prepare($sqlQuery); //Prepares the PDO statement
        $statement->execute();
    }

    //Method that retrieves all favourite user shortcuts.
    public function fetchAllFavourites() : array
    {
        $sqlQuery = "SELECT catValues, category_name, favourite FROM favourites WHERE favourite = 1";
        $statement = $this->_dbHandle->prepare($sqlQuery); //Prepares the PDO statement
        $statement->execute();

        $dataSet = [];
        while($row = $statement->fetch()){
            $dataSet[] = new CategoryData($row);
        }
        return $dataSet;


    }


}

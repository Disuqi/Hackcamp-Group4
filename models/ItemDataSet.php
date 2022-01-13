<?php

require_once ('Models/Database.php');
require_once ('Models/ItemData.php');

class ItemDataSet {
    protected $_dbHandle, $_dbInstance;

    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    public function fetchAllItems() {
        $sqlQuery = 'SELECT * FROM gamesales';
        return $this->getObjectsFromQuery($sqlQuery);
    }

    public function fetchItemsByValue($value) {
        $sqlQuery = 'SELECT * FROM gamesales WHERE instr(appid, ?) > 0 OR instr(release_date, ?) > 0  OR instr(english, ?) > 0  OR instr(developer, ?) > 0 ';
        //necessary values are put into an array to later be bound to the query
        $array = [$value];
        return $this->getObjectsFromQuery($sqlQuery, $array);
    }

    function fetchItemsByAttributeAndValue($attribute, $value)
    {
        //query that checks all the users and returns the users that have the attribute = to the value
        $sqlQuery = "SELECT * FROM gamesales WHERE ".$attribute."= ?";
        //adding the value to an array, so it can be bound to the query
        $array = [$value];
        //checks if any user was returned, if a user was returned then the attribute does exist.
        return $this->getObjectsFromQuery($sqlQuery, $array);
    }

    function getObjectsFromQuery($sqlQuery, $values = null)
    {
        //preparing the PDO statement
        $statement = $this->executeQuery($sqlQuery, $values);
        //creating an empty array
        $dataset = [];
        //filling up the array with the result gotten from executing the query
        while($row = $statement->fetch()){
            $dataset[] = new ItemDataSet($row);
        }
        //returning a list of users that match the query
        return $dataset;
    }

    function executeQuery($sqlQuery, $values = null){
        //preparing the PDO statement
        $statement = $this->_dbHandle->prepare($sqlQuery);
        //executing query
        $statement->execute($values);
        return $statement;
    }
}

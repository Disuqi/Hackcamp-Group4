<?php

class UserData {

    protected $_userID, $_userType, $_privilege;

    public function __construct($dbRow) {
        $this->_userID = $dbRow['user_id']; // ['user_id'] will be named according to the database columns
        $this->_userType = $dbRow['user_type'];
        $this->_privilege = $dbRow['user_privileges'];
    }

    /**
     * @return userID
     */
    public function getUserID() {
        return $this->_userID;
    }

    /**
     * @return userType
     */
    public function getUserType() {
        return $this->_userType;
    }

    /**
     * @return previleges
     */
    public function getPrivilege() {
        return $this->_privilege;
    }
}
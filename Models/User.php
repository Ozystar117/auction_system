<?php


class User
{
    // declare required fields
    private $userID, $firstName, $lastName, $username, $password;

    /**
     * User constructor.
     * @param $userID
     * @param $firstName
     * @param $lastName
     * @param $username
     * @param $password
     */
    public function __construct($dbRow)
    {
        $this->userID = $dbRow['id'];
        $this->firstName = $dbRow['first_name'];
        $this->lastName = $dbRow['last_name'];
        $this->username = $dbRow['username'];
        $this->password = $dbRow['password'];
    }

    /**
     * @return mixed
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }


}
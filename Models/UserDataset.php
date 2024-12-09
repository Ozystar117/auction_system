<?php
require_once ("Models/Database.php");
require_once ("User.php");

class UserDataset
{
    protected $_dbHandle, $_dbInstance;

    /**
     * AuctionDataset constructor.
     * constructor for creating a new instance of this class
     * by connecting to the database
     */

    // constructor
    public function __construct(){
        $this->_dbInstance = Database::getInstance(); //create a new instance of Database
        $this->_dbHandle = $this->_dbInstance->getdbConnection(); //get the database connection
    }

//    public function fetchAllUsers(){
//        $sqlQuery = 'SELECT * FROM users';
//        //echo $sqlQuery . "<br>";
//        $statement = $this->_dbHandle->prepare($sqlQuery);
//        $statement->execute();
//
//        $dataset = [];
//        while($row = $statement->fetch()){
//            $user = new User($row);
//            $dataset[] = $user;
//        }
//        return $dataset;
//    }

    public function fetchUserDetails($username){
        $sqlQuery = "SELECT * FROM users WHERE username = ?";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(1, $username);
        $statement->execute();

        $row = $statement->fetch();
        $user = new User($row);
        return $user;
    }

    public function getUser($userID){
        $sqlQuery = "SELECT * FROM users WHERE id = ?";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(1, $userID);
        $statement->execute();

        $row = $statement->fetch();
        $user = new User($row);
        return $user;
    }

    /**
     * @param $email
     * @param $password
     * @return bool
     * verify the details passed in by the user
     */
    public function verifyUserLogin($email, $password){
        $sqlQuery = "SELECT * FROM users WHERE username = ?";
        $statement = $this->_dbHandle->prepare($sqlQuery);

        //prevent sql injection
        $statement->bindParam(1, $email);
        $statement->execute();

        $row = $statement->fetch();
        $user = new User($row);
        if(password_verify($password, $user->getPassword())){
            return true;
        }else{
            return false;
        }

    }

    public function signup($firstName, $lastName, $username, $password){
        $sqlQuery = "SELECT * FROM users WHERE username = ?";
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(1, $username);
        $statement->execute();
        $row = $statement->fetch();
        if(empty($row)){
            $sqlQuery = "INSERT INTO users(first_name, last_name, username, password) VALUES(?, ?, ?, ?)";
            //echo $sqlQuery;
            $statement = $this->_dbHandle->prepare($sqlQuery);
            $parameters = array($firstName,$lastName,$username,$password);
            $statement->execute($parameters);
            return true;
        }else{
            return false;
        }



    }
}
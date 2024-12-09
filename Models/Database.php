<?php


class Database
{
    protected static $_dbInstance = null;
    protected $_dbHandle;

    public static function getInstance()
    {
        $username = 'aee726';
        $password = 'Ozystar@117';
        $host = 'poseidon.salford.ac.uk';
        $dbName = 'aee726_auctionsystem';
        if(self::$_dbInstance === null){
            self::$_dbInstance = new self($username, $password, $host, $dbName);
        }
        return self::$_dbInstance;
    }

    private function __construct($username, $password, $host, $database){
        try{
            $this->_dbHandle = new PDO("mysql:host=$host; dbname=$database", $username, $password);
        }catch(PDOException $e){ //catch any failure to connect with the database
            echo $e->getMessage();
        }
    }

    // return the PDO connection
    public function getdbConnection(){
        return $this->_dbHandle;
    }

    // destroy the PDO connection when no longer needed
    public function __destruct(){
        $this->_dbHandle = null;
    }
}
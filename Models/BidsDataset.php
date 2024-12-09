<?php
require_once("Models/BidItem.php");
require_once ("Models/Database.php");
require_once ("Models/Lot.php");

class BidsDataset
{
    /**
     * BidsDataset constructor.
     * the constructor gets the single database instance and connect to it
     */
    public function __construct(){
        $this->dbInstance = Database::getInstance();
        $this->dbHandle = $this->dbInstance->getdbConnection();
    }

    /**
     * @param $userID
     * @return array
     */
    public function getAllBadeItems($userID){
        //join the bids and lots table
        $sqlQuery = "SELECT * FROM bids, lot WHERE bids.userID = ? AND bids.itemLotID = lot.itemLotID";
        //echo $sqlQuery;
        $statement = $this->dbHandle->prepare($sqlQuery);
        //prevent SQL injection
        $statement->bindParam(1, $userID);
        // execute the query
        $statement->execute();


        $dataset = [];
        while($row = $statement->fetch()){
            //var_dump($row);
            $bidItem = new BidItem($row);
            $dataset[] = $bidItem;
        }
        return $dataset; //return the dataset of all bids
    }

    /**
     * @param $userID
     * @param $itemLotID
     * @param $amount
     * @return bool
     * Check if the bid is in the users bid list. If it isn't, bid for the item and return true
     *if not don't bid and return false
     */
    public function bid($userID, $itemLotID, $amount){
        //select the user id associated with a bid
        $sqlQuery = "SELECT userID FROM bids WHERE userID = ? AND itemLotID = ?";
        $statement = $this->dbHandle->prepare($sqlQuery);
        //prevent SQL injection
        $parameters = array($userID, $itemLotID);
        $statement->execute($parameters);
        $row = $statement->fetch();
        if(empty($row['userID'])){ //if the user haven't already bid for the item, return true else return false
            $sqlQuery = "INSERT INTO bids(itemLotID, userID, amount) VALUES(?, ?, ?)";
            $statement = $this->dbHandle->prepare($sqlQuery);
            $bParameters = array($itemLotID, $userID, $amount);
            $statement->execute($bParameters);
            return true;
        }else{
            return false;
        }
    }

    // Edit a bid in the user's bid list
    public function editBid($itemLotID, $amount){
        $user = $_SESSION["userID"];
        $sqlQuery = "UPDATE bids SET bids.amount = ? WHERE bids.itemLotID = ? AND bids.userID = ?";
        $statement = $this->dbHandle->prepare($sqlQuery);
        $parameters = array($amount, $itemLotID, $user);
        $statement->execute($parameters);
    }

    // return a bid item based on the item lot id
    public function getBid($itemLotID){
        // select and join bids and  lot table table
        $sqlQuery = "SELECT * FROM bids,lot WHERE bids.itemLotID = ? AND bids.ItemLotID = lot.itemLotID";
        $statement = $this->dbHandle->prepare($sqlQuery);
        $statement->bindParam(1, $itemLotID);
        $statement->execute();

        $row = $statement->fetch();
        $bid = new BidItem($row);
        return $bid;
    }

    public function getHighestBidder($itemLotID){
        $sqlQuery = "SELECT userID FROM bids WHERE bids.amount = (SELECT max(bids.amount) FROM bids WHERE bids.itemLotID = ?);";
        $statement = $this->dbHandle->prepare($sqlQuery);
        $statement->bindParam(1, $itemLotID);
        $statement->execute();

        $row = $statement->fetch();
        $userID = $row['userID'];
        return $userID;
    }

    public function getHighestBid($itemLotID){
        $sqlQuery = "SELECT bids.amount FROM bids WHERE bids.amount = (SELECT max(bids.amount) FROM bids WHERE bids.itemLotID = ?);";
        $statement = $this->dbHandle->prepare($sqlQuery);
        $statement->bindParam(1, $itemLotID);
        $statement->execute();

        $row = $statement->fetch();
        $amount = $row['amount'];
        return $amount;
    }
}
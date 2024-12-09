<?php
require_once ("Models/Auction.php");
require_once ("Models/Database.php");
/**
 * Class AuctionDataset
 * this is used to query the auctions database
 */
class AuctionDataset
{
    //constructor to get the single instance of the database and connect to it
    public function __construct(){
        $this->dbInstance = Database::getInstance();
        $this->dbHandle = $this->dbInstance->getdbConnection();
    }

    /**
     * @return array
     * Returns an array of all auctions
     */
    public function getAllAuctions(){
        $sqlQuery = "SELECT * FROM auctions";
        $statement = $this->dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataset = [];
        while($row = $statement->fetch()){
            $auction = new Auction($row);
            $dataset[] = $auction;
        }
        return $dataset;
    }

    // return an auction based on its id
    public function getAuction($auctionID){
        $sqlQuery = "SELECT * FROM auctions WHERE auctionID = ?";
        $statement = $this->dbHandle->prepare($sqlQuery);
        $statement->bindParam(1, $auctionID);
        $statement->execute();
        while($row = $statement->fetch()){
            $auction = new Auction($row);
        }
        return $auction;
    }
}
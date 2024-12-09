<?php
require_once("Models/Database.php");
require_once ("Models/Lot.php");
require_once ("Models/Image.php");
require_once ("Models/ImageDataset.php");
class LotDataset
{
    public function __construct(){
        $this->dbInstance = Database::getInstance();
        $this->dbHandle = $this->dbInstance->getdbConnection();
    }

    /**
     * @return array
     * Returns an array of all auctions
     */
    public function getAllLots(){
        $sqlQuery = "SELECT * FROM lot";
        $statement = $this->dbHandle->prepare($sqlQuery);
        $statement->execute();

        $dataset = [];
        while($row = $statement->fetch()){
            $lot = new Lot($row);
            $dataset[] = $lot;
        }
        return $dataset;
    }

    public function getLot($itemID){

        $sqlQuery = "SELECT * FROM lot WHERE itemLotID = ?";
        //echo "query: " . $sqlQuery;
        $statement = $this->dbHandle->prepare($sqlQuery);
        $statement->bindParam(1, $itemID);
        $statement->execute();

        while($row = $statement->fetch()){
            $lot = new Lot($row);
            //echo "name: " . $lot->getItemTitle();
            //allocate the lot item's image
            $imageDataset = new ImageDataset();
            $images = $imageDataset->fetchImages($itemID);
            $lot->setImages($images);
        }
        return $lot;
    }

    public function insertLot($itemTitle, $itemDescription, $auctionID){
        $sqlQuery = "INSERT INTO lot(itemTitle, itemDescription, auctionID) VALUES(?, ?, ?)";
        $statement = $this->dbHandle->prepare($sqlQuery);
        $parameters = array($itemTitle, $itemDescription, $auctionID);
        $statement->execute($parameters);
    }

}
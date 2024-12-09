<?php

require_once("Models/Database.php");
class ImageDataset
{
    public function __construct(){
        $this->dbInstance = Database::getInstance();
        $this->dbHandle = $this->dbInstance->getdbConnection();
    }

    public function fetchImages($itemLotID){

        $sqlQuery = "SELECT * FROM lot, images WHERE images.itemLotID = ? AND images.itemLotID = lot.itemLotID";

        //echo "query: " . $sqlQuery;
        $statement = $this->dbHandle->prepare($sqlQuery);
        $statement->bindParam(1, $itemLotID);
        $statement->execute();

        $dataset = [];
        while($row = $statement->fetch()){
            $image = new Image($row);
            //echo "name: " . $lot->getItemTitle();
            $dataset[] = $image->getPath();
        }
        return $dataset;
    }

    //insert an image to the database
    public function insertImage($imagePath, $lotID){
        $sqlQuery = "INSERT INTO images(imagePath, itemLotID) VALUES(?, ?)";
        $statement = $this->dbHandle->prepare($sqlQuery);
        $parameters = array($imagePath, $lotID);
        $statement->execute($parameters);
    }
}
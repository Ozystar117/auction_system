<?php


require_once("Models/Database.php");
require_once ("Models/Lot.php");
require_once ("Models/ImageDataset.php");
require_once ("Models/Image.php");
class SearchDataset
{
    //store the number of results gotten from the search
    private $noOfSearchResults;
    public function __construct(){
        $this->dbInstance = Database::getInstance();
        $this->dbHandle = $this->dbInstance->getdbConnection();
        $this->noOfSearchResults = 0;
    }

    /**
     * @param $keyWord: the key word to be searched for
     * @param $start: the 1st parameter of LIMIT
     * @param $limit: the last parameter of LIMIT
     * @return array
     */
    public function searchFor($keyWord, $start, $limit){
        //if the keyword is the name of an auction search for all lots in that auction else search for lots starts starts with the key word
        if(substr($keyWord, 0, 7) === "Auction"){
            $sqlQuery = "SELECT * FROM auctions, lot WHERE auctionName = ? AND lot.auctionID = auctions.auctionID LIMIT $start, $limit";
            $countResult = "SELECT COUNT(*) AS result FROM auctions, lot WHERE auctionName = ? AND lot.auctionID = auctions.auctionID";
            $statement = $this->dbHandle->prepare($sqlQuery);
            $parameters = array($keyWord);
            //used to bind the parameters of the 2nd query
            $cParameters = array($keyWord);

        }else{
            $sqlQuery = "SELECT * FROM lot WHERE lot.itemTitle LIKE ? OR lot.itemDescription LIKE ? LIMIT $start, $limit";
            $countResult = "SELECT COUNT(*) AS result FROM lot WHERE lot.itemTitle LIKE ? OR lot.itemDescription LIKE ?";
            $statement = $this->dbHandle->prepare($sqlQuery);
            $keyWord = $keyWord . "%";
            // bind the parameters for the first query
            $parameters = array($keyWord, $keyWord);
            $cParameters = array($keyWord, $keyWord);
        }

        //execute the query
        $statement->execute($parameters);

        $dataset = [];
        while($row = $statement->fetch()){
            $lot = new Lot($row);
            $imageDataset = new ImageDataset();
            $lot->setImages($imageDataset->fetchImages($lot->getItemLotID()));
            //echo "name: " . $lot->getItemTitle();
            $dataset[] = $lot;
        }
        $statement = $this->dbHandle->prepare($countResult);
        $statement->execute($cParameters);
        $row = $statement->fetch();
        $this->noOfSearchResults = $row['result'];
        return $dataset;
    }

    /**
     * @return int: return the number of results gotten from the search operation
     */
    public function getNumberOfResults(){
        return $this->noOfSearchResults;
    }
}
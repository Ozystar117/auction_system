<?php


class BidItem
{
    private $bidsID, $itemLotID, $userID,$amount, $itemDescription, $itemTitle, $auctionID;

    public function __construct($dbRow){
        $this->bidsID = $dbRow['bidsID'];
        $this->itemLotID = $dbRow['itemLotID'];
        $this->userID = $dbRow['userID'];
        $this->amount = $dbRow['amount'];
        $this->itemDescription = $dbRow['itemDescription'];
        $this->itemTitle = $dbRow['itemTitle'];
        $this->auctionID = $dbRow['auctionID'];
    }

    public function getBidsID()
    {
        return $this->bidsID;
    }

    public function getItemLotID(){
        return $this->itemLotID;
    }

    public function getUserID(){
        return $this->userID;
    }

    public function  getAmount(){
        return $this->amount;
    }

    /**
     * @return mixed
     */
    public function getItemDescription()
    {
        return $this->itemDescription;
    }

    /**
     * @return mixed
     */
    public function getItemTitle()
    {
        return $this->itemTitle;
    }

    /**
     * @return mixed
     */
    public function getAuctionID()
    {
        return $this->auctionID;
    }


}
<?php


class Lot
{
    private $itemLotID, $itemTitle, $itemDescription, $auctionID, $images;

    public function __construct($dbRow){
        $this->itemLotID = $dbRow['itemLotID'];
        $this->itemTitle = $dbRow['itemTitle'];
        $this->itemDescription = $dbRow['itemDescription'];
        $this->auctionID = $dbRow['auctionID'];
        $images = [];
    }

    /**
     * @return mixed
     */
    public function getItemLotID()
    {
        return $this->itemLotID;
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
    public function getItemDescription()
    {
        return $this->itemDescription;
    }

    /**
     * @return mixed
     */
    public function getAuctionID()
    {
        return $this->auctionID;
    }

    public function addImageDir($imageDir){
        $this->images[] = $imageDir;
    }

    public function setImages($images){
        $this->images = $images;
    }

    public function getImage($index){
        return $this->images[$index];
    }

    public function getImageArr(){
        return $this->images;
    }

}
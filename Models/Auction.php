<?php

/**
 * Class Auction
 * This is a class used to create an instance of an auction
 */
class Auction
{
    // fields required for an auction
    private $auctionID, $auctionName, $auctionStartDate, $address, $adminUserID;

    /**
     * Auction constructor.
     *
     */
    public function __construct($dbRow){
        $this->auctionID = $dbRow['auctionID'];
        $this->auctionName = $dbRow['auctionName'];
        $this->auctionStartDate = $dbRow['auctionStartDate'];
        $this->address = $dbRow['address'];
        $this->adminUserID = $dbRow['adminUserID'];
    }

    /**
     * @return mixed
     * An accessor method that returns the id of the auction
     */
    public function getAuctionID(){
        return $this->auctionID;
    }

    /**
     * @return mixed
     * return the name of the auction
     */
    public function getAuctionName(){
        return $this->auctionName;
    }

    /**
     * @return mixed
     * An accessor method that returns the start date of an auction
     */
    public function getAuctionStartDate(){
        return $this->auctionStartDate;
    }

    /**
     * @return mixed
     * return the address of the auction
     */
    public function getAddress(){
        return $this->address;
    }

    /**
     * @return mixed
     */
    public function getAdminUserID()
    {
        return $this->adminUserID;
    }


}
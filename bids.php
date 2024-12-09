<?php
require_once ("Models/BidsDataset.php");
require_once ("Models/LotDataset.php");
$view = new stdClass();
$view->pageTitle = "Your Bids";

session_start();
//require_once ("session.php");

//set the user ID to logged in user
$userID = $_SESSION['userID'];
// if the user is logged in
if(isset($userID)){
    $bidsDataset = new BidsDataset();
    $view->bidsDataset = $bidsDataset->getAllBadeItems($userID);
    if(!empty($view->bidsDataset)){
        $view->noOfBids = count($view->bidsDataset) . " bid(s) made";
    }else{
        $view->noOfBids = "You are yet to make a bid";
    }

}

//if the user attempts to bid for an item
if(isset($_POST['bidSubmitBtn'])){
    if(isset($userID)){
        $amount = $_POST['bidAmount'];
        $itemLotID = $_GET['lotID'];
        $validateBid = $bidsDataset->bid($userID, $itemLotID, $amount);
        if(!$validateBid){
            $view->duplicateMessage = "You've bade for the item already. Please edit it here";
        }else{
            header("Location: lot.php?lotID=" . $_GET['lotID']);
        }
    }
}

if(isset($_POST['editBidBtn'])){
    $itemLotID = $_GET['lotID'];
    $amount = $_POST['editBid'];
    //if the amount inserted is less than the initial amount
    //if($amount > $bidsDataset->getBid($itemLotID)->getAmount()){
    $highestBid = $bidsDataset->getHighestBid($itemLotID);
    if($amount > $highestBid){
        $bidsDataset->editBid($itemLotID, $amount);
    }else{
        $view->duplicateMessage = "Must be greater than $" . $highestBid;
    }


}
require_once ("Views/bids.phtml");
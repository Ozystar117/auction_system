<?php
require_once ("Models/LotDataset.php");
require_once ("Models/BidsDataset.php");
$view = new stdClass();
$view->pageTitle = "Lot -" . $_GET["lotID"];

//require_once ("session.php");
session_start();

//user clicked to view the item
$lotID = $_GET['lotID'];
if(isset($lotID)){
    $lotDataset = new LotDataset();
    $view->lot = $lotDataset->getLot($lotID);

    $bidDataset = new BidsDataset();
    $view->highestBid = $bidDataset->getHighestBid($lotID);
}
require_once ("Views/lot.phtml");
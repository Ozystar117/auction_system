<?php
require_once ("Models/AuctionDataset.php");
$view = new stdClass();
$view->pageTitle = "Auctions";
$view->page="active"; // used in the header to set it as the current page

//require_once ("session.php");
session_start();

//create a new instance of the auction dataset
$auctionDataset = new AuctionDataset();
$view->auctionDataset = $auctionDataset->getAllAuctions(); //to be used in the view to loop through all auctions
require_once ("Views/auctions.phtml");

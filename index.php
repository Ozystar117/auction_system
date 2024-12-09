<?php
require_once ("Models/AuctionDataset.php");
$view = new stdClass();
$view->pageTitle = "Home";
$view->page="active"; // used in the header to set it as the current page
session_start();
//require_once ("session.php");
require_once ("Views/index.phtml");

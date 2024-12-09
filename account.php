<?php
require_once ("Models/UserDataset.php");
require_once ("Models/BidsDataset.php");
$view = new stdClass();
$view->pageTitle="Account";

session_start();
$userDataset = new UserDataset();
$view->user = $userDataset->getUser($_SESSION['userID']);

$bidsDataset = new BidsDataset();
$badeItems = $bidsDataset->getAllBadeItems($_SESSION['userID']);
$view->noOfBids = count($badeItems);
require_once ("Views/account.phtml");
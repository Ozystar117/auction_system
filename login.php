<?php
require_once("Models/UserDataset.php");
require_once("Models/AuctionDataset.php");
$view = new stdClass();
$view->pageTitle = "Login";

session_start();

/**
 * for each auction in auction dataset if the session[userID] == auction session[adminUser] == true
 */
// login button was pressed
if(isset($_POST["loginSubmitBtn"])){
    $userDataset = new userDataset();
    $auctionDataset = new AuctionDataset();
    $auctions = $auctionDataset->getAllAuctions();
    $correct = $userDataset->verifyUserLogin($_POST['username'], $_POST['password']);
    // if the details supplied by the user is correct
    if($correct){
        //get an instance of the user
        $user = $userDataset->fetchUserDetails($_POST['username']);
        //create a session for the user
        $_SESSION["userID"] = $user->getUserID();
        $_SESSION["firstName"] = $user->getFirstName();

        // check if the admin user logged in
        foreach ($auctions as $auction){
            if($_SESSION['userID'] == $auction->getAdminUserID()){
                $_SESSION['adminUser'] = true;
                $_SESSION['auctionID'] = $auction->getAuctionID();
            }
        }

        // redirect the user to the home page
        header("Location: index.php");
    }else{
        $view->loggedin = "Wrong email or password";
    }
}

// logout button was pressed
if(isset($_POST["logoutButton"])){
    //end the session
    unset($_SESSION["userID"]);
    unset($_SESSION["firstName"]);
    if(isset($_SESSION['adminUser'])){
        unset($_SESSION['adminUser']);
        unset($_SESSION['auctionID']);
    }
    session_destroy();
    // logout and take the user to the home page
//    header("Location:" . $_GET['redirect']);
}

require_once ("Views/login.phtml");
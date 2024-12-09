<?php require_once ("Models/SearchDataset.php");
$view = new stdClass();
$view->pageTitle = "Search Results";

session_start();

//create a new instance of the search dataset
$searchDataset = new SearchDataset();
//set the number of items to be viewed per page
$limit = 9;
//set the first item to be displayed in the page
$start = ($_GET['page'] - 1) * $limit;
//set the page the user is currently on
$page = $_GET['page'];

// if the user click the search button
if(isset($_POST['searchSubmitBtn'])){
    //key word should be what the user searched for
    $keyWord = $_POST['keyWord'];
    $view->keyWord = $keyWord;
    $view->lotDataset = $searchDataset->searchFor($keyWord, $start, $limit);
}else if(isset($_GET['auction'])){ //if the user chose to view all lots for an auction
    $keyWord = $_GET['auction'];
    $view->keyWord = $keyWord; //used in the view to mark
    $view->lotDataset = $searchDataset->searchFor($keyWord, $start, $limit);
}else{ //if the user clicked on any of the pagination link
    $keyWord = $_GET['keyWord'];
    $view->keyWord = $keyWord;
    $view->lotDataset = $searchDataset->searchFor($keyWord, $start, $limit);
}

// if any result matched the search
if(!empty($view->lotDataset)){
    //$noOfResults = count($view->lotDataset);
    $noOfResults = $searchDataset->getNumberOfResults();

    $view->noOfResults = $noOfResults . " lot(s) matches " . "'$keyWord'";

}else{
    $view->noOfResults = "No result matches " . "'$keyWord'";
}

//set the number of pages to be displayed to the user
$view->noOfPages = ceil($noOfResults / $limit);
//enable the next button to take the user to the next page
$view->nextPage = $page + 1;
//enable the prev button to take the user to the previous page
$view->prevPage = $page - 1;
require_once ("Views/search.phtml");
?>

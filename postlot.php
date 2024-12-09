<?php
require_once ("Models/LotDataset.php");
require_once ("Models/ImageDataset.php");
require_once ("Models/AuctionDataset.php");
$view = new stdClass();
$view->pageTitle = "Post Lot";

session_start();

// create a new instance of an auction dataset
$auctionDataset = new AuctionDataset();
// create a new instance of a lot dataset
$lotDataset = new LotDataset();

// if the upload picture button was clicked
if(isset($_POST['uploadPicSubmitBtn'])){
    //create a new instance of the image dataset
    $imageDataset = new ImageDataset();
    //get the lot id of the item to be updated from the user input in the form
    $itemLotID = $_POST['picLotID'];

    // get the image's data
    $file = $_FILES['picFile'];
    $fileName = $_FILES['picFile']['name'];
    $fileTmpName = $_FILES['picFile']['tmp_name'];
    $fileSize = $_FILES['picFile']['size'];
    $fileError = $_FILES['picFile']['error'];
    $fileType = $_FILES['picFile']['type'];

    //make sure the extension is in lower case
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    // which file will be allowed
    $allowed = array('jpg', 'jpeg');
    //if the file ext is allowed
    if(in_array($fileActualExt, $allowed)){
        //check if there's an error
        if($fileError === 0){
            // check if the file size is within the limit
            if($fileSize < 1000000){
                $lot = $lotDataset->getLot($itemLotID);
                // check if the user tried to update an item in the auction he is allowed to
                if($lot->getAuctionID() == $_SESSION['auctionID'])
                {
                    //get a unique id for the file
                    $fileNameNew = uniqid('', true).".".$fileActualExt;
                    $fileDestination = 'images/' . $fileNameNew;

                    //move the file from temporary location to new location
                    move_uploaded_file($fileTmpName, $fileDestination);


                    //resize the image
                    $originalImage = imagecreatefromjpeg($fileDestination);
                    $originalWidth = imagesx($originalImage);
                    $originalHeight = imagesy($originalImage);

                    $newImage = imagecreatetruecolor(320, 240);
                    imagecopyresampled($newImage, $originalImage, 0, 0, 0, 0, 320, 240, $originalWidth, $originalHeight);
                    imagejpeg($newImage, $fileDestination, 100);

                    //store the file name in the database
                    $imageDataset->insertImage($fileDestination, $itemLotID);
                    $view->successful = $fileName . " uploaded successfully";
                }else{
                    $auction = $auctionDataset->getAuction($_SESSION['auctionID']);
                    $view->notAllowed = "You can only update lot(s) in " . $auction->getAuctionName();
                }

            }else{
                $view->notAllowed = "Your file is too big";
            }
        }else{
            $view->notAllowed = "There was an error uploading your file";
        }
    }else {
        $view->notAllowed = "You can't upload files of this type";
    }

}

//if the user tried to upload an item
if(isset($_POST['uploadItemSubmitBtn'])){
    $auctionID = $_SESSION['auctionID'];
    $itemTitle = $_POST['itemTitle'];
    $itemDescription = $_POST['itemDescription'];
//    var_dump($itemDescription);
    $lotDataset->insertLot($itemTitle, $itemDescription, $auctionID);
    $view->successfulItem = "Uploaded successfully!";
}

//if(isset($fileName)){
//    echo $fileDestination;
//}
//echo $_SESSION['auctionID'];
require_once ("Views/postlot.phtml");
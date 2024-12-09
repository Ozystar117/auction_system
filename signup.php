<?php
require_once ("Models/UserDataset.php");
$view = new stdClass();
$view->pageTitle = "Sign Up";


session_start();

$usersDataset = new UserDataset();
if(isset($_POST['signupSubmitBtn'])){
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['emailAddress'];
    $confirmEmail = $_POST['confirmEmailAddress'];
    $password = $_POST['pwd'];
    $confirmPassword = $_POST['confirmPwd'];

    //confirm email and password are correct
    if($email == $confirmEmail){
        if($password == $confirmPassword){
            //encrypt the password
            $password = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
            // add the user's details to the users table
            $successfulSignup = $usersDataset->signup($firstName, $lastName, $email, $password);
            if($successfulSignup){
                $user = $usersDataset->fetchUserDetails($_POST['emailAddress']);

                //login the user after successfully signing up
                $_SESSION["userID"] = $user->getUserID();
                $_SESSION["firstName"] = $user->getFirstName();
                $_SESSION["loggedin"] = true;
                header("Location: index.php");
            }else{
                $view->emailMismatch = "This username is taken";
            }

        }else{
            $view->pwdMismatch = "Password doesn't match";
        }
    }else{
        $view->emailMismatch = "Email doesn't match";
    }
}
//register the user and log him/her in
require_once ("Views/signup.phtml");

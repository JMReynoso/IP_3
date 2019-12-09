<?php

require_once "home/common/mail.php";
require_once "home/common/dbInterface.php";
processPageRequest();

function authenticateUser($username, $password){
    $file = file_get_contents("data/credentials.db");
    $str_arr = preg_split("/\,/", $file);
    $usernameF = $str_arr[0];
    $passwordF = $str_arr[1];

    if($username == $usernameF){
        if($password == $passwordF){
            session_start();
            $_SESSION["displayName"] = $str_arr[2];
            $_SESSION["email"] = $str_arr[3];
            header("Location: index.php");
            exit();
        }

        else displayLoginForm("Incorrect password.");
    }

    else displayLoginForm("Incorrect username or password.");

}

function createAccout($username, $password, $displayName, $emailAddress){

}

function displayCreateAccountForm(){

}

function displayForgotPasswordForm(){

}

function displayLoginForm($message=""){
    require_once ("templates/logon_form.html");
}

function displayResetPassForm($userID){

}

function processPageRequest(){

    session_destroy();

    $username = $_POST["username"];
    $password = $_POST["password"];

    if(isset($username)) {
        if (isset($password)) {
            authenticateUser($username, $password);
        }
        else displayLoginForm();
    }

    else{
        displayLoginForm();
    }

}

function resetPass($userID, $password){

}

function sendForgotPassEmail($username){

}

function sendValidationEmail($userID, $displayName, $emailAddress){

}

function validateAcc($userId){

}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
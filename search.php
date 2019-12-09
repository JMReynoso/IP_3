<?php

session_start();
processPageRequest();

function displaySearchForm(){
    require_once ("templates/search_form.html");
}

function displaySearchResults($searchString){
    $results = file_get_contents('http://www.omdbapi.com/?apikey=a00774f1&s='.urlencode($searchString).'&type=movie&r=json');
    $array = json_decode($results, true)["Search"];

    require_once ("templates/results_form.html");
}

function processPageRequest(){

    $searchString = $_POST["toSearch"];

    if (isset($_POST["toSearch"])){
        displaySearchResults($searchString);

    }

    else{
        displaySearchForm();
    }
}


?>

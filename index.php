<?php
include 'data/cart.db';

session_start();
require_once ("/home/common/mail.php");
processPageRequest();

function addMovieToCart($movieID){
    $movieArray = readMovieData();
    array_push($movieArray, $movieID);
    writeMovieData($movieArray);
    displayCart();
}

function checkout($name, $address){

    $message = "<table>
        <tr>
            <th>Movie</th>
            <th>Title</th>
        </tr>";

            $arrayMovies = readMovieData();

            for ($i =0; $i < count($arrayMovies) ; $i++) {
                $movieID = $arrayMovies [$i];

                if (!isset($movieID)) {
                    break;
                }

                $movie = file_get_contents('http://www.omdbapi.com/?apikey=a00774f1&i=' . urlencode($movieID) . '&type=movie&r=json');
                $array = json_decode($movie, true);

                $movieImage = $array['Poster'];
                $movieTitle = $array['Title'];
                $movieYear = $array['Year'];

                $message .= "<tr>";
                $message .= "<th><img src='<?= echo $movieImage; ?>' height='100'></th>";
                $message .= "<th> <?php echo $movieTitle; ?> , (<?php echo $movieYear ?>)</th>";

                $message .= "</tr>";

            }
    $result = sendMail(690327006, $address, $name, "Your Receipt from myMovies!", $message);

    //0 => sent 1-59=> time remaining
    //-1 => error sending, -2 => invalid email -3 => error in database
    return $result;
}

function displayCart(){
    $arrayOfMovieID = readMovieData();

    require_once ("templates/cart_form.html");
}

function processPageRequest(){

    //if value does not exist, displayCart()

    if(isset($_GET["action"])){

        $action = $_GET["action"];
        if($action === "add"){
            $movieID = $_GET['movie_id'];
            addMovieToCart($movieID);
        }

        if($action === "checkout"){

             $displayName = $_SESSION['displayName'];
             $emailAdd = $_SESSION['email'];

            checkout($displayName, $emailAdd);
        }

        if($action === "remove"){
            $movieID = $_GET['movie_id'];
            removeMovieFromCart($movieID);
        }
    }

    else{
        displayCart();
    }

}

function readMovieData(){
    $file = file_get_contents("data/cart.db");

    if(empty($file)){
        return (array) null;
    }

    else{
        $arrayID = preg_split("/\,/", $file);

        return $arrayID;
    }

}

function removeMovieFromCart($movieID){
    $movieIDArray = readMovieData();

    $search = array_search($movieID, $movieIDArray);
    unset($movieIDArray[$search]);
    array_values($movieIDArray);

    writeMovieData($movieIDArray);
    displayCart();
}


function writeMovieData($array){
    $file = fopen("data/cart.db", 'w');

    fwrite($file, $array[0]);

    for($i = 1; $i <= sizeof($array); $i++){

        if(isset($array[$i])){

            fwrite($file, ",");
            fwrite($file, $array[$i]);

        }
    }
    fclose($file);
}

?>
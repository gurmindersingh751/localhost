<?php


$file = parse_ini_file("https://gurmindersingh751.github.io/localhost/RentACar.ini");

$host = trim($file["dbhost"]);
$user = trim($file["dbuser"]);
$pass = trim($file["dbpass"]);
$name = trim($file["dbname"]);

require("https://gurmindersingh751.github.io/localhost/RentACar/secure/access.php");
$access = new access($host, $user, $pass,$name);
$access->connect();

$word = null;
$make = htmlentities($_REQUEST["make"]);

if(!empty($_REQUEST["word"])){
    $word = htmlentities($_REQUEST["word"]);
    
}
$searchCars = $access->search($word, $make);

if(!empty($searchCars)){
    $returnArray["searchCars"] = $searchCars;
} else {
    $returnArray["message"] = 'Could not find records';
}
$access->disconnect();
echo json_encode($returnArray);

?>
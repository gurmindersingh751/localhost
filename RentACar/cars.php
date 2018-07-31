<?php 
$id = isset($_REQUEST["id"]);
$make = isset($_REQUEST["make"]);
$model = isset($_REQUEST["model"]);
$color = isset($_REQUEST["color"]);


$file = parse_ini_file("https://gurmindersingh751.github.io/localhost/RentACar.ini");

$host = trim($file["dbhost"]);
$user = trim($file["dbuser"]);
$pass = trim($file["dbpass"]);
$name = trim($file["dbname"]);

require("secure/access.php");
$access = new access($host, $user, $pass,$name);
$access->connect();

$user = $access->selectCars();

if(!empty($user)){
    $returnArray["cars"] = $user;
    echo json_encode($returnArray);
    return;
}

$returnArray["id"] = $user["id"];
$returnArray["make"] = $user["make"];
$returnArray["model"] = $user["model"];
$returnArray["color"] = $user["color"];


$access->disconnect();
echo json_encode($returnArray);


?>
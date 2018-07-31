<?php

$username = htmlentities($_REQUEST["username"]);
$password = htmlentities($_REQUEST["password"]);

if (empty($username) || empty($password)){
$returnArray["status"] = "400";
$returnArray["messege"] = "Missing required info";
}

$file = parse_ini_file("../../../RentACar.ini");

$host = trim($file["dbhost"]);
$user = trim($file["dbuser"]);
$pass = trim($file["dbpass"]);
$name = trim($file["dbname"]);

require("secure/access.php");
$access = new access($host, $user, $pass,$name);
$access->connect();


$user = $access->getUser($username);

if (empty($user)){
    $returnArray["status"] = "403";
    $returnArray["message"] = "User is not found";
    echo json_encode($returnArray);
    return;
}
$secured_password = $user["password"];
$salt = $user["salt"];
if($secured_password === sha1($password . $salt)){
    $returnArray["status"] = "200";
    $returnArray["message"] = "Logged in successfully";
    $returnArray["id"] = $user["id"];
    $returnArray["username"] = $user["username"];
    $returnArray["email"] = $user["email"];
    $returnArray["fullname"] = $user["fullname"];
    $returnArray["ava"] = $user["ava"];
    //echo json_encode($returnArray);
} else {
    $returnArray["status"] = "403";
    $returnArray["message"] = "Password do not match";
}
$access->disconnect();
echo json_encode($returnArray);
?>
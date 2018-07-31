<?php



$username = htmlentities($_REQUEST["username"]);
$password = htmlentities($_REQUEST["password"]);
$email = htmlentities($_REQUEST["email"]);
$fullname = htmlentities($_REQUEST["fullname"]);

if(empty($username) || empty($password) || empty($email) || empty($fullname)){
        $returnArray["status"] = "400";
        $returnArray["messege"] = "Missing info";
        echo json_encode($returnArray);
        return;
}

$salt = openssl_random_pseudo_bytes(20);
$secured_password = sha1($password . $salt);

$file = parse_ini_file("https://gurmindersingh751.github.io/localhost/RentACar.ini");

$host = trim($file["dbhost"]);
$user = trim($file["dbuser"]);
$pass = trim($file["dbpass"]);
$name = trim($file["dbname"]);

require("https://gurmindersingh751.github.io/localhost/RentACar/secure/access.php");
$access = new access($host, $user, $pass,$name);
$access->connect();

$result = $access->registerUser($username, $secured_password, $salt, $email,$fullname);
if($result){
    $user = $access->selectUser($username);
    $returnArray["status"] = "200";
    $returnArray["message"] = "Successfully registered";
    $returnArray["id"] = $user["id"];
    $returnArray["username"] = $user["username"];
    $returnArray["email"] = $user["email"];
    $returnArray["fullname"] = $user["fullname"];
    $returnArray["ava"] = $user["ava"];
} else{
    $returnArray["status"] = "400";
    $returnArray["mnessage"] = "Could not registered with provided info";
}


$access->disconnect();


echo json_encode($returnArray);
?>
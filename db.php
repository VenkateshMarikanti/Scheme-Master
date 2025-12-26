<?php
$host = "127.0.0.1";
$user = "root";
$password = "";
$database = "schememasters";
$port = 3307;

$conn = mysqli_connect($host, $user, $password, $database, $port);

if (!$conn) {
    die(json_encode([
        "status" => "error",
        "message" => mysqli_connect_error()
    ]));
}
?>

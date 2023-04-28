<?php

// show all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$name = $_POST['name'];
$phone = $_POST['phone'];
$price = $_POST['price'];
$payment_method = $_POST['payment_method'];

$folder_root = "photos";
$folder_name = $folder_root . "/" . str_replace(" ", "_", $name) . "_" . time();
$raw_folder_name = $folder_name . "/raw";
mkdir($folder_name, 0777, true);
mkdir($raw_folder_name, 0777, true);

//add to database
$servername = $_SERVER['DB_HOST'];
$username = $_SERVER['DB_USER'];
$dbname = $_SERVER['DB_DB'];
$password = $_SERVER['DB_PASS'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO orders (name, phone, price, payment_method, folder_name)";
$sql .= "VALUES ('$name', '$phone', '$price', '$payment_method', '$folder_name')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    $conn->close();
    header("Location: index.html");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    $conn->close();
}

<?php
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
$servername = "localhost";
$username = "root";
$dbname = "photobooth";
$password = "";

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

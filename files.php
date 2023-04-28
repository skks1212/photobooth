<?php

// show all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$servername = $_SERVER['DB_HOST'];
$username = $_SERVER['DB_USER'];
$dbname = $_SERVER['DB_DB'];
$password = $_SERVER['DB_PASS'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

$id = $_GET['id'];

$sql = "SELECT * FROM orders WHERE id = $id";
$result = $conn->query($sql);

$row = $result->fetch_assoc();

$folder = $row['folder_name'];

$raw_folder = $folder . "/raw";

$raw_files = scandir($raw_folder);

$raw_files = array_diff($raw_files, array('.', '..'));

$files = scandir($folder);

$files = array_diff($files, array('.', '..'));

?>

<h1>
    Raw Files
</h1>
<div>
    <?php
    foreach ($raw_files as $raw_file) {
        echo "<a href='$raw_folder/$raw_file' download ><img src='$raw_folder/$raw_file' width='200px' /></a>";
    }
    ?>
</div>

<h1>
    Processed Files
</h1>
<div>
    <?php
    foreach ($files as $file) {
        echo "<a href='$folder/$file' download ><img src='$folder/$file' width='200px' /></a>";
    }
    ?>
</div>
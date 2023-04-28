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

// get data from database
$id = $_GET['id'];
$sql = "SELECT * FROM orders WHERE id='$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$name = $row['name'];
$phone = $row['phone'];
$price = $row['price'];
$payment_method = $row['payment_method'];
$folder_name = $row['folder_name'];
$type = $row['type'];
$notes = $row['notes'];

if (isset($_POST["submit"])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $price = $_POST['price'];
    $payment_method = $_POST['payment_method'];
    $type = $_POST['type'];
    $notes = $_POST['notes'];

    $folder_root = "photos";
    $raw_folder_name = $folder_name . "/raw";

    // upload raw files
    if (isset($_FILES['raw_files'])) {
        echo "raw files exist";
        $raw_files = $_FILES['raw_files'];
        foreach ($_FILES['raw_files']['tmp_name'] as $key => $tmpName) {
            // Check if file was uploaded successfully
            if ($_FILES['raw_files']['error'][$key] === UPLOAD_ERR_OK) {
                // Generate unique filename to avoid collisions
                $filename = uniqid() . '-' . $_FILES['raw_files']['name'][$key];

                // Move file to upload directory
                move_uploaded_file($tmpName, $raw_folder_name . "/" . $filename);
            }
        }
    }
    // upload edited files
    if (isset($_FILES['files'])) {
        echo "edited files exist";
        $files = $_FILES['files'];
        $files_count = count($files['name']);
        for ($i = 0; $i < $files_count; $i++) {
            $file_name = $files['name'][$i];
            $file_tmp_name = $files['tmp_name'][$i];
            $file_path = $folder_name . "/" . $file_name;
            move_uploaded_file($file_tmp_name, $file_path);
        }
    }

    //add to database


    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $id = $_GET['id'];

    //update database
    $sql = "UPDATE orders SET name='$name', phone='$phone', price='$price', payment_method='$payment_method', folder_name='$folder_name', type='$type', notes='$notes' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
        $conn->close();
        header("Location: index.html");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        $conn->close();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="post" enctype="multipart/form-data">
        <input type="text" placeholder="name" name="name" value="<?php echo $name; ?>">
        <input type="text" placeholder="phone" name="phone" value="<?php echo $phone; ?>">
        <input type="number" placeholder="Price" name="price" value="<?php echo $price; ?>">
        <select name="payment_method">
            <option value="cash" <?php if ($payment_method == "cash") echo "selected"; ?>>Cash</option>
            <option value="upi" <?php if ($payment_method == "upi") echo "selected"; ?>>UPI</option>
        </select>
        <select name="type">
            <option value="1" <?php if ($type == 1) echo "selected"; ?>>Polaroid</option>
            <option value="2" <?php if ($type == 2) echo "selected"; ?>>Film Strip</option>
        </select>
        <br>
        <br>
        <textarea name="notes" placeholder="notes"><?php echo $notes; ?></textarea>
        <br>
        <br>
        Raw Files
        <input type="file" multiple name="raw_files[]">
        <br>
        <br>
        Edited Files
        <input type="file" multiple name="files[]">
        <br>
        <br>
        <input type="submit" value="submit" name="submit">
    </form>
</body>

</html>
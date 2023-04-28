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

?>

<table>
    <thead>
        <tr>
            <th>
                Name
            </th>
            <th>
                Phone
            </th>
            <th>
                Price
            </th>
            <th>
                Payment Method
            </th>
            <th>
                Folder Name
            </th>
            <th>
                Actions
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT * FROM orders";
        $result = $conn->query($sql);

        $rows = $result->fetch_all(MYSQLI_ASSOC);

        foreach ($rows as $row) {
        ?>
            <tr>
                <td>
                    <?php echo $row['name']; ?>
                </td>
                <td>
                    <?php echo $row['phone']; ?>
                </td>
                <td>
                    <?php echo $row['price']; ?>
                </td>
                <td>
                    <?php echo $row['payment_method']; ?>
                </td>
                <td>
                    <?php echo $row['folder_name']; ?>
                </td>
                <td>
                    <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
                    <a href="raw.php?id=<?php echo $row['id']; ?>">Raw</a>
                    <a href="files.php?id=<?php echo $row['id']; ?>">Files</a>
                    <a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>

<br>
<br>
<a href=" index.html">Add</a>
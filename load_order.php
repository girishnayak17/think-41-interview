<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "think41";

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Path to your CSV file
$csvFile = 'C:\Users\Girish\Downloads\archive\archive\orders.csv';

// Open the CSV file
if (($handle = fopen($csvFile, "r")) !== FALSE) {
    // Skip header row
    fgetcsv($handle);

    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO `orders` (order_id, user_id, status, gender, created_at, returned_at, shipped_at, delivered_at, num_of_item) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "iissssssi",
            $data[0], // order_id (int)
            $data[1], // user_id (int)
            $data[2], // status (string)
            $data[3], // gender (string)
            $data[4], // created_at (string/date)
            $data[5], // returned_at (string/date)
            $data[6], // shipped_at (string/date)
            $data[7], // delivered_at (string/date)
            $data[8]  // num_of_item (int)
        );
        $stmt->execute();
        $stmt->close();
    }
    fclose($handle);
    echo "Order CSV data imported successfully!";
} else {
    echo "Error opening the file.";
}

$conn->close();
?>
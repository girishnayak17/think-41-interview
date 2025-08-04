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
$csvFile = 'C:\Users\Girish\Downloads\archive\archive\users.csv';

// Open the CSV file
if (($handle = fopen($csvFile, "r")) !== FALSE) {
    // Skip header row
    fgetcsv($handle);

    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (id, first_name, last_name, email, age, gender, state, street_address, postal_code, city, country, latitude, longitude, traffic_source, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "isssissssssddss",
            $data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $data[9], $data[10], $data[11], $data[12], $data[13], $data[14]
        );
        $stmt->execute();
        $stmt->close();
    }
    fclose($handle);
    echo "CSV data imported successfully!";
} else {
    echo "Error opening the file.";
}

$conn->close();
?>
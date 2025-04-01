<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "bhushan";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected to the database successfully!<br>";
}

// Debug: Print all form data
echo "<pre>";
print_r($_POST);
echo "</pre>";

// Get form data
$item = $_POST['item'] ?? '';
$priority = $_POST['priority'] ?? '';
$delivery = $_POST['delivery'] ?? '';
$delivery_branch = $_POST['delivery_branch'] ?? '';
$from_branch = $_POST['from_branch'] ?? '';
$to_branch = $_POST['to_branch'] ?? '';
$otherItem = $_POST['otherItem'] ?? '';

// If "Other Items" is selected, use the value from the textarea
if ($item === 'Other Items' && !empty($otherItem)) {
    $item = $otherItem;
}

// Validate required fields
if (empty($item) || empty($priority) || empty($delivery)) {
    die("Please fill all required fields!");
}

// Validate branch fields based on delivery type
if ($delivery === 'Delivery to Branch' && empty($delivery_branch)) {
    die("Please select a delivery branch!");
} elseif ($delivery === 'Transfer Item' && (empty($from_branch) || empty($to_branch))) {
    die("Please select both 'From Branch' and 'To Branch' for transfer!");
}

// Prepare SQL query
$sql = "INSERT INTO requests (item, priority, delivery_type, branch, from_branch, to_branch, other_item) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

// Bind parameters
$stmt->bind_param("sssssss", $item, $priority, $delivery, $delivery_branch, $from_branch, $to_branch, $otherItem);

// Execute the query
if ($stmt->execute()) {
    echo "Request submitted successfully!";
} else {
    echo "Error: " . $stmt->error; // Debug: Display SQL error
}

// Close connections
$stmt->close();
$conn->close();
?>
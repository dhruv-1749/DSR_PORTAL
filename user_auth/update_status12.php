<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if POST data exists
if (!isset($_POST['id'], $_POST['action'])) {
    die("Error: Missing required data (ID or action).");
}

// Sanitize inputs
$id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
$action = strtolower($_POST['action']);

// Validate action
if ($action !== 'approve' && $action !== 'reject') {
    die("Error: Invalid action. Use 'approve' or 'reject'.");
}

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
}

// Update the status
$status = ($action === 'approve') ? 'approved' : 'rejected';
$sql = "UPDATE requests SET status = ? WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("si", $status, $id);

if ($stmt->execute()) {
    // Close connections before redirect
    $stmt->close();
    $conn->close();
    
    // Redirect (must be before any output)
    header("Location: admin12.php");
    exit();
} else {
    die("Error updating request: " . $stmt->error);
}
?>
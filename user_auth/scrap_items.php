<?php
// Database connection details
$host = 'localhost'; // Replace with your database host
$dbname = 'user_auth'; // Replace with your database name
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password

// Create a connection to the database
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the data from the form
    $item_descriptions = $_POST['item_description'];
    $quantities = $_POST['quantity']; // Updated from 'qty' to 'quantity'
    $remarks = $_POST['remark'];

    // Prepare the SQL query for inserting data
    $stmt = $conn->prepare("INSERT INTO scrap_items (item_description, quantity, remark) VALUES (:item_description, :quantity, :remark)");

    // Loop through the data and insert each item into the database
    for ($i = 0; $i < count($item_descriptions); $i++) {
        $stmt->execute([
            ':item_description' => $item_descriptions[$i],
            ':quantity' => $quantities[$i], // Updated from 'qty' to 'quantity'
            ':remark' => $remarks[$i]
        ]);
    }

    // Display a success message and redirect to HOME.php
    echo "<script>
            alert('Item scrape successfully!');
            setTimeout(function() {
                window.location.href = 'HOME.php';
            }, 100);
          </script>";
}
?>
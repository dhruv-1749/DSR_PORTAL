<?php
// Database connection
$host = 'localhost';
$dbname = 'user_auth';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $consumableList = $_POST['consumable_list'];
    $itemDescription = $_POST['item_description'];
    $quantity = $_POST['quantity'];
    $transferDate = $_POST['transferDate'];
    $totalPrice = $_POST['total_price'];
    $branch = $_POST['branch'];
    $dsrNo = $_POST['item_image'];

    // Insert data into the database
    try {
        $sql = "INSERT INTO received_items (consumable_list, item_description, quantity, transfer_date, total_price, branch, dsr_no)
                VALUES (:consumable_list, :item_description, :quantity, :transfer_date, :total_price, :branch, :dsr_no)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':consumable_list' => $consumableList,
            ':item_description' => $itemDescription,
            ':quantity' => $quantity,
            ':transfer_date' => $transferDate,
            ':total_price' => $totalPrice,
            ':branch' => $branch,
            ':dsr_no' => $dsrNo
        ]);

        echo "<script>
                alert('Item received successfully!');
                setTimeout(function() {
                    window.location.href = 'HOME.php';
                }, 100);
              </script>";
    } catch (PDOException $e) {
        die("Error inserting data: " . $e->getMessage());
    }
}
?>
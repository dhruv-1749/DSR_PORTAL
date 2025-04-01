<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "bhushan";

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Fetch all requests from the database
    $sql = "SELECT id, item, priority, delivery_type, from_branch, to_branch, other_item, status FROM requests";
    $result = $conn->query($sql);

    // Check if the query was successful
    if (!$result) {
        throw new Exception("Error fetching requests: " . $conn->error);
    }
} catch (Exception $e) {
    die("<div style='color: red; padding: 20px; background: #ffeeee; border: 1px solid red; margin: 20px; border-radius: 5px;'>
            <h2>Database Error</h2>
            <p>" . htmlspecialchars($e->getMessage()) . "</p>
            <p>Please check:</p>
            <ul>
                <li>Is MySQL server running in XAMPP?</li>
                <li>Are the database credentials correct?</li>
                <li>Does the 'bhushan' database exist?</li>
                <li>Does the 'requests' table exist?</li>
            </ul>
        </div>");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Status Tracker</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 20px;
            background-color: #2c3e50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .back-button:hover {
            background-color: #1a252f;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
            font-size: 2.5rem;
            margin-bottom: 30px;
            padding-top: 20px;
        }
        .status-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        .status-card:hover {
            transform: translateY(-5px);
        }
        .status-header {
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
        }
        .request-id {
            font-weight: bold;
            color: #2c3e50;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-approved {
            background-color: #d4edda;
            color: #155724;
        }
        .status-rejected {
            background-color: #f8d7da;
            color: #721c24;
        }
        .status-details {
            padding: 20px;
        }
        .detail-row {
            display: flex;
            margin-bottom: 10px;
        }
        .detail-label {
            font-weight: bold;
            width: 150px;
            color: #7f8c8d;
        }
        .detail-value {
            flex: 1;
        }
        .no-requests {
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            color: #7f8c8d;
        }
        .progress-tracker {
            margin-top: 20px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .progress-steps {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin-top: 20px;
        }
        .progress-steps::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 0;
            right: 0;
            height: 4px;
            background: #e0e0e0;
            z-index: 1;
        }
        .progress-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
        }
        .step-number {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 5px;
            color: white;
            font-weight: bold;
        }
        .step-label {
            font-size: 0.8rem;
            color: #95a5a6;
            text-align: center;
        }
        .step-active .step-number {
            background: #3498db;
        }
        .step-complete .step-number {
            background: #2ecc71;
        }
        .step-rejected .step-number {
            background: #e74c3c;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="HOME.php" class="back-button">← Back to Home</a>
        <h1>Your Request Status</h1>
        
        <?php if (isset($result) && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="status-card">
                    <div class="status-header">
                        <div class="request-id">Request ID: #<?php echo htmlspecialchars($row['id']); ?></div>
                        <div class="status-badge status-<?php echo strtolower(htmlspecialchars($row['status'])); ?>">
                            <?php echo htmlspecialchars($row['status']); ?>
                        </div>
                    </div>
                    
                    <div class="status-details">
                        <div class="detail-row">
                            <div class="detail-label">Item:</div>
                            <div class="detail-value"><?php echo htmlspecialchars($row['item']); ?></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Priority:</div>
                            <div class="detail-value"><?php echo htmlspecialchars($row['priority']); ?></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Delivery Type:</div>
                            <div class="detail-value"><?php echo htmlspecialchars($row['delivery_type']); ?></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">From Branch:</div>
                            <div class="detail-value"><?php echo htmlspecialchars($row['from_branch']); ?></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">To Branch:</div>
                            <div class="detail-value"><?php echo htmlspecialchars($row['to_branch']); ?></div>
                        </div>
                        <?php if (!empty($row['other_item'])): ?>
                        <div class="detail-row">
                            <div class="detail-label">Additional Info:</div>
                            <div class="detail-value"><?php echo htmlspecialchars($row['other_item']); ?></div>
                        </div>
                        <?php endif; ?>
                        
                        <div class="progress-tracker">
                            <h3>Request Progress</h3>
                            <div class="progress-steps">
                                <div class="progress-step step-complete">
                                    <div class="step-number">1</div>
                                    <div class="step-label">Submitted</div>
                                </div>
                                <div class="progress-step <?php 
                                    echo $row['status'] == 'approved' ? 'step-complete' : 
                                         ($row['status'] == 'rejected' ? 'step-rejected' : 'step-active'); ?>">
                                    <div class="step-number">2</div>
                                    <div class="step-label"><?php 
                                        echo $row['status'] == 'pending' ? 'Under Review' : 
                                             ($row['status'] == 'approved' ? 'Approved' : 'Rejected'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-requests">
                <h3>No requests found</h3>
                <p>You haven't submitted any requests yet.</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
// Close connection if it exists
if (isset($conn)) {
    $conn->close();
}
?>
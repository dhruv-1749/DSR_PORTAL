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
}

// Pagination variables
$rows_per_page = 5; // Decreased page size
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $rows_per_page;

// Fetch total number of records
$total_sql = "SELECT COUNT(*) as total FROM requests";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $rows_per_page);

// Fetch requests for the current page
$sql = "SELECT id, item, priority, delivery_type, from_branch, to_branch, other_item, status FROM requests LIMIT $offset, $rows_per_page";
$result = $conn->query($sql);

// Check if the query was successful
if (!$result) {
    die("Error fetching requests: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Approve/Reject Requests</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: #333;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        h1 {
            color: #2c3e50;
            font-size: 2rem;
            margin: 0;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
        
        .home-btn {
            background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 30px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }
        
        .home-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
        
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-bottom: 30px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        
        th {
            background-color: #f8f9fa;
            color: #2c3e50;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        
        tr:hover {
            background-color: #f8f9fa;
        }
        
        .status {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .pending { background-color: #fff3cd; color: #856404; }
        .approved { background-color: #d4edda; color: #155724; }
        .rejected { background-color: #f8d7da; color: #721c24; }
        
        .button-container {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .action-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .approve-btn {
            background-color: #28a745;
            color: white;
        }
        
        .reject-btn {
            background-color: #dc3545;
            color: white;
        }
        
        .edit-btn {
            background-color: #17a2b8;
            color: white;
            text-decoration: none;
        }
        
        .action-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 20px;
        }
        
        .page-item {
            display: inline-block;
        }
        
        .page-link {
            padding: 8px 14px;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            color: #3498db;
            text-decoration: none;
            transition: all 0.2s;
        }
        
        .page-link:hover {
            background-color: #f8f9fa;
        }
        
        .page-link.active {
            background-color: #3498db;
            color: white;
            border-color: #3498db;
        }
        
        .no-requests {
            padding: 30px;
            text-align: center;
            color: #6c757d;
        }
        
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
            }
            
            .button-container {
                flex-direction: column;
            }
            
            .action-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Request Status Dashboard</h1>
            <a href="HOME.php" class="home-btn">
                <i class="fas fa-home"></i> Back to Home
            </a>
        </div>
        
        <div class="card">
            <?php if ($result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Item</th>
                            <th>Priority</th>
                            <th>Delivery Type</th>
                            <th>From Branch</th>
                            <th>To Branch</th>
                            <th>Other Item</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['item']); ?></td>
                                <td><?php echo htmlspecialchars($row['priority']); ?></td>
                                <td><?php echo htmlspecialchars($row['delivery_type']); ?></td>
                                <td><?php echo htmlspecialchars($row['from_branch']); ?></td>
                                <td><?php echo htmlspecialchars($row['to_branch']); ?></td>
                                <td><?php echo htmlspecialchars($row['other_item']); ?></td>
                                <td>
                                    <span class="status <?php echo $row['status']; ?>">
                                        <?php echo ucfirst($row['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="button-container">
                                        <form action='update_status12.php' method='POST' style='display:inline;'>
                                            <input type='hidden' name='id' value='<?php echo $row['id']; ?>'>
                                            <button type='submit' name='action' value='approve' class="action-btn approve-btn">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                        </form>
                                        <form action='update_status12.php' method='POST' style='display:inline;'>
                                            <input type='hidden' name='id' value='<?php echo $row['id']; ?>'>
                                            <button type='submit' name='action' value='reject' class="action-btn reject-btn">
                                                <i class="fas fa-times"></i> Reject
                                            </button>
                                        </form>
                                        <a href='edit_request12.php?id=<?php echo $row['id']; ?>' class='action-btn edit-btn'>
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                
                <?php if ($total_pages > 1): ?>
                    <div class="pagination">
                        <?php if ($page > 1): ?>
                            <a href="?page=<?php echo $page - 1; ?>" class="page-link">&laquo; Previous</a>
                        <?php endif; ?>
                        
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <a href="?page=<?php echo $i; ?>" class="page-link <?php echo $i == $page ? 'active' : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                        
                        <?php if ($page < $total_pages): ?>
                            <a href="?page=<?php echo $page + 1; ?>" class="page-link">Next &raquo;</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
            <?php else: ?>
                <div class="no-requests">
                    <p>No requests found in the database.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
<?php
// Enable strict error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "bhushan";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate and get ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid request ID");
}
$id = (int)$_GET['id'];

// Fetch request data
$stmt = $conn->prepare("SELECT * FROM requests WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Request not found");
}
$request = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $item = $conn->real_escape_string($_POST['item']);
    $priority = $conn->real_escape_string($_POST['priority']);
    $delivery = $conn->real_escape_string($_POST['delivery']);
    $department = $conn->real_escape_string($_POST['department'] ?? '');
    $from_department = $conn->real_escape_string($_POST['from_department'] ?? '');
    $to_department = $conn->real_escape_string($_POST['to_department'] ?? '');
    $otherItem = $conn->real_escape_string($_POST['otherItem']);

    // Determine which department fields to use based on request type
    $branch = '';
    $from_branch = '';
    $to_branch = '';
    
    if (isset($_POST['request_type']) && $_POST['request_type'] === 'department_transfer') {
        $from_branch = $from_department;
        $to_branch = $to_department;
    } else {
        $branch = $department;
    }

    // Update query
    $sql = "UPDATE requests SET 
            item = ?, 
            priority = ?, 
            delivery_type = ?, 
            branch = ?, 
            from_branch = ?, 
            to_branch = ?, 
            other_item = ? 
            WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $item, $priority, $delivery, $branch, $from_branch, $to_branch, $otherItem, $id);

    if ($stmt->execute()) {
        $success = "Request updated successfully!";
    } else {
        $error = "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Request</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4895ef;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --success-color: #4cc9f0;
            --warning-color: #f72585;
            --danger-color: #ef233c;
            --border-radius: 8px;
            --box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: var(--dark-color);
            line-height: 1.6;
            min-height: 100vh;
            padding: 40px 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 40px;
            position: relative;
            overflow: hidden;
        }
        
        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 8px;
            height: 100%;
            background: linear-gradient(to bottom, var(--primary-color), var(--accent-color));
        }
        
        h1 {
            color: var(--secondary-color);
            margin-bottom: 30px;
            font-size: 2rem;
            position: relative;
            padding-bottom: 10px;
        }
        
        h1::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            background: var(--accent-color);
            border-radius: 2px;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: var(--border-radius);
            font-weight: 500;
            animation: fadeIn 0.5s ease;
        }
        
        .alert-success {
            background-color: rgba(76, 201, 240, 0.2);
            color: var(--success-color);
            border-left: 4px solid var(--success-color);
        }
        
        .alert-error {
            background-color: rgba(239, 35, 60, 0.2);
            color: var(--danger-color);
            border-left: 4px solid var(--danger-color);
        }
        
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--secondary-color);
        }
        
        input[type="text"],
        select,
        textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: var(--border-radius);
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            transition: var(--transition);
            background-color: #f9f9f9;
        }
        
        input[type="text"]:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(72, 149, 239, 0.2);
            background-color: white;
        }
        
        textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        .priority-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 8px;
        }
        
        .priority-low { background-color: var(--success-color); }
        .priority-medium { background-color: orange; }
        .priority-high { background-color: var(--warning-color); }
        
        .radio-group {
            margin-bottom: 25px;
            display: flex;
            gap: 20px;
        }
        
        .radio-option {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }
        
        .radio-option input[type="radio"] {
            width: 18px;
            height: 18px;
            accent-color: var(--accent-color);
        }
        
        .content-section {
            display: none;
            animation: fadeIn 0.5s ease;
        }
        
        .content-section.active {
            display: block;
        }
        
        button {
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: var(--border-radius);
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 10px rgba(67, 97, 238, 0.3);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(67, 97, 238, 0.4);
        }
        
        button i {
            margin-right: 8px;
        }
        
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: var(--secondary-color);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }
        
        .back-link:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }
        
        .back-link i {
            margin-right: 5px;
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .form-group {
            animation: fadeIn 0.5s ease forwards;
            opacity: 0;
        }
        
        .form-group:nth-child(1) { animation-delay: 0.1s; }
        .form-group:nth-child(2) { animation-delay: 0.2s; }
        .form-group:nth-child(3) { animation-delay: 0.3s; }
        .form-group:nth-child(4) { animation-delay: 0.4s; }
        .form-group:nth-child(5) { animation-delay: 0.5s; }
        .form-group:nth-child(6) { animation-delay: 0.6s; }
        .form-group:nth-child(7) { animation-delay: 0.7s; }
        .form-group:nth-child(8) { animation-delay: 0.8s; }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container {
                padding: 30px 20px;
            }
            
            h1 {
                font-size: 1.5rem;
            }
            
            .radio-group {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Request <small>(ID: <?php echo htmlspecialchars($id); ?>)</small></h1>
        
        <?php if (isset($success)): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?php echo $success; ?>
            </div>
        <?php elseif (isset($error)): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="item">Item Name</label>
                <input type="text" id="item" name="item" value="<?php echo htmlspecialchars($request['item']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="priority">Priority Level</label>
                <select id="priority" name="priority" required>
                    <option value="low" <?php echo $request['priority'] === 'low' ? 'selected' : ''; ?>>
                        <span class="priority-indicator priority-low"></span> Low Priority
                    </option>
                    <option value="medium" <?php echo $request['priority'] === 'medium' ? 'selected' : ''; ?>>
                        <span class="priority-indicator priority-medium"></span> Medium Priority
                    </option>
                    <option value="high" <?php echo $request['priority'] === 'high' ? 'selected' : ''; ?>>
                        <span class="priority-indicator priority-high"></span> High Priority
                    </option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="delivery">Delivery Type</label>
                <input type="text" id="delivery" name="delivery" value="<?php echo htmlspecialchars($request['delivery_type']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Request Type</label>
                <div class="radio-group">
                    <label class="radio-option">
                        <input type="radio" name="request_type" value="department_list" <?php echo empty($request['from_branch']) ? 'checked' : ''; ?> onchange="toggleContent('deptListContent', 'deptTransferContent')">
                        Department Item List
                    </label>
                    <label class="radio-option">
                        <input type="radio" name="request_type" value="department_transfer" <?php echo !empty($request['from_branch']) ? 'checked' : ''; ?> onchange="toggleContent('deptTransferContent', 'deptListContent')">
                        Inter-Department Transfer
                    </label>
                </div>
            </div>
            
            <!-- Department List Content -->
            <div id="deptListContent" class="content-section <?php echo empty($request['from_branch']) ? 'active' : ''; ?>">
                <div class="form-group">
                    <label for="department">Department</label>
                    <select id="department" name="department" class="form-control">
                        <option value="">Select Department</option>
                        <option value="Computer Technology" <?php echo $request['branch'] === 'Computer Technology' ? 'selected' : ''; ?>>Computer Technology</option>
                        <option value="Electrical Engineering" <?php echo $request['branch'] === 'Electrical Engineering' ? 'selected' : ''; ?>>Electrical Engineering</option>
                        <option value="Mechanical Engineering" <?php echo $request['branch'] === 'Mechanical Engineering' ? 'selected' : ''; ?>>Mechanical Engineering</option>
                        <option value="Civil Engineering" <?php echo $request['branch'] === 'Civil Engineering' ? 'selected' : ''; ?>>Civil Engineering</option>
                        <option value="Electronics Engineering" <?php echo $request['branch'] === 'Electronics Engineering' ? 'selected' : ''; ?>>Electronics Engineering</option>
                    </select>
                </div>
            </div>
            
            <!-- Department Transfer Content -->
            <div id="deptTransferContent" class="content-section <?php echo !empty($request['from_branch']) ? 'active' : ''; ?>">
                <div class="form-group">
                    <label for="from_department">From Department</label>
                    <select id="from_department" name="from_department" class="form-control">
                        <option value="">Select Source Department</option>
                        <option value="Computer Technology" <?php echo $request['from_branch'] === 'Computer Technology' ? 'selected' : ''; ?>>Computer Technology</option>
                        <option value="Electrical Engineering" <?php echo $request['from_branch'] === 'Electrical Engineering' ? 'selected' : ''; ?>>Electrical Engineering</option>
                        <option value="Mechanical Engineering" <?php echo $request['from_branch'] === 'Mechanical Engineering' ? 'selected' : ''; ?>>Mechanical Engineering</option>
                        <option value="Civil Engineering" <?php echo $request['from_branch'] === 'Civil Engineering' ? 'selected' : ''; ?>>Civil Engineering</option>
                        <option value="Electronics Engineering" <?php echo $request['from_branch'] === 'Electronics Engineering' ? 'selected' : ''; ?>>Electronics Engineering</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="to_department">To Department</label>
                    <select id="to_department" name="to_department" class="form-control">
                        <option value="">Select Destination Department</option>
                        <option value="Computer Technology" <?php echo $request['to_branch'] === 'Computer Technology' ? 'selected' : ''; ?>>Computer Technology</option>
                        <option value="Electrical Engineering" <?php echo $request['to_branch'] === 'Electrical Engineering' ? 'selected' : ''; ?>>Electrical Engineering</option>
                        <option value="Mechanical Engineering" <?php echo $request['to_branch'] === 'Mechanical Engineering' ? 'selected' : ''; ?>>Mechanical Engineering</option>
                        <option value="Civil Engineering" <?php echo $request['to_branch'] === 'Civil Engineering' ? 'selected' : ''; ?>>Civil Engineering</option>
                        <option value="Electronics Engineering" <?php echo $request['to_branch'] === 'Electronics Engineering' ? 'selected' : ''; ?>>Electronics Engineering</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="otherItem">Additional Notes</label>
                <textarea id="otherItem" name="otherItem"><?php echo htmlspecialchars($request['other_item']); ?></textarea>
            </div>
            
            <button type="submit">
                <i class="fas fa-save"></i> Update Request
            </button>
            
            <a href="javascript:history.back()" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Requests
            </a>
        </form>
    </div>

    <script>
        function toggleContent(showId, hideId) {
            document.getElementById(showId).classList.add('active');
            document.getElementById(hideId).classList.remove('active');
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>
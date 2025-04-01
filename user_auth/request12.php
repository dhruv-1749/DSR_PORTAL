<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request for Items</title>
    <style>
        /* Modern Professional Color Scheme */
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --accent: #4895ef;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #4cc9f0;
            --warning: #f72585;
            --text: #2b2d42;
            --border: #e9ecef;
        }

        /* Base Styles */
        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            color: var(--text);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            line-height: 1.6;
        }

        /* Professional Container (Smaller Size) */
        .container {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            width: 90%;
            max-width: 450px;
            color: var(--text);
            position: relative;
            overflow: hidden;
        }

        /* Header Styling */
        h2, h3 {
            color: var(--primary);
            text-align: center;
            margin-bottom: 1.25rem;
        }

        h2 {
            font-size: 1.5rem;
            font-weight: 600;
            position: relative;
            padding-bottom: 0.75rem;
        }

        h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            border-radius: 3px;
        }

        h3 {
            font-size: 1.1rem;
            font-weight: 500;
            margin-top: 1.25rem;
        }

        /* Grid Layout */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 0.75rem;
            margin-bottom: 1.25rem;
        }

        /* Form Elements */
        label {
            display: flex;
            align-items: center;
            background: var(--light);
            padding: 0.75rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 0.9rem;
            border: 1px solid var(--border);
        }

        label:hover {
            background: #e9ecef;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }

        input[type="radio"] {
            margin-right: 0.5rem;
            accent-color: var(--primary);
        }

        input[type="textarea"],
        select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            background: white;
            transition: border 0.2s ease, box-shadow 0.2s ease;
        }

        input[type="textarea"]:focus,
        select:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(72, 149, 239, 0.2);
        }

        /* Button Styling */
        button {
            width: 100%;
            padding: 0.9rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        button:hover {
            background: linear-gradient(135deg, var(--secondary), var(--primary));
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        button:active {
            transform: translateY(0);
        }

        /* Back Button Styling */
        .back-btn {
            display: inline-block;
            margin-bottom: 1rem;
            padding: 0.5rem 1rem;
            background: var(--light);
            color: var(--primary);
            text-decoration: none;
            border-radius: 6px;
            border: 1px solid var(--border);
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .back-btn:hover {
            background: #e9ecef;
            color: var(--secondary);
        }

        /* Hidden Elements */
        .hidden {
            display: none;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .container {
            animation: fadeIn 0.5s ease-out;
        }

        /* Custom Alert Styling */
        .custom-alert {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            z-index: 1000;
            text-align: center;
            max-width: 300px;
            animation: fadeIn 0.3s ease;
        }

        .custom-alert p {
            margin-bottom: 1.5rem;
            font-size: 1rem;
            color: var(--text);
        }

        .custom-alert button {
            padding: 0.5rem 1rem;
            background: var(--primary);
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .custom-alert button:hover {
            background: var(--secondary);
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .grid {
                grid-template-columns: 1fr;
            }
            
            .container {
                padding: 1.25rem;
                width: 95%;
            }
            
            h2 {
                font-size: 1.3rem;
            }
            
            h3 {
                font-size: 1rem;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Request for Items</h2>
        <a href="HOME.php" class="back-btn">← Back to Home</a>
        
        <form id="requestForm" action="submit12.php" method="POST">
            <!-- Requested Items Section -->
            <h3>Requested Items:</h3>
            <div class="grid">
                <label><input type="radio" name="item" value="Computer" onclick="displaySelection()"> Computer</label>
                <label><input type="radio" name="item" value="Mouse" onclick="displaySelection()"> Mouse</label>
                <label><input type="radio" name="item" value="Keyboard" onclick="displaySelection()"> Keyboard</label>
                <label><input type="radio" name="item" value="Other Items"> Other Items</label>
            </div>

            <!-- Other Item Section -->
            <div id="otherItemText" class="hidden">
                <h3>Enter Other Item:</h3>
                <input type="textarea" name="otherItem" placeholder="Enter item name">
            </div>

            <!-- Priority Section -->
            <h3>Priority:</h3>
            <select name="priority" id="priority">
                <option value="">Select Priority</option>
                <option value="High">High</option>
                <option value="Medium">Medium</option>
                <option value="Low">Low</option>
            </select>

            <!-- Delivery or Transfer Section -->
            <h3>Transfer or Delivery:</h3>
            <div class="grid">
                <label><input type="radio" name="delivery" value="Delivery to Branch"> Delivery to Branch</label>
                <label><input type="radio" name="delivery" value="Transfer Item"> Transfer Item</label>
            </div>

            <!-- Delivery Branch Section -->
            <div id="branchSelection" class="hidden">
                <h3>Select Branch:</h3>
                <select name="delivery_branch">
                    <option value="">Select Branch</option>
                    <option value="Computer Technology">Computer Technology</option>
                    <option value="Electrical Engineering">Electrical Engineering</option>
                    <option value="Electronics & Telecommunication">Electronics & Telecommunication</option>
                    <option value="Mechanical Engineering">Mechanical Engineering</option>
                    <option value="Civil Engineering">Civil Engineering</option>
                    <option value="Workshop">Workshop</option>
                    <option value="Library">Library</option>
                    <option value="Science">Science</option>
                    <option value="Office">Office</option>
                </select>
            </div>

            <!-- Transfer Branch Section -->
            <div id="transferSelection" class="hidden">
                <h3>Transfer Details:</h3>
                <select name="from_branch">
                    <option value="">From Branch</option>
                    <option value="Computer Technology">Computer Technology</option>
                    <option value="Electrical Engineering">Electrical Engineering</option>
                    <option value="Electronics & Telecommunication">Electronics & Telecommunication</option>
                    <option value="Mechanical Engineering">Mechanical Engineering</option>
                    <option value="Civil Engineering">Civil Engineering</option>
                    <option value="Workshop">Workshop</option>
                    <option value="Library">Library</option>
                    <option value="Science">Science</option>
                    <option value="Office">Office</option>
                </select>
                <select name="to_branch">
                    <option value="">To Branch</option>
                    <option value="Computer Technology">Computer Technology</option>
                    <option value="Electrical Engineering">Electrical Engineering</option>
                    <option value="Electronics & Telecommunication">Electronics & Telecommunication</option>
                    <option value="Mechanical Engineering">Mechanical Engineering</option>
                    <option value="Civil Engineering">Civil Engineering</option>
                    <option value="Workshop">Workshop</option>
                    <option value="Library">Library</option>
                    <option value="Science">Science</option>
                    <option value="Office">Office</option>
                </select>
            </div>

            <!-- Submit Button -->
            <button type="submit">Submit Request</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const otherItemText = document.getElementById('otherItemText');
            const branchSelection = document.getElementById('branchSelection');
            const transferSelection = document.getElementById('transferSelection');

            // Show/hide "Other Item" textarea
            document.querySelectorAll('input[name="item"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'Other Items') {
                        otherItemText.classList.remove('hidden');
                    } else {
                        otherItemText.classList.add('hidden');
                    }
                });
            });

            // Show/hide delivery or transfer sections
            document.querySelectorAll('input[name="delivery"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'Delivery to Branch') {
                        branchSelection.classList.remove('hidden');
                        transferSelection.classList.add('hidden');
                    } else if (this.value === 'Transfer Item') {
                        transferSelection.classList.remove('hidden');
                        branchSelection.classList.add('hidden');
                    } else {
                        branchSelection.classList.add('hidden');
                        transferSelection.classList.add('hidden');
                    }
                });
            });

            // Handle form submission
            document.getElementById('requestForm').addEventListener('submit', function(event) {
                event.preventDefault();

                // Disable the unused branch field
                if (document.querySelector('input[name="delivery"]:checked').value === 'Delivery to Branch') {
                    document.querySelector('select[name="from_branch"]').disabled = true;
                    document.querySelector('select[name="to_branch"]').disabled = true;
                } else {
                    document.querySelector('select[name="delivery_branch"]').disabled = true;
                }

                // Submit form data
                let formData = new FormData(this);

                fetch('submit12.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (response.ok) {
                        // Show custom alert
                        showSuccessAlert();
                    } else {
                        alert('There was an error submitting the form.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('There was an error submitting the form.');
                });
            });

            function showSuccessAlert() {
                // Create overlay
                const overlay = document.createElement('div');
                overlay.className = 'overlay';
                
                // Create alert box
                const alertBox = document.createElement('div');
                alertBox.className = 'custom-alert';
                alertBox.innerHTML = `
                    <p>Submit Request successfully!..</p>
                    <button onclick="closeAlert()">OK</button>
                `;
                
                // Add to body
                document.body.appendChild(overlay);
                document.body.appendChild(alertBox);
            }
        });

        function closeAlert() {
            // Remove alert and overlay
            document.querySelector('.custom-alert').remove();
            document.querySelector('.overlay').remove();
            
            // Redirect to HOME.php
            window.location.href = 'HOME.php';
        }

        function displaySelection() {
            // Your existing displaySelection function
        }
    </script>
</body>
</html>
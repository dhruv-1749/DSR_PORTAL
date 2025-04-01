<!DOCTYPE html>
<html lang="en">
<head>
    <title>Engineering Branches - Deadstock Register</title>
    <style>
        /* Professional Color Scheme */
        :root {
            --primary: #2c3e50;
            --secondary: #34495e;
            --accent: #3498db;
            --light: #ecf0f1;
            --dark: #2c3e50;
            --text: #333333;
        }

        /* Base Styles */
        body {
            font-family: 'Roboto', 'Helvetica Neue', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: var(--text);
            line-height: 1.6;
        }

        /* Professional Header */
        header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            padding: 12px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        header .logo {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        header .logo img {
            width: 45px;
            height: 45px;
            /* filter: brightness(0) invert(1); */
        }

        header .logo h1 {
            margin: 0;
            font-size: 1.5rem;
            color: white;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        header nav {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        header nav a {
            color: white;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 400;
            padding: 8px 12px;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        header nav a:hover {
            background-color: rgba(255,255,255,0.15);
        }

        /* Main Content */
        .page-title {
            text-align: center;
            margin: 40px 0 30px;
            font-size: 2rem;
            color: var(--primary);
            font-weight: 500;
            position: relative;
        }

        .page-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background-color: var(--accent);
        }

        .container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 25px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Professional Card Design */
        .branch-card {
            background: white;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
            transition: all 0.2s ease;
            cursor: pointer;
            border: 1px solid #e0e0e0;
        }

        .branch-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
            border-color: var(--accent);
        }

        .branch-card img {
            width: 100%;
            height: 140px;
            object-fit: contain;
            padding: 20px;
            background-color: #f5f7fa;
            border-bottom: 1px solid #e0e0e0;
        }

        .branch-info {
            padding: 18px;
            text-align: center;
        }

        .branch-name {
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--dark);
            margin: 0;
        }

        /* Professional Footer */
        footer {
            background: var(--primary);
            color: white;
            padding: 30px 20px 20px;
            margin-top: 50px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 25px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-section h3 {
            color: var(--accent);
            font-size: 1.1rem;
            margin-bottom: 15px;
            font-weight: 500;
            position: relative;
            padding-bottom: 8px;
        }

        .footer-section h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 2px;
            background-color: var(--accent);
        }

        .footer-section p, .footer-section a {
            margin: 8px 0;
            color: #ecf0f1;
            font-size: 0.9rem;
        }

        .footer-section a {
            display: block;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .footer-section a:hover {
            color: var(--accent);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            margin-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
            font-size: 0.8rem;
            color: #bdc3c7;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                padding: 15px;
                text-align: center;
            }
            
            header .logo {
                margin-bottom: 15px;
                justify-content: center;
            }
            
            header nav {
                width: 100%;
                justify-content: center;
                flex-wrap: wrap;
                gap: 10px;
            }
            
            .container {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                padding: 15px;
            }
            
            .page-title {
                font-size: 1.6rem;
                margin: 30px 0 20px;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
</head>
<body>

<!-- Professional Header -->
<header>
    <div class="logo">
        <img src="clglogo.png" alt="">
        <h1>Deadstock Register Portal</h1>
    </div>
    <nav>
        <a href="#">Home</a>
        <a href="https://www.gpsakoli.ac.in/">About</a>
        <a href="#">Contact</a>
        <a href="request12.php">Request</a>
        <a href="status_tracker.php">Status Tracker</a>
        <a href="admin12.php">Status</a>
        <a href="DSR.php">LogOut</a>
    </nav>
</header>

<!-- Main Content -->
<h1 class="page-title">Department Inventory Access</h1>

<div class="container">
    <div class="branch-card" onclick="openBranchPage('Central DSR')">
        <img src="DSRlogo.png" alt="Central DSR">
        <div class="branch-info">
            <div class="branch-name">Central DSR</div>
        </div>
    </div>

    <div class="branch-card" onclick="openBranchPage('Computer Science')">
        <img src="CS.png" alt="Computer Science">
        <div class="branch-info">
            <div class="branch-name">Computer Science</div>
        </div>
    </div>

    <div class="branch-card" onclick="openBranchPage('Mechanical')">
        <img src="ME.png" alt="Mechanical">
        <div class="branch-info">
            <div class="branch-name">Mechanical</div>
        </div>
    </div>

    <div class="branch-card" onclick="openBranchPage('Electrical')">
        <img src="EE.png" alt="Electrical">
        <div class="branch-info">
            <div class="branch-name">Electrical</div>
        </div>
    </div>

    <div class="branch-card" onclick="openBranchPage('Civil')">
        <img src="cv.png" alt="Civil">
        <div class="branch-info">
            <div class="branch-name">Civil</div>
        </div>
    </div>

    <div class="branch-card" onclick="openBranchPage('Electronics')">
        <img src="E& TC .png" alt="Electronics">
        <div class="branch-info">
            <div class="branch-name">Electronics</div>
        </div>
    </div>

    <div class="branch-card" onclick="openBranchPage('Information Technology')">
        <img src="IT.png" alt="Information Technology">
        <div class="branch-info">
            <div class="branch-name">Information Technology</div>
        </div>
    </div>

    <div class="branch-card" onclick="openBranchPage('Artificial Intelligence')">
        <img src="AI.png" alt="Artificial Intelligence">
        <div class="branch-info">
            <div class="branch-name">Artificial Intelligence</div>
        </div>
    </div>

    <div class="branch-card" onclick="openBranchPage('Machine Learning')">
        <img src="ML.png" alt="Machine Learning">
        <div class="branch-info">
            <div class="branch-name">Machine Learning</div>
        </div>
    </div>

    <div class="branch-card" onclick="openBranchPage('Science Lab')">
        <img src="science.png" alt="Science Lab">
        <div class="branch-info">
            <div class="branch-name">Science Lab</div>
        </div>
    </div>

    <div class="branch-card" onclick="openBranchPage('Library')">
        <img src="lab.png" alt="Library">
        <div class="branch-info">
            <div class="branch-name">Library</div>
        </div>
    </div>

    <div class="branch-card" onclick="openBranchPage('Principal Office')">
        <img src="office.png" alt="Principal Office">
        <div class="branch-info">
            <div class="branch-name">Principal Office</div>
        </div>
    </div>
</div>

<!-- Professional Footer -->
<footer>
    <div class="footer-content">
        <div class="footer-section">
            <h3>Quick Links</h3>
            <a href="#">Home</a>
            <a href="https://www.gpsakoli.ac.in/">About Us</a>
        </div>
        <div class="footer-section">
            <h3>Contact</h3>
            <p>Email: info@gpsakoli.ac.in</p>
            <p>Phone: 07186-295112</p>
            <p>Address: Sakoli, Maharashtra, India</p>
        </div>
        <div class="footer-section">
            <h3>Connect</h3>
            <a href="https://www.facebook.com/p/Govt-Polytechnic-Sakoli-100072289660451/">Facebook</a>
            <a href="https://twitter.com/Governm97972244">Twitter</a>
            <a href="https://in.linkedin.com/school/gpsakoli/">LinkedIn</a>
        </div>
    </div>
    <div class="footer-bottom">
        &copy; 2025 Government Polytechnic Sakoli. All rights reserved. [Sumit Lokare]|[Dhruv Gujar]|[Bhushan Lanje]|[Rahul Hajare].
    </div>
</footer>

<script>
function openBranchPage(branchName) {
    window.location.href = "frontpage.html?branch=" + encodeURIComponent(branchName);
}
</script>

</body>
</html>
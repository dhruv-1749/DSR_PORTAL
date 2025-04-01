<!DOCTYPE html>
<html>
<head>
    <title>Welcome to DSR</title>
    <style>
        /* ===== BASE STYLES ===== */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow: hidden;
        }

        /* ===== ANIMATED BACKGROUND ELEMENTS ===== */
        body::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(0,123,255,0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
            z-index: -1;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* ===== MAIN CONTAINER ===== */
        .container {
            background: rgba(0, 123, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            text-align: center;
            max-width: 400px;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .container::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #007bff, #00b4ff, #007bff);
            z-index: -1;
            border-radius: 16px;
            opacity: 0.7;
            animation: borderGlow 3s linear infinite;
        }

        @keyframes borderGlow {
            0% { filter: blur(5px); opacity: 0.7; }
            50% { filter: blur(7px); opacity: 0.4; }
            100% { filter: blur(5px); opacity: 0.7; }
        }

        /* ===== HEADING ===== */
        h1 {
            font-size: 2.5rem;
            margin-bottom: 30px;
            font-weight: 700;
            background: linear-gradient(to right, #fff, #cce7ff);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        /* ===== LINK BUTTON ===== */
        a {
            display: inline-block;
            background: linear-gradient(to right, #fff, #e6f2ff);
            color: #007bff;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
            position: relative;
            overflow: hidden;
            border: none;
            cursor: pointer;
        }

        a:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
            color: #0056b3;
        }

        a:active {
            transform: translateY(0);
        }

        a::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, transparent, rgba(255,255,255,0.3), transparent);
            transform: translateX(-100%);
            transition: transform 0.6s ease;
        }

        a:hover::after {
            transform: translateX(100%);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to DSR</h1>
        <!-- Original file path preserved -->
        <a href="index.html">Click here</a>
    </div>
</body>
</html>
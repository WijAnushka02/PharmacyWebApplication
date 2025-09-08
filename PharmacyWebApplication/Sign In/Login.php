<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - AXR Pharmacy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* General Body and Fonts */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
            background-image: url('blurred-pharmacy-background.jpg'); /* Replace with your image path */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        /* Header and Navigation Bar Styling */
        .header {
            background-color: #2e7d32;
            color: white;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header .logo {
            display: flex;
            align-items: center;
            font-size: 1.2em;
            font-weight: bold;
        }

        .header .logo img {
            height: 40px;
            margin-right: 10px;
        }

        .header .search-bar {
            position: relative;
            display: flex;
            align-items: center;
        }

        .header .search-bar input {
            border: none;
            padding: 8px 30px 8px 15px;
            border-radius: 20px;
            outline: none;
            background-color: white;
        }

        .header .search-bar .fa-search {
            position: absolute;
            right: 15px;
            color: #555;
        }

        .top-nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
        }

        .top-nav li {
            margin-left: 20px;
        }

        .top-nav a {
            text-decoration: none;
            color: white;
            font-weight: bold;
            display: flex;
            align-items: center;
            transition: color 0.3s;
        }

        .top-nav a:hover {
            color: #d4e8d5;
        }

        .top-nav a i {
            margin-right: 5px;
        }

        .main-nav {
            background-color: #216124;
            padding: 10px 20px;
        }

        .main-nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: space-between;
        }

        .main-nav a {
            text-decoration: none;
            color: white;
            font-weight: bold;
            display: flex;
            align-items: center;
            transition: background-color 0.3s;
            padding: 10px 15px;
        }

        .main-nav a:hover {
            background-color: #1a4d1d;
        }

        /* Main Content and Login Form Styling */
        .main-content {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 50px 20px;
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
        }

        .login-box h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 1em;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            font-size: 0.9em;
        }

        .form-options a {
            color: #2e7d32;
            text-decoration: none;
            transition: color 0.3s;
        }

        .form-options a:hover {
            color: #1a4d1d;
        }

        .sign-in-button {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 8px;
            background-color: #2e7d32;
            color: white;
            font-size: 1.1em;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .sign-in-button:hover {
            background-color: #216124;
        }

        .or-divider {
            text-align: center;
            position: relative;
            margin: 30px 0;
            color: #777;
            font-size: 0.9em;
        }

        .or-divider::before, .or-divider::after {
            content: '';
            position: absolute;
            width: 40%;
            height: 1px;
            background-color: #ddd;
            top: 50%;
        }

        .or-divider::before {
            left: 0;
        }

        .or-divider::after {
            right: 0;
        }

        .social-login {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .social-button {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            font-size: 1em;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: background-color 0.3s;
        }

        .google-button {
            background-color: #fff;
            color: #333;
        }

        .google-button i {
            color: #db4437; /* Google red */
        }

        .facebook-button {
            background-color: #1877f2;
            color: white;
            border: 1px solid #1877f2;
        }

        .facebook-button i {
            color: white;
        }

        .signup-link {
            text-align: center;
            margin-top: 25px;
            font-size: 0.9em;
        }

        .signup-link a {
            color: #2e7d32;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        .signup-link a:hover {
            color: #1a4d1d;
        }

        /* Footer Styling */
        .footer {
            background-color: #2e7d32;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .footer-row {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 30px;
            margin-bottom: 20px;
        }

        .footer-item {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .footer-item i {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .contact-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
        }

        .contact-info h3 {
            margin-bottom: 10px;
        }

        .contact-info p {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 5px 0;
        }

        .copyright {
            font-size: 0.8em;
            color: #b0c9b1;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <?php
        // This is a very basic example and is NOT secure for a real application.
        // For a real-world project, you need to use a database and password hashing.

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);

            // Dummy credentials for demonstration purposes
            $valid_email = "test@example.com";
            $valid_password = "password123";
            $message = "";

            if ($email === $valid_email && $password === $valid_password) {
                // Successful login - In a real app, you would start a session here
                $message = "<div style='color: green; text-align: center; margin-bottom: 15px;'>Login successful!</div>";
                // Redirect to a user dashboard, e.g., header("Location: dashboard.php");
            } else {
                // Failed login
                $message = "<div style='color: red; text-align: center; margin-bottom: 15px;'>Invalid email or password.</div>";
            }
        }
    ?>

    <header class="header">
        <div class="logo">
            <img src="logo.png" alt="AXR Pharmacy Logo">
            <span>AXR PHARMACY</span>
        </div>
        <div class="search-bar">
            <input type="text" placeholder="Search">
            <i class="fas fa-search"></i>
        </div>
        <nav class="top-nav">
            <ul>
                <li><a href="#"> <i class="fas fa-tags"></i> Offers</a></li>
                <li><a href="#"> <i class="fas fa-shopping-cart"></i> Cart</a></li>
                <li><a href="#"> <i class="fas fa-user"></i> Sign In</a></li>
                <li><a href="#">Sign Up</a></li>
            </ul>
        </nav>
    </header>

    <nav class="main-nav">
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Medications <i class="fas fa-caret-down"></i></a></li>
            <li><a href="#">Prescriptions <i class="fas fa-caret-down"></i></a></li>
            <li><a href="#">Inventory <i class="fas fa-caret-down"></i></a></li>
            <li><a href="#">Orders <i class="fas fa-caret-down"></i></a></li>
            <li><a href="#">Admin <i class="fas fa-caret-down"></i></a></li>
            <li><a href="#">Support <i class="fas fa-caret-down"></i></a></li>
        </ul>
    </nav>

    <main class="main-content">
        <div class="login-container">
            <div class="login-box">
                <h2>Sign In</h2>
                <?php if (isset($message)) echo $message; ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="someone@gamil.com">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="At least 8 characters">
                    </div>
                    <div class="form-options">
                        <label>
                            <input type="checkbox" name="remember-me"> Remember Me
                        </label>
                        <a href="#">Forgot Password?</a>
                    </div>
                    <button type="submit" class="sign-in-button">Sign In</button>
                    <div class="or-divider">Or</div>
                </form>
                <div class="social-login">
                    <button class="social-button google-button">
                        <i class="fab fa-google"></i> Sign in with Google
                    </button>
                    <button class="social-button facebook-button">
                        <i class="fab fa-facebook"></i> Sign in with Facebook
                    </button>
                </div>
                <div class="signup-link">
                    Don't you have an account? <a href="#">Sign Up</a>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="footer-row">
            <div class="footer-item">
                <i class="fas fa-truck"></i>
                <p>FREE DELIVERY</p>
            </div>
            <div class="footer-item">
                <i class="fas fa-stethoscope"></i>
                <p>NEW MEDICAL ENCOUNTER</p>
            </div>
            <div class="footer-item">
                <i class="fas fa-shield-alt"></i>
                <p>MEDICAL GUARANTEED</p>
            </div>
        </div>
        <div class="footer-row contact-info">
            <h3>Contact Info</h3>
            <p><i class="fas fa-map-marker-alt"></i> Address</p>
            <p><i class="fas fa-phone"></i> +94 75 256 5423</p>
            <p><i class="fas fa-envelope"></i> someone@gmail.com</p>
        </div>
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 text-center text-sm text-[var(--text-secondary)]">
            © 2025 MediCare. All rights reserved.
        </div>
        </div>
    </footer>

</div>

</body>
</html>
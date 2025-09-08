<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - AXR Pharmacy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* General Body and Fonts */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
            background-image: url('blurred-pharmacy-background.jpg'); /* Replace with your background image path */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        /* Header and Navigation Bar Styling (reused from previous design) */
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

        /* Main Content for Category Selection */
        .main-content {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 50px 20px;
            min-height: calc(100vh - 180px); /* Adjust based on header/footer height */
        }

        .category-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            width: 100%;
            text-align: center;
        }

        .category-container h2 {
            color: #2e7d32;
            margin-bottom: 10px;
            font-size: 2.2em;
        }

        .category-container p {
            color: #555;
            margin-bottom: 30px;
            font-size: 1.1em;
        }

        .category-buttons {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .category-button {
            width: 100%;
            padding: 18px;
            border: none;
            border-radius: 8px;
            background-color: #3f51b5; /* A primary blue color */
            color: white;
            font-size: 1.3em;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .category-button:hover {
            background-color: #303f9f;
            transform: translateY(-2px);
        }

        /* Footer Styling (reused from previous design) */
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
        <div class="category-container">
            <h2>Sign Up</h2>
            <p>Choose the relevant category,</p>
            <div class="category-buttons">
                <button class="category-button" onclick="redirectToSignUp('admin')">Admin</button>
                <button class="category-button" onclick="redirectToSignUp('staff')">Staff</button>
                <button class="category-button" onclick="redirectToSignUp('customer')">Customer</button>
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

    <script>
        function redirectToSignUp(userType) {
            // In a real application, you would redirect to a specific signup form
            // based on the userType. For example:
            // window.location.href = `signup_${userType}.php`;
            alert(`Redirecting to ${userType} signup form... (This is a placeholder)`);
            // Example:
            // if (userType === 'admin') {
            //     window.location.href = 'signup_admin.php';
            // } else if (userType === 'staff') {
            //     window.location.href = 'signup_staff.php';
            // } else if (userType === 'customer') {
            //     window.location.href = 'signup_customer.php';
            // }
        }
    </script>

</body>
</html>
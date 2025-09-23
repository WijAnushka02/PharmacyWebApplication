<?php

    // Database configuration
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Pharmacy_db";

    // Create a new database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $message = "";

    // Process form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];
        
        // Basic validation
        if (empty($firstName) || empty($lastName) || empty($phone) || empty($address) || empty($email) || empty($password) || empty($confirmPassword)) {
            $message = "<div style='color: red; text-align: center; margin-bottom: 15px;'>Please fill in all fields.</div>";
        } elseif ($password !== $confirmPassword) {
            $message = "<div style='color: red; text-align: center; margin-bottom: 15px;'>Passwords do not match.</div>";
        } else {
            // Check if the table 'patient_users' exists.
            $tableCheckQuery = "SHOW TABLES LIKE 'patient_users'";
            $tableResult = $conn->query($tableCheckQuery);

            if ($tableResult->num_rows == 0) {
                // If the table doesn't exist, create it.
                $createTableSql = "CREATE TABLE patient_users (
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    first_name VARCHAR(50) NOT NULL,
                    last_name VARCHAR(50) NOT NULL,
                    phone VARCHAR(20) NOT NULL,
                    address TEXT NOT NULL,
                    email VARCHAR(100) NOT NULL,
                    password VARCHAR(255) NOT NULL,
                    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                )";

                if ($conn->query($createTableSql) === TRUE) {
                    $message .= "<div style='color: green; text-align: center; margin-bottom: 5px;'>Table 'patient_users' created successfully.</div>";
                } else {
                    $message .= "<div style='color: red; text-align: center; margin-bottom: 5px;'>Error creating table: " . $conn->error . "</div>";
                }
            }
            
            // Hash the password for security
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // SQL query to insert data into the 'patient_users' table.
            // Use a prepared statement to prevent SQL injection
            $insertSql = "INSERT INTO patient_users (first_name, last_name, phone, address, email, password) VALUES (?, ?, ?, ?, ?, ?)";
            
            $stmt = $conn->prepare($insertSql);
            $stmt->bind_param("ssssss", $firstName, $lastName, $phone, $address, $email, $hashedPassword);

            if ($stmt->execute()) {
                $message .= "<div style='color: green; text-align: center; margin-bottom: 15px;'>Customer account created successfully!</div>";
            } else {
                $message .= "<div style='color: red; text-align: center; margin-bottom: 15px;'>Error: " . $stmt->error . "</div>";
            }

            $stmt->close();
        }
    }
    // Close the database connection
    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>MediCare Pharmacy - Patient Sign Up</title>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <style type="text/tailwindcss">
        :root {
            --primary-color: #34D399;
            --secondary-color: #f0fdf4;
            --background-color: #2b9e4d;
            --text-primary: #1a202c;
            --text-secondary: #4b5563;
            --accent-color: #06441d;
        }
        body {
            font-family: "Inter", sans-serif;
            background-color: var(--background-color);
            color: var(--text-primary);
        }
        
        /* Updated Navigation CSS for dropdown */
        .dropdown {
            position: relative;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 10;
            border-radius: 4px;
            top: calc(100% + 8px); /* Position below the link */
            left: 50%;
            transform: translateX(-50%);
            white-space: nowrap;
        }
        .dropdown-content a {
            color: var(--text-primary);
            padding: 12px 16px;
            display: block;
            text-align: left;
            transition: background-color 0.3s;
        }
        .dropdown-content a:hover {
            background-color: var(--secondary-color);
        }
        .dropdown-content.active {
            display: block;
        }
        
        /* Main content and form styling */
        .main-content {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 50px 20px;
            min-height: calc(100vh - 180px);
        }

        .signup-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            width: 100%;
        }

        .signup-container h2 {
            color: var(--accent-color);
            text-align: center;
            font-size: 1.8em;
            margin-bottom: 5px;
        }

        .signup-container p {
            color: var(--text-secondary);
            text-align: center;
            margin-bottom: 25px;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        .form-group.full-width {
            flex: none;
            width: 100%;
        }

        .form-group label {
            font-weight: bold;
            margin-bottom: 5px;
            color: var(--text-secondary);
        }

        .form-group input, .form-group textarea {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1em;
            width: 100%;
            box-sizing: border-box;
            background-color: white; /* Ensure consistent background */
            color: var(--text-primary);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .signup-button {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 8px;
            background-color: var(--primary-color);
            color: white;
            font-size: 1.1em;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .signup-button:hover {
            background-color: #27ae60;
        }

        /* Footer styling to match new design */
        .footer {
            background-color: #f0f2f5;
            color: #4b5563;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
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
            color: var(--primary-color);
        }
        
        .contact-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
        }

        .contact-info h3 {
            margin-bottom: 10px;
            color: var(--primary-color);
        }

        .contact-info p {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 5px 0;
            color: white;
        }

        .copyright {
            font-size: 0.8em;
            color: var(--text-secondary);
            margin-top: 20px;
        }
    </style>
</head>
<body class="bg-[var(--background-color)] text-[var(--text-primary)] min-h-screen flex flex-col">
    <header class="border-b border-gray-200">
        <div class="container mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-8">
                <a class="flex items-center gap-2 text-[var(--text-primary)]" href="#">
                    <svg class="h-8 w-8 text-[var(--primary-color)]" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.5 14h-3v-3.5a1.5 1.5 0 00-3 0V16h-3V8.5a.5.5 0 011 0V11h2.5a.5.5 0 01.5.5v2.5h2V16zm-1.5-6h-4V8h4v2z"></path>
                    </svg>
                    <h1 class="text-2xl font-bold">MediCare</h1>
                </a>
                <nav class="hidden items-center gap-6 lg:flex">
                    <a class="text-sm font-medium text-[var(--text-secondary)] hover:text-[var(--primary-color)]" href="#">Home</a>
                    <div class="dropdown">
                        <a class="text-sm font-medium text-[var(--text-secondary)] hover:text-[var(--primary-color)]" href="#" onclick="toggleDropdown(event)">Medications</a>
                        <div class="dropdown-content">
                            <a href="#">Search</a>
                            <a href="#">Categories</a>
                        </div>
                    </div>
                    <div class="dropdown">
                        <a class="text-sm font-medium text-[var(--text-secondary)] hover:text-[var(--primary-color)]" href="#" onclick="toggleDropdown(event)">Prescriptions</a>
                        <div class="dropdown-content">
                            <a href="#">Upload</a>
                            <a href="#">History</a>
                        </div>
                    </div>
                    <div class="dropdown">
                        <a class="text-sm font-medium text-[var(--text-secondary)] hover:text-[var(--primary-color)]" href="#" onclick="toggleDropdown(event)">Inventory</a>
                        <div class="dropdown-content">
                            <a href="#">Stock</a>
                            <a href="#">Expiry</a>
                        </div>
                    </div>
                    <div class="dropdown">
                        <a class="text-sm font-medium text-[var(--text-secondary)] hover:text-[var(--primary-color)]" href="#" onclick="toggleDropdown(event)">Orders</a>
                        <div class="dropdown-content">
                            <a href="#">Pending</a>
                            <a href="#">History</a>
                        </div>
                    </div>
                    <div class="dropdown">
                        <a class="text-sm font-medium text-[var(--text-secondary)] hover:text-[var(--primary-color)]" href="#" onclick="toggleDropdown(event)">Admin</a>
                        <div class="dropdown-content">
                            <a href="../Admin/Users/user_list.php">Users</a>
                            <a href="../Admin/Settings/add_user1.php">Settings</a>
                        </div>
                    </div>
                    <div class="dropdown">
                        <a class="text-sm font-medium text-[var(--text-secondary)] hover:text-[var(--primary-color)]" href="#" onclick="toggleDropdown(event)">Support</a>
                        <div class="dropdown-content">
                            <a href="../Support/FAQ/faq.html">FAQ</a>
                            <a href="../Support/Contact/contact.html">Contact</a>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="flex items-center gap-4">
                <div class="relative hidden sm:block">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg aria-hidden="true" class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" fill-rule="evenodd"></path>
                        </svg>
                    </span>
                    <input class="block w-full rounded-md border-gray-300 bg-gray-50 py-2 pl-10 pr-3 text-sm placeholder-gray-500 focus:border-[var(--primary-color)] focus:bg-white focus:text-gray-900 focus:outline-none focus:ring-1 focus:ring-[var(--primary-color)] sm:text-sm" placeholder="Search" type="search"/>
                </div>
                <div class="hidden items-center gap-2 md:flex">
                    <a class="rounded-md bg-[var(--secondary-color)] px-4 py-2 text-sm font-medium text-[var(--primary-color)] hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] focus:ring-opacity-50 transition-colors duration-200" href="../Offers/offers.html">Offers</a>
                    <a class="rounded-md bg-[var(--primary-color)] px-4 py-2 text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] focus:ring-opacity-50 transition-colors duration-200" href="../Sign In/Login.php">Sign In</a>
                    <a class="rounded-md border border-[var(--primary-color)] px-4 py-2 text-sm font-medium text-[var(--primary-color)] hover:bg-[var(--secondary-color)] focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] focus:ring-opacity-50 transition-colors duration-200" href="../Sign Up/signup_main.php">Sign Up</a>
                </div>
                <button class="relative rounded-full bg-gray-100 p-2 text-gray-600 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] focus:ring-offset-2">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-[var(--primary-color)] text-xs text-white">0</span>
                </button>
                <button class="p-2 text-gray-500 hover:text-gray-700 lg:hidden">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 6h16M4 12h16m-7 6h7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                </button>
            </div>
        </div>
    </header>
    <main class="main-content">
        <div class="signup-container">
            <h2>Patient Page - Sign Up</h2>
            <p>Fill out all the details below,</p>
            <?php if (isset($message)) echo $message; ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="form-row">
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" placeholder="Enter First Name">
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" placeholder="Enter Last Name">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" placeholder="Enter Your Phone Number">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" placeholder="Enter Your Address Here"></textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group full-width">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="someone@gamil.com">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="At least 8 characters">
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Password (Re-Enter)</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="At least 8 characters">
                    </div>
                </div>
                <div class="form-row">
                    <button type="submit" class="signup-button">Sign Up</button>
                </div>
            </form>
        </div>
    </main>
    
    <footer class="footer">
        <div class="container mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-baseline justify-between">
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold text-gray-800">MediCare Pharmacy</h2>
                    <p class="text-sm text-[var(--text-secondary)]">123 Health St, Wellness City, 12345</p>
                    <p class="text-sm text-[var(--text-secondary)]">Phone: (123) 456-7890</p>
                    <p class="text-sm text-[var(--text-secondary)]">Email: contact@medicare.com</p>
                </div>
                <nav aria-label="Footer" class="-mx-5 -my-2 flex flex-wrap justify-center">
                    <div class="px-5 py-2"><a class="text-base text-gray-500 hover:text-gray-900" href="#">Contact Us</a></div>
                    <div class="px-5 py-2"><a class="text-base text-gray-500 hover:text-gray-900" href="#">Privacy Policy</a></div>
                    <div class="px-5 py-2"><a class="text-base text-gray-500 hover:text-gray-900" href="#">Terms of Service</a></div>
                </nav>
                <div class="mt-8 flex justify-center space-x-6 md:mt-0">
                    <a class="text-gray-400 hover:text-gray-500" href="#">
                        <span class="sr-only">Facebook</span>
                        <svg aria-hidden="true" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path clip-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" fill-rule="evenodd"></path>
                        </svg>
                    </a>
                    <a class="text-gray-400 hover:text-gray-500" href="#">
                        <span class="sr-only">Instagram</span>
                        <svg aria-hidden="true" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path clip-rule="evenodd" d="M12.315 2c-4.062 0-4.575.018-6.174.089C4.403 2.158 3.117 2.5 2.18 3.437c-.937.938-1.278 2.224-1.347 3.965C.768 9.098.75 9.61.75 12.315c0 2.705.018 3.217.089 4.816.07 1.741.41 3.027 1.348 3.965.937.937 2.223 1.278 3.965 1.347 1.6.07 2.112.088 4.816.088s3.217-.018 4.816-.088c1.741-.07 3.027-.41 3.965-1.348.937-.937 1.278-2.223 1.347-3.965.07-1.6.088-2.112.088-4.816s-.018-3.217-.088-4.816c-.07-1.741-.41-3.027-1.348-3.965C20.902 2.5 19.616 2.158 17.875 2.09C16.275 2.018 15.762 2 12.315 2zm0 1.802c4.004 0 4.475.016 6.06.086 1.463.066 2.305.358 2.87.824.642.545.96 1.27.995 2.182.07 1.585.086 2.057.086 5.225s-.016 3.64-.086 5.225c-.035.912-.353 1.637-.995 2.182-.565.466-1.407.758-2.87.824-1.585.07-2.056.086-6.06.086s-4.475-.016-6.06-.086c-1.463-.066-2.305-.358-2.87-.824-.642-.545-.96-1.27-.995-2.182-.07-1.585-.086-2.057-.086-5.225s.016-3.64.086-5.225c.035-.912.353-1.637.995-2.182.565-.466 1.407-.758 2.87-.824 1.585-.07 2.056-.086 6.06-.086zM12.315 7.1a5.215 5.215 0 100 10.43 5.215 5.215 0 000-10.43zm0 8.628a3.413 3.413 0 110-6.826 3.413 3.413 0 010 6.826zm5.225-9.332a1.23 1.23 0 100 2.46 1.23 1.23 0 000-2.46z" fill-rule="evenodd"></path>
                        </svg>
                    </a>
                    <a class="text-gray-400 hover:text-gray-500" href="#">
                        <span class="sr-only">Twitter</span>
                        <svg aria-hidden="true" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.71v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="mt-8 border-t border-gray-200 pt-8 text-center">
                <p class="text-base text-gray-400">© 2025 MediCare Pharmacy. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <script>
        function toggleDropdown(event) {
            event.preventDefault();
            const dropdownContent = event.target.nextElementSibling;
            
            // Close all other dropdowns
            document.querySelectorAll('.dropdown-content.active').forEach(openDropdown => {
                if (openDropdown !== dropdownContent) {
                    openDropdown.classList.remove('active');
                }
            });

            // Toggle the 'active' class on the clicked dropdown
            dropdownContent.classList.toggle('active');
        }

        // Close dropdowns if the user clicks outside
        window.onclick = function(event) {
            if (!event.target.matches('.dropdown a')) {
                const dropdowns = document.querySelectorAll('.dropdown-content');
                dropdowns.forEach(dropdown => {
                    if (dropdown.classList.contains('active')) {
                        dropdown.classList.remove('active');
                    }
                });
            }
        }
    </script>
</body>
</html>
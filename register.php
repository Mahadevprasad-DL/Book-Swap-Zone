<?php
// register.php

// Start session
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'bookstore');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = '';

// Registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    if (empty($username) || empty($lastname) || empty($email) || empty($password)) {
        $error = 'Please fill in all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare("INSERT INTO users (username, lastname, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $lastname, $email, $hashed_password);
        
        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            $error = 'Registration failed. Try again.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register</title>
<style>
    /* Background and Layout */
    body {
        font-family: Arial, sans-serif;
        background-image: url('images/back.jpg'); /* Replace 'back.jpg' with your image path */
        background-size: cover;
        background-position: center;
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 100vh;
        padding: 0 5%;
        color: #fff;
    }

    /* Left Side Title and Message */
    .left-content {
        max-width: 45%;
        margin-bottom: 170px;
    }

    .left-content h1 {
        font-size: 42px;
        font-weight: bold;
        line-height: 1.2;
        color: #ffe06c;
        margin-bottom: 15px;
    }

    .left-content p {
        font-size: 20px;
        color: #fffae3;
        margin-top: 10px;
    }

    /* Registration Container */
    .container {
        width: 100%;
        max-width: 400px;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        animation: fadeIn 1.2s ease-in-out;
        background-color: rgba(255, 255, 255, 0.85); 
        margin-bottom: 190px;/* Slight transparency */
    }

    /* Animation for the container */
    @keyframes fadeIn {
        0% { opacity: 0; transform: translateX(50px); }
        100% { opacity: 1; transform: translateX(0); }
    }

    /* Form Styles */
    h2 { 
        text-align: center; 
        color: #333; 
    }

    form { 
        display: flex; 
        flex-direction: column; 
    }

    input[type="text"], input[type="email"], input[type="password"] {
        padding: 10px;
        margin: 8px 0;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    button {
        padding: 10px;
        border: none;
        background: #4CAF50;
        color: #fff;
        cursor: pointer;
        border-radius: 5px;
        margin-top: 10px;
    }

    button:hover {
        background: #45a049;
    }

    /* Error Message */
    .error {
        color: red;
        text-align: center;
    }

    /* Link to login */
    .login-link {
        text-align: center;
        color: #333;
        font-size: 14px;
        margin-top: 10px;
    }
    .login-link a {
        color: #4CAF50;
        text-decoration: none;
    }
    .login-link a:hover {
        text-decoration: underline;
    }

    .header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    display: flex;
    justify-content: flex-start;
    align-items: center;
    padding: 10px 20px;
    z-index: 10;
}

.header a {
    text-decoration: none;
    color: #000;
    margin-right: 50px; /* Increased space between links */
    font-size: 20px; /* Increased font size */
    font-weight: bold;
    margin-top: 15px;
}

.header a:hover {
    color: #007BFF;
}

</style>
</head>
<body>

<div class="header">
    <a href="about.html">About Us</a>
    <a href="contact.html">Contact Us</a>
    <a href="services.html">Services</a>
</div>


<!-- Left Side with Title and Message -->
<div class="left-content">
    <h1>The Digital Platform for Exchange Of Pre-owned Books</h1>
    <p>Discover a world of stories and knowledge. Join our community and start your journey with us!</p>
</div>

<!-- Registration Form Container -->
<div class="container">
    <h2>Register</h2>
    <?php if ($error): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>
    <form action="register.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="text" name="lastname" placeholder="Last Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
        <p class="login-link">Already have an account? <a href="login.php">Login here</a></p>
    </form>
</div>

</body>
</html>

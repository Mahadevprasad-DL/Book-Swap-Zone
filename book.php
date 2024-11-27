<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bookstore";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch books from the database
$sql = "SELECT * FROM inventory LIMIT 6"; // Adjust the LIMIT to display more books
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(to right, #f0f8ff, #e0f7fa);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }
        .header .nav-links {
            display: flex;
            gap: 20px;
        }
        .header .nav-links a {
            text-decoration: none;
            color: white;
            font-weight: bold;
            transition: color 0.3s;
        }
        .header .nav-links a:hover {
            color: #ddd;
        }
        .logout-btn {
            background-color: #ff4d4d;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .logout-btn:hover {
            background-color: #d93636;
        }
        h1 {
            color: #333;
            margin-top: 70px;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(-20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .book-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); /* Smaller container size */
            gap: 30px; /* Increased spacing between items */
            margin-top: 30px;
            animation: fadeIn 1s ease-in-out;
        }
        .book-item {
            border: 1px solid #ccc;
            padding: 10px; /* Reduced padding */
            border-radius: 10px;
            text-align: center;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .book-item:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .book-item img {
            width: 80px; /* Reduced image size */
            height: 120px; /* Adjusted image height */
            object-fit: cover;
            margin-bottom: 10px;
            border-radius: 5px;
            transition: transform 0.3s;
        }
        .book-item img:hover {
            transform: scale(1.1);
        }
        .book-item h3 {
            font-size: 18px; /* Smaller font size for the title */
            color: #007BFF;
            margin-bottom: 8px;
        }
        .book-item p {
            font-size: 12px; /* Smaller font size for details */
            color: #666;
            margin: 5px 0;
        }
        .quantity-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .add-to-cart {
            background-color: #28a745;
            color: white;
            padding: 8px 12px; /* Reduced button padding */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .add-to-cart:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="header">
    <div class="nav-links">
        <a href="book.php">Available Books</a>
        <a href="browse.php">Browse Books</a>
        <a href="categories.php">Categories</a>
    </div>
    <a href="logout.php" class="logout-btn">Logout</a>
</div>

<h1>"Immediately available books"</h1>
<div class="book-list">
    <?php
    if ($result->num_rows > 0) {
        // Inside the while loop where you display each book
    while ($row = $result->fetch_assoc()) {
    echo "<div class='book-item'>";
    echo "<img src='" . $row['image'] . "' alt='" . $row['title'] . "'>";
    echo "<h3>" . $row['title'] . "</h3>";
    echo "<p>ISBN: " . $row['isbn'] . "</p>";
    echo "<p>Price: $" . $row['price'] . "</p>";
    echo "<p>Author: " . $row['author'] . "</p>";
    echo "<div class='quantity-container'>";
    echo "<form action='pay2.html' method='get'>"; // Change to GET method and pay2.html
    echo "<input type='hidden' name='book_name' value='" . $row['title'] . "'>";
    echo "<input type='hidden' name='book_price' value='" . $row['price'] . "'>";
    echo "<button type='submit' class='add-to-cart'>Buy</button>";
    echo "</form>";
    echo "</div>";
    echo "</div>";
}
    } else {
        echo "<p>No books available.</p>";
    }
    ?>
</div>

</body>
</html>

<?php
$conn->close();
?>

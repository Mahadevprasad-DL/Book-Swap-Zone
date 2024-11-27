<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "bookstore");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch books from the database (15 books for this example)
$sql = "SELECT * FROM books LIMIT 15";
$result = $conn->query($sql);

if (!$result) {
    die("Error fetching books: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #f0f8ff;
        }
        /* Header styles */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
        }
        .header .nav-links {
            display: flex;
            gap: 20px;
        }
        .header .nav-links a {
            text-decoration: none;
            color: white;
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
            margin-bottom: 30px;
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(-20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .book-list {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            width: 100%;
            max-width: 1200px;
            animation: fadeIn 1s ease-in-out;
            margin-top: 30px;
        }
        .book-item {
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            animation: popUp 0.5s ease-in-out;
        }
        @keyframes popUp {
            0% { transform: scale(0.9); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        .book-item:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }
        .book-item img {
            width: 100px;
            height: 150px;
            object-fit: cover;
            margin-bottom: 10px;
            border-radius: 5px;
            transition: transform 0.3s;
        }
        .book-item img:hover {
            transform: scale(1.1);
        }
        .book-item h3 {
            font-size: 20px;
            color: #333;
            margin-bottom: 8px;
        }
        .book-item p {
            font-size: 14px;
            color: #666;
            margin: 5px 0;
        }
    </style>
</head>
<body>

<div class="header">
    <div class="nav-links">
        <a href="add_books.php">Add Books</a>
        
        <a href="arrivals.php">New Arrivals</a>
    </div>
    <a href="logout.php" class="logout-btn">Logout</a>
</div>

<div class="book-list">
    <?php while ($book = $result->fetch_assoc()): ?>
        <div class="book-item">
            <img src="images/<?php echo $book['image']; ?>" alt="<?php echo $book['title']; ?>">
            <h3><?php echo $book['title']; ?></h3>
            <p>ISBN: <?php echo $book['isbn']; ?></p>
            <p>Author: <?php echo $book['author']; ?></p>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>

<?php
$conn->close();
?>

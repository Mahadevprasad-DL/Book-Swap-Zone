<?php
// Database Connection
$conn = new mysqli("localhost", "root", "", "bookstore");

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process Favorite Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'add_favorite') {
    $bookName = $conn->real_escape_string($_POST['book_name']);
    $bookImage = $conn->real_escape_string($_POST['book_image']);

    // Insert into favorites table
    $sql = "INSERT INTO favorites (book_name, book_image) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $bookName, $bookImage);
    if ($stmt->execute()) {
        echo "<script>alert('Book added to favorites successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
    $stmt->close();
}

// Process Book Removal
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'remove_favorite') {
    $bookId = intval($_POST['book_id']);
    // Delete from favorites table
    $sql = "DELETE FROM favorites WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bookId);
    if ($stmt->execute()) {
        echo "<script>alert('Book removed from favorites!');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
    $stmt->close();
}

// Fetch Favorite Books
$sql = "SELECT * FROM favorites";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorite Books</title>
    <style>
        /* Header Styles */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #007bff;
            padding: 15px 20px;
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
        }

        /* Navigation Links */
        .nav-links {
            display: flex;
            gap: 20px;
            justify-content: flex-end; /* Align the links to the right */
            flex-grow: 1;
        }
        .nav-links a {
            text-decoration: none;
            color: white;
            font-size: 16px;
            padding: 10px 20px;
            background-color: #007BFF;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .nav-links a:hover {
            background-color: #0056b3;
        }

        /* Page Styles */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            padding-top: 80px;
            background-color: #f8f9fa;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .books {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 20px;
        }
        .book {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 200px;
            text-align: center;
            transform: scale(1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .book:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        }
        .book img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }
        .book h3 {
            margin: 10px 0;
            font-size: 18px;
            color: #333;
        }
        .remove-btn {
            display: inline-block;
            margin-top: 10px;
            padding: 5px 10px;
            background-color: #dc3545;
            color: white;
            font-size: 14px;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .remove-btn:hover {
            background-color: #c82333;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .book {
            animation: fadeIn 0.8s ease-in-out;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-container">
            <h1>Bookstore Favorites</h1>
            <nav class="nav-links">
                <a href="donate.php">Donate</a>
                <a href="search.php">Search Books</a>
            </nav>
        </div>
    </div>

    <h1>Your Favorite Books</h1>
    <div class="books">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="book">
                <img src="<?= $row['book_image']; ?>" alt="<?= $row['book_name']; ?>">
                <h3><?= $row['book_name']; ?></h3>
                <!-- Remove Button Form -->
                <form method="POST">
                    <input type="hidden" name="book_id" value="<?= $row['id']; ?>">
                    <input type="hidden" name="action" value="remove_favorite">
                    <button type="submit" class="remove-btn">Remove</button>
                    <a href="pay2.html" class="remove-btn">Buy</a> 
                </form>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>

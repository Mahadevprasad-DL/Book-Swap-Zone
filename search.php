<?php
// Database Connection
$conn = new mysqli("localhost", "root", "", "bookstore");

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Search Query
$searchQuery = isset($_POST['search']) ? $_POST['search'] : '';
$sql = "SELECT * FROM searchbooks WHERE book_name LIKE ?";
$stmt = $conn->prepare($sql);
$likeQuery = "%$searchQuery%";
$stmt->bind_param("s", $likeQuery);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Books</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

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

        .nav-links {
            display: flex;
            gap: 15px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: #ffcc00;
        }

        .container {
            max-width: 1200px;
            margin: 100px auto 30px; /* Added top margin for gap */
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .search-bar {
            margin-bottom: 20px;
            text-align: center;
        }

        .search-bar input[type="text"] {
            width: 60%;
            padding: 10px;
            font-size: 16px;
        }

        .search-bar input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .books {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .book {
            position: relative;
            border: 1px solid #ddd;
            border-radius: 8px;
            width: 30%;
            padding: 10px;
            text-align: center;
            background-color: #fff;
        }

        .book img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .book h3 {
            font-size: 18px;
            margin: 10px 0;
        }

        .favorite-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 30px;
            color: red;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .favorite-icon:hover {
            transform: scale(1.2);
        }

        .details-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .details-btn:hover {
            background-color: #0056b3;
        }

        .favorites-container {
            margin-top: 30px;
            padding: 20px;
            background: #f1f1f1;
            border-radius: 8px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .favorite-book {
            width: 22%;
            text-align: center;
        }

        .favorite-book img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            max-width: 400px;
            text-align: center;
            position: relative;
        }

        .modal-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 20px;
            color: red;
        }

        .buy-btn {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .buy-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="header">
    <div class="header-container">
        <h1>Search Books</h1>
        <nav class="nav-links">
            <a href="donate.php">Donate</a>
            <a href="favorite.php">Favorite</a>
        </nav>
    </div>
</div>

<div class="container">
    <div class="search-bar">
        <form method="POST">
            <input type="text" name="search" placeholder="Search for Book name" value="<?= htmlspecialchars($searchQuery); ?>">
            <input type="submit" value="Search">
        </form>
    </div>

    <div class="books">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="book">
                <form method="POST" action="favorite.php">
                    <input type="hidden" name="book_name" value="<?= $row['book_name']; ?>">
                    <input type="hidden" name="book_image" value="<?= $row['book_image']; ?>">
                    <button type="submit" class="favorite-icon">&#9829;</button>
                </form>
                <img src="<?= $row['book_image']; ?>" alt="<?= $row['book_name']; ?>">
                <h3><?= $row['book_name']; ?></h3>
                <button class="details-btn" onclick="showDetails(<?= htmlspecialchars(json_encode($row)); ?>)">Details</button>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<!-- Modal -->
<div id="bookModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <img id="modalImage" src="" alt="">
        <h3 id="modalName"></h3>
        <a href="pay2.html"><button class="buy-btn">Buy</button></a>
                <a href="pay2.html"><button class="buy-btn">Buy</button></a>

    </div>
</div>

<script>
    function showDetails(book) {
        const modal = document.getElementById('bookModal');
        document.getElementById('modalImage').src = book.book_image;
        document.getElementById('modalName').textContent = book.book_name;
        modal.style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('bookModal').style.display = 'none';
    }
</script>

</body>
</html>

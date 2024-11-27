<?php
// Database Connection
$conn = new mysqli("localhost", "root", "", "bookstore");

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $bookName = $conn->real_escape_string($_POST['book_name']);
    $creditsRequired = (int)$_POST['credits_required'];
    $bookCondition = $conn->real_escape_string($_POST['book_condition']);
    
    // Handle File Upload
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true); // Ensure the uploads directory exists
    }
    
    $bookImage = "default.jpg"; // Default image if no upload
    if (!empty($_FILES['book_image']['name'])) {
        $fileTmpPath = $_FILES['book_image']['tmp_name'];
        $fileName = uniqid() . "-" . basename($_FILES['book_image']['name']);
        $bookImage = $uploadDir . $fileName;

        // Validate file type
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileMimeType = mime_content_type($fileTmpPath);
        if (in_array($fileMimeType, $allowedMimeTypes)) {
            if (!move_uploaded_file($fileTmpPath, $bookImage)) {
                echo "<script>alert('Error uploading the file.');</script>";
                $bookImage = "default.jpg";
            }
        } else {
            echo "<script>alert('Invalid file type. Only JPEG, PNG, and GIF are allowed.');</script>";
            $bookImage = "default.jpg";
        }
    }

    // Insert Into Database
    $sql = "INSERT INTO searchbooks (book_name, book_image, book_description, credits_required) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $description = "Condition: " . ucfirst($bookCondition); // Basic description with condition
        $stmt->bind_param("sssi", $bookName, $bookImage, $description, $creditsRequired);

        if ($stmt->execute()) {
            echo "<script>alert('Book donated successfully!');</script>";
        } else {
            echo "<script>alert('Error donating book: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Error preparing statement: " . $conn->error . "');</script>";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate a Book</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            padding-top: 70px; /* Space for fixed header */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
            animation: backgroundFade 5s infinite alternate;
        }
        @keyframes backgroundFade {
            0% { background-color: #f4f4f9; }
            100% { background-color: #e8f0fe; }
        }
        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            width: 400px;
            transform: scale(0.9);
            animation: popIn 1s forwards;
        }
        @keyframes popIn {
            0% { transform: scale(0.7); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="number"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="file"]:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px #007bff;
        }
        .condition {
            margin-bottom: 15px;
        }
        .condition label {
            display: inline-block;
            margin-right: 15px;
            font-weight: normal;
        }
        .condition input {
            margin-right: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
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

    </style>
</head>
<div class="header">
    <div class="header-container">
        <h1>Search Books</h1>
        <nav class="nav-links">
            <a href="search.php">Search Books</a>
            <a href="favorite.php">Favorite</a>
        </nav>
    </div>
</div>

<body>
    
    <div class="form-container">
        <h1>Donate a Book</h1>
        <form method="POST" enctype="multipart/form-data" action="">
            <label for="book_name">Name of your donated book:</label>
            <input type="text" name="book_name" id="book_name" required>
            <label for="credits_required">Credits Required for requesting this book:</label>
            <input type="number" name="credits_required" id="credits_required" value="5" min="1" required>
            <label for="book_image">Upload a photo:</label>
            <input type="file" name="book_image" id="book_image" accept="image/*">
            <label>Book condition:</label>
            <div class="condition">
                <label><input type="radio" name="book_condition" value="poor" required> Poor</label>
                <label><input type="radio" name="book_condition" value="fair"> Fair</label>
                <label><input type="radio" name="book_condition" value="good"> Good</label>
                <label><input type="radio" name="book_condition" value="very_good"> Very Good</label>
                <label><input type="radio" name="book_condition" value="as_new"> As New</label>
            </div>
            <button type="submit">Donate</button>
        </form>
    </div>
</body>
</html>
CREATE DATABASE bookstore;

USE bookstore;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);


CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    isbn VARCHAR(13) NOT NULL,
    author VARCHAR(255) NOT NULL,
    image VARCHAR(255), -- Path to the image file for each book
    quantity INT DEFAULT 1
);

INSERT INTO books (title, isbn, author, image) VALUES
    ('To Kill a Mockingbird', '1205', 'Harper Lee', 'mockingbird.jpg'),
    ('1984', '2842', 'George Orwell', '1984.jpg'),
    ('Pride and Prejudice', '3355', 'Jane Austen', 'pride_and_prejudice.jpg'),
    ('The Great Gatsby', '7356', 'F. Scott Fitzgerald', 'great_gatsby.jpg'),
    ('Moby Dick', '3724', 'Herman Melville', 'moby_dick.jpg'),
    ('War and Peace', '4793', 'Leo Tolstoy', 'war_and_peace.jpg'),
    ('The Catcher in the Rye', '6948', 'J.D. Salinger', 'catcher_in_the_rye.jpg'),
    ('The Lord of the Rings', '0222', 'J.R.R. Tolkien', 'lord_of_the_rings.jpg'),
    ('The Hobbit', '0221', 'J.R.R. Tolkien', 'the_hobbit.jpg'),
    ('Harry Potter and the Chamber of Secrets', '3849', 'J.K. Rowling', 'harry_potter2.jpg'),
    ('Harry Potter and the Prisoner of Azkaban', '4215', 'J.K. Rowling', 'harry_potter3.jpg'),
    ('The Chronicles of Narnia', '7119', 'C.S. Lewis', 'chronicles_of_narnia.jpg'),
    ('Jane Eyre', '3720', 'Charlotte Brontë', 'jane_eyre.jpg'),
      ('The Odyssey', '1234', 'Homer', 'odyssey.jpg'),
    ('The Divine Comedy', '3564', 'Dante Alighieri', 'divine_comedy.jpg');

CREATE TABLE inventory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    isbn VARCHAR(20) NOT NULL,
    author VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255) NOT NULL
);


 CREATE TABLE `new_arrivals` (
       `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `title` VARCHAR(255) NOT NULL,
      `isbn` VARCHAR(20) NOT NULL,
       `author` VARCHAR(255) NOT NULL,
       `price` DECIMAL(10, 2) NOT NULL,
       `image` VARCHAR(255) NOT NULL
 );

INSERT INTO `new_arrivals` (`title`, `isbn`, `author`, `price`, `image`)
VALUES
('The Great Adventure', '1234', 'John Doe', 150.99, 'images/book1.jpg'),
('A Journey Through Time', '2345', 'Jane Smith', 120.49, 'images/book2.jpg'),
('The Last Horizon', '3456', 'Michael Brown', 180.99, 'images/book3.jpg'),
('Mystery of the Ocean', '4567', 'Emily White', 220.99, 'images/book4.jpg'),
('Exploring Space', '5678', 'David Green', 200.99, 'images/book5.jpg'),
('The Secret Garden', '6789', 'Sarah Blue', 140.49, 'images/book6.jpg');

CREATE TABLE searchbooks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    book_name VARCHAR(255) NOT NULL,
    book_image VARCHAR(255) NOT NULL,
    book_description TEXT NOT NULL,
    credits_required INT DEFAULT 5
);

INSERT INTO searchbooks (book_name, book_image, book_description) VALUES
('The Great Gatsby', 'images/gatsby.jpg', 'A classic tale of love, wealth, and ambition.'),
('To Kill a Mockingbird', 'images/mockingbird.jpg', 'A powerful story about justice and racial inequality.'),
('1984', 'images/1984.jpg', 'A dystopian novel about surveillance and totalitarianism.'),
('Pride and Prejudice', 'images/pride.jpg', 'A timeless romance with wit and social critique.'),
('The Catcher in the Rye', 'images/catcher.jpg', 'A young man’s journey through alienation and identity.'),
('The Hobbit', 'images/hobbit.jpg', 'A magical adventure in Middle-earth by J.R.R. Tolkien.'),
('The Da Vinci Code', 'images/davinci.jpg', 'A gripping mystery combining art, history, and religion.'),
('The Alchemist', 'images/alchemist.jpg', 'A philosophical tale about pursuing one’s dreams.'),
('The Road', 'images/road.jpg', 'A post-apocalyptic journey of survival and hope.');

CREATE TABLE favorites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    book_name VARCHAR(255) NOT NULL,
    book_image VARCHAR(255) NOT NULL
);

DROP TABLE IF EXISTS Wishlist;
DROP TABLE IF EXISTS Videogames;
DROP TABLE IF EXISTS Comics;
DROP TABLE IF EXISTS Music;
DROP TABLE IF EXISTS Books;
DROP TABLE IF EXISTS Products;
DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Reservation;

CREATE TABLE Users (
  username VARCHAR(25) NOT NULL,
  password VARCHAR(30) NOT NULL,
  PRIMARY KEY (username)
);

CREATE TABLE Products (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) UNIQUE NOT NULL,
  price DECIMAL(10,2) UNSIGNED,
  release_date DATE,
  product_type ENUM('book','music','comic','videogame') NOT NULL,
  status ENUM('available', 'not available'),
  PRIMARY KEY (id)
);

CREATE TABLE Books (
  id INT UNSIGNED NOT NULL,
  author VARCHAR(50) NOT NULL,
  pages INT UNSIGNED,
  genre VARCHAR(50),
  PRIMARY KEY(id),
  FOREIGN KEY(id) REFERENCES Products(id)
);

CREATE TABLE Music (
  id INT UNSIGNED NOT NULL,
  artist VARCHAR(50) NOT NULL,
  length INT UNSIGNED, -- in minutes
  genre VARCHAR(50),
  format ENUM('cd', 'vinyl', 'other'),
  PRIMARY KEY(id),
  FOREIGN KEY(id) REFERENCES Products(id)
);

CREATE TABLE Comics (
  id INT UNSIGNED NOT NULL,
  author VARCHAR(50) NOT NULL,
  pages INT UNSIGNED,
  genre VARCHAR(50),
  PRIMARY KEY(id),
  FOREIGN KEY(id) REFERENCES Products(id)
);

CREATE TABLE Videogames (
  id INTEGER UNSIGNED NOT NULL,
  genre VARCHAR(50),
  developer VARCHAR(50),
  PRIMARY KEY(id),
  FOREIGN KEY(id) REFERENCES Products(id)
);

CREATE TABLE Wishlist (
  user_username VARCHAR(25) NOT NULL,
  product_id INT UNSIGNED NOT NULL,
  PRIMARY KEY(user_username, product_id),
  FOREIGN KEY(user_username) REFERENCES Users(username),
  FOREIGN KEY(product_id) REFERENCES Products(id)
);

CREATE TABLE Categories (
  product_id INT UNSIGNED NOT NULL,
  category_name VARCHAR(100) NOT NULL,
  PRIMARY KEY(product_id, category_name),
  FOREIGN KEY(product_id) REFERENCES Products(id)
);

CREATE TABLE Reservation (
  product_id INT UNSIGNED NOT NULL,
  username VARCHAR(25) NOT NULL,
  reservation_time TIMESTAMP NOT NULL,
  notes VARCHAR(140),
  PRIMARY KEY (product_id,username,reservation_time),
  FOREIGN KEY(product_id) REFERENCES Products(id),
  FOREIGN KEY(username) REFERENCES Users(username)
);



-- Users
INSERT INTO Users (username, password) VALUES
('user1@email.com', 'password1'),
('user2@email.com', 'password2'),
('user3@email.com', 'password3'),
('user4@email.com', 'password4'),
('user5@email.com', 'password5'),
('user6@email.com', 'password6'),
('user7@email.com', 'password7'),
('user8@email.com', 'password8'),
('user9@email.com', 'password9'),
('user10@email.com', 'password10');

-- Books
INSERT INTO Products (name, price, release_date, product_type, status)
SELECT 
    CONCAT('Book ', LPAD(num, 2, '0')),
    ROUND(RAND() * 50 + 10, 2),
    DATE_ADD('2020-01-01', INTERVAL FLOOR(RAND() * 1095) DAY),
    'book',
    CASE WHEN RAND() > 0.2 THEN 'available' ELSE 'not available' END
FROM (SELECT @row := @row + 1 AS num FROM (SELECT 0 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4) t1,
     (SELECT 0 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4) t2,
     (SELECT @row:=0) t3 LIMIT 50) numbers;

INSERT INTO Books (id, author, pages, genre)
SELECT 
    id,
    CONCAT('Author ', LPAD(FLOOR(RAND() * 20) + 1, 2, '0')),
    FLOOR(RAND() * 500 + 100),
    ELT(FLOOR(RAND() * 5) + 1, 'Fiction', 'Non-fiction', 'Mystery', 'Sci-Fi', 'Fantasy')
FROM Products WHERE product_type = 'book';

-- Music
INSERT INTO Products (name, price, release_date, product_type, status)
SELECT 
    CONCAT('Album ', LPAD(num, 2, '0')),
    ROUND(RAND() * 30 + 5, 2),
    DATE_ADD('2020-01-01', INTERVAL FLOOR(RAND() * 1095) DAY),
    'music',
    CASE WHEN RAND() > 0.2 THEN 'available' ELSE 'not available' END
FROM (SELECT @row := @row + 1 AS num FROM (SELECT 0 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4) t1,
     (SELECT 0 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4) t2,
     (SELECT @row:=0) t3 LIMIT 50) numbers;

INSERT INTO Music (id, artist, length, genre, format)
SELECT 
    id,
    CONCAT('Artist ', LPAD(FLOOR(RAND() * 20) + 1, 2, '0')),
    FLOOR(RAND() * 60 + 30),
    ELT(FLOOR(RAND() * 5) + 1, 'Rock', 'Pop', 'Jazz', 'Classical', 'Electronic'),
    ELT(FLOOR(RAND() * 3) + 1, 'cd', 'vinyl', 'other')
FROM Products WHERE product_type = 'music';

-- Comics
INSERT INTO Products (name, price, release_date, product_type, status)
SELECT 
    CONCAT('Comic ', LPAD(num, 2, '0')),
    ROUND(RAND() * 20 + 5, 2),
    DATE_ADD('2020-01-01', INTERVAL FLOOR(RAND() * 1095) DAY),
    'comic',
    CASE WHEN RAND() > 0.2 THEN 'available' ELSE 'not available' END
FROM (SELECT @row := @row + 1 AS num FROM (SELECT 0 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4) t1,
     (SELECT 0 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4) t2,
     (SELECT @row:=0) t3 LIMIT 50) numbers;

INSERT INTO Comics (id, author, pages, genre)
SELECT 
    id,
    CONCAT('Comic Author ', LPAD(FLOOR(RAND() * 20) + 1, 2, '0')),
    FLOOR(RAND() * 100 + 20),
    ELT(FLOOR(RAND() * 5) + 1, 'Superhero', 'Manga', 'Graphic Novel', 'Humor', 'Horror')
FROM Products WHERE product_type = 'comic';

-- Videogames
INSERT INTO Products (name, price, release_date, product_type, status)
SELECT 
    CONCAT('Game ', LPAD(num, 2, '0')),
    ROUND(RAND() * 40 + 20, 2),
    DATE_ADD('2020-01-01', INTERVAL FLOOR(RAND() * 1095) DAY),
    'videogame',
    CASE WHEN RAND() > 0.2 THEN 'available' ELSE 'not available' END
FROM (SELECT @row := @row + 1 AS num FROM (SELECT 0 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4) t1,
     (SELECT 0 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4) t2,
     (SELECT @row:=0) t3 LIMIT 50) numbers;

INSERT INTO Videogames (id, genre, developer)
SELECT 
    id,
    ELT(FLOOR(RAND() * 5) + 1, 'RPG', 'FPS', 'Strategy', 'Sports', 'Adventure'),
    CONCAT('Developer ', LPAD(FLOOR(RAND() * 20) + 1, 2, '0'))
FROM Products WHERE product_type = 'videogame';

-- Wishlist (random entries, ensuring consistency with DB constraints)
INSERT INTO Wishlist (user_username, product_id)
SELECT 
    u.username,
    p.id
FROM 
    Users u
CROSS JOIN 
    Products p
WHERE 
    RAND() < 0.1  -- This will give roughly 10% chance for each user-product combination
LIMIT 
    100;  -- Limiting to 100 total wishlist entries, adjust as needed

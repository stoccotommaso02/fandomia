DROP TABLE IF EXISTS Wishlist;
DROP TABLE IF EXISTS Videogames;
DROP TABLE IF EXISTS Comics;
DROP TABLE IF EXISTS Music;
DROP TABLE IF EXISTS Books;
DROP TABLE IF EXISTS Products;
DROP TABLE IF EXISTS Users;

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
  FOREIGN KEY(id) REFERENCES products(id)
);

CREATE TABLE Music (
  id INT UNSIGNED NOT NULL,
  artist VARCHAR(50) NOT NULL,
  length INT UNSIGNED, -- in minutes
  genre VARCHAR(50),
  format ENUM('cd', 'vinyl', 'other'),
  PRIMARY KEY(id),
  FOREIGN KEY(id) REFERENCES products(id)
);

CREATE TABLE Comics (
  id INT UNSIGNED NOT NULL,
  author VARCHAR(50) NOT NULL,
  pages INT UNSIGNED,
  genre VARCHAR(50),
  PRIMARY KEY(id),
  FOREIGN KEY(id) REFERENCES products(id)
);

CREATE TABLE Videogames (
  id INTEGER UNSIGNED NOT NULL,
  genre VARCHAR(50),
  developer VARCHAR(50),
  PRIMARY KEY(id),
  FOREIGN KEY(id) REFERENCES products(id)
);

CREATE TABLE Wishlist (
  user_username VARCHAR(25) NOT NULL,
  product_id INT UNSIGNED NOT NULL,
  PRIMARY KEY(user_username, product_id),
  FOREIGN KEY(user_username) REFERENCES users(username),
  FOREIGN KEY(product_id) REFERENCES products(id)
);


CREATE TABLE ProductCategories (
  product_id INT UNSIGNED NOT NULL,
  category_id INT UNSIGNED NOT NULL,
  PRIMARY KEY(product_id, category_id),
  FOREIGN KEY(product_id) REFERENCES products(id),
  FOREIGN KEY(category_id) REFERENCES Categories(id)
);

CREATE TABLE Categories (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  PRIMARY KEY(id)
)
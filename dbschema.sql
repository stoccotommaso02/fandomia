DROP TABLE IF EXISTS wishlist;
DROP TABLE IF EXISTS videogames;
DROP TABLE IF EXISTS comics;
DROP TABLE IF EXISTS music;
DROP TABLE IF EXISTS books;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
  username VARCHAR(25) NOT NULL,
  password VARCHAR(30) NOT NULL,
  PRIMARY KEY (username)
);

CREATE TABLE products (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) UNIQUE NOT NULL,
  price DECIMAL(10,2) UNSIGNED,
  release_date DATE,
  product_type ENUM('book','music','comic','videogame') NOT NULL,
  status ENUM('available', 'not available'),
  PRIMARY KEY (id)
);

CREATE TABLE books (
  id INT UNSIGNED NOT NULL,
  author VARCHAR(50) NOT NULL,
  pages INT UNSIGNED,
  genre VARCHAR(50),
  PRIMARY KEY(id),
  FOREIGN KEY(id) REFERENCES products(id)
);

CREATE TABLE music (
  id INT UNSIGNED NOT NULL,
  artist VARCHAR(50) NOT NULL,
  length INT UNSIGNED, -- in minutes
  genre VARCHAR(50),
  format ENUM('cd', 'vinyl', 'other'),
  PRIMARY KEY(id),
  FOREIGN KEY(id) REFERENCES products(id)
);

CREATE TABLE comics (
  id INT UNSIGNED NOT NULL,
  author VARCHAR(50) NOT NULL,
  pages INT UNSIGNED,
  genre VARCHAR(50),
  PRIMARY KEY(id),
  FOREIGN KEY(id) REFERENCES products(id)
);

CREATE TABLE videogames (
  id INTEGER UNSIGNED NOT NULL,
  genre VARCHAR(50),
  developer VARCHAR(50),
  PRIMARY KEY(id),
  FOREIGN KEY(id) REFERENCES products(id)
);

CREATE TABLE wishlist (
  user_username VARCHAR(25) NOT NULL,
  product_id INT UNSIGNED NOT NULL,
  PRIMARY KEY(user_username, product_id),
  FOREIGN KEY(user_username) REFERENCES users(username),
  FOREIGN KEY(product_id) REFERENCES products(id)
);

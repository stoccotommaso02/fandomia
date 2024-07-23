CREATE TABLE users(
  username VARCHAR(25) NOT NULL, -- forse e-mail
  password VARCHAR(30) NOT NULL,

  PRIMARY KEY (username)
);

CREATE TABLE products(
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) UNIQUE NOT NULL,
  price decimal(10,2) UNSIGNED,
  release DATE,
  type ENUM('book', 'music', 'comic', 'videogame') NOT NULL,
  status ENUM('available', 'not available'),

  PRIMARY KEY (id)
);

CREATE TABLE books(
  id int UNSIGNED NOT NULL,
  author varchar(50) NOT NULL,
  pages int UNSIGNED,
  genre varchar(50),

  PRIMARY KEY(id),
  FOREIGN KEY(id) REFERENCES products(id)
);

CREATE TABLE music(
  id int UNSIGNED NOT NULL,
  artist varchar(50) NOT NULL,
  length int unsigned, --in minutes
  genre varchar(50),
  format ENUM('cd', 'vinyl', 'other'),

  PRIMARY KEY(id),
  FOREIGN KEY(id) REFERENCES products(id)
)

CREATE TABLE comics(
  id int UNSIGNED NOT NULL,
  author varchar(50) NOT NULL,
  pages int unsigned,
  genre varchar(50),
)

CREATE TABLE videogames(
  id INTEGER UNSIGNED NOT NULL,
  genre varchar(50),
  developer varchar(50),

  PRIMARY KEY(id),
  FOREIGN KEY(id) REFERENCES products(id)
)

CREATE TABLE wishlist(
  user_username varchar(25) NOT NULL,
  product_id int UNSIGNED NOT NULL,

  PRIMARY KEY(user_username, product_id),
  FOREIGN KEY(user_username) REFERENCES users(username),
  FOREIGN KEY(product_id) REFERENCES products(id)
);

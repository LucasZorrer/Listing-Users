CREATE DATABASE listingUsers;

USE listingusers;

CREATE TABLE users (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(200) NOT NULL,
    lastName VARCHAR(200) NOT NULL,
    email VARCHAR(200) NOT NULL,
    password VARCHAR(200) NOT NULL,
    image VARCHAR(200),
    bio VARCHAR(200),
    token VARCHAR(200) NOT NULL
);

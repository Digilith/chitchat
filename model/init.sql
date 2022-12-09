CREATE DATABASE IF NOT EXISTS chitchat_db;
CREATE USER IF NOT EXISTS 'user'@'%' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON chitchat_db.* TO 'user'@'%';
FLUSH PRIVILEGES;

use chitchat_db;

CREATE TABLE IF NOT EXISTS person (
    id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL UNIQUE ,
    nickname VARCHAR(64) NOT NULL UNIQUE ,
    password_hash CHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS room (
    id INT NOT NULL AUTO_INCREMENT,
    admin_id INT NOT NULL, #room admin
    room_name VARCHAR(64) NOT NULL,
    room_desc TEXT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (admin_id) REFERENCES person(id)
);

# table of users in every chat room
CREATE TABLE IF NOT EXISTS person_room (
    id INT NOT NULL AUTO_INCREMENT,
    person_id INT NOT NULL,
    room_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (room_id) REFERENCES room(id),
    FOREIGN KEY (person_id) REFERENCES person(id)
);

CREATE TABLE IF NOT EXISTS message (
    id INT NOT NULL AUTO_INCREMENT,
    person_id INT NOT NULL, #who sent it
    room_id INT NOT NULL, #in which room was it sent
    message_txt TEXT NOT NULL, #contents
    PRIMARY KEY (id),
    FOREIGN KEY (room_id) REFERENCES room(id),
    FOREIGN KEY (person_id) REFERENCES person(id)
);

CREATE TABLE IF NOT EXISTS request (
    id INT NOT NULL AUTO_INCREMENT,
    person_id INT NOT NULL,
    room_id INT NOT NULL,
    request_desc TINYTEXT,
    status TINYINT NOT NULL, # 0 - pending, 1 - ok, 2 - declined
    PRIMARY KEY (id),
    FOREIGN KEY (room_id) REFERENCES room(id),
    FOREIGN KEY (person_id) REFERENCES person(id)
);

INSERT INTO person (email, nickname, password_hash)
VALUES ("test@mail.ru", "test", "1234"),
       ("test_2@mail.ru", "test_2", "1234"),
       ("test_3@mail.ru", "test_3", "1234");

# TODO: add dummy info, 1) room id 1 GENERAL, user id 1 ADMIN 2) other dummy users, rooms, requests
# TODO: TRIGGER RULE upon adding a user add them to general
# TODO: fill out person_room table
# TODO: TRIGGER RULE upon creating a room add the admin to person_room table
# TODO: TRIGGER RULE upon deleting a room delete all person_room records and requests w/ it
# TODO: TRIGGER RULE upon deleting a user delete the ROOM anf then all the records with them in all the tables
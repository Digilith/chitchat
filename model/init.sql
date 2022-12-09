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
    room_name VARCHAR(64) NOT NULL UNIQUE,
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

INSERT INTO room (admin_id, room_name, room_desc)
VALUES (1, "general", "A chatroom for everything."),
       (1, "gardening", "A chatroom for everyone interested in gardening."),
       (1, "books", "Are you an avid reader? Join the discussion!"),
       (2, "movies", "Anyone interested in movies and cinema are welcome! Make sure to write a little bit about yourself before applying!");

INSERT INTO request (person_id, room_id, request_desc, status)
VALUES (1, 4, "I like soap operas and romcoms, can I join?", 0),
       (3, 4, "Hello, I'm a beginner director, would love to chat!", 0),
       (2, 2, "Hi, I'd like to join", 0);

INSERT INTO person_room(person_id, room_id)
VALUES (1, 1),
       (2, 1),
       (3, 1),
       (1, 2),
       (3, 2);

INSERT INTO message(person_id, room_id, message_txt)
VALUES (1, 1, "Hello, World!"),
       (2, 1, "Hi everyone!"),
       (3, 1, "Hi, how's it going?"),
       (1, 1, "OK, you?"),
       (3, 1, "Nothing special really");


# TODO: TRIGGER RULE upon adding a user add them to general
# TODO: TRIGGER RULE upon creating a room add the admin to person_room table
# TODO: TRIGGER RULE upon deleting a room delete all person_room records and requests w/ it
# TODO: TRIGGER RULE upon deleting a user delete the ROOM and then all the records with them in all the tables
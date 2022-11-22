CREATE TABLE patients (
    id              INTEGER PRIMARY KEY AUTO_INCREMENT,
    first_name      VARCHAR(64) NOT NULL,
    last_name       VARCHAR(64) NOT NULL,
    weight          INTEGER,
    age             INTEGER
);

INSERT INTO patients (first_name, last_name, weight, age) VALUES ('Bob', 'Bobson', 174, 53);
INSERT INTO patients (first_name, last_name, weight, age) VALUES ('Jane', 'Doe', 130, 44);
INSERT INTO patients (first_name, last_name, weight, age) VALUES ('Spongebob', 'SquarePants', 2, 35);
INSERT INTO patients (first_name, last_name, weight, age) VALUES ('Homer', 'Simpson', 280, 32);
INSERT INTO patients (first_name, last_name, weight, age) VALUES ('Father', 'Time', 144, 183);
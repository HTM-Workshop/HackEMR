USE EMR;
CREATE TABLE tips (
    id      INTEGER PRIMARY KEY AUTO_INCREMENT,
    text    VARCHAR(128)
);

INSERT INTO tips (text) VALUES ("Don't stare into the sun.");
INSERT INTO tips (text) VALUES ("Try turning it off and on again.");

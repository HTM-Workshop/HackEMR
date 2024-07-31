USE EMR;
CREATE TABLE users (
    id          INTEGER PRIMARY KEY AUTO_INCREMENT,
    username    VARCHAR(16) NOT NULL UNIQUE,
    password    VARCHAR(32) NOT NULL,
    enabled     INTEGER NOT NULL DEFAULT 0,
    regtime     DATE DEFAULT NOW(),
    is_admin INTEGER NOT NULL DEFAULT 0
    );

INSERT INTO users (username, password, enabled, is_admin) VALUES ('admin', '0f359740bd1cda994f8b55330c86d845', 1, 1);
INSERT INTO users (username, password, enabled, is_admin) VALUES ('john.smith', '0d107d09f5bbe40cade3de5c71e9e9b7', 1, 0);
INSERT INTO users (username, password, enabled, is_admin) VALUES ('mr.bean', '962b2d2b8e72dc6771bca613d49b46fb', 1, 0);
INSERT INTO users (username, password, enabled, is_admin) VALUES ('dr.evil', '13a94d4deb9bad93ca53454ab88ec342', 1, 0);

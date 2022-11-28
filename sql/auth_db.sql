USE EMR;
CREATE TABLE users (
    id          INTEGER PRIMARY KEY AUTO_INCREMENT,
    username    VARCHAR(16) NOT NULL UNIQUE,
    password    VARCHAR(16) NOT NULL,
    enabled     INTEGER NOT NULL DEFAULT 0,
    regtime     DATE DEFAULT NOW(),
    is_admin INTEGER NOT NULL DEFAULT 0
    );

INSERT INTO users (username, password, enabled, is_admin) VALUES ('admin', 'p@ssw0rd', 1, 1);
INSERT INTO users (username, password, enabled, is_admin) VALUES ('john.smith', 'letmein', 1, 0);
INSERT INTO users (username, password, enabled, is_admin) VALUES ('mr.bean', 'teddy', 1, 0);
INSERT INTO users (username, password, enabled, is_admin) VALUES ('dr.evil', 'sharklazer', 1, 0);
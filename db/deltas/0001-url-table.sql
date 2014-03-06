CREATE TABLE IF NOT EXISTS url (
    id INT NOT NULL AUTO_INCREMENT,
    identifier VARCHAR(10) NOT NULL,
    url VARCHAR(1000) NOT NULL,
    PRIMARY KEY (id)
);

CREATE UNIQUE INDEX idx_url_identifier ON url ( identifier );

--//@UNDO

DROP INDEX idx_url_identifier;
DROP TABLE url;

--//
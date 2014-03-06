-- Fragment begins: 1 --
INSERT INTO changelog
                                (change_number, delta_set, start_dt, applied_by, description) VALUES (1, 'Main', NOW(), 'dbdeploy', '0001-url-table.sql');
CREATE TABLE IF NOT EXISTS url (
    id INT NOT NULL AUTO_INCREMENT,
    identifier VARCHAR(10) NOT NULL,
    url VARCHAR(1000) NOT NULL,
    PRIMARY KEY (id)
);

CREATE UNIQUE INDEX idx_url_identifier ON url ( identifier );

UPDATE changelog
	                         SET complete_dt = NOW()
	                         WHERE change_number = 1
	                         AND delta_set = 'Main';
-- Fragment ends: 1 --

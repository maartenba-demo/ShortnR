-- Fragment begins: 1 --


DROP INDEX idx_url_identifier;
DROP TABLE url;

--//
DELETE FROM changelog
	                         WHERE change_number = 1
	                         AND delta_set = 'Main';
-- Fragment ends: 1 --

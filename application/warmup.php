<?php
// Create database tables
try {
    $db->query('CREATE TABLE IF NOT EXISTS url (
        id INT NOT NULL AUTO_INCREMENT,
        identifier VARCHAR(10) NOT NULL,
        url VARCHAR(1000) NOT NULL,
        PRIMARY KEY (id)
    );');

    $db->query('CREATE UNIQUE INDEX IF NOT EXISTS idx_url__identifier ON url ( identifier );');

    syslog(LOG_INFO, 'Created database table "url".');
} catch (PDOException $e) {
    syslog(LOG_INFO, 'All hell breaks loose.');
}
<?php
$db = null;
try {
    $db = new PDO('mysql:host=' . $configuration['database']['host'] . ';port=' . $configuration['database']['port'] . ';dbname=' . $configuration['database']['database'], $configuration['database']['username'], $configuration['database']['password']);
    syslog(LOG_DEBUG, 'Connected to database.');
} catch (PDOException $e) {
    syslog(LOG_ERR, 'Failed to get PDO DB handle: ' . $e->getMessage());
    exit;
}
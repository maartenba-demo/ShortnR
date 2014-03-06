<?php
$identifier = substr($requestedPage, 2);
syslog(LOG_INFO, '[' . $identifier . '] Request for identifier.');

$redirectUrl = null;

$sql = 'SELECT url FROM url WHERE identifier = ?';
try {
    $stmt = $db->prepare($sql);
    $stmt->execute(array($identifier));
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($row) == 1) {
        $redirectUrl = $row[0]['url'];
    }
    $stmt = null;
}
catch (PDOException $e) {
    print $e->getMessage();
}

if (!is_null($redirectUrl)) {
    syslog(LOG_INFO, '[' . $identifier . '] Request for identifier satisfied.');
    header('Location: ' . $redirectUrl);
} else {
    syslog(LOG_WARNING, '[' . $identifier . '] Request for identifier could not be satisfied.');
    die('Unknown identifier');
}
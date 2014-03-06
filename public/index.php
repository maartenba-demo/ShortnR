<?php
require_once dirname(__FILE__) . '/../application/config.php';
require_once dirname(__FILE__) . '/../application/functions.php';
require_once dirname(__FILE__) . '/../application/database.php';

$requestedPage = substr($_SERVER['REQUEST_URI'], 1);
if ($requestedPage == '') {
    $requestedPage = 'index';
}

// Perform routing
if (strpos($_SERVER["REQUEST_URI"], '/css/') !== false
    || strpos($_SERVER["REQUEST_URI"], '/img/') !== false
    || strpos($_SERVER["REQUEST_URI"], '/js/') !== false) {
    return false;
}

// Load page
if (substr($requestedPage, 0, 1) == 'u') {
    require_once dirname(__FILE__) . '/../application/perform_redirect.php';
} else {
    require_once dirname(__FILE__) . '/../application/views/master.php';
}
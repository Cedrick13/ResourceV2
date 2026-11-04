
<?php

// ResourceV2 root directory
$root = dirname(__DIR__);

// Set working directory
chdir($root);

// Main application
$mainFile = $root . '/index.php';

if (!file_exists($mainFile)) {
    http_response_code(500);
    exit('ResourceV2: Main index.php not found.');
}

// Load main website
require $mainFile;


<?php
declare(strict_types=1);

// ResourceV2 root directory
$root = dirname(__DIR__);

// Set working directory
chdir($root);

// Main application
$mainFile = $root . '/index.php';

if (!is_file($mainFile)) {
    http_response_code(500);
    exit('ResourceV2: Main index.php not found.');
}

// Render website
require $mainFile;

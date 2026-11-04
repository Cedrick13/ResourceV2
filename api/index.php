
<?php

declare(strict_types=1);

// Set project root directory
$root = dirname(__DIR__);

// Set working directory to ResourceV2 root
chdir($root);

// Load the main website
$mainFile = $root . '/index.php';

if (!file_exists($mainFile)) {
    http_response_code(500);
    exit('Error: Main index.php not found.');
}

require $mainFile;

<?php
// router.php

// Route everything through index.php except actual files
if (file_exists(__DIR__ . parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH))) {
    return false; // Let built-in server serve the file
}

require __DIR__ . '/index.php'; // Send all other requests to index.php

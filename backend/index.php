<?php
// index.php

header("Content-Type: application/json");

// Remove query strings (e.g. ?id=1)
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Basic routing
switch ($request) {
    case '/api/calls':
        require __DIR__ . '/api/calls.php';
        break;

    default:
        http_response_code(404);
        echo json_encode(["error" => "Not Found"]);
        break;
}

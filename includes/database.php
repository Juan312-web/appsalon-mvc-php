<?php

$db = mysqli_connect(
    $_ENV['DB_HOST'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASS'],
    $_ENV['DB_NAME'],
);



mysqli_set_charset($db, 'utf8mb4');

if (!$db) {
    echo "Error: Could not connect to MySQL.";
    echo "Error of debugging: " . mysqli_connect_errno();
    echo "Error of debugging: " . mysqli_connect_error();
    exit;
}

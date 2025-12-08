<?php

$pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '200804');
$pdo->exec('CREATE DATABASE IF NOT EXISTS laporinaha');
echo "Database created successfully!";

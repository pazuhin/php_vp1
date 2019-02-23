<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=orders", 'root','');
} catch (PDOException $e) {
    echo $e->getMessage();
    die;
};
<?php

try {
    $db = new PDO("mysql:host=localhost;dbname=youtube_clone;charset=utf8", "root", "");
} catch (PDOException $e) {
    die($e->getMessage());
}


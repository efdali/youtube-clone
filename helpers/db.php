<?php

try {
    // veritabanı bağlantısı
    $db = new PDO("mysql:host=localhost;dbname=youtube_clone;charset=utf8", "root", "");
} catch (PDOException $e) {
    // bağlantıda hata varsa hata mesajını yazdırıp bağlantıyı sonlandır
    die($e->getMessage());
}


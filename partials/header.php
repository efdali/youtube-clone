<?php

session_start();

require_once 'helpers/db.php';
?>

<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= isset($title) ? $title : 'Youtube Clone' ?></title>
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>

<header>
    <div class="container">
        <h1><a href="index.php" class="brand">Youtube Clone</a></h1>
        <form class="search-form" method="GET" action="index.php">
            <input type="text" name="arama" placeholder="Ara..."/>
            <button type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </button>
        </form>
        <? if (!isset($_SESSION["id"])): ?>
            <div class="auth">
                <a href="giris.php">Giriş Yap</a>
                <span class="seperator"></span>
                <a href="kayit.php">Kayıt Ol</a>
            </div>
        <? else: ?>
            <div class="user-auth">
                <h4><?= $_SESSION["username"] ?></h4>
                <a href="cikis.php">(Çıkış Yap)</a>
            </div>
        <? endif; ?>
    </div>
</header>
<div class="container">


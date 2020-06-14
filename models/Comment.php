<?php

require_once 'User.php';

// Veritabanı Comment tablosu modeli
class Comment
{

    public $content;
    public $created_at;
    public User $user;

}
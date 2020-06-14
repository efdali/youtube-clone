<?php

require_once 'User.php';

// Veritabanı Video tablosu modeli
class Video
{
    public $video_id;
    public $title;
    public $description;
    public $url;
    public $thumbnail;
    public $created_at;
    public $category_id;
    public User $user;
}

<?php

require_once 'User.php';

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

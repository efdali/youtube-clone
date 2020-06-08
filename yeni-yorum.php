<?php

require_once 'helpers/db.php';

if (isset($_POST["yeni"])) {

    $content = $_POST["content"];
    $video = $_POST["video"];
    $user = $_SESSION["id"];

    if (empty($content) || empty($video) || empty($user)) {
        header("Location:video.php?result=0&message=Eksik Alan Var...&id=" . $video);
    }

    $query = $db->prepare("insert into comments set content=:content,video=:video,user=:user");
    $query->bindParam(":content", $content, PDO::PARAM_STR);
    $query->bindParam(":video", $video, PDO::PARAM_STR);
    $query->bindParam(":user", $user, PDO::PARAM_STR);
    $insert = $query->execute();

    if ($insert) {
        header("Location:video.php?result=1&id=" . $video);
    } else {
        header("Location:video.php?result=0&message=Hata Oluştu&id=" . $video);

    }
}
<?php
session_start();
// veritabanı bağlantısını yaptığımız php dosyamızı dahil ediyoruz
require_once 'helpers/db.php';

// post isteği var mı?
if (isset($_POST["yeni"])) {

    $content = $_POST["content"];
    $video = $_POST["video"];
    $user = $_SESSION["id"];

    // herhangi bir değer eksikse bilgilendirme mesajıyla ilgili video sayfasına yönlendiriyoruz
    if (empty($content) || empty($video) || empty($user)) {
        header("Location:video.php?result=0&message=Eksik Alan Var...&id=" . $video);
    }

    // yorumu veritabanına kaydediyoruz
    $query = $db->prepare("insert into comments set content=:content,video=:video,user=:user");
    $query->bindParam(":content", $content, PDO::PARAM_STR);
    $query->bindParam(":video", $video, PDO::PARAM_STR);
    $query->bindParam(":user", $user, PDO::PARAM_STR);
    $insert = $query->execute();

    // eğer veritabanına kayıt işlemi başarılıysa
    if ($insert) {
        // ilgili videoya yönlendiriyoruz
        header("Location:video.php?result=1&id=" . $video);
    } else {
        // kayıt işleminde sorun olursa bilgilendirme mesajıyla ilgili videoya yönlendiriyoruz
        header("Location:video.php?result=0&message=Hata Oluştu&id=" . $video);

    }
}
<?php
// header ve Video modelini dahil ediyoruz
require_once 'partials/header.php';
include_once 'models/Video.php';

// eğer arama isimle get parametresi varsa sql sorgumuzu veritabanından arama yapacak şekilde oluşturuyoruz
if (!empty($_GET["arama"])) {
    $queryString = "select * from videos v,users u where v.owner=u.user_id and v.title like '%" . $_GET["arama"] . "%'";
} else {
    // arama isteği yoksa veritabanından bütün videoları getiriyoruz
    $queryString = "select * from videos v,users u where v.owner=u.user_id";
}
$query = $db->query($queryString);
$videos = $query->fetchAll(PDO::FETCH_CLASS, "Video");

?>
<!-- veritabanından gelen videoları foreachle ekrana yazdırıyoruz -->
<? foreach ($videos as $video): ?>
    <a href="video.php?id=<?= $video->video_id ?>" class="small-video-box">
        <div class="img-wrapper">
            <img src="public/thumbnails/<?= $video->thumbnail ?>" alt="<?= $video->title ?>" class="video-thumbnail"/>
        </div>
        <h2 class="video-title"><?= $video->title ?></h2>
        <div class="video-secondary">
            <h3 class="video-description"><?= $video->username ?></h3>
            <time class="video-time"><?= $video->created_at ?></time>
        </div>
    </a>

<? endforeach; ?>


<?php
// footerı dahil ediyoruz
require_once 'partials/footer.php';
?>
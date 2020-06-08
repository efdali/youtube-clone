<?php
require_once 'partials/header.php';
include_once 'classes/Video.php';

if (!empty($_GET["arama"])) {
    $queryString = "select * from videos v,users u where v.owner=u.user_id and v.title like '%" . $_GET["arama"] . "%'";
} else {
    $queryString = "select * from videos v,users u where v.owner=u.user_id";
}
$query = $db->query($queryString);
$videos = $query->fetchAll(PDO::FETCH_CLASS, "Video");

?>

<? foreach ($videos as $video): ?>
    <a href="video.php?id=<?= $video->video_id ?>" class="small-video-box">
        <div class="img-wrapper">
            <img src="thumbnails/<?= $video->thumbnail ?>" alt="<?= $video->title ?>" class="video-thumbnail"/>
        </div>
        <h2 class="video-title"><?= $video->title ?></h2>
        <div class="video-secondary">
            <h3 class="video-description"><?= $video->username ?></h3>
            <time class="video-time"><?= $video->created_at ?></time>
        </div>
    </a>

<? endforeach; ?>


<?php
require_once 'partials/footer.php';
?>
<?php
$title = "Video İzle";
require_once 'partials/header.php';
include_once 'classes/Video.php';
include_once 'classes/Comment.php';

$id = !empty($_GET["id"]) ? (int)$_GET["id"] : 0;

if ($id === 0) {
    die("yanlış url");
}

#Video Query
$videoQuery = $db->prepare("select * from videos v,users u,categories c where v.owner=u.user_id and c.category_id=v.category and v.video_id=:video_id");
$videoQuery->bindParam(":video_id", $id, PDO::PARAM_INT);
$videoQuery->setFetchMode(PDO::FETCH_CLASS, "Video");
$videoQuery->execute();
$video = $videoQuery->fetch();

#Comment Query
$commentQuery = $db->prepare("select * from comments c,users u where c.user=u.user_id and c.video=:video");
$commentQuery->bindParam(":video", $id);
//$commentQuery->setFetchMode(PDO::FETCH_CLASS, "Comment");
$commentQuery->execute();
$comments = $commentQuery->fetchAll();

#Recommended Videos Query
$recommendedQuery = $db->prepare("select * from videos v,users u where v.owner=u.user_id and v.category=:category and v.video_id != :video order by created_at desc limit 5");
$recommendedQuery->bindParam(":category", $video->category_id);
$recommendedQuery->bindParam(":video", $id);
$recommendedQuery->setFetchMode(PDO::FETCH_CLASS, "Video");
$recommendedQuery->execute();
$recommended = $recommendedQuery->fetchAll();

if (!empty($_GET["result"])) {
    $result = $_GET["result"];

    if ($result === "1") {
        echo "<script>alert('Yorumunuz Başarıyla Kaydedildi.');</script>";
    }
}

?>

    <div class="video-container">
        <div class="video-wrapper">
            <video controls class="video">
                <source src="videos/<?= $video->url ?>" type="video/mp4">
                Tarayıcınız desteklemiyor.
            </video>
        </div>
        <h1><?= $video->title ?></h1>
        <div class="video-info">
            <img src="public/default-user.png" alt="Kullanıcı"/>
            <div>
                <h2><?= $video->username ?></h2>
                <p><?= $video->description ?></p>
            </div>
        </div>
        <hr/>
        <div class="comment-container">
            <h1>Yorumlar</h1>
            <? if (isset($_SESSION["id"])): ?>

                <form class="comment-form" method="POST" action="yeni-yorum.php">
                    <span>Yorum Yaz</span>
                    <input type="hidden" name="video" value="<?= $id ?>"/>
                    <textarea name="content" placeholder="Yorumunuz..."></textarea>
                    <button type="submit" name="yeni">Gönder</button>
                </form>
            <? else: ?>
                <p>Yorum yapmak için giriş yapmalısınız...</p>
            <? endif; ?>
            <div class="comments">
                <? foreach ($comments as $comment): ?>
                    <div class="comment">
                        <h5><?= $comment["username"] ?></h5>
                        <time><?= $comment["created_at"] ?></time>
                        <p><?= $comment["content"] ?></p>
                    </div>
                <? endforeach; ?>
            </div>
        </div>
    </div>
    <aside class="recommend-video-container">
        <h4 class="recommended-title">Benzer Videolar</h4>
        <? foreach ($recommended as $video): ?>
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
    </aside>


<?php
require_once 'partials/footer.php';
?>
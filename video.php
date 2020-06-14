<?php
// sayfa başlığını değiştiriyoruz
$title = "Video İzle";
// header, Video model ve Comment modeli dahil ediyoruz
require_once 'partials/header.php';
include_once 'models/Video.php';
include_once 'models/Comment.php';

// eğer get metoduyla gelen id değerini alıyoruz eğer id gelmemişse 0 atıyoruz
$id = !empty($_GET["id"]) ? (int)$_GET["id"] : 0;

// eğer gelen id 0 ise yani id yok ise mesaj yazdırıp bağlantıyı sonlandırıyoruz
if ($id === 0) {
    die("Yanlış url");
}

// Veritabanından gelen idye sahip videoyu ve gerekli bilgileri çekiyoruz
#Video Query
$videoQuery = $db->prepare("select * from videos v,users u,categories c where v.owner=u.user_id and c.category_id=v.category and v.video_id=:video_id");
$videoQuery->bindParam(":video_id", $id, PDO::PARAM_INT);
$videoQuery->setFetchMode(PDO::FETCH_CLASS, "Video");
$videoQuery->execute();
$video = $videoQuery->fetch();

// veritabanından videoya gelen yorumları çekiyoruz
#Comment Query
$commentQuery = $db->prepare("select * from comments c,users u where c.user=u.user_id and c.video=:video");
$commentQuery->bindParam(":video", $id);
//$commentQuery->setFetchMode(PDO::FETCH_CLASS, "Comment");
$commentQuery->execute();
$comments = $commentQuery->fetchAll();

// veritabanından aynı türde olan 5 videoyu çekiyoruz
#Recommended Videos Query
$recommendedQuery = $db->prepare("select * from videos v,users u where v.owner=u.user_id and v.category=:category and v.video_id != :video order by created_at desc limit 5");
$recommendedQuery->bindParam(":category", $video->category_id);
$recommendedQuery->bindParam(":video", $id);
$recommendedQuery->setFetchMode(PDO::FETCH_CLASS, "Video");
$recommendedQuery->execute();
$recommended = $recommendedQuery->fetchAll();

// eğer get metoduyla gelen result değeri varsa
if (!empty($_GET["result"])) {

    // gelen değeri result değişkenine atıyoruz
    $result = $_GET["result"];

    // eğer result 1e eşitse
    if ($result === "1") {
        // ekrana script tagleri içinde js kodu yazdırıp alert fonksiyonuyla mesaj verdiriyoruz
        echo "<script>alert('Yorumunuz Başarıyla Kaydedildi.');</script>";
    }
}

?>

    <div class="video-container">
        <div class="video-wrapper">
            <video controls class="video">
                <source src="public/videos/<?= $video->url ?>" type="video/mp4">
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
            <!-- eğer giriş yapılmışsa ekrana yorum ekleme formunu yazdırıyoruz -->
            <? if (isset($_SESSION["id"])): ?>

                <form class="comment-form" method="POST" action="yeni-yorum.php">
                    <span>Yorum Yaz</span>
                    <input type="hidden" name="video" value="<?= $id ?>"/>
                    <textarea name="content" placeholder="Yorumunuz..."></textarea>
                    <button type="submit" name="yeni">Gönder</button>
                </form>
            <? else: ?>
                <!-- eğer giriş yapılmamışsa bilgilendirme mesajı yazdırıyoruz -->
                <p>Yorum yapmak için giriş yapmalısınız...</p>
            <? endif; ?>
            <? foreach ($comments as $comment): ?>
                <div class="comments">
                    <!-- foreach ile videoya gelen yorumları yazdırıyoruz -->
                    <div class="comment">
                        <h5><?= $comment["username"] ?></h5>
                        <time><?= $comment["created_at"] ?></time>
                        <p><?= $comment["content"] ?></p>
                    </div>

                </div>
            <? endforeach; ?>
        </div>
    </div>
    <aside class="recommend-video-container">
        <h4 class="recommended-title">Benzer Videolar</h4>
        <!-- foreach ile aynı türde olan videoları yazdırıyoruz -->
        <? foreach ($recommended as $video): ?>
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
    </aside>


<?php
// footerı dahil ediyoruz
require_once 'partials/footer.php';
?>
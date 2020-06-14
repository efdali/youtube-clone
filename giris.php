<?php
$title="Giriş Yap";
// header ve User modelini dahil ediyoruz
require_once 'partials/header.php';
include_once 'models/User.php';

// session varsa yani giriş yapılmışsa anasayfaya yönlendiriyoruz
if (isset($_SESSION["id"])) {
    header("Location:/");
}

// giriş isteği var mı?
if (isset($_POST["giris"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    // veritabanından username alanı formdan gelen username alanına eşit olan kaydı çekiyoruz
    $query = $db->prepare("select * from users where username=:username limit 1");
    $query->bindParam(":username", $username, PDO::PARAM_STR);
    $query->setFetchMode(PDO::FETCH_CLASS, "User");
    $query->execute();

    // eşleşen kayıt var mı?
    if ($query->rowCount()) {
        $user = $query->fetch();
        // veritabanındaki hashlenmiş şifre ile formdan gelen şifreyi karşılaştırıyoruz
        if (password_verify($password, $user->password)) {
            // doğruysa giriş yapan kullanıcının username ve id bilgilerini daha sonra kullanmak için sessionda depoluyoruz
            $_SESSION["username"] = $user->username;
            $_SESSION["id"] = $user->user_id;
            // anasayfaya yönlendiriyouz
            header("Location:index.php");
        }else{
            // şifre yanlışsa sayfaya script taglerini arasında js kodu yazdırıp alert ile mesaj veriyoruz
            echo "<script>alert('Şifreniz Yanlış.Yeniden Deneyin.');</script>";
        }
    }
}

?>

    <form method="POST" class="sign-form">
        <input type="text" name="username" placeholder="kullanıcı adı"/>
        <input type="password" name="password" placeholder="şifre"/>
        <button type="submit" name="giris">Giriş Yap</button>
    </form>


<?php
// footerı dahil ediyoruz
require_once 'partials/footer.php';
?>

<?php
// sayfanın başlığını değiştiriyoruz
$title="Kayıt Ol";
// header ve user modelini dahil ediyoruz
require_once 'partials/header.php';
include_once 'models/User.php';

// sesion varsa yani giriş yapılmışsa anasayfaya yönlendiriyoruz
if (isset($_SESSION["id"])) {
    header("Location:/");
}

// kayıt isteği var mı?
if (isset($_POST["kayit"])) {

    $username = $_POST["username"];
    $email = $_POST["email"];
    // formdan gelen şifreyi güvenlik için hashliyoruz
    $password = password_hash($_POST["password"],PASSWORD_DEFAULT);

    // veritabanına yeni kullanıcı bilgilerini kaydediyoruz
    $query = $db->prepare("insert into users set username=:username,email=:email, password=:password");
    $query->bindParam(":username", $username, PDO::PARAM_STR);
    $query->bindParam(":email", $email, PDO::PARAM_STR);
    $query->bindParam(":password", $password, PDO::PARAM_STR);
    $query->setFetchMode(PDO::FETCH_CLASS, "User");
    $insert = $query->execute();

    // eğer kayıt başarılıysa
    if ($insert) {
        // giriş sayfasına yönlendiriyoruz
        header("Location:giris.php");
    } else {
        // kayıt işleminde sorun varsa get parametreleriyle yönlendirme yapıyoruz
        header("Location:kayit.php?result=0&message=Bir Hata Oluştu...");
    }
}
// eğer kayıt işleminde hata varsa
if(isset($_GET["result"]) && $_GET["result"]==0){
    // ekrana script tagleri arasında js kodu yazdırıp alert fonksiyonuyla mesaj verdiriyoruz
    echo "<script>alert('Bir Hata Oluştu');</script>";
}

?>

    <form method="POST" class="sign-form">
        <input type="text" name="username" placeholder="kullanıcı adı"/>
        <input type="email" name="email" placeholder="email"/>
        <input type="password" name="password" placeholder="şifre"/>
        <button type="submit" name="kayit">Kayıt Ol</button>
    </form>


<?php
// footerı dahil ediyoruz
require_once 'partials/footer.php';
?>

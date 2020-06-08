<?php
require_once 'partials/header.php';
include_once 'classes/User.php';

if (isset($_SESSION["id"])) {
    header("Location:/");
}

if (isset($_POST["kayit"])) {

    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"],PASSWORD_DEFAULT);

    $query = $db->prepare("insert into users set username=:username,email=:email, password=:password");
    $query->bindParam(":username", $username, PDO::PARAM_STR);
    $query->bindParam(":email", $email, PDO::PARAM_STR);
    $query->bindParam(":password", $password, PDO::PARAM_STR);
    $query->setFetchMode(PDO::FETCH_CLASS, "User");
    $insert = $query->execute();

    if ($insert) {
        header("Location:giris.php");
    } else {
        header("Location:giris.php?result=0&message=Bir Hata Oluştu...");
    }
}

if(isset($_GET["result"]) && $_GET["result"]==0){
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
require_once 'partials/footer.php';
?>
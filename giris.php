<?php
require_once 'partials/header.php';
include_once 'classes/User.php';

if (isset($_SESSION["id"])) {
    header("Location:/");
}

if (isset($_POST["giris"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $query = $db->prepare("select * from users where username=:username limit 1");
    $query->bindParam(":username", $username, PDO::PARAM_STR);
    $query->setFetchMode(PDO::FETCH_CLASS, "User");
    $query->execute();

    if ($query->rowCount()) {
        $user = $query->fetch();
        if (password_verify($password, $user->password)) {
            $_SESSION["username"] = $user->username;
            $_SESSION["id"] = $user->user_id;
            header("Location:index.php");
        }else{
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
require_once 'partials/footer.php';
?>
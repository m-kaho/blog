<?php
if(isset($_SESSION["isLogin"])){
    $isLogin = $_SESSION["isLogin"];
    $user = $_SESSION["user"];
    $sUserid = $_SESSION['userid'];
    //ログインしているか確かめる
}

if(isset($_SESSION["isLogin"])){
    $log = '<a class="login" href="logout.php">ログアウト</a><a class="login" href="mypage.php">マイページ</a>';
}else{
    $log = '<a class="login" href="login.php">ログイン</a>';
}
?>
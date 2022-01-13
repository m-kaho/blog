<?php
if(isset($_SESSION["isLogin"])){
    $isLogin = $_SESSION["isLogin"];
    $user = $_SESSION["user"];
    $userid = $_SESSION['userid'];
    //ログインしているか確かめる
    if($isLogin == False){//ログインできていない場合
        header( "Location: login.php" ) ;
    }
}else{//セッション何もなかった場合
    header( "Location: login.php" ) ;
}    

if(isset($_SESSION["isLogin"])){
    $log = '<a class="log"href="logout.php">ログアウト</a>';
}else{
    $log = '<a class="log" href="login.php">ログイン</a>';
}
?>
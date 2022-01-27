<?php
    session_start();
?>
<link rel="stylesheet" href="mypage.css">
<?php
// if(isset($_SESSION["isLogin"])){
//     $isLogin = $_SESSION["isLogin"];
//     $user = $_SESSION["user"];
//     $userid = $_SESSION['userid'];
//     //ログインしているか確かめる
//     if($isLogin == False){//ログインできていない場合
//         header( "Location: login.php" ) ;
//     }
// }else{//セッション何もなかった場合
//     header( "Location: login.php" ) ;
// }      
require("checkLogin.php");


?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>my page</title>
</head>
<body>
    <header>
        <img src="logo/logo2.png" class="logoImage">
        <nav>
            <ul class="clearfix">
                <a class="view1" href="view1.php?page_num=1&userid=<?php echo $sUserid; ?>">閲覧画面</a>
                <?php
                    echo($log);
                ?>
                
                
            </ul>
        </nav>
    </header>
    <div class="main">
        <h1>ようこそ!<?php echo $user?>さん</h1>
        <a class="btn" href="post_page.php">投稿画面</a><br>
        <a class="btn" href="view3.php?page_num=1&userid=".$sUserid>削除・編集画面</a><br>
        <a class="btn" href="view4.php?page_num=1&userid=".$sUserid>日記画面</a>
    </div>
    <footer>
    <p id="copy">
        &copy;beginner's
    </p>
    </footer>
</body>
</html>

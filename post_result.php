<?php
    session_start();
?>
<?php
    if(isset($_SESSION["isLogin"])){
        $isLogin = $_SESSION["isLogin"];
        $user = $_SESSION["user"];
        $sUserid = $_SESSION["userid"];
        //ログインしているか確かめる
        if($isLogin == False){//ログインできていない場合
            header( "Location: login.php" ) ;
        }
    }else{//セッション何もなかった場合
        header( "Location: login.php" ) ;
    }  

    if(isset($_SESSION["postTitle"])){
        if($_SESSION["postTitle"] == NULL){//投稿していない
            header( "Location: post_page.php" ) ;
        }
        $title = $_SESSION["postTitle"];
        $content = $_SESSION["postContent"];
        $private = $_SESSION["postPrivate"];

        unset($_SESSION["postTitle"]);
        unset($_SESSION["postContent"]);
        unset($_SESSION["postPrivate"]);

    }else{//セッション何もなかった場合
        header( "Location: post_page.php" ) ;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PostResult</title>
</head>
<body>
    <div class="container">
        <h2>投稿できました</h2>
        <a href="view1.php?page_num=1&userid=".$sUserid>投稿を見に行く</a>
        <a href="post_page.php">戻る</a>
    </div>

</body>
</html>
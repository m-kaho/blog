<?php
    session_start();
?>
<link rel="stylesheet" href="post_result.css">
<?php
    require("checkLogin.php");
    
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
    <header>
        <img src="logo/logo2.png" class="logoImage">
        <nav>
            <ul class="clearfix">
            <a class="view1" href="main.php">メインページ</a>
                <?php
                    echo($log);
                ?>
            </ul>
        </nav>
    </header>
    <div class="container">
        <h2>投稿できました</h2>
        <a class="btn" href="post_page.php">戻る</a>
        <a class="btn" href="view1.php?page_num=1&userid=<?php echo $sUserid; ?>">投稿を見に行く</a>
    </div>
    <footer>
        <p id="copy">
            &copy;beginner's
        </p>
    </footer>
</body>
</html>

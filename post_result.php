<?php
    session_start();
?>
<?php
    if(isset($_SESSION["postTitle"])){
        if($_SESSION["postTitle"] == NULL){//ログインできていない場合
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
    <title>Document</title>
</head>
<body>
    <h2>以下の内容で投稿しました</h2>
    <h3>タイトル</h3>
    <p><?=$title?></p>
    <h3>本文</h3>
    <p><?=$content?></p>
    <h3>公開状態</h3>
    <?php
    if($private == 1){
        echo("<p>公開</p>");
    }else{
        echo("<p>非公開</p>"); 
    }
    ?>
    <a href="post_page.php">戻る</a>
</body>
</html>
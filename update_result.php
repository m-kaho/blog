<?php
    session_start();
?>
<?php
    if(isset($_SESSION["isLogin"])){
        $isLogin = $_SESSION["isLogin"];
        $user = $_SESSION["user"];
        //ログインしているか確かめる
        if($isLogin == False){//ログインできていない場合
            header( "Location: login.php" ) ;
        }
    }else{//セッション何もなかった場合
        header( "Location: login.php" ) ;
    }  
    
    if(isset($_SESSION["upId"])){
        if($_SESSION["upId"] == NULL){//ログインできていない場合
            header( "Location: view3.php?page_num=1" ) ;
        }
        $id = $_SESSION["upId"];
        $title = $_SESSION["upTitle"];
        $content = $_SESSION["upContent"];
        $private = $_SESSION["upPrivate"];

        unset($_SESSION["upId"]);
        unset($_SESSION["upTitle"]);
        unset($_SESSION["upContent"]);
        unset($_SESSION["upPrivate"]);

    }else{//セッション何もなかった場合
        header( "Location: view3.php?page_num=1" ) ;
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
    <h2>以下の内容で更新しました</h2>
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
    <a href="view3.php?page_num=1">戻る</a>
</body>
</html>
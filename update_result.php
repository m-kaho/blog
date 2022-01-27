<?php
    session_start();
?>
<link rel="stylesheet" href="update.css">

<?php
    require("checkLogin.php");
    
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
        //header( "Location: view3.php?page_num=1" ) ;
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
        <h2>更新しました</h2>
        <a class="btn" href="view3.php?page_num=1">戻る</a>
    </div>    
    <footer>
    <p id="copy">
        &copy;beginner's
    </p>
    </footer>
</body>
</html>

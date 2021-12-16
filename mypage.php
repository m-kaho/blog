<?php
    session_start();
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
    <?php
        //セッション変数を調べる
        if(isset($_SESSION["isLogin"])){
            $isLogin = $_SESSION["isLogin"];
            $user = $_SESSION["user"];
            //ログインしているか確かめる
            if($isLogin == True){//ログインできている場合
                echo ("<h2>".$user."さんのマイページ</h2>");
                echo ("<a href="."post_page.php".">投稿画面へ</a><br>");
                echo ("<a href="."view3.php?page_num=1".">削除・更新画面へ</a>");
            }else{//ログインしていない場合
                echo ("ログインされていません<br>");
                echo ("<a href="."login.php".">ログイン</a>");
            }
        }else{//セッション何もなかった場合
            echo ("セッションエラーです<br>ログインしなおしてください<br>");
            echo ("<a href="."login.php".">ログイン</a>");
        }
        
    ?>
</body>
</html>
<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="post_page.css">
    <title>PostPage</title>
</head>
<body>
    <?php
        //セッション変数を調べる
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
        
    ?>
        <h1>投稿画面</h1>
        <form id="post-form" method='post' action='post_page.php'>
        <h2>タイトルを入力してください</h2>
        <input type='text' id='title' name='title'>
        <h2>本文を入力して下さい</h2>
        <input type='text' id='content' name='content'>
        <br>
        <input type='radio' name='private' value='1' checked/>公開
        <input type='radio' name='private' value='2'/>非公開
        </br>
        </form>
        <button id='postBtn'>投稿</button>
        <div id='alert'>
        <p id='emptyTitle' class="hide">タイトルが空です</p>
        <p id='lengthTitle' class="hide">タイトルを40文字以下にしてください</p>
        <p id='emptyContent' class="hide">本文が空です</p>
    </div>
        <script>
            const post = document.querySelector('#postBtn');
            post.addEventListener('click', ()=> {
                console.log("ボタン押された");
                var title = document.getElementById('title').value;
                var content = document.getElementById('content').value
                let hideElement = document.querySelector('.show');
                console.log(hideElement);
            if(hideElement !== null){
                hideElement.className = 'hide';
            }
            if(title == ""){
                let element = document.querySelector('#emptyTitle');
                element.className = 'show';
                return;
            }
            if(title.length > 40){
                let element = document.querySelector('#lengthTitle');
                element.className = 'show';
                return;
            }
            if(content == ""){
                let element = document.querySelector('#emptyContent');
                element.className = 'show';
                return;
            }
            var result = window.confirm("投稿しますか？");
            if(result){
                const form = document.getElementById('post-form');
                form.submit();
            }

            }, false);
        </script>

    <?php
    if($_POST){
            $title = $_POST["title"];
            $content = $_POST["content"];
            $private = $_POST["private"];
            //sql文
            $sql =  'INSERT INTO
                post(title, content, private)
            VALUES
                (:title, :content, :private)';
            //userID
            $user = "postuser";
            //PassWord
            $pass = "e2k2021";

            try{
                //DBに接続
                $dbh = new PDO('mysql:host=localhost;dbname=blog', $user, $pass);
                // $dbh = null;
                //var_dump($dbh);
                // print "接続成功しています";
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(':title',$title, PDO::PARAM_STR);
                $stmt->bindValue(':content',$content, PDO::PARAM_STR);
                $stmt->bindValue(':private',$private, PDO::PARAM_INT);
                //DBに書き込み
                $stmt->execute();

                $_SESSION['postTitle'] = $title;
                $_SESSION['postContent'] = $content;
                $_SESSION['postPrivate'] = $private;
                header( "Location: post_result.php" ) ;
                $dbh = null;
            }catch (PDOException $e){
                print "エラー:".$e->getMessage()."</br>";
                die();
            }   

    }




        
        
        
    ?>

</body>
</html>
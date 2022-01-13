<?php
    session_start();
?>
<link rel="stylesheet" href="post.css">
    <?php
        require("checkLogin.php");
    ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PostPage</title>
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
    <div id='contents'>
        <form id="post-form" method='post' action='post_page.php'>
            <div class="post">
                <input type='text' id='title' name='title' placeholder="タイトルを入力してください"><br>
                <textarea name="content" id="content" cols="120" rows="10" placeholder="内容を入力してください"></textarea>
            </div>

            <br>
            <input type='radio' name='private' value='1' checked/>公開
            <input type='radio' name='private' value='2'/>非公開
            </br>
        </form>
        <div id='alert'>
            <p id='emptyTitle' class="hide">タイトルが空です</p>
            <p id='lengthTitle' class="hide">タイトルを40文字以下にしてください</p>
            <p id='emptyContent' class="hide">本文が空です</p>
        </div>
        <div>
        <button id='postBtn'>投稿</button>
        </div>


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
            $userid = $_SESSION["userid"];
            //echo($userid);
            //sql文
            $sql =  'INSERT INTO
                post(title, content, private, userid)
            VALUES
                (:title, :content, :private, :userid)';
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
                $stmt->bindValue(':userid',$userid, PDO::PARAM_INT);
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
    <!-- <footer>
        <p id="copy">&copy;beginner's</p>
    </footer> -->
</body>
</html>
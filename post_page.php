<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PostPage</title>
</head>
<body>
    <form method="post" action="post_page.php">
    <h1>titleを入力してください</h1>
    <input type="text" id="title" name="title">
    <h1>本文を入力して下さい</h1>
    <input type="text" id="content" name="content">
    <br>
    <input type="radio" name="private" value="1"/>公開
    <input type="radio" name="private" value="2"/>非公開
    </br>
    <input type="submit" name="add" value="投稿">
    </form>
    <?php
        if(isset($_POST['add'])){
            if(!isset($_POST["private"])){
                $_POST["private"]="";
            }
                $title = $_POST["title"];
                $content = $_POST["content"];
                $private = $_POST["private"];
            //echo($title." ".$content." ".$private);
            
            //タイトルが空だった時
            if(empty($title)){
                ?>
                <script>
                    alert('タイトルを入力してください');
                </script>
                <?php
                exit();
            }
            //内容がないとき
            if(empty($content)){
                ?>
                <script>
                    alert('内容を入力してください');
                </script>
                <?php
                exit();
            }
            //公開か非公開か選んでいない時
            if(empty($private)){
                ?>
                <script>
                    alert('公開か非公開か選んでください');
                </script>
                <?php
                exit();
            }
            //タイトルが41文字以上の時
            if(mb_strlen($title) > 40){
                ?>
                <script>
                    alert('タイトルを40文字以下にしてください');
                </script>
                <?php
                exit();
            }
            
            //sql文
            $sql =  'INSERT INTO
                        post(title, content, private)
                    VALUES
                        (:title, :content, :private)';
            $user = "postuser";
            $pass = "e2k2021";
        
            try{
                $dbh = new PDO('mysql:host=localhost;dbname=blog', $user, $pass);
                // $dbh = null;
                //var_dump($dbh);
                // print "接続成功しています";
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(':title',$title, PDO::PARAM_STR);
                $stmt->bindValue(':content',$content, PDO::PARAM_STR);
                $stmt->bindValue(':private',$private, PDO::PARAM_INT);
                $stmt->execute();
                ?>
                <script>
                    alert("投稿完了しました");
                </script>
                <?php
                $dbh = null;
            }catch (PDOException $e){
                print "エラー:".$e->getMessage()."</br>";
                die();
            }

        }
        
    ?>

</body>
</html>


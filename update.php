<?php
    session_start();
?>

<?php
if(empty($_GET['post_id'])){
    // echo('不正だよー');
    $_GET['post_id'] = NULL;
    exit('PostIDが不正です');
}
$id = $_GET['post_id'];

if($_POST) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $private = $_POST['private'];
    //echo($id);
    try {
        $sql = "UPDATE post SET title = :title, content = :content, private = :private, update_date = NOW() WHERE post_id = :id";
        $dbh = dbConnect();
        $stmt = $dbh->prepare($sql);
    
        $stmt->bindParam(':id',$id, PDO::PARAM_INT);
        $stmt->bindValue(':title',$title, PDO::PARAM_STR);
        $stmt->bindValue(':content',$content, PDO::PARAM_STR);
        $stmt->bindValue(':private',$private, PDO::PARAM_INT);
        
        $stmt->execute();

        $_SESSION['upId'] = $id;
        $_SESSION['upTitle'] = $title;
        $_SESSION['upContent'] = $content;
        $_SESSION['upPrivate'] = $private;

        header("Location: update_result.php");

    } catch (PDOException $e) {
        print "エラー発生：".$e->getMessage()."</br>";
        die();
    }
}

//echo($id);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="update.css">
    <title>更新画面</title>
</head>
<body>
    <?php

    function dbConnect(){
        $user = 'postuser';
        $pass = 'e2k2021';

        try {
            $dbh = new PDO('mysql:host=localhost;dbname=blog', $user, $pass);
            //var_dump($dbh);
        } catch (PDOException $e) {
            echo '接続失敗'.$e -> getMessage();
            die();
        }
        return $dbh;
    }

        //セッション変数を調べる
        if(isset($_SESSION["isLogin"])){
            $isLogin = $_SESSION["isLogin"];
            $user = $_SESSION["user"];
            //ログインしているか確かめる
            if($isLogin == False){//ログインできていない場合
                header( "Location: loginStatus.php" ) ;
            }
        }else{//セッション何もなかった場合
            header( "Location: loginStatus.php" ) ;
        }
        
        try {
            $dbh = dbConnect();
            $sql = 'SELECT * FROM post WHERE post_id =:id';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue('id',(int)$id,PDO::PARAM_INT);
            $stmt->execute();
            //var_dump($stmt);
            $data = $stmt->fetch();
            //var_dump($data);
            $dbh = NULL;
            $sql = NULL;
        } catch (PDOException $e) {
            print "エラー発生：".$e->getMessage()."</br>";
            die();
        }


        // echo($data['post_id']);
        // echo($data['title']);
        // echo($data['content']);
        // echo($data['private']);
        $pri = "<input type='radio' id = 'release' name='private' value='1'>
        <label for='release'>公開</label>
        <input type='radio' id = 'private' name='private' value='2' checked>
        <label for='private'>非公開</label>";
        $release = "<input type='radio' id = 'release' name='private' value='1' checked>
        <label for='release'>公開</label>
        <input type='radio' id = 'private' name='private' value='2'>
        <label for='private'>非公開</label>";

        $action = 'update.php?post_id='.$id;
    ?>
    <form id="edit-form" method='post' action="<?=$action?>">
    <h2>タイトル</h2>
    <input type="text" id='title' name='title' value='<?=$data['title']?>'>
    <h2>本文を入力してください</h2>
    <input type="text" id="content" name='content' value='<?=$data['content']?>'>
    <br>
    <?php
        if($data['private'] == 1){
            //echo('公開だよ');
            echo($release);
        }else{
            //echo("非公開だよ");
            echo($pri);
        }
    ?>
    <br>
    <!-- <input type="submit" name='update' value='更新'> -->
    </form>
    <button id="submitBtn">更新</button>
    <div id='alert'>
        <p id='emptyTitle' class="hide">タイトルが空です</p>
        <p id='lengthTitle' class="hide">タイトルを40文字以下にしてください</p>
        <p id='emptyContent' class="hide">本文が空です</p>
    </div>

    <script>
        const submit = document.querySelector('#submitBtn');
        submit.addEventListener('click', ()=> {
            var title = document.getElementById('title').value;
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
            if(document.getElementById('content').value == ""){
                let element = document.querySelector('#emptyContent');
                element.className = 'show';
                return;
            }
            

            var result = window.confirm('本当に更新しますか？');
            console.log(result);
            if(result) {
                const form = document.getElementById('edit-form');
                form.submit();

            }
        }, false);
    </script>
</body>
</html>
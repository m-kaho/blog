<?php
    session_start();
?>
<?php
//DBに接続するための関数
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


//postIDを確かめる
if(empty($_GET['post_id'])){
    // echo('不正だよー');
    $_GET['post_id'] = NULL;
    exit('PostIDが不正です');
}
$id = $_GET['post_id'];

//ログインしているかを確かめる
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
        
//データベースから投稿内容を取ってくる
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

//削除する
if($_POST) {
    $id = $_POST['post_id'];
    //echo($id);
    try {
        $sql = "DELETE FROM post WHERE post_id = :id";
        $dbh = dbConnect();
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':id',$id, PDO::PARAM_INT);
        $stmt->execute();
        $dbh = NULL;
        header( "Location: view3.php?page_num=1" ) ;
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
    <title>更新画面</title>
</head>
<body>
    <form id="delete-form" method='post' action="delete.php?post_id=<?=$id?>">
    <input type="hidden" value="<?=$id?>" name="post_id">
    </form>
<?php
if(!$data){
    echo('ページは削除されたか、URLが違います');
    return;
}
?>
    <h1>本当に削除しますか？</h1>
    <h2><?=$data['title']?></h2>
    <h3><?=$data['content']?></h3>
    <h3?>公開状態</h3>
    <?php
        if($data['private'] == 1){
            //echo('公開だよ');
            echo('<h3>公開</h3>');
        }else{
            //echo("非公開だよ");
            echo('<h3>非公開</h3>');
        }
    ?>
    <br>
    <a href="view3.php?page_num=1">戻る</a>
    <button id="deleteBtn">削除</button>
    
    <div>

    <script>
        const submit = document.querySelector('#deleteBtn');
        submit.addEventListener('click', ()=> {
            const form = document.getElementById('delete-form');
            form.submit();
        }, false);
    </script>
</body>
</html>
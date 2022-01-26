<?php
    session_start();
?>
<?php
require("checkLogin.php");
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
    $sUserid = $_SESSION["userid"];
    //ログインしているか確かめる
    if($isLogin == False){//ログインできていない場合
        header( "Location: login.php" ) ;
    }
}else{//セッション何もなかった場合
    header( "Location: login.php" ) ;
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
//投稿者のIDとセッションのIDが同じか
if($data['userid'] != $sUserid){
    header( "Location: view3.php?page_num=1&userid=".$sUserid ) ;
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
    <link href="delete.css" rel="stylesheet" type=text/css>
    <title>更新画面</title>
</head>
<body>
    <header>
        <img src="logo/logo2.png" class="logoImage">
        <nav>
            <ul class="clearfix">
                <a class="view1" href="view1.php?page_num=<?php echo $page; ?>">閲覧画面</a>
                <?php
                    echo($log);
                ?>
            </ul>
        </nav>
    </header>
    <form id="delete-form" method='post' action="delete.php?post_id=<?=$id?>">
    <input type="hidden" value="<?=$id?>" name="post_id">
    </form>
<?php
if(!$data){
    echo('ページは削除されたか、URLが違います');
    return;
}
?>
<div class="contents">
    <h1>本当に削除しますか？</h1>
    <br>
    <a href="view3.php?page_num=1" class="NoBtn">戻る</a>
    <button id="deleteBtn">削除</button>
</div>

    
    <script>
        const submit = document.querySelector('#deleteBtn');
        submit.addEventListener('click', ()=> {
            console.log("クリックされた");
            const form = document.getElementById('delete-form');
            form.submit();
        }, false);
    </script>
</body>
</html>
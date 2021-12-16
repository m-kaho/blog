<?php
    session_start();
?>


<?php
//セッション変数を調べる(変更点)
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

$title = "Mylog";
$user = "postuser";
$pass = "e2k2021";
//もしURLにGETの変数がついていない場合(変更点)
if($_GET['page_num']==NULL){
    header( "Location: view3.php?page_num=1" ) ;
}

$pageNum = $_GET['page_num'] - 1;
$by = 4;

try {
    $dbh = new PDO('mysql:host=localhost;dbname=blog', $user, $pass);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    //プリペアドステートメント
    $stmt = $dbh->prepare('select * from post order by post_id limit ?, ?');
    $stmt->execute(array($pageNum * $by, $by));
    $result = $stmt->fetchAll();

    $count = $dbh->query('select count(post_id) from post' );
    $cnt = $count->fetch(PDO::FETCH_NUM);

    $dbh = null;

} catch (PDOException $e) {
    print "エラー発生：".$e->getMessage()."</br>";
    die();
}

$id_sum = $cnt[0]; //総数
$max = ceil($id_sum / $by); //ページの最大値

if (!isset($_GET['page_num'])) {
    $page = 1;
  } else {
    $page = $_GET['page_num'];
  }

?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
</head>
<body>
    <h1><?= $user ?>のブログ</h1>
    <button onclick="location.href='login.php'">ログイン</button>
    <?php foreach($result as $content): ?>
    <div>
        <h2><a href="view2.php?post_id=<?= $content["post_id"] ?>"><?= $content["title"] ?></a></h2>
        <p><?= $content["content"].'…' ?></p>
        <p>投稿日:<?= $content["post_date"] ?>,最終更新日:<?=$content["update_date"] ?></p>
        <!-- 削除・更新画面へ移動する(変更点) -->
        <a href="update.php?post_id=<?=$content["post_id"]?>">更新</a> <a href="delete.php?post_id=<?=$content["post_id"]?>">削除</a>
    </div>
    <?php endforeach; ?>
    
    <?php if($id_sum > $by): ?>
    <?php  if ($page > 1 && $page!=$max): ?>
    <a href="view3.php?page_num=<?php echo ($page-1); ?>">前へ</a>
    <a href="view3.php?page_num=<?php echo ($page+1); ?>">次へ</a>
    <?php endif; ?>
    <?php  if ($page == $max): ?>
    <a href="view3.php?page_num=<?php echo ($page-1); ?>">前へ</a>
    <?php endif; ?>
    <?php  if ($page == 1): ?>
    <a href="view3.php?page_num=<?php echo ($page+1); ?>">次へ</a>
    <?php endif; ?>
    <?php endif; ?>
    <br>
    <?php echo '全'.$id_sum.'件' ; ?>
</body>
</html>


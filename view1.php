<?php
    session_start();
?>
<?php
error_reporting(0);
//phpinfo();
require('headerLogin.php');
$title = "Mylog";
$user = "postuser";
$pass = "e2k2021";

$pageNum = $_GET['page_num'] - 1;
$by = 4;

$userId = $_GET['userid'];

if(empty($_GET['page_num'])){
    exit('ページが存在しません');
}

if(empty($_GET['userid'])){
    exit('ページが存在しません');
}

function getUserData($userid){
    try {
        $user = "postuser";
        $pass = "e2k2021";
        $dbh = new PDO('mysql:host=localhost;dbname=blog', $user, $pass);
        $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $sql = 'SELECT username FROM user WHERE userid = :id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue('id',(int)$userid,PDO::PARAM_INT);
        $stmt->execute();
        $username = $stmt->fetch();
        $dbh = NULL;
        // var_dump($username);
        $dbh = null;
        return $username;
    } catch (PDOException $e) {
        print "エラー発生：".$e->getMessage()."</br>";
        die();
    }
}
try {
    $dbh = new PDO('mysql:host=localhost;dbname=blog', $user, $pass);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    //プリペアドステートメント
    $stmt = $dbh->prepare('select post.* from post,user where post.private=1 and post.userid=? and post.userid=user.userid order by post.post_id limit ?, ?');
    $stmt->execute(array($userId, $pageNum * $by, $by));
    $result = $stmt->fetchAll();

    $count = $dbh->prepare('select count(post.post_id) from post,user where post.private=1 and post.userid=? and post.userid=user.userid' );
    $count->execute(array($userId));
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
    <link href="view1.css" rel="stylesheet" type=text/css>
    <title><?= $title ?></title>
</head>
<body>
<header>
    <img src="logo/logo2.png">
    <nav>
        <ul class="clearfix">
            <a class="view1" href="main.php">メインページ</a>
            <?php echo($log);?>
        </ul>
    </nav>
</header>
<div class=contents>
    <?php
        $username = getUserData($userId);
        // var_dump($username);
    ?>
    <p class="page"><?= $username['username'] ?>さんのブログ</p>
    <?php foreach($result as $content): ?>
    <div>
        <h2><a class="title" href="view2.php?post_id=<?= $content["post_id"] ?>"><?= $content["title"] ?></a></h2>
        <p class="content"><?= mb_substr($content['content'],0,20).'…'; ?></p>
        <p class="date">投稿日:<?= $content["post_date"] ?> 最終更新日:<?=$content["update_date"] ?></p>
    </div>
    <?php endforeach; ?>

    <?php if($id_sum > $by): ?>
    <?php  if ($page > 1 && $page!=$max): ?>
    <a href="view1.php?page_num=<?php echo ($page-1); ?>&userid=<?php echo $userId; ?>">前へ</a>
    <a href="view1.php?page_num=<?php echo ($page+1); ?>&userid=<?php echo $userId; ?>">次へ</a>
    <?php endif; ?>
    <?php  if ($page == $max): ?>
    <a href="view1.php?page_num=<?php echo ($page-1); ?>&userid=<?php echo $userId; ?>">前へ</a>
    <?php endif; ?>
    <?php  if ($page == 1): ?>
    <a href="view1.php?page_num=<?php echo ($page+1); ?>&userid=<?php echo $userId; ?>">次へ</a>
    <?php endif; ?>
    <?php endif; ?>
    <br>
    <?php echo '全'.$id_sum.'件' ; ?>
</div>
<footer>
<p id="copy">
    &copy;beginner's
</p>
</footer>
</body>
</html>

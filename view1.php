<?php
//phpinfo();
$title = "ブログシステム";
$user = "postuser";
$pass = "2021";

$pageNum = $_GET['page_num'] - 1;
$by = 2;

try {
    $dbh = new PDO('mysql:host=localhost;dbname=blog', $user, $pass);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    //プリペアドステートメント
    $stmt = $dbh->prepare('select * from blog where private=1 order by post_id limit ?, ?');
    $stmt->execute(array($pageNum * $by, $by));
    $result = $stmt->fetchAll();

    $count = $dbh->query('select count(post_id) from blog where private=1' );
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
        <?php if ($content["private"] == 1): ?>
        <h2><a href="view2.php?post_id=<?= $content["post_id"] ?>"><?= $content["title"] ?></a></h2>
        <p>投稿日:<?= $content["post_date"] ?>,最終更新日:<?=$content["update_date"] ?></p>
        <p><?= $content["content"] ?></p>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
    
    <?php  if ($page > 1 && $page!=$max): ?>
    <a href="view1.php?page_num=<?php echo ($page-1); ?>">前へ</a>
    <a href="view1.php?page_num=<?php echo ($page+1); ?>">次へ</a>
    <?php endif; ?>
    <?php  if ($page == $max): ?>
    <a href="view1.php?page_num=<?php echo ($page-1); ?>">前へ</a>
    <?php endif; ?>
    <?php  if ($page == 1): ?>
    <a href="view1.php?page_num=<?php echo ($page+1); ?>">次へ</a>
    <?php endif; ?>

</body>
</html>

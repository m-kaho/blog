<?php
//phpinfo();
$title = "ブログシステム";
$user = "postuser";
$pass = "2021";


try {
    $dbh = new PDO('mysql:host=localhost;dbname=blog', $user, $pass);
    //プリペアドステートメント
    $stmt = $dbh->query('select * from blog');
    $dbh =null;
} catch (PDOException $e) {
    print "エラー発生：".$e->getMessage()."</br>";
    die();
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
    <button>ログイン</button>
    <?php foreach($stmt as $content): ?>
    <div>
        <h2><a href="view2.php?post_id=<?= $content["post_id"] ?>"><?= $content["title"] ?></a></h2>
        <p>投稿日:<?= $content["post_date"] ?>,最終更新日:<?=$content["update_date"] ?></p>
        <p><?= $content["content"] ?></p>
    </div>
    <?php endforeach; ?>
</body>
</html>


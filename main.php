<?php
    session_start();
?>

<?php
//データベースに接続
function dbConnect(){
    $user = 'postuser';
    $pass = 'e2k2021';
    try {
        $dbh = new PDO('mysql:host=localhost;dbname=blog', $user, $pass);
    } catch (PDOException $e) {
        echo '接続失敗'.$e -> getMessage();
        die();
    }
    return $dbh;
}
//pvが多い投稿を調べる
function pvPosts(){
    try {
        $dbh = dbConnect();
        $sql = 'SELECT * FROM post order by pv desc limit 5';
        $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();
        $dbh = null;
        // var_dump($data);
        return $data;
    } catch (PDOException $e) {
        echo '接続失敗'.$e -> getMessage();
        die();
    }
}
//ユーザーIDの引数からユーザー情報を取り出す
function searchPostID($userid){
    try {
        $dbh = dbConnect();
        $sql = 'SELECT * FROM user WHERE userid =:id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue('id',(int)$userid,PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch();
        $dbh = NULL;
        // var_dump($data);
        return $data;
    } catch (PDOException $eh) {
        print "エラー発生：".$e->getMessage()."</br>";
        die();
    }
}
//最近の投稿 TOP5をDBから取り出す
function recentPosts(){
    $dbh = dbConnect();
    $sql = 'SELECT * FROM post order by post_date desc limit 5';
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll();
    // var_dump($data);
    $dbh = null;
    return $data;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メイン</title>
</head>
<body>
    <h1>最近の投稿</h1>
    <?php
    //ループのカウント
    $count = 1;
    $result = recentPosts();
    foreach($result as $data):?>
        <h2><?=$count?>位</h2>
        <h3><a href="view2.php?post_id=<?=$data['post_id']?>"><?=$data['title']?></a></h3>
        <?php
        $user = searchPostID($data['userid']);//useridからユーザー情報を呼び出す
        ?>
        <a href="view1.php?userid=<?=$data['userid']?>&page_num=1"><?=$user['username']?></a><!-- ユーザーの投稿ページ -->
        <p><?=$data['post_date']?></p>
        <?php
        $count++;
    endforeach;

    ?>
    <h1>アクセス数</h1>
    <?php
    $result = pvPosts();
    $count = 1;
    //resultのデータすべてループ
    foreach($result as $data)://もし見た目に内容が必要であれば$data['content']で表示できます?>
        <h1><?=$count?>位</h1>
        <h2><a href="view2.php?post_id=<?=$data['post_id']?>"><?=$data['title']?></a></h2><!-- 投稿内容に飛ぶリンク -->
        <?php
        $user = searchPostID($data['userid']);//useridからユーザー情報を呼び出す
        ?>
        <a href="view1.php?userid=<?=$data['userid']?>&page_num=1"><?=$user['username']?></a><!-- ユーザーの投稿ページ -->
        <p><?=$data['post_date']?></p>
    <?php
    $count++; //ループのカウント
    endforeach;
    ?>
    <h1>最近の投稿が多いユーザー</h1>
</body>
</html>
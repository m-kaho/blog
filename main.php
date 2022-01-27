<?php
    session_start();
?>
<link rel="stylesheet" href="main.css">
<?php
require('headerLogin.php');
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
//登録されているユーザーが何人いるか調べる
function searchUser(){
    $dbh = dbConnect();
    $sql = 'SELECT count(userid) FROM user';
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetch();
    var_dump($data['count(userid)']);
    $dbh = null;
    return $data['count(userid)'];
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
    <div>
    <div class="main">
        <br><h1>"Mylog"<span style="color:gray">とは？</span></h1>
        <h4>
            Mylogとは、誰でも<span style="color:#f8a065">気軽に・簡単に</span>ブログを作成し・投稿できるサービスです。<br>
        </h4>
        <br>
        <h2>            
        <span style="color:gray">今すぐ</span>Mylog<span style="color:gray">を始めよう！</span><br>
        </h2>
        <h4>
            <a class="register" href="register.php">新規登録</a>
        </h4>
        <br>
        <p class="none"> </p>
        <br>
        <h1>最近の投稿</h1>
        <?php
        //ループのカウント
        $count = 1;
        $result = recentPosts();
        ?>
        <div class='recentPosts'>
        <?php
        foreach($result as $data):?>
            <div class='box'>
                <h2><?=$count?>位</h2>
                <h3><a href="view2.php?post_id=<?=$data['post_id']?>"><?=mb_substr($data['title'],0,8).'...'?></a></h3>
                <?php
                $user = searchPostID($data['userid']);//useridからユーザー情報を呼び出す
                ?>
                <a href="view1.php?userid=<?=$data['userid']?>&page_num=1"><?=$user['username']?></a><!-- ユーザーの投稿ページ -->
                <p class="post_date"><?=$data['post_date']?></p>
            </div>

            <?php
            $count++;
        endforeach;
        ?>
        </div>
        <h1>アクセス数</h1>
        <div class="pvRanking">
        <?php
        $result = pvPosts();
        $count = 1;
        //resultのデータすべてループ
        foreach($result as $data)://もし見た目に内容が必要であれば$data['content']で表示できます?>
            <div class='box'>
            <h2><?=$count?>位</h2>
            <h3><a href="view2.php?post_id=<?=$data['post_id']?>"><?=mb_substr($data['title'],0,8).'...'?></a></h3><!-- 投稿内容に飛ぶリンク -->
            <?php
            $user = searchPostID($data['userid']);//useridからユーザー情報を呼び出す
            ?>
            <a href="view1.php?userid=<?=$data['userid']?>&page_num=1"><?=$user['username']?></a><!-- ユーザーの投稿ページ -->
            <p><?=$data['pv']?>PV</p>
            </div>
        <?php
        $count++; //ループのカウント
        endforeach;
        ?>
        </div>
    </div>
    
    <footer>
    <p id="copy">
        &copy;beginner's
    </p>
    </footer>

</body>
</html>

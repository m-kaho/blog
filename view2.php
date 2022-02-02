<?php
if($_GET['post_id']) {
    $id = $_GET['post_id'];
}

if(empty($id)){
    exit('IDが不正です');
}

function dbConnect(){
$dsn='mysql:host=localhost;dbname=blog;charset=utf8';
$user= 'postuser';
$pass='e2k2021';
try{
    $dbh =new PDO($dsn,$user,$pass,[
        PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES =>false,
    ]);
}catch(PDOException $e){
    echo '接続失敗'.$e ->getMessage();
    exit('');
}
return $dbh;
}
require("pvCounter.php");
$dbh=dbConnect();
//SQL準備
$stmt = $dbh->prepare('SELECT * FROM post Where post_id =:id');
$stmt->bindValue(':id',(int)$id,PDO::PARAM_INT);
//SQL実行
$stmt->execute();
//結果を取得
$result =$stmt->fetch(PDO::FETCH_ASSOC);
if(!$result){
    exit('このブログは非表示です');
}
//コメント情報の表示
$stmt = $dbh->prepare('SELECT comment.comment, comment.time FROM comment INNER JOIN post ON comment.post_id=post.post_id Where post.post_id=:id');
// $stmt = $dbh->prepare('SELECT * FROM comment INNER JOIN post ON comment.post_id=post.post_id Where post.post_id=:id');
//SQL実行
$stmt->execute(array("id" => $id));
//結果を取得
$comments =$stmt->fetchAll(PDO::FETCH_ASSOC);
    
// var_dump($comments);
$dbh=null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="view2.css"type="text/css">
    <title>ブログ詳細</title>
</head>
<body>
    <div class="container">
        <header>
            <img src="logo/logo2.png">
            <nav>
                <ul class="clearfix">
                <a class="view1" href="main.php">メインページ</a>
                    <a class="login" href="login.php">ログイン</a>
                </ul>
            </nav>
        </header>
        <div class="main">
                <!-- <h2><?php //echo $result['user'] ?>のブログ</h2> -->
                <h2><?php echo $result['title'] ?></h2>
                <p id="time">投稿日時:<?=$result["post_date"] ?>,最終更新日:<?=$result["update_date"] ?></p>
                <p id="main"><?php echo $result['content'] ?></p> 
                <!--コメント欄-->
                <form action="coment.php" method ="POST" >
                    <input type="hidden" name="post_id" value="<?= $id ?>">           
                    <textarea name="comment" id="comment" cols="30" rows="3" size="100" placeholder="コメントする" required></textarea>
                    <br>
                    <input type="submit" type="submit" value="送信する">      
                </form>
                
                <div class="comment">
                        <form method ="POST" action="coment.php">
                            <table id="comment" border="1">
                                    <tr>
                                        <th>コメント</th>
                                        <th>時間</th>
                                    </tr>
                                    <?php foreach($comments as $value):?>
                                    <tr>    
                                            <th><?php echo $value['comment']?></th>
                                            <th><?php echo $value['time']?></th>
                                    </tr>
                                    <?php endforeach; ?>
                            </table>
                        </from>
                </div>
            </div>
            <footer>
                <a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false">Tweet</a>
                <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                <p id="copy">&copy;beginner's</p>
            </footer>
    </div>
</body>
</html>

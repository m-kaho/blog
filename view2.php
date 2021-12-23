<?php
$id=1;
//$id = $_GET['post_id'];

if(empty($id)){
    exit('IDが不正です');
}

function dbConnect(){
$dsn='mysql:host=localhost;dbname=blog;charset=utf8';
$user= 'postuser';
$pass='2021';
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

// コメントデータを取得
require_once("read_memofile.php");
$commets = readComment();
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
   <header>
   <img src="logo/logo2.png">
    <nav>
        <ul class="clearfix">
            <a class="view1" href="view1.php?page_num=<?php echo $page; ?>">閲覧画面</a>
            <a class="login" href="login.php">ログイン</a>
        </ul>
    </nav>
   </header>
   <div class="main">
        <!-- <h2><?php //echo $result['user'] ?>のブログ</h2> -->
        <h2><?php echo $result['title'] ?></h2>
        <p id="time">投稿日時:<?=$result["post_date"] ?>,最終更新日:<?=$result["update_date"] ?></p>
        <p id="main"><?php echo $result['content'] ?></p>
        <form method ="POST" action="write_memofile.php">            
            <textarea name="memo" cols="30" rows="5" maxlength="100" placeholder="コメントする" required></textarea>
            <br>
            <input type="submit" type="submit" value="送信する">            
       </form>


        <form method ="POST" action="write_memofile.php">       
            <?php
                foreach($commets as $value){
                    // var_dump($value);
                    // echo("<br>");
                    echo"<li>".$value['datetime'].":".$value["text"]."</li>\n";
                }
            ?>  

        </form>

    </div>
<footer>
<p id="copy">
    &copy;beginner's
</p>
</footer>
</body>
</html>

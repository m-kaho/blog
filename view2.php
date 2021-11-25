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


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ブログ詳細</title>
</head>
<body>
    <!-- <h2><?php //echo $result['user'] ?>のブログ</h2> -->
    <h3>タイトル:<?php echo $result['title'] ?></h3>
    <p>投稿日時:<?=$result["post_date"] ?>,最終更新日:<?=$result["update_date"] ?>></p>
    <hr>
    <p>本文:<?php echo $result['content'] ?></p>
    <p>コメント：</p>
        <textarea name="content" id="content" cols="30" rows="10"></textarea>
        <br>
    <button>コメントする</button>
</body>
</html>
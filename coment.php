<?php
session_start();

if($_SESSION["isLogin"]=="true"){
    $postId = $_POST["post_id"];
    $comment = $_POST["comment"];
    // var_dump($comment);

    function dbConnect(){
        $dsn='mysql:host=localhost;dbname=blog;charset=utf8';
        $user= 'postuser';
        $pass='e2k2021';
        try{
            return new PDO($dsn,$user,$pass,[
                PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES =>false,
            ]);
        } catch(PDOException $e){
            echo '接続失敗'.$e ->getMessage();
            exit('');
        }
    }   

    $dbh=dbConnect();
    $sql= 'INSERT INTO comment(comment, post_id) VALUES (:comment, :post_id)';

    try{
        $stmt = $dbh->prepare($sql);
        $stmt ->execute(array(
            "comment" => $comment,
            "post_id" => $postId,
        ));
    }catch(PDOException $e){
        exit($e);
    }
header("Location: view2.php?post_id=" . $postId);
}
else{
        header("Location:login.php");
        return;
}
?>

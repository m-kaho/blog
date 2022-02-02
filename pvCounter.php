<?php

try {
    $dbh = dbConnect();
    $sql = 'SELECT pv FROM post WHERE post_id =:id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue('id',(int)$id,PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetch();
    $dbh=NULL;
    $sql=NULL;
    $pv = $data['pv'] + 1;
} catch (PDOException $e) {
    print "エラー発生：".$e->getMessage()."</br>";
    die();
}

try {
    $dbh = dbConnect();
    $sql = "UPDATE post SET pv = :pv WHERE post_id = :id";
    $stmt = $dbh->prepare($sql);

    $stmt->bindParam(':pv',$pv, PDO::PARAM_INT);
    $stmt->bindValue('id',(int)$id,PDO::PARAM_INT);
    $stmt->execute();
} catch (PDOException $e) {
    print "エラー発生：".$e->getMessage()."</br>";
    die();
}
?>

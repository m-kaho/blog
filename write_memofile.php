<?php
if(empty($_POST["memo"])){
    $url="http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
    header("Location:" . $url . "localhost/view2.php");
    exit();

}
$memo =$_POST["memo"];
$date =date("Y/n/j G:i:s",time());
$writedata = $date . "%%" . $memo . "\n";
$filename ="memo.txt";
try{
    $fileObj =new SplFileObject($filename,"a+b");
}catch(Exception $e){
    echo'<span class="error">エラーが派生しました</span><br>';
    echo $e->getMessaeg();
    exit();
}

$fileObj->flock(LOCK_EX);
$result = $fileObj->fwrite($writedata);
$fileObj->flock(LOCK_UN);

$url="http://" . $SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
header("Location:" . $url . "localhost/view2.php");
exit();
?>
<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login page</title>
</head>
<body>
        <?php
            //セッション変数を調べる
            if(isset($_SESSION["isLogin"])){
                $isLogin = $_SESSION["isLogin"];
                $user = $_SESSION["user"];
                //echo($isLogin);
                //ログイン出ているか確かめる
                if($isLogin == True){//Trueだった場合
                    header( "Location: loginStatus.php" ) ;
                }
            }

        ?>
    <form method="post" action="login.php">
    <h2>ユーザーネームを入力してください</h2>
    <input type="text" id="username" name="username">
    <h2>パスワードを入力してください</h2>
    <input type="password" id="password" name="password">
    <br>
    <input type="submit" name="login" value="ログイン">
    </form>
    <?php
        // session_start();

        if(isset($_POST['login'])){
            $data = [];
            $username = $_POST["username"];
            $password = $_POST["password"];
            //echo($username." ".$password);

            if(empty($username)){
                ?>
                <script>
                    alert('ユーザーネームを入力してください');
                </script>
                <?php
                die();
            }
            if(empty($password)){
                ?>
                <script>
                    alert('パスワードを入力してください');
                </script>
                <?php
                die();
            }

            

            try {
                //userID
                $user = "postuser";
                //PassWord
                $pass = "e2k2021";
                $sql = 'SELECT * FROM user WHERE username = :username';
                $dbh = new PDO('mysql:host=localhost;dbname=blog', $user, $pass);
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->execute();
                $data = $stmt->fetch();
                //var_dump($data);


            }catch (PDOException $e){
                print "エラー:".$e->getMessage()."</br>";
                die();
            }

            if(!$data){
                ?>
                <script>
                    alert("ユーザーネームかパスワードが間違っています");
                </script>
                <?php
                die();
            }
            if($password != $data["password"]){
                ?>
                <script>
                    alert("ユーザーネームかパスワードが間違っています");
                </script>
                
                <?php
                die();
            }else{
                $_SESSION['user'] = $username;
                $_SESSION['isLogin'] = True;
                header( "Location: loginStatus.php" ) ;
            }
        }
    ?>





    
</body>
</html>
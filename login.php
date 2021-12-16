<?php
    session_start();
?>
<?php
//ログインしているか調べる
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
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="login.css" rel="stylesheet" type=text/css>
    <title>login page</title>
</head>
<body>

    <header>
        <img src="logo/logo2.png" class="logoImage">
        <nav>
            <ul class="clearfix">
                <a class="view1" href="view1.php?page_num=<?php echo $page; ?>">閲覧画面</a>
                <a class="login" href="login.php">ログイン</a>
            </ul>
        </nav>
    </header>
    <div class="contents">
        <h1>ログイン</h1>
        <form id='login-form' method="post" action="login.php">
        <div class="inputForm">
            <input type="text" id="username" name="username" placeholder="ログインID"><br>
            <input type="password" id="password" name="password" placeholder="パスワード">
        </div>
        <div id=alert>
            <p id='emptyUsername' class='hide'>ユーザーネームを入力して下さい</p>
            <p id='emptyPassword' class='hide'>パスワードを入力してください</p>
            <p id='different' class='hide'>ユーザーネームかパスワードが間違っています</p>
        </div>
        </form>
        <button id="loginBtn">ログイン</button>
    </div>
    <footer>
        <p id="copy">&copy;beginner's</p>
    </footer>
    
    <script>
        const submit = document.querySelector('#loginBtn');
        submit.addEventListener('click', ()=> {
            var username = document.getElementById('username').value;
            var password = document.getElementById('password').value;
            let hideElement = document.querySelector('.show');
            if(hideElement !== null){
                hideElement.className = 'hide';
            }
            if(username == ""){
                let element = document.querySelector('#emptyUsername');
                element.className = 'show';
                return;
            }
            if(password == ""){
                let element = document.querySelector('#emptyPassword');
                element.className = 'show';
                return;
            }
            const form = document.getElementById('login-form');
            form.submit();
        })
    </script>
<?php
//ログインボタンを押されてPOSTが飛んできたとき
if($_POST){
    // echo("押されたよ");
    $data = [];
    $username = $_POST["username"];
    $password = $_POST["password"];
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
            let element = document.querySelector('#different');
            element.className = 'show';
        </script>
        <?php
        die();
    }
    if($password != $data["password"]){
        ?>
        
        <script>
            let element = document.querySelector('#different');
            element.className = 'show';
        </script>
        
        <?php
        die();
    }else{
        $_SESSION['user'] = $username;
        $_SESSION['isLogin'] = True;
        header( "Location: mypage.php" ) ;
    }
}
?>
</body>
</html>
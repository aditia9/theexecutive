<?php
//defined('__NOT_DIRECT') || define('__NOT_DIRECT',1);
include 'cek-akses.php';

if($_POST){
	mysqli_connect(DB_HOST,DB_USER,DB_PASS);
	mysqli_select_db($db,'theexecu_magentoback') or die(mysqli_error($db));
	$userId = mysqli_real_escape_string($db, $_POST['user_id']);
	$data = mysqli_fetch_array(mysqli_query($db, "select * from tbl_user where user_id='".$userId."'"));
	if($data !== false && $data['password'] == md5($_POST['password'])){
		//login berhasil
		$_SESSION['tipe_user'] = $data['type'];
		$_SESSION['user_id'] = $data['user_id'];
		$_SESSION['my_user_agent'] = md5($_SERVER['HTTP_USER_AGENT']);
		header("Location: admin/index.php");
	}else{
		echo "ID User atau password salah!";
	}
}
?>

<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="css/login.css">
        <link rel="stylesheet" type="text/css" href="buttons/css/buttons.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>

<body>
 <div class="container">
        <div class="card card-container">
            <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
            <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
            <p id="profile-name" class="profile-name-card"></p>
            <form class="form-signin" method="post" action="">
                 <span id="reauth-email" class="reauth-email"></span>
                <input type="text" id="user_id" name="user_id" class="form-control" placeholder="username" required autofocus>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                <div id="remember" class="checkbox">
                    <label>
                        <input type="checkbox" value="Login"> 
                    </label>
                </div>
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" value="login">Sign in</button>
            </form><!-- /form -->
            
        </div><!-- /card-container -->
    </div><!-- /container -->

    <script type="text/javascript" src="css/login.js"></script>
</body>
</html>

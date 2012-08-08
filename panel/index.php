<?php
include_once '../config.php';
if((!isset($_SESSION['logged'])) || (@$_SESSION['logged'] != 'yes')) {

		if((isset($_POST['user'])) && (isset($_POST['password']))) {
			$user = trim(strip_tags($_POST['user']));
			$password = md5(trim(strip_tags($_POST['password'])));

			$sql = "SELECT id FROM admin WHERE user = :user AND password = :password";
			$sth = $db->prepare($sql);
			$sth->bindValue(':user', $user);
			$sth->bindValue(':password', $password);
			$sth->execute();
			$say = $sth->rowCount();

			if($say == 1){
				$_SESSION['logged'] = 'yes';
				header("Location: admin.php");
			}
			else{
				echo "<style type=\"text/css\" media=\"all\">#error {display: block !important;}</style>";
			}
		}
	}
else{
	header("Location: admin.php");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=7" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Herkobi CMS - Yönetim Paneli</title>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/custom.js"></script>  
	<style type="text/css" media="all">
	@import url("css/style.css");
	</style>
	
	<!--[if lt IE 9]>
	<style type="text/css" media="all"> @import url("css/ie.css"); </style>
	<![endif]-->
</head>

<body class="loginpage">
	<div id="header">
		<h1><a href="admin.php">HERKOBİ</a></h1>
		<a href="<?=$SITE_ADRESI;?>" class="backlink">&laquo; Siteyi Göster</a>			
	</div>			
  <!-- #header ends -->
      	
  <div id="content" class="loginbox">
  <div id="error"><div class="message errormsg"><p>Kullanıcı adı veya şifreniz yanlış. Lütfen tekrar deneyiniz.</p></div></div>				
		<form action="" method="post">
			<p>
				<label>Kullanıcı Adı:</label> <br />
				<input type="text" class="text" name="user" />
			</p>
			
			<p>
				<label>Şifre:</label> <br />
				<input type="password" class="text" name="password" />
			</p>
			
			<p class="formend">
				<input type="submit" class="submit" value="Giriş" /> &nbsp; 
			</p>
		</form>
	</div>		
  <!-- .loginbox ends -->
</body>
</html>

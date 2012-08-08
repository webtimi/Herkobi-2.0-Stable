<?php
require_once '../config.php';
if((!isset($_SESSION['logged'])) || (@$_SESSION['logged'] != 'yes')) { header("Location: index.php"); die; }

require_once 'inc/functions.php';

	if(isset($_POST['user']) && (isset($_POST['password']) && (isset($_POST['passwordagain'])))) {
				$user = @$_POST['user'];
				$password = @$_POST['password'];
				$passwordagain = @$_POST['passwordagain'];

  class Kullanici{
		public $VeriKont;

		public function __construct(){
			global $db;
			$this->db = $db;
		}

		public function kullaniciEkle($user, $password, $passwordagain){

				$user = trim(strip_tags($user));
				$password = md5(trim(strip_tags($password)));
				$passwordagain = md5(trim(strip_tags($passwordagain)));

				if(($user == "") || ($password == "") || ($passwordagain == "")) {
	                $_SESSION['var'] = 'Lütfen formdaki bütün alanları doldurunuz!';
	                $this->VeriKont = false;
	            }
	            else if ($password != $passwordagain){
	            	$_SESSION['var'] = 'Yazdığınız şifreler birbiriyle uyuşmuyor.';
	            	$this->VeriKont = false;
	            }
	            else if ($user != ""){
	            	$sql = "SELECT user FROM admin WHERE user = :user";
	            	$sth = $this->db->prepare($sql);
	            	$sth->bindValue(':user', $user);
	            	$sth->execute();
	            	$sth->fetchAll();
	            	$say = $sth->rowCount();
	            	if($say >= 1){
	            		$_SESSION['var'] = "Bu kullanıcı daha önce eklenmiş.";
	            		$this->VeriKont = false;
	            	}
                else{
                $sql = "INSERT INTO admin (
                        user, 
                        password)
		            			VALUES (
                        :user, 
                        :password)";
		            		$sth = $this->db->prepare($sql);
			            	$sth->bindValue(':user', $user);
			            	$sth->bindValue(':password', $password);
		            		if($sth->execute()){
                      $this->VeriKont = true;
		            		}
		            	return $this->VeriKont;
                }
              }
		}
	}
    $Veri = new Kullanici;
        $Veri->kullaniciEkle($user, $password, $passwordagain);
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=7" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Yönetici Bilgileri | Herkobi CMS Yönetim Paneli</title>
	<meta name="description" content="." />
	<meta name="keywords" content="." />
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/custom.js"></script>
	<style type="text/css" media="all">
	@import url("css/style.css");
	</style>
	<!--[if lt IE 9]>
	<style type="text/css" media="all"> @import url("css/ie.css"); </style>
	<![endif]-->

  <?php
  if(isset($_POST['user']) && (isset($_POST['password']) && (isset($_POST['passwordagain'])))) {
    if($Veri->VeriKont){
      echo "<style type=\"text/css\" media=\"all\">#success {display: block;}</style>";
    } else {
      echo "<style type=\"text/css\" media=\"all\">#error {display: block;}</style>";
        if(isset($_SESSION['var'])) {
          $HataSebep = $_SESSION['var'];
          unset($_SESSION['var']);
          echo "<style type=\"text/css\" media=\"all\">#warning {display: block;}</style>";
        }
      }
    }
  ?>
</head>
<body>
	<div id="header">
		<h1><a href="admin.php">HERKOBİ</a></h1>
		<div class="userprofile">
			<ul>
				<li><a href="user.php"><img src="images/avatar.gif" alt="" /> admin</a></li>
				<li><a href="<?php echo $SITE_ADRESI; ?>" target="_blank">Siteyi Göster</a></li>
				<li><a href="logout.php">Oturumu Kapat</a></li>
			</ul>
		</div>		<!-- .userprofile ends -->
	</div>			
  <!-- #header ends -->
  <div id="sidebar">	
		<ul id="nav">
			<li><a href="admin.php"><img src="images/nav/dashboard.png" alt="" /> Başlangıç</a></li>
			<li><a href="#" class="collapse"><img src="images/nav/pages.png" alt="" /> Sayfalar</a>
				<ul>
					<li><a href="pages.php">Sayfalar</a></li>
					<li><a href="page-add.php">Sayfa Ekle</a></li>
				</ul>
      </li>
      <li><a href="#" class="collapse"><img src="images/nav/rss.png" alt="" /> Haberler</a>
				<ul>
					<li><a href="posts.php">Haberler</a></li>
					<li><a href="post-add.php">Haber Ekle</a></li>
	        <li><a href="post-categories.php">Kategoriler</a></li>
				</ul>      
	    </li>
      <li><a href="#" class="collapse"><img src="images/nav/product.png" alt="" /> Ürünler</a>
				<ul>
					<li><a href="products.php">Ürünler</a></li>
					<li><a href="product-add.php">Ürün Ekle</a></li>
          <li><a href="product-categories.php">Kategoriler</a></li>
          <li><a href="brands.php">Markalar</a></li>
				</ul>
			</li>
      <li><a href="#" class="collapse"><img src="images/nav/media.png" alt="" /> Galeriler</a>
        <ul>
          <li><a href="galleries.php">Albümler</a></li>
          <li><a href="slide.php">Manşet</a></li>
        </ul>
      </li>
      <li><a href="#" class="collapse"><img src="images/nav/links.png" alt="" /> Linkler</a>
        <ul>
          <li><a href="links.php">Link Ekle</a></li>
          <li><a href="link-categories.php">Kategoriler</a></li>
        </ul>
      </li>  
	    <li><a href="files.php"><img src="images/nav/files.png" alt="" /> Dosyalar</a></li>
      <li><a href="#"><strong><img src="images/nav/settings.png" alt="" /> Ayarlar</strong></a>
				<ul>
					<li><a href="info.php">Firma Bilgileri</a></li>
					<li><a href="settings.php">Site Bilgileri</a></li>
          <li><a href="user.php">Yönetici Bilgileri</a></li>
          <li><a href="user-add.php">Yeni Kullanıcı</a></li>
				</ul>
	    </li>
    </ul>
  </div>		
  <!-- #sidebar ends -->
	
	<div id="content">
		<div class="breadcrumb">
			<a href="admin.php">Başlangıç</a> &raquo; <a href="user-add.php">Kullanıcı Ekle</a>
		</div>		
    <!-- .breadcrumb ends -->
    
    <div id="success"><div class="message success"><p>Kullanıcı başarılı bir şekilde kayıt edildi.</p></div></div>
    <div id="error"><div class="message errormsg"><p>Hata oluştu, lütfen tekrar deneyiniz.</p></div></div>
    <div id="warning"><div class="message warning"><p><?php echo @$HataSebep; ?></p></div></div>
    
		<h2>Yeni Kullanıcı Ekleme Paneli</h2>
		<form id="bilgi" action="" method="post">
		  <div class="textbox half kleft">
			 
       <h2>Yeni Kullanıcı Bilgileri</h2>
			
			 <div class="textbox_content">
        <p><label>Yeni Kullanıcı Adı:</label><br /><input type="text" size="71" class="text" name="user" /></p>
        <p><label>Yeni Şifreniz:</label><br /><input type="password" size="71" class="text" name="password" /></p>
        <p><label>Yeni Şifreniz (Tekrar):</label><br /><input type="password" size="71" class="text" name="passwordagain" /></p>                 
			 </div>
		  </div>
      <div class="textbox half kright">
        <h2>Kaydet</h2>        
        <div class="textbox_content">
          <p>
            <input type="submit" class="submit" value="Kaydet" />
            <input type="reset" class="submit disabled" value="İptal" />
          </p>
        </div>      
      </div>            
		</form>
  </div>
</body>
</html>
<?php
require_once '../config.php';
if((!isset($_SESSION['logged'])) || (@$_SESSION['logged'] != 'yes')) { header("Location: index.php"); die; }

require_once 'inc/functions.php';

		$sql = "SELECT id, user FROM admin";
		$sth = $db->prepare($sql);
		$db->query("SET NAMES 'UTF8'");
		if($sth->execute()){
			$uyeler = $sth->fetchAll();
			$uyelerSay = count($uyeler);
		}
		else {
			die;
		}

	if(isset($_GET['duzelt'])){
		$id = $_GET['duzelt'];
		if(!is_numeric($id)){
			$id = 1;
		}
		$DuzenleSonuc = duzelt("id, user, password", "admin", $id);
	}

	if(isset($_POST['user']) && (isset($_POST['passwordold']) && (isset($_POST['password'])) && (isset($_GET['duzelt'])) && ($_GET['duzelt'] != ""))) {
				$user = @$_POST['user'];
				$passwordold = @$_POST['passwordold'];
				$password = @$_POST['password'];
				$passwordagain = @$_POST['passwordagain'];

	class Kullanici{
		public $VeriKont;

		public function __construct(){
			global $db;
			$this->db = $db;
		}

		public function kullaniciDuzenle($id, $user, $passwordold, $password, $passwordagain){

				$user = trim(strip_tags($user));
				$passwordold = md5(trim(strip_tags($passwordold)));
				$password = md5(trim(strip_tags($password)));
				$passwordagain = md5(trim(strip_tags($passwordagain)));

				if(($user == "") || ($passwordold == "") || ($password == "") || ($passwordagain == "")) {
	                $_SESSION['var'] = 'Lütfen formdaki bütün alanları doldurunuz!';
	                $this->VeriKont = false;
	          }
	          else if ($password != $passwordagain){
	            	$_SESSION['var'] =  'Yeni şifreleriniz aynı değil, lütfen tekrar deneyiniz.';
	            	$this->VeriKont = false;
	          }
            else if ($passwordold != ""){
	            	$sql = "SELECT id FROM admin WHERE password = :paold AND user = :user";
	            	$sth = $this->db->prepare($sql);
	            	$sth->bindValue(':paold', $passwordold);
                $sth->bindValue(':user', $user);
	            	$sth->execute();
	            	$sth->fetchAll();
	            	$say = $sth->rowCount();
	            	if($say == 0){
	            		$_SESSION['var'] =  'Eski şifreniz yanlış.';//eski sifre yanlissa
	            		$this->VeriKont = false;
	            	}
	            if ($user != ""){
		            	$sql = "SELECT user FROM admin WHERE user = :user";
		            	$sth = $this->db->prepare($sql);
		            	$sth->bindValue(':user', $user);
		            	$sth->execute();
		            	$sth->fetchAll();
		            	$say = $sth->rowCount();
		            	if($say == 0){
		            		$_SESSION['var'] =  'Böyle bir kullanıcı bulunamadı';
		            		$this->VeriKont = false;
		            	}
			            else{
			            	$sql = "UPDATE admin
			            			SET
				            			user = :user,
				            			password = :password
			            			WHERE id = :id";
			            	$sth = $this->db->prepare($sql);
			            	$sth->bindValue(':id', $id);
				            $sth->bindValue(':user', $user);
				            $sth->bindValue(':password', $password);
			            	$this->db->query("SET NAMES 'utf8'");
				            	if($sth->execute()){
				            		$this->VeriKont = true;
				            	}
				            	else{
				            		$this->VeriKont = false;
				            	}
				            	return $this->VeriKont;
			            }
					     }
	            }
	        }
	    }
				$Veri = new Kullanici;
					$Veri->kullaniciDuzenle($id, $user, $passwordold, $password, $passwordagain);
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
  if(isset($_POST['user']) && (isset($_POST['passwordold']) && (isset($_POST['password'])) && (isset($_GET['duzelt'])) && ($_GET['duzelt'] != ""))) {
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
      <li><a href="#" class="collapse"><img src="images/nav/rss.png" alt="" /> Yazılar</a>
				<ul>
					<li><a href="posts.php">Yazılar</a></li>
					<li><a href="post-add.php">Yazı Ekle</a></li>
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
			<a href="admin.php">Başlangıç</a> &raquo; <a href="user.php">Kullanıcı Bilgileri</a>
		</div>		<!-- .breadcrumb ends -->
    
    <div id="success"><div class="message success"><p>Kullanıcı bilgileri başarılı bir şekilde değiştirildi.</p></div></div>
    <div id="error"><div class="message errormsg"><p>Hata oluştu, lütfen tekrar deneyiniz.</p></div></div>
    <div id="warning"><div class="message warning"><p><?php echo @$HataSebep; ?></p></div></div>
    
		<h2>Kullanıcı Bilgileri</h2>
		
		<form id="kullanici" action="" method="post">
		  <div class="textbox half kleft">
			 <h2>Yönetici Bilgileri Değiştir</h2>
			
			 <div class="textbox_content">
        <p><label>Kullanıcı Adı:</label><br /><input type="text" size="71" class="text" name="user" value="<?php echo @$DuzenleSonuc[0]['user']; ?>" /></p>
        <p><label>Eski Şifre:</label><br /><input type="password" size="71" class="text" name="passwordold" /></p>       
        <p><label>Yeni Şifre:</label><br /><input type="password" size="71" class="text" name="password" /></p>       
        <p><label>Yeni Şifre (Tekrar):</label><br /><input type="password" size="71" class="text" name="passwordagain" /></p>       
			 </div>
		  </div>

      <div class="textbox half kright">
        <h2>Kullanıcılar</h2>        
        <div class="textbox_content">
      <div class="textbox_content">
			 <table cellpadding="0" cellspacing="0" width="100%" class="sortable">
				<thead>
					<tr>
						<th>Kullanıcı Adı</th>
						<th>Düzenle</th>
						<th>Sil</th>
					</tr>
				</thead>
				
				<tbody>
					<?php
						for($i=0;$i<$uyelerSay;$i++){
							echo '
							<tr>
								<td><strong><a href="?duzelt='.@$uyeler[$i]["id"].'">'.@$uyeler[$i]["user"].'</a></strong></td>
								<td><a href="?duzelt='.@$uyeler[$i]["id"].'">Düzenle</a></td>
								<td class="delete"><a class="kl" alt="'.@$uyeler[$i]["id"].'" href="#"><img src="images/close.png" alt="Delete" title="Delete" /></a></td>
							</tr>';
						}
						echo '<i>*: En az bir kullanıcı olmak zorundadır.</i>';
					?>
         </tbody>
        </table>      
      </div>
  </div>
  </div>
      <div class="textbox half kright">
        <h2>Kaydet</h2>        
        <div class="textbox_content">
          <p>
            <input type="submit" class="submit" value="Kaydet" />
            <input type="submit" class="submit disabled" disabled="disabled" value="İptal" />
          </p>
        </div>  
      </div>
		</form>
  </div>
</body>
</html>
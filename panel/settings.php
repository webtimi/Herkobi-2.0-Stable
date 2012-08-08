<?php
require_once '../config.php';
if((!isset($_SESSION['logged'])) || (@$_SESSION['logged'] != 'yes')) { header("Location: index.php"); die; }

	$sql = "SELECT * FROM settings";//Daha önce site kaydedilmiş mi kontrolü
	$sth = $db->prepare($sql);
	$db->query("SET NAMES 'UTF8'");
	$sth->execute();
	$say = $sth->rowCount();

	if(($say == 0) || (isset($_POST['d']))) {

	if(isset($_POST['title'])){
				$title = @$_POST['title'];
				$metadesc = @$_POST['metadesc'];
				$metatags = @$_POST['metatags'];
				$category = @$_POST['category'];
				$newproducts = @$_POST['newproducts'];
				$latestposts = @$_POST['latestposts'];
				$posts = @$_POST['posts'];
				$products = @$_POST['products'];
				$home = @$_POST['home'];

  class Site{
		public $VeriKont;

		public function __construct(){
			global $db;
			$this->db = $db;
		}

		public function siteEkle($title, $metadesc="", $metatags="", $category="", $newproducts="", $latestposts="", $posts="", $products="", $home){
				if($title == "") {
	            $_SESSION['var'] = "Lütfen site adını giriniz!";
              $this->VeriKont = false;
	      }
        else if(isset($title)) {
              $sql = "INSERT INTO settings (
                        title, 
                        metadesc, 
                        metatags,
						category,
						newproducts,
						latestposts,
						posts,
						products,
                        home)
                      VALUES (
                        :title, 
                        :metadesc, 
                        :metatags,
						:category,
						:newproducts,
						:latestposts,
						:posts,
						:products,						
                        :home)";
		          $sth = $this->db->prepare($sql);
			            $sth->bindValue(':title', $title);
			            $sth->bindValue(':metadesc', $metadesc);
			            $sth->bindValue(':metatags', $metatags);
						$sth->bindValue(':category', $category);
						$sth->bindValue(':newproducts', $newproducts);
						$sth->bindValue(':latestposts', $latestposts);
						$sth->bindValue(':posts', $posts);
						$sth->bindValue(':products', $products);
						$sth->bindValue(':home', $home);
                      if($sth->execute()){
                        $this->VeriKont = true;
                      }
                      return $this->VeriKont;
	      }
	  }

		public function siteDuzenle($id, $title, $metadesc="", $metatags="", $category="", $newproducts="", $latestposts="", $posts="", $products="",  $home){
				if($title == "") {
	            $_SESSION['var'] = "Lütfen site adı giriniz!";
              $this->VeriKont = false;
	      }
        else{
	            $sql = "UPDATE settings SET 
                        title = :title, 
                        metadesc = :metadesc, 
                        metatags = :metatags,
						category = :category,
						newproducts = :newproducts,
						latestposts = :latestposts,
						posts = :posts,
						products = :products,						
                        home = :home
	            			WHERE id = :id";
	            $sth = $this->db->prepare($sql);
	            		$sth->bindValue(':id', $id);
		            	$sth->bindValue(':title', $title);
		            	$sth->bindValue(':metadesc', $metadesc);
		            	$sth->bindValue(':metatags', $metatags);
						$sth->bindValue(':category', $category);
						$sth->bindValue(':newproducts', $newproducts);
						$sth->bindValue(':latestposts', $latestposts);
						$sth->bindValue(':posts', $posts);
						$sth->bindValue(':products', $products);						
						$sth->bindValue(':home', $home);
                    $this->db->query("SET NAMES 'utf8'");
                    $sth->execute();
                    $sonuc = $sth->fetchAll();
                    $say = $sth->rowCount();
                    if($say >= 1){
                      $this->VeriKont = true;
                    } else {
                      $this->VeriKont = false;
                    }
                    return $this->VeriKont;
	      }
	  }
	}

	$Veri = new Site;
				if(isset($_POST['d']) && ($_POST['d'] == 1)) {
						$id = $_POST['d']; // yazinin id'si
				if(!is_numeric($id)){
						$id = 1;
					}
						$Veri->SiteDuzenle($id, $title, $metadesc, $metatags, $category, $newproducts, $latestposts, $posts, $products, $home);
					}
					else{
						$Veri->SiteEkle($title, $metadesc, $metatags, $category, $newproducts, $latestposts, $posts, $products, $home);
					}
	}
	}
	else{
		$sonuc = $sth->fetchAll();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=7" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Site Bilgileri | Herkobi CMS Yönetim Paneli</title>
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
	if(isset($_POST['title'])){
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
					<li><a href="page-add.php">Yeni Sayfa</a></li>
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
			<a href="admin.php">Başlangıç</a> &raquo; <a href="settings.php">Site Bilgileri</a>
		</div>		<!-- .breadcrumb ends -->
    
    <div id="success"><div class="message success"><p>Site bilgileri başarıyla kayıt edildi.</p></div></div>
    <div id="error"><div class="message errormsg"><p>İşlem gerçekleşmedi. Bir hata oluştu.</p></div></div>
    <div id="warning"><div class="message warning"><p><?php echo @$HataSebep; ?></p></div></div>
    
		<h2>Site Bilgileri</h2>
		<form id="bilgi" action="" method="post">
		  <div class="textbox left">
			 <h2>Site Tanımlama Bilgileri</h2>
			
			 <div class="textbox_content">
        <p><label>Site Adı:</label><br /><input type="text" size="100" class="text" name="title" value="<?php echo @$sonuc[0]['title']; ?>" /></p>
        <p><label>Site Açıklaması:</label><br /><textarea rows="4" cols="103" id="metadesc" name="metadesc" /><?php echo @$sonuc[0]['metadesc']; ?></textarea></p>
        <p><label>Anahtar Kelimeler:</label><br /><input type="text" size="100" class="text" name="metatags" value="<?php echo @$sonuc[0]['metatags']; ?>" /></p>                 
			 </div>
		  </div>
      <div class="textbox right">
        <h2>Kaydet</h2>        
        <div class="textbox_content">
          <p>
          	<input type="hidden" name="d" id="d" value="<?php echo @$sonuc[0]['id']; ?>"/><br />
            <input type="submit" class="submit" value="Kaydet" />
            <input type="submit" class="submit disabled" disabled="disabled" value="İptal" />
          </p>
        </div>      
      </div>
      <div class="textbox left">
        <h2>Limitler</h2>
        <div class="textbox_content">
          <p>
            Bu bölümde listeleme yapılan değerlerin sayılarını belirleyebilirsiniz.<br />
          </p>
		  <table cellpadding="5" cellspacing="5" border="0">
			<tbody>
				<tr>
					<td>Ana Sayfada gösterilecek <b>kategori</b> sayısı</td>
					<td><input type="text" size="5" class="text" name="category" value="<?php echo @$sonuc[0]['category']; ?>" /></td>
				</tr>
				<tr>
					<td>Ana Sayfada gösterilecek <b>yeni ürün</b> sayısı</td>
					<td><input type="text" size="5" class="text" name="newproducts" value="<?php echo @$sonuc[0]['newproducts']; ?>" /></td>
				</tr>
				<tr>
					<td>Ana Sayfada gösterilecek <b>son yazılar</b> sayısı</td>
					<td><input type="text" size="5" class="text" name="latestposts" value="<?php echo @$sonuc[0]['latestposts']; ?>" /></td>
				</tr>
				<tr>
					<td>Yazılar sayfasında gösterilecek her sayfada ki <b>yazı</b> sayısı</td>
					<td><input type="text" size="5" class="text" name="posts" value="<?php echo @$sonuc[0]['posts']; ?>" /></td>
				</tr>
				<tr>
					<td>Ürünler ve markalar sayfalarında gösterilecek her sayfada ki <b>ürün</b> sayısı</td>
					<td><input type="text" size="5" class="text" name="products" value="<?php echo @$sonuc[0]['products']; ?>" /></td>
				</tr>				
			</tbody>
		  </table>
        </div>
      </div>

      <div class="textbox left">
        <h2>Ana Sayfa Yazısı</h2>
        <div class="textbox_content">
          <p>
            Ana sayfada sabit yazı yayınlamak istiyorsanız bu alana yazınızı girebilirsiniz.<br />
            Yazınızın görünmesi için temanızda ilgili yerin oluşturulması gerekmektedir.
          </p>
          <p><textarea name="home" rows="7" cols="104"><?php echo @$sonuc[0]['home']; ?></textarea></p>
        </div>
      </div>            
		</form>
  </div>
</body>
</html>
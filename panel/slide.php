<?php
include_once '../config.php';
if((!isset($_SESSION['logged'])) || (@$_SESSION['logged'] != 'yes')) { header("Location: index.php"); die; }

if(isset($_POST['description']) && (isset($_POST['image'])) && (isset($_POST['url']))) {

	$description = @$_POST['description'];
	$image = @$_POST['image'];	$image = str_replace($SITE_ADRESI."/","",$image);
	$url = @$_POST['url'];

	
	class Slide{

		public $VeriKont;


		public function __construct(){
			global $db, $SITE_ADRESI;
			$this->db = $db;
			$this->SITE_ADRESI = $SITE_ADRESI;
		}

		public function slideEkle($description="", $image, $url=""){
				if($image == "") {
					$_SESSION['var'] = "Lütfen manşet alanında kullanacağınız resminizi belirtiniz!";
					$this->VeriKont = false;
	            }
		        else{
		            $sql = "INSERT INTO slide ( 
                              description, 
                              image,
                              url)
                            VALUES (
                              :description, 
                              :image,
                              :url)";
		            		$sth = $this->db->prepare($sql);
		            		$sth->bindValue(':description', $description);
		            		$sth->bindValue(':image', $image);
							$sth->bindValue(':url', $url);
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
  
  $Veri = new Slide;

				$Veri->slideEkle($description, $image, $url);
			//} buradan kaldırıldı
  }
    
	$sql = "SELECT * FROM slide";
    $sth = $db->prepare($sql);
    $db->query("SET NAMES 'utf8'");
    $sth->execute();

    $TumGaleriler = $sth->fetchAll();
    $TumGalerilerSay = count($TumGaleriler);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head>	<meta http-equiv="X-UA-Compatible" content="IE=7" />	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	<title>Afiş Ekle | Herkobi CMS Yönetim Paneli</title>	<meta name="description" content="." />	<meta name="keywords" content="." />  <?php	if(isset($_POST['description']) && (isset($_POST['image'])) && (isset($_POST['url']))) {    if($Veri->VeriKont){      echo "<style type=\"text/css\" media=\"all\">#success {display: block;}</style>";    } else {      echo "<style type=\"text/css\" media=\"all\">#error {display: block;}</style>";        if(isset($_SESSION['var'])) {          $HataSebep = $_SESSION['var'];          unset($_SESSION['var']);          echo "<style type=\"text/css\" media=\"all\">#warning {display: block;}</style>";        }      }  }  ?>    <!-- elFinder -->	<script src="elfinder/js/jquery-1.6.1.min.js" type="text/javascript" charset="utf-8"></script>  <script type="text/javascript" src="js/jquery-ui.min.js"></script>  <script type="text/javascript" src="js/custom.js"></script>	<script src="elfinder/js/jquery-ui-1.8.13.custom.min.js" type="text/javascript" charset="utf-8"></script>		<link rel="stylesheet" href="elfinder/css/smoothness/jquery-ui-1.8.13.custom.css" type="text/css" media="screen" title="no title" charset="utf-8">		<link rel="stylesheet" href="elfinder/css/elfinder.css" type="text/css" media="screen" title="no title" charset="utf-8">  <script type="text/javascript" src="js/jquery.fancybox.js"></script>                  <style type="text/css" media="all">                    @import url("css/style.css");                    @import url("css/jquery.fancybox.css");                </style>		<script src="elfinder/js/elFinder.js" type="text/javascript" charset="utf-8"></script>	<script src="elfinder/js/elFinder.view.js" type="text/javascript" charset="utf-8"></script>	<script src="elfinder/js/elFinder.ui.js" type="text/javascript" charset="utf-8"></script>	<script src="elfinder/js/elFinder.quickLook.js" type="text/javascript" charset="utf-8"></script>	<script src="elfinder/js/elFinder.eventsManager.js" type="text/javascript" charset="utf-8"></script>	<script src="elfinder/js/i18n/elfinder.tr.js" type="text/javascript" charset="utf-8"></script>  <script type="text/javascript" charset="utf-8">  $().ready(function() {    var opt = {      // Must change variable name    url : 'elfinder/connectors/php/connector.php',    lang : 'tr',    editorCallback : function(url) {document.getElementById('field').value=url;},    // Must change the form field id    closeOnEditorCallback : true,    docked : false,    dialog : { title : 'Dosya Yöneticisi', height: 500 },    }    $('#open').click(function() {                        // Must change the button's id    $('#finder_browse').elfinder(opt)                // Must update the form field id    $('#finder_browse').elfinder($(this).attr('id'));   // Must update the form field id    })                  });  </script>    <!-- elFinder -->                  <script type="text/javascript">                    $().ready(function() {                        $("a.modal").fancybox({                            'transitionIn'	:	'elastic',                            'transitionOut'	:	'elastic',                            'speedIn'		:	600,                             'speedOut'		:	200,                             'overlayShow'	:	true,                            'titlePosition'	:       'over'                        });                    });                </script>		<!--[if lt IE 9]>	<style type="text/css" media="all"> @import url("css/ie.css"); </style>	<![endif]--></head><body>	<div id="header">		<h1><a href="admin.php">HERKOBİ</a></h1>		<div class="userprofile">			<ul>				<li><a href="user.php"><img src="images/avatar.gif" alt="" /> admin</a></li>				<li><a href="<?php echo $SITE_ADRESI; ?>" target="_blank">Siteyi Göster</a></li>				<li><a href="logout.php">Oturumu Kapat</a></li>			</ul>		</div>		<!-- .userprofile ends -->	</div>			  <!-- #header ends -->  <div id="sidebar">			<ul id="nav">			<li><a href="admin.php"><img src="images/nav/dashboard.png" alt="" /> Başlangıç</a></li>			<li><a href="#" class="collapse"><img src="images/nav/pages.png" alt="" /> Sayfalar</a>				<ul>					<li><a href="pages.php">Sayfalar</a></li>					<li><a href="page-add.php">Sayfa Ekle</a></li>				</ul>      </li>      <li><a href="#" class="collapse"><img src="images/nav/rss.png" alt="" /> Yazılar</a>				<ul>
					<li><a href="posts.php">Yazılar</a></li>
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
      <li><a href="#"><strong><img src="images/nav/media.png" alt="" /> Galeriler</strong></a>
        <ul>
          <li><a href="galleries.php">Albümler</a></li>
          <li><a href="slide.php">Manşet</a></li>
        </ul>
      </li>      <li><a href="#" class="collapse"><img src="images/nav/links.png" alt="" /> Linkler</a>        <ul>          <li><a href="links.php">Link Ekle</a></li>          <li><a href="link-categories.php">Kategoriler</a></li>        </ul>      </li>  	    <li><a href="files.php"><img src="images/nav/files.png" alt="" /> Dosyalar</a></li>      <li><a href="#" class="collapse"><img src="images/nav/settings.png" alt="" /> Ayarlar</a>				<ul>					<li><a href="info.php">Firma Bilgileri</a></li>					<li><a href="settings.php">Site Bilgileri</a></li>          <li><a href="user.php">Yönetici Bilgileri</a></li>          <li><a href="user-add.php">Yeni Kullanıcı</a></li>				</ul>	    </li>    </ul>  </div>		  <!-- #sidebar ends -->		<div id="content">		<div class="breadcrumb">			<a href="admin.php">Başlangıç</a> &raquo; <a href="slide.php">Manşet Ekle</a> 		</div>		<!-- .breadcrumb ends -->    <div id="success"><div class="message success"><p>Manşetiniz başarılı bir şekilde kayıt edildi.</p></div></div>    <div id="error"><div class="message errormsg"><p>Hata oluştu, lütfen tekrar deneyiniz.</p></div></div>    <div id="warning"><div class="message warning"><p><?php echo @$HataSebep; ?></p></div></div>   		<h2>Manşet Ekle</h2>				<form action="" method="post">		  <div class="textbox left">			 <h2>Manşet Bilgileri</h2>						 <div class="textbox_content">        <p class="fileupload">          <label>Manşet:</label>          <div id="finder_browse"></div>          <input type="text" id="field" name="image" value="" />          <input type="button" id="open" class="file" value="Resim Seç" />                    </p>        <p><label>Bağlantı Adresi:</label><br /><input type="text" size="100" class="text" name="url" /><br /><small>Boş bırakmak için # koyunuz</small></p>        <p><label>Manşet Yazısı:</label><br /><input type="text" size="100" class="text" name="description" /></p>         			 </div>		  </div>		        <div class="textbox right">        <h2>Kaydet</h2>                <div class="textbox_content">          <p>            <input type="submit" class="submit" value="Kaydet" />            <input type="submit" class="submit disabled" disabled="disabled" value="İptal" />          </p>        </div>            </div>      		</form>		  <div class="textbox left">			 <h2>Manşet İçeriği</h2>						 <div class="textbox_content">        <ul class="imglist">          <?php            for($i=0;$i<$TumGalerilerSay;$i++){              echo '                    <li>                      <img src="'.$SITE_ADRESI."/".$TumGaleriler[$i]["image"].'" />                      <ul>                        <li class="view"><a href="'.$SITE_ADRESI."/".$TumGaleriler[$i]["image"].'" class="modal" rel="gallery">Göster</a></li>                        <li class="delete"><a class="sl" alt="'.$TumGaleriler[$i]["id"].'" href="#">Sil</a></li>                      </ul>                    </li>                ';             }          ?>                                                     </ul>                			 </div>		  </div>		  </div></body></html>
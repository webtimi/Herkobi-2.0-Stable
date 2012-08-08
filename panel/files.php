<?php
include("../config.php");
if((!isset($_SESSION['logged'])) || (@$_SESSION['logged'] != 'yes')) { header("Location: index.php"); die; }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=7" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Dosyalar | Herkobi CMS Yönetim Paneli</title>
	<meta name="description" content="." />
	<meta name="keywords" content="." />
  
	<style type="text/css" media="all">
	@import url("css/style.css");
	</style>
  
	<!-- elFinder -->
  <script src="elfinder/js/jquery-1.6.1.min.js" type="text/javascript" charset="utf-8"></script>
  <script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/custom.js"></script>
	<script type="text/javascript" src="elfinder/js/jquery-ui-1.8.13.custom.min.js" charset="utf-8"></script>
	
	<link rel="stylesheet" href="elfinder/css/smoothness/jquery-ui-1.8.13.custom.css" type="text/css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="elfinder/css/elfinder.css" type="text/css" media="screen" title="no title" charset="utf-8">

	<script src="elfinder/js/elFinder.js" type="text/javascript" charset="utf-8"></script>
	<script src="elfinder/js/elFinder.view.js" type="text/javascript" charset="utf-8"></script>
	<script src="elfinder/js/elFinder.ui.js" type="text/javascript" charset="utf-8"></script>
	<script src="elfinder/js/elFinder.quickLook.js" type="text/javascript" charset="utf-8"></script>
	<script src="elfinder/js/elFinder.eventsManager.js" type="text/javascript" charset="utf-8"></script>

	<script src="elfinder/js/i18n/elfinder.tr.js" type="text/javascript" charset="utf-8"></script>

	<script type="text/javascript" charset="utf-8">
		$().ready(function() {
			var f = $('#finder').elfinder({
				url : 'elfinder/connectors/php/connector.php',
				lang : 'tr',
				docked : true,
				// editorCallback : function(url) { window.console.log(url) },
				// closeOnEditorCallback : false,
				selectMultiple : true,
				dialog : {
					title : 'Dosya Yöneticisi',
					height : 500
				}
			})
			
		})
	</script>
  
	<style type="text/css">
		#close, #open, #dock, #undock, #destroy {
			width: 100px;
			position:relative;
			display: -moz-inline-stack;
			display: inline-block;
			vertical-align: top;
			zoom: 1;
			*display: inline;
			margin:0 3px 3px 0;
			padding:1px 0;
			text-align:center;
			border:1px solid #ccc;
			background-color:#eee;
			margin:1em .5em;
			padding:.3em .7em;
			border-radius:5px; 
			-moz-border-radius:5px; 
			-webkit-border-radius:5px;
			cursor:pointer;
		}
	</style>
  <!-- elFinder -->	
	<!--[if lt IE 9]>
	<style type="text/css" media="all"> @import url("css/ie.css"); </style>
	<![endif]-->
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
	    <li><a href="files.php"><strong><img src="images/nav/files.png" alt="" /> Dosyalar</strong></a></li>
      <li><a href="#" class="collapse"><img src="images/nav/settings.png" alt="" /> Ayarlar</a>
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
			<a href="admin.php">Başlangıç</a> &raquo; <a href="files.php">Dosyalar</a>
		</div>		<!-- .breadcrumb ends -->
    
    <h2>Dosyalar</h2>
    
    <div class="textbox">
      <h2>Dosyaları Yönet</h2>
      <div class="textbox_content">
      <div id="finder"></div>
      </div>
    </div>	
	</div>

</body>
</html>

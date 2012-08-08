<?php

	/* Genel Ayarlar */
	include "config.php";
	
	/* Tema Yapısı */
	include "inc/rain.tpl.class.php";
	include "inc/settings.php";

	/* Sabit Değerler */
	include "info.php";
	
	/* Listeleme ve Fonksiyonlar */
	include "static.php";	
     
	
	/* Genel SEO Bilgileri */
	$header = "SELECT * FROM `settings`";  
	$sth = $db->prepare($header);
	$db->query("SET NAMES 'UTF8'");
	$sth->execute();
	$result = $sth->fetchAll();
  
		$title    = $result[0]['title'];
		$metadesc = $result[0]['metadesc'];
		$metatags = $result[0]['metatags'];
    
    $tpl->assign( "title", $title );
    $tpl->assign( "metadesc", $metadesc );
    $tpl->assign( "metatags", $metatags );	
	
	
	/* Slide */
	$sql = "SELECT * FROM slide ORDER BY id ASC";
	$sth = $db->prepare($sql);
	$db->query("SET NAMES 'utf8'");
	$sth->execute();
	$result = $sth->fetchAll();
	
	$tpl->assign( "slide", $result );	
	
	
	/* Yeni Ürünler */
	$sql = "SELECT `id`, `product`, `price`, `image`, currency FROM `products` WHERE `publish` = 'Yayınlandı' ORDER BY `id` DESC LIMIT 0,".$newproducts."";  
	$sth = $db->prepare($sql);
	$db->query("SET NAMES 'UTF8'");
	$sth->execute();
	$result = $sth->fetchAll();				
  
	$tpl->assign( "newproducts", $result );
  
	
	/* Ana Sayfada Gösterilecek Ürün Kategorileri */
	$sql = "SELECT `id`, `category`, `image` FROM `productcategories` WHERE `front` = '1' ORDER BY `category` ASC LIMIT 0, ".$category."";  
	$sth = $db->prepare($sql);
	$db->query("SET NAMES 'UTF8'");
	$sth->execute();
	$result = $sth->fetchAll();				
  
	$tpl->assign( "frontcategories", $result );  
  
	
	/* Son Yazılar */
	$sql = "SELECT `id`, `post`, `image`, `summary` FROM `posts` ORDER BY `id` DESC LIMIT 0,".$latestposts."";
	$sth = $db->prepare($sql);
	$db->query("SET NAMES 'UTF8'");
	$sth->execute();
	$result = $sth->fetchAll();				
  
	$tpl->assign( "latestposts", $result );     
	
	echo $tpl->draw( 'index', $return_string = true );

?>
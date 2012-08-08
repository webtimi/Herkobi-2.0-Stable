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
	
	
	/* Kategori Kontrolü */	
	$id = 0;
	
	if  ($_GET) {
		
		@$id = strip_tags(trim($_GET['id']));
		
		/* Kategoriye Ait Ürünleri Listele */
		$sql = "SELECT id, product, image, brand, code, price, currency FROM products WHERE publish = 'Yayınlandı' AND category LIKE '%-$id-%' ORDER BY id DESC";
		$sth = $db->prepare($sql);
		$db->query("SET NAMES 'UTF8'");
		$sth->execute();
		$result = $sth->fetchAll();
						
		$tpl->assign("products", $result);	
		
		
		/* Varsa Kategorinin Alt Kategorilerini Listele */
		$sql = "SELECT id, category FROM productcategories WHERE mid = ".intval($id)."";
		$sth = $db->prepare($sql);
		$db->query("SET NAMES 'utf8'");
		$sth->execute();
		$result = $sth->fetchAll();
		
		$tpl->assign("subcategories", $result);

		
		/* Kategori Adını Yazdır */
		$sql = "SELECT id, category FROM productcategories WHERE id = ".intval($id)."";
		$sth = $db->prepare($sql);
		$db->query("SET NAMES 'utf8'");
		$sth->execute();
		$result = $sth->fetchAll();
		
			$category = $result[0]['category'];
		
		$tpl->assign("category_name", $category);
	
	} else {
		
		/* Kategorisiz Ürünleri Listele */
		$sql = "SELECT id, product, image, brand, code, price, currency FROM products WHERE publish = 'Yayınlandı' ORDER BY id DESC";
		$sth = $db->prepare($sql);
		$db->query("SET NAMES 'UTF8'");
		$sth->execute();
		$result = $sth->fetchAll();
		
		$tpl->assign("products", $result);
		
	}	
	
	echo $tpl->draw( 'products', $return_string = true );

?>
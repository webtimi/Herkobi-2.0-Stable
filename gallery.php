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
	
	
	/* Albüm İçeriği */
	@$id = strip_tags(trim($_GET['id']));
	
	if ($id == "" || $id < 1 || !is_numeric($id)) {
		header("Location: index.php");
	} 
	
	$sql = "SELECT * FROM photos WHERE gallery = $id";
	$sth = $db->prepare($sql);
	$db->query("SET NAMES 'UTF8'");
	$sth->execute();
	$result = $sth->fetchAll();
	
	$tpl->assign( "photos", $result );
	
	
	/* Galeri Adı */
	$sql = "SELECT album FROM galleries WHERE id = $id";
	$sth = $db->prepare($sql);
	$db->query("SET NAMES 'UTF8'");
	$sth->execute();
	$result = $sth->fetchAll();
	
		$album = $result[0]["album"];
	
	$tpl->assign( "album", $album );
	
	echo $tpl->draw( 'gallery', $return_string = true );
	
?>
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
	
	echo $tpl->draw( 'contact', $return_string = true );

?>
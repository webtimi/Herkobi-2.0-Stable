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


	/* Sayfa İçeriği */
	@$id = strip_tags(trim($_GET['id']));
	
	if ($id == "" || $id < 1 || !is_numeric($id)) {
		header("Location: index.php");
	} 
	
	$sql = "SELECT * FROM pages WHERE id = $id";
	$sth = $db->prepare($sql);
	$db->query("SET NAMES 'UTF8'");
	$sth->execute();
	$result = $sth->fetchAll();

		$page		= $result[0]['page'];
		$summary	= $result[0]['summary'];
		$content	= $result[0]['content'];
		$image		= $result[0]['image'];
		$gallery	= $result[0]['gallery'];
		$title		= $result[0]['title'];
		$metadesc	= $result[0]['metadesc'];
		$metatags	= $result[0]['metatags'];
		$date		= $result[0]['date'];
	
	$tpl->assign( "page", $page );
	$tpl->assign( "summary", $summary );
	$tpl->assign( "content", $content );
	$tpl->assign( "image", $image );
	$tpl->assign( "title", $title );
	$tpl->assign( "metadesc", $metadesc );
	$tpl->assign( "metatags", $metatags );
	$tpl->assign( "date", $date );
	
	/* Galeri */
	$sql = "SELECT DISTINCT m.*, md.gallery FROM photos AS m LEFT JOIN pages AS md ON m.gallery = md.gallery WHERE md.gallery = $gallery";
	$sth = $db->prepare($sql);
	$db->query("SET NAMES 'UTF8'");
	$sth->execute();  
	$result = $sth->fetchAll(); 
	
	$tpl->assign("pagegallery", $result);	
	
	/* Alt Sayfalar */
	$sql = "SELECT id, page, image, summary FROM pages WHERE mid = $id ORDER BY id ASC";
	$sth = $db->prepare($sql);
	$db->query("SET NAMES 'UTF8'");
	$sth->execute();
	$result = $sth->fetchAll();
	
	$tpl->assign( "subpages", $result );	

	
	echo $tpl->draw( 'page', $return_string = true );
	
?>
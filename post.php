<?php 

	/* Genel Ayarlar */
	include "config.php";
	
	/* Tema Yapýsý */
	include "inc/rain.tpl.class.php";
	include "inc/settings.php";

	/* Sabit Deðerler */
	include "info.php";
	
	/* Listeleme ve Fonksiyonlar */
	include "static.php";	


	/* Sayfa Ýçeriði */
	@$id = strip_tags(trim($_GET['id']));
	
	if ($id == "" || $id < 1 || !is_numeric($id)) {
		header("Location: index.php");
	} 
	
	$sql = "SELECT * FROM posts WHERE id = $id";
	$sth = $db->prepare($sql);
	$db->query("SET NAMES 'UTF8'");
	$sth->execute();
	$result = $sth->fetchAll();

		$post		= $result[0]['post'];
		$summary	= $result[0]['summary'];
		$content	= $result[0]['content'];
		$image		= $result[0]['image'];
		$gallery	= $result[0]['gallery'];
		$title		= $result[0]['title'];
		$metadesc	= $result[0]['metadesc'];
		$metatags	= $result[0]['metatags'];
		$date		= $result[0]['date'];
	
	$tpl->assign( "post", $post );
	$tpl->assign( "summary", $summary );
	$tpl->assign( "content", $content );
	$tpl->assign( "image", $image );
	$tpl->assign( "title", $title );
	$tpl->assign( "metadesc", $metadesc );
	$tpl->assign( "metatags", $metatags );
	$tpl->assign( "date", $date );
	
	/* Galeri */
	$sql = "SELECT DISTINCT m.*, md.gallery FROM photos AS m LEFT JOIN posts AS md ON m.gallery = md.gallery WHERE md.gallery = $gallery";
	$sth = $db->prepare($sql);
	$db->query("SET NAMES 'UTF8'");
	$sth->execute();  
	$result = $sth->fetchAll(); 
	
	$tpl->assign("postgallery", $result);		

	
	echo $tpl->draw( 'post', $return_string = true );
	
?>
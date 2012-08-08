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
	
	$sql = "SELECT id,product,category,brand,content,code,price,currency,image,image1,image2,image3,image4,title,metadesc,metatags FROM products WHERE id = $id AND publish = 'Yayınlandı'";
	$sth = $db->prepare($sql);
	$db->query("SET NAMES 'UTF8'");
	$sth->execute();
	$result = $sth->fetchAll();

		$id			= $result[0]['id'];
		$product	= $result[0]['product'];
		$category	= $result[0]['category'];
		$brand		= $result[0]['brand'];
		$content	= $result[0]['content'];
		$code		= $result[0]['code'];
		$price		= $result[0]['price'];
		$currency	= $result[0]['currency'];
		$image		= $result[0]['image'];
		$image1		= $result[0]['image1'];
		$image2		= $result[0]['image2'];
		$image3		= $result[0]['image3'];
		$image4		= $result[0]['image4'];
		$title		= $result[0]['title'];
		$metadesc	= $result[0]['metadesc'];
		$metatags	= $result[0]['metatags'];
	
	$tpl->assign( "product", $product );
	$tpl->assign( "category", $category );
	$tpl->assign( "content", $content );
	$tpl->assign( "code", $code );
	$tpl->assign( "price", $price );
	$tpl->assign( "currency", $currency );
	$tpl->assign( "image", $image );
	$tpl->assign( "image1", $image1 );
	$tpl->assign( "image2", $image2 );
	$tpl->assign( "image3", $image3 );
	$tpl->assign( "image4", $image4 );
	$tpl->assign( "title", $title );
	$tpl->assign( "metadesc", $metadesc );
	$tpl->assign( "metatags", $metatags );
	
	
	/* Marka Bilgisi */
	if ($brand != 0) {
	
		$sql = "SELECT brand FROM brands WHERE id = $brand";
		$sth = $db->prepare($sql);
		$db->query("SET NAMES 'UTF8'");
		$sth->execute();
		$result = $sth->fetchAll();
	
			$brand	= $result[0]['brand'];
	
		$tpl->assign( "brand", $brand );
	}
	
	
	echo $tpl->draw( 'product', $return_string = true );
	
?>
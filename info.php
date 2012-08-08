<?php

	/* Ana Sayfa yazısı ve limitler */
	$sql = "SELECT * FROM settings";
	$sth = $db->prepare($sql);
	$db->query("SET NAMES 'UTF8'");
	$sth->execute();
	$result = $sth->fetchAll();
	
		$category		= $result[0]['category'];
		$newproducts	= $result[0]['newproducts'];
		$latestposts	= $result[0]['latestposts'];
		$posts			= $result[0]['posts'];
		$products		= $result[0]['products'];
		$home			= $result[0]['home'];
	
	$tpl->assign( "category", $category );
	$tpl->assign( "newproducts", $newproducts );
	$tpl->assign( "latestposts", $latestposts );
	$tpl->assign( "posts", $posts );
	$tpl->assign( "products", $products );
	$tpl->assign( "home", $home );
	
	
	/* Firma Bilgileri */
	$sql = "SELECT * FROM info";
	$sth = $db->prepare($sql);
	$db->query("SET NAMES 'utf8'");
	$sth->execute();
	$result = $sth->fetchAll();
	
		$name 		= $result[0]['name'];
		$fullname 	= $result[0]['fullname'];
		$slogan 	= $result[0]['slogan'];
		$address 	= $result[0]['address'];
		$county 	= $result[0]['county'];
		$city 		= $result[0]['city'];
		$taxoffice	= $result[0]['taxoffice'];
		$taxnumber	= $result[0]['taxnumber'];
		$phone 		= $result[0]['phone'];
		$phoneother	= $result[0]['phoneother'];
		$fax 		= $result[0]['fax'];
		$gsm 		= $result[0]['gsm'];
		$mail 		= $result[0]['mail'];	
	
	$tpl->assign( "name", $name );
	$tpl->assign( "fullname", $fullname );
	$tpl->assign( "slogan", $slogan );
	$tpl->assign( "address", $address );
	$tpl->assign( "county", $county );
	$tpl->assign( "city", $city );
	$tpl->assign( "taxoffice", $taxoffice );
	$tpl->assign( "taxnumber", $taxnumber );
	$tpl->assign( "phone", $phone );
	$tpl->assign( "phoneother", $phoneother );
	$tpl->assign( "fax", $fax );
	$tpl->assign( "gsm", $gsm );
	$tpl->assign( "mail", $mail );

	/* Footer */
	$tpl->assign( 'footer', '<a href="http://www.herkobi.com" title="Herkobi CMS">Herkobi CMS</a>');	

?>
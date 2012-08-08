<?php

	/* Albümler */
	$sql = "SELECT id, album, description, image FROM `galleries`";  
	$sth = $db->prepare($sql);
	$db->query("SET NAMES 'UTF8'");
	$sth->execute();
	$result = $sth->fetchAll();
	
	$tpl->assign( "galleries", $result );

?>
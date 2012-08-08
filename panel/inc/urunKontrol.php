<?php
	include("../../config.php");
	if((!isset($_SESSION['logged'])) && (@$_SESSION['logged'] != 'yes')) { header("Location: index.php"); die; }

	$id = @$_POST['id'];
	$id = "%$id%";

	$sql = "SELECT id FROM products WHERE category LIKE :id";

	$sth = $db->prepare($sql);
	$sth->bindValue(':id', $id);
	$sth->execute();
	$say = count($sth->fetchAll());

	if($say >= 1){
		echo $say;
	}
	else{
		return false;
	}
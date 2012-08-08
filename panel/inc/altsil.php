<?php
	include("../../config.php");
	if((!isset($_SESSION['logged'])) || (@$_SESSION['logged'] != 'yes')) { header("Location: ../index.php"); die; }

function sil($id, $kontrol)
{
	if($kontrol == 1){ $tablo = 'category'; $updateTablog = 'products'; $updateSet = 'category'; }
	else if($kontrol == 2){ $tablo = 'postcategories'; $updateTablog = 'posts'; $updateSet = 'cid'; }
	global $db;



	$sql = "SELECT * FROM $tablo WHERE mid = :id";

	$sth = $db->prepare($sql);
	$sth->bindValue(':id', $id);
	$sth->execute();
 


	while($sonuc = $sth->fetchAll())
	{
		foreach($sonuc as $record)
		{

	$yaziVarMiSql = "SELECT id FROM products WHERE category LIKE :id";
	$yaziVarMiid = "%-".$record["id"]."-,%";
	$sth2 = $db->prepare($yaziVarMiSql);
	$sth2->bindValue(':id', $yaziVarMiid);
	$sth2->execute();
	$sonuc2 = $sth2->fetchAll();
	$say = count($sonuc2);

	if($say >= 1){
		global $ilkid;
			/*Burada alt kategoriler silinirken, alt kategoride yazı varsa komut bitiriliyor.
			Ancak ilk basta secilen kategori silinemeyecegi icin burada silindi. */
			$sql3 = "DELETE FROM $tablo WHERE id = :id;UPDATE productcategories SET mid = '0' WHERE id = :id2";
			$sth = $db->prepare($sql3);
			$sth->bindValue(':id', $ilkid);
			$sth->bindValue(':id2', $record["id"]);
			$sth->execute();

		die;
	}

			$sql2 = "DELETE FROM $tablo WHERE id = :id;";
			$sth = $db->prepare($sql2);
			$sth->bindValue(':id', $record["id"]);
			$sth->execute();
			
			sil($record["id"], $kontrol);

		}
	}

	$sql3 = "DELETE FROM $tablo WHERE id = :id;";
	$sth = $db->prepare($sql3);
	$sth->bindValue(':id', $id);
	$sth->execute();
}

	$id = @$_POST['id'];
	$kontrol = @$_POST['n'];

	$ilkid = $id;

	if($id != 1){
		sil($id, $kontrol);
	}
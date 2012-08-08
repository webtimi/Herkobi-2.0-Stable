<?php
/* Tüm sayfalarda ortak olan kodlar.*/

	function duzelt($sutun, $tablo, $id){//duzenleme işlemi başladığında gerekli olan veriler
		global $db;

			$sql = "
			SELECT $sutun
			FROM $tablo
			WHERE id = :id";
			$sth = $db->prepare($sql);
			$sth->bindValue(':id', $id);
			$db->query("SET NAMES 'utf8'");
			$sth->execute();
			$DuzenleSonuc = $sth->fetchAll();
			return $DuzenleSonuc;
	}
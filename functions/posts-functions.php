<?php 

	/* Yazı Kategorileri Listesi - Sadece Ana Kategoriler */
	$sql = "SELECT id, category FROM postcategories WHERE mid = 0 ORDER BY id ASC";
	$sth = $db->prepare($sql);
	$db->query("SET NAMES 'UTF8'");
	$sth->execute();
	$result = $sth->fetchAll();
	
	$tpl->assign( "postcategories", $result );	
	
	/* Yazı Kategorileri Listeleme Fonksiyonu*/
	function postcategories($id='') {
		global $db;
		if ($id == ''){
			$sql = "SELECT id, category FROM postcategories";
			$sth = $db->prepare($sql);
			$db->query("SET NAMES 'utf8'");
			$sth->execute();
			$result = $sth->fetchAll();
			$count = count($result);
 
			echo '<ul>';
			for($i=0;$i<$count;$i++) {
				echo '
					<li><a href="posts.php?id='.$result[$i]["id"].'" title="'.$result[$i]["category"].'">'.$result[$i]["category"].'</a></li>';
			}
			echo '</ul>';		
		} else {
			$sql = "SELECT id, category FROM postcategories WHERE mid = ".intval($id)."";
			$sth = $db->prepare($sql);
			$db->query("SET NAMES 'utf8'");
			$sth->execute();
			$result = $sth->fetchAll();
			$count = count($result);
 
			echo '<ul>';
			for($i=0;$i<$count;$i++) {
				echo '
					<li><a href="posts.php?id='.$result[$i]["id"].'" title="'.$result[$i]["category"].'">'.$result[$i]["category"].'</a></li>';
			}
			echo '</ul>';
		}
	}
	
	/* Seçilen Yazı Kategorilerini Listeleme Fonksiyonu */
	function custom_postcategories($id = '') {
		global $db;
		if ($id == '') {
		
			echo "Bu fonksiyonu kullanmak için listelemek istediğiniz yazı kategorilerinin id değerlerini tırnak içinde ve virgülle ayırarak parantezin içine yazmanız gerekmektedir.";
		
		} else {
			
			$sql = "SELECT id, category FROM postcategories WHERE id IN ($id)";
			$sth = $db->prepare($sql);
			$db->query("SET NAMES 'utf8'");
			$sth->execute();
			$result = $sth->fetchAll();
			$count = count($result);
			
			echo '<ul>';
			for($i=0;$i<$count;$i++) {
				echo '
					<li><a href="posts.php?id='.$result[$i]["id"].'" title="'.$result[$i]["category"].'">'.$result[$i]["category"].'</a></li>';
			}
			echo '</ul>';
		
		}
	}	

?>
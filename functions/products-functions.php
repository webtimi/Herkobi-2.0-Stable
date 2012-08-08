<?php 

	/* Ürün Kategorileri Listesi - Sadece Ana Kategoriler */
	$sql = "SELECT id, category, image FROM productcategories WHERE mid = 0 ORDER BY id ASC";
	$sth = $db->prepare($sql);
	$db->query("SET NAMES 'UTF8'");
	$sth->execute();
	$result = $sth->fetchAll();
	
	$tpl->assign( "productcategories", $result );

	/* Tüm Ürün Kategorilerini ve Seçilen Kategorinin Alt Kategorilerini Listeleme Fonksiyonu*/
	function productcategories($id='') {
		global $db;
		if ($id == ''){
			$sql = "SELECT id, category FROM productcategories";
			$sth = $db->prepare($sql);
			$db->query("SET NAMES 'utf8'");
			$sth->execute();
			$result = $sth->fetchAll();
			$count = count($result);
 
			echo '<ul>';
			for($i=0;$i<$count;$i++) {
				echo '
					<li><a href="products.php?id='.$result[$i]["id"].'" title="'.$result[$i]["category"].'">'.$result[$i]["category"].'</a></li>';
			}
			echo '</ul>';		
		} else {
			$sql = "SELECT id, category FROM productcategories WHERE mid = ".intval($id)."";
			$sth = $db->prepare($sql);
			$db->query("SET NAMES 'utf8'");
			$sth->execute();
			$result = $sth->fetchAll();
			$count = count($result);
 
			echo '<ul>';
			for($i=0;$i<$count;$i++) {
				echo '
					<li><a href="products.php?id='.$result[$i]["id"].'" title="'.$result[$i]["category"].'">'.$result[$i]["category"].'</a></li>';
			}
			echo '</ul>';
		}
	}
	
	/* Seçilen Ürün Kategorilerini Listeleme Fonksiyonu */
	function custom_productcategories($id = '') {
		global $db;
		if ($id == '') {
		
			echo "Bu fonksiyonu kullanmak için listelemek istediğiniz ürün kategorilerinin id değerlerini tırnak içinde ve virgülle ayırarak parantezin içine yazmanız gerekmektedir.";
		
		} else {
			
			$sql = "SELECT id, category FROM productcategories WHERE id IN ($id)";
			$sth = $db->prepare($sql);
			$db->query("SET NAMES 'utf8'");
			$sth->execute();
			$result = $sth->fetchAll();
			$count = count($result);
			
			echo '<ul>';
			for($i=0;$i<$count;$i++) {
				echo '
					<li><a href="products.php?id='.$result[$i]["id"].'" title="'.$result[$i]["category"].'">'.$result[$i]["category"].'</a></li>';
			}
			echo '</ul>';
		
		}
	}	
	
	/* Markalar */
	$sql = "SELECT id, brand, image FROM brands ORDER BY id ASC";
	$sth = $db->prepare($sql);
	$db->query("SET NAMES 'UTF8'");
	$sth->execute();
	$result = $sth->fetchAll();
	
	$tpl->assign( "brands", $result );
	
	/* Seçilen Markaları Listeleme Fonksiyonu */
	function custom_brands($id = '') {
		global $db;
		if ($id == '') {
		
			echo "Bu fonksiyonu kullanmak için listelemek istediğiniz markaların id değerlerini tırnak içinde ve virgülle ayırarak parantezin içine yazmanız gerekmektedir.";
		
		} else {
			
			$sql = "SELECT id, brand FROM brands WHERE id IN ($id)";
			$sth = $db->prepare($sql);
			$db->query("SET NAMES 'utf8'");
			$sth->execute();
			$result = $sth->fetchAll();
			$count = count($result);
			
			echo '<ul>';
			for($i=0;$i<$count;$i++) {
				echo '
					<li><a href="brands.php?id='.$result[$i]["id"].'" title="'.$result[$i]["brand"].'">'.$result[$i]["brand"].'</a></li>';
			}
			echo '</ul>';
		
		}
	}	
?>
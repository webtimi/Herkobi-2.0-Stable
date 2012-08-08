<?php 

	/* Sayfa Listesi - Sadece Üst Sayfalar	*/
	$sql = "SELECT id, mid, page FROM pages WHERE mid = 0 ORDER BY id ASC";
	$sth = $db->prepare($sql);
	$db->query("SET NAMES 'UTF8'");
	$sth->execute();
	$result = $sth->fetchAll();
	
	$tpl->assign( "pages", $result );
	
	
	/* Tüm Sayfaları ve İstenen Sayfanın Alt Sayfalarını Listeleme Fonksiyonu */
	function pages($id='') {
		global $db;
		if ($id == ''){
			$sql = "SELECT id, page FROM pages";
			$sth = $db->prepare($sql);
			$db->query("SET NAMES 'utf8'");
			$sth->execute();
			$result = $sth->fetchAll();
			$count = count($result);
 
			echo '<ul>';
			for($i=0;$i<$count;$i++) {
				echo '
					<li><a href="page.php?id='.$result[$i]["id"].'" title="'.$result[$i]["page"].'">'.$result[$i]["page"].'</a></li>';
			}
			echo '</ul>';		
		} else {
			$sql = "SELECT id, page FROM pages WHERE mid = ".intval($id)."";
			$sth = $db->prepare($sql);
			$db->query("SET NAMES 'utf8'");
			$sth->execute();
			$result = $sth->fetchAll();
			$count = count($result);
 
			echo '<ul>';
			for($i=0;$i<$count;$i++) {
				echo '
					<li><a href="page.php?id='.$result[$i]["id"].'" title="'.$result[$i]["page"].'">'.$result[$i]["page"].'</a></li>';
			}
			echo '</ul>';
		}
	}

	
	/* Herhangi Bir Alana İstenilen Sayfa İçeriğini Getirme */
	function embedpage($id='', $class = '', $image = '') {
		global $db;
		if ($id == '' || $class == ''){
		
			echo 'Lütfen id ve class değerlerini kontrol ediniz.';
		
		} elseif ($image !== '') {
			
			$sql = "SELECT id, page, summary FROM pages WHERE id = ".intval($id)."";
			$sth = $db->prepare($sql);
			$db->query("SET NAMES 'utf8'");
			$sth->execute();
			$result = $sth->fetchAll();
			
				$id = $result[0]['id'];
				$page = $result[0]['page'];
				$summary = $result[0]['summary'];
				
				$image = "tpl/images/".$image."";
				
			echo '
				<div class="'.$class.'">
					<h2><a href="page.php?id='.$id.'" title="'.$page.'">'.$page.'</a></h2>
					<img src="'.$image.'" alt="'.$page.'" />
					<p>'.$summary.'</p>
				</div>
			';		
		
			} else {
			
				$sql = "SELECT id, page, image, summary FROM pages WHERE id = ".intval($id)."";
				$sth = $db->prepare($sql);
				$db->query("SET NAMES 'utf8'");
				$sth->execute();
				$result = $sth->fetchAll();
			
					$id = $result[0]['id'];
					$page = $result[0]['page'];
					$image = $result[0]['image'];
					$summary = $result[0]['summary'];
				
				echo '
					<div class="'.$class.'">
						<h2><a href="page.php?id='.$id.'" title="'.$page.'">'.$page.'</a></h2>
						<img src="'.$image.'" alt="'.$page.'" />
						<p>'.$summary.'</p>
					</div>
				';		
			}
	}


	/* Seçilen Sayfaları Listeleme Fonksiyonu */
	function custom_pages($id = '') {
		global $db;
		if ($id == '') {
		
			echo "Bu fonksiyonu kullanmak için listelemek istediğiniz sayfaların id değerlerini tırnak içinde ve virgülle ayırarak parantezin içine yazmanız gerekmektedir.";
		
		} else {
			
			$sql = "SELECT id, page FROM pages WHERE id IN ($id)";
			$sth = $db->prepare($sql);
			$db->query("SET NAMES 'utf8'");
			$sth->execute();
			$result = $sth->fetchAll();
			$count = count($result);
			
			echo '<ul>';
			for($i=0;$i<$count;$i++) {
				echo '
					<li><a href="page.php?id='.$result[$i]["id"].'" title="'.$result[$i]["page"].'">'.$result[$i]["page"].'</a></li>';
			}
			echo '</ul>';
		
		}
	}
	
?>
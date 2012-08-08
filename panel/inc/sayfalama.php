<?php
function Sayfalama($tablo){
	global $db;
	$sql = "SELECT COUNT( id ) FROM $tablo";
	$sth = $db->prepare($sql);
	$sth->execute();
	$dbSayi = $sth->fetch();


	$sayfalamaLimit = 20;

	$sayfaSayisi = ceil($dbSayi[0] / $sayfalamaLimit);	
	return $sayfaSayisi;
}

function SayfaIcerik($tablo){
	global $db;
	$sayfalamaLimit = 20;
	if(!isset($_GET['s'])){
		$sayfalama = 1;
	}
	else{
		$sayfalama = $_GET['s'];
		if(!is_numeric($sayfalama)){
			$sayfalama = 1;
		}
	}

	$kacta = (($sayfalama * $sayfalamaLimit) - $sayfalamaLimit);

	if($tablo == 'pages'){
		$sql = "SELECT uk.id, uk.mid, uk.page, uk.date, u.id, u.mid, u.page, u.date
				FROM pages AS u
				RIGHT JOIN pages AS uk ON u.id = uk.mid
				ORDER BY  `uk`.`id` DESC";
	}
	else if($tablo == 'posts'){
		$sql = "SELECT u.id, u.post, uk.category, u.date
				FROM posts AS u
				LEFT JOIN postcategories AS uk ON u.cid = uk.id
				ORDER BY  `u`.`id` DESC";
	}
	else if($tablo == 'productcategories'){
		$sql = "SELECT uk.id, uk.mid, uk.category, u.id, u.mid, u.category
				FROM productcategories AS u
				RIGHT JOIN productcategories AS uk ON u.id = uk.mid
				ORDER BY  `u`.`id` ASC";
	}
	else if ($tablo == 'postcategories'){
		$sql = "SELECT u.id, u.mid, u.category, uk.id, uk.mid, uk.category
		   		FROM postcategories AS u
		   		RIGHT JOIN postcategories AS uk on u.id = uk.mid";
	}      
	else if ($tablo == 'products'){
		$sql = "SELECT u.brand, u.id, u.publish, u.product, u.category, uk.mid
				FROM products AS u
				LEFT JOIN productcategories AS uk ON u.category = uk.id
				ORDER BY  `u`.`id` DESC";
	}  
	else if ($tablo == 'galleries'){
		$sql = "SELECT * FROM galleries";
	}
	else if ($tablo == 'slides'){
		$sql = "SELECT * FROM slides";
	}  
	$sql .= " LIMIT $kacta , $sayfalamaLimit;";

	$sth = $db->prepare($sql);

	$db->query("SET NAMES 'utf8'");
	$sth->execute();
	$TumHaberler = $sth->fetchAll();
	return $TumHaberler;
}

function oklar(){
		global $sayfaSayisi;
		if($sayfaSayisi >= 2){
			$sy = 1;
			$next = '';
			$previous = '';
			$advanced = '';
			$i = 2;
			if(isset($_GET['s'])){
				$sy = $_GET['s'];
				$back = $sy - 1;
				if($sy == $sayfaSayisi) {
					$advanced = "class='remove'";
				}
				if($sy == 1){
					$back = '';
					$previous = "class='remove'";
					$i = 2;
				}
			}
			else{
				$previous = "class='remove'";
				$back = $sy - 1;
			}
				$next = $sy + 1;
			echo '<a '.$previous.' href="?s='.$back.'">&laquo;</a>';
			for($i;$i<=$sayfaSayisi;$i++){
					echo '<a href="?s='.$i.'" class="active">'.$i.'</a>';
			}
				echo '<a '.$advanced.' href="?s='.$next.'">&raquo;</a>';
		}
}
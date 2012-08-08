<?php
include_once '../config.php';
if((!isset($_SESSION['logged'])) || (@$_SESSION['logged'] != 'yes')) { header("Location: index.php"); die; }

if(isset($_POST['description']) && (isset($_POST['image'])) && (isset($_POST['url']))) {

	$description = @$_POST['description'];
	$image = @$_POST['image'];
	$url = @$_POST['url'];

	
	class Slide{

		public $VeriKont;


		public function __construct(){
			global $db, $SITE_ADRESI;
			$this->db = $db;
			$this->SITE_ADRESI = $SITE_ADRESI;
		}

		public function slideEkle($description="", $image, $url=""){
				if($image == "") {
					$_SESSION['var'] = "Lütfen manşet alanında kullanacağınız resminizi belirtiniz!";
					$this->VeriKont = false;
	            }
		        else{
		            $sql = "INSERT INTO slide ( 
                              description, 
                              image,
                              url)
                            VALUES (
                              :description, 
                              :image,
                              :url)";
		            		$sth = $this->db->prepare($sql);
		            		$sth->bindValue(':description', $description);
		            		$sth->bindValue(':image', $image);
							$sth->bindValue(':url', $url);
		            		$this->db->query("SET NAMES 'utf8'");
		            		
		            		if($sth->execute()){
		            			$this->VeriKont = true;
		            		}
		            		else{
		            			$this->VeriKont = false;
		            		}
								return $this->VeriKont;
					}
		        }
		}  
  
  $Veri = new Slide;

				$Veri->slideEkle($description, $image, $url);
			//} buradan kaldırıldı
  }
    
	$sql = "SELECT * FROM slide";
    $sth = $db->prepare($sql);
    $db->query("SET NAMES 'utf8'");
    $sth->execute();

    $TumGaleriler = $sth->fetchAll();
    $TumGalerilerSay = count($TumGaleriler);
?>
					<li><a href="posts.php">Yazılar</a></li>
					<li><a href="post-add.php">Haber Ekle</a></li>
	        <li><a href="post-categories.php">Kategoriler</a></li>
				</ul>      
	    </li>
      <li><a href="#" class="collapse"><img src="images/nav/product.png" alt="" /> Ürünler</a>
				<ul>
					<li><a href="products.php">Ürünler</a></li>
					<li><a href="product-add.php">Ürün Ekle</a></li>
          <li><a href="product-categories.php">Kategoriler</a></li>
          <li><a href="brands.php">Markalar</a></li>
				</ul>
			</li>
      <li><a href="#"><strong><img src="images/nav/media.png" alt="" /> Galeriler</strong></a>
        <ul>
          <li><a href="galleries.php">Albümler</a></li>
          <li><a href="slide.php">Manşet</a></li>
        </ul>
      </li>
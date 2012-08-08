<?php
require_once '../config.php';
if((!isset($_SESSION['logged'])) || (@$_SESSION['logged'] != 'yes')) { header("Location: index.php"); die; }

	$sql = "SELECT * FROM info";//Daha önce firma kaydedilmiş mi kontrolü
	$sth = $db->prepare($sql);
	$db->query("SET NAMES 'UTF8'");
	$sth->execute();
	$say = $sth->rowCount();

	if(($say == 0) || (isset($_POST['d']))) {

	if(isset($_POST['name'])){
				$name       = @$_POST['name'];
				$fullname   = @$_POST['fullname'];
				$slogan     = @$_POST['slogan'];
				$address    = @$_POST['address'];
				$county     = @$_POST['county'];
				$city       = @$_POST['city'];
				$taxoffice  = @$_POST['taxoffice'];
				$taxnumber  = @$_POST['taxnumber'];
				$phone      = @$_POST['phone'];
				$phoneother = @$_POST['phoneother'];
				$fax        = @$_POST['fax'];
				$gsm        = @$_POST['gsm'];
				$mail       = @$_POST['mail'];
        
  
  class Firma{
		public $VeriKont;

		public function __construct(){
			global $db;
			$this->db = $db;
		}

		public function firmaEkle($name, $fullname, $slogan, $address, $county, $city, $taxoffice, $taxnumber, $phone, $phoneother, $fax, $gsm, $mail){
				if($name == "") {
	            $_SESSION['var'] = 'Lütfen firma adını giriniz!';
	            $this->VeriKont = false;	                
	      } else if(isset($name)) {
							$sql = "INSERT INTO info (
                        name, 
                        fullname, 
                        slogan, 
                        address, 
                        county, 
                        city, 
                        taxoffice, 
                        taxnumber, 
                        phone, 
                        phoneother, 
                        fax, 
                        gsm, 
                        mail)
		            			VALUES (
                        :name, 
                        :fullname, 
                        :slogan, 
                        :address, 
                        :county, 
                        :city, 
                        :taxoffice, 
                        :taxnumber, 
                        :phone, 
                        :phoneother, 
                        :fax, 
                        :gsm, 
                        :mail)";
		            		$sth = $this->db->prepare($sql);
			            		$sth->bindValue(':name', $name);
			            		$sth->bindValue(':fullname', $fullname);
			            		$sth->bindValue(':slogan', $slogan);
			            		$sth->bindValue(':address', $address);
			            		$sth->bindValue(':county', $county);
			            		$sth->bindValue(':city', $city);
			            		$sth->bindValue(':taxoffice', $taxoffice);
			            		$sth->bindValue(':taxnumber', $taxnumber);
			            		$sth->bindValue(':phone', $phone);
			            		$sth->bindValue(':phoneother', $phoneother);
			            		$sth->bindValue(':fax', $fax);
			            		$sth->bindValue(':gsm', $gsm);
			            		$sth->bindValue(':mail', $mail);
		            		if($sth->execute()){
								$this->VeriKont = true;
		            		}
		            	return $this->VeriKont;
	            }
	        }

		  public function firmaDuzenle($id, $name, $fullname, $slogan, $address, $county, $city, $taxoffice, $taxnumber, $phone, $phoneother, $fax, $gsm, $mail){
          if($name == "") {
	            $_SESSION['var'] = 'Lütfen firma adını giriniz!';
	            $this->VeriKont = false;
          } else {
	            	$sql = "UPDATE info
	            			SET
		            			name = :name,
		            			fullname = :fullname,
		            			slogan = :slogan,
		            			address = :address, 
		            			county = :county, 
		            			city = :city, 
		            			taxoffice = :taxoffice, 
		            			taxnumber = :taxnumber, 
		            			phone = :phone, 
		            			phoneother = :phoneother, 
		            			fax = :fax, 
		            			gsm = :gsm, 
		            			mail = :mail
	            			WHERE id = :id";
	            	$sth = $this->db->prepare($sql);
	            			$sth->bindValue(':id', $id);
		            		$sth->bindValue(':name', $name);
		            		$sth->bindValue(':fullname', $fullname);
		            		$sth->bindValue(':slogan', $slogan);
		            		$sth->bindValue(':address', $address);
		            		$sth->bindValue(':county', $county);
		            		$sth->bindValue(':city', $city);
		            		$sth->bindValue(':taxoffice', $taxoffice);
		            		$sth->bindValue(':taxnumber', $taxnumber);
		            		$sth->bindValue(':phone', $phone);
		            		$sth->bindValue(':phoneother', $phoneother);
		            		$sth->bindValue(':fax', $fax);
		            		$sth->bindValue(':gsm', $gsm);
		            		$sth->bindValue(':mail', $mail);
	            	$this->db->query("SET NAMES 'utf8'");
	            	$sth->execute();
	            	$sonuc = $sth->fetchAll();
	            	$say = $sth->rowCount();
		            	if($say >= 1){
		            		$this->VeriKont = true;
		            	}
		            	else{
		            		$this->VeriKont = false;
		            	}
		            	return $this->VeriKont;
	            }
	        }
	    }        

			$Veri = new Firma;
					if(isset($_POST['d']) && ($_POST['d'] == 1)) {
						$id = $_POST['d']; // yazinin id'si
						if(!is_numeric($id)){
							$id = 1;
						}
						$Veri->firmaDuzenle($id, $name, $fullname, $slogan, $address, $county, $city, $taxoffice, $taxnumber, $phone, $phoneother, $fax, $gsm, $mail);
					} else {
						$Veri->firmaEkle($name, $fullname, $slogan, $address, $county, $city, $taxoffice, $taxnumber, $phone, $phoneother, $fax, $gsm, $mail);
					}
				}
		}
	else{
		$sonuc = $sth->fetchAll();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=7" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Firma Bilgileri | Herkobi CMS Yönetim Paneli</title>
	<meta name="description" content="." />
	<meta name="keywords" content="." />
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/custom.js"></script>
	<style type="text/css" media="all">
	@import url("css/style.css");
	</style>
	<?php
		if(isset($_POST['name'])){
    if($Veri->VeriKont){
      echo "<style type=\"text/css\" media=\"all\">#success {display: block;}</style>";
    } else {
      echo "<style type=\"text/css\" media=\"all\">#error {display: block;}</style>";
        if(isset($_SESSION['var'])) {
          $HataSebep = $_SESSION['var'];
          unset($_SESSION['var']);
          echo "<style type=\"text/css\" media=\"all\">#warning {display: block;}</style>";
        }
      }
    }
  ?>
	<!--[if lt IE 9]>
	<style type="text/css" media="all"> @import url("css/ie.css"); </style>
	<![endif]-->
</head>
<body>
	<div id="header">
		<h1><a href="admin.php">HERKOBİ</a></h1>
		<div class="userprofile">
			<ul>
				<li><a href="kullanici.php"><img src="images/avatar.gif" alt="" /> admin</a></li>
				<li><a href="<?php echo $SITE_ADRESI; ?>" target="_blank">Siteyi Göster</a></li>
				<li><a href="logout.php">Oturumu Kapat</a></li>
			</ul>
		</div>		<!-- .userprofile ends -->
	</div>			
  <!-- #header ends -->
  <div id="sidebar">	
		<ul id="nav">
			<li><a href="admin.php"><img src="images/nav/dashboard.png" alt="" /> Başlangıç</a></li>
			<li><a href="#" class="collapse"><img src="images/nav/pages.png" alt="" /> Sayfalar</a>
				<ul>
					<li><a href="pages.php">Sayfalar</a></li>
					<li><a href="page-add.php">Sayfa Ekle</a></li>
				</ul>
      </li>
      <li><a href="#" class="collapse"><img src="images/nav/rss.png" alt="" /> Yazılar</a>
				<ul>
					<li><a href="posts.php">Yazılar</a></li>
					<li><a href="post-add.php">Yazı Ekle</a></li>
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
      <li><a href="#" class="collapse"><img src="images/nav/media.png" alt="" /> Galeriler</a>
        <ul>
          <li><a href="galleries.php">Albümler</a></li>
          <li><a href="slide.php">Manşet</a></li>
        </ul>
      </li>
      <li><a href="#" class="collapse"><img src="images/nav/links.png" alt="" /> Linkler</a>
        <ul>
          <li><a href="links.php">Link Ekle</a></li>
          <li><a href="link-categories.php">Kategoriler</a></li>
        </ul>
      </li>  
	    <li><a href="files.php"><img src="images/nav/files.png" alt="" /> Dosyalar</a></li>
      <li><a href="#"><strong><img src="images/nav/settings.png" alt="" /> Ayarlar</strong></a>
				<ul>
					<li><a href="info.php">Firma Bilgileri</a></li>
					<li><a href="settings.php">Site Bilgileri</a></li>
          <li><a href="user.php">Yönetici Bilgileri</a></li>
          <li><a href="user-add.php">Yeni Kullanıcı</a></li>
				</ul>
	    </li>
    </ul>
  </div>		
  <!-- #sidebar ends -->
	<div id="content">
		<div class="breadcrumb">
			<a href="admin.php">Başlangıç</a> &raquo; <a href="info.php">Firma Bilgileri</a>
		</div>		<!-- .breadcrumb ends -->
    
    <div id="success"><div class="message success"><p>Firma Bilgileri başarıyla kayıt edildi.</p></div></div>
    <div id="error"><div class="message errormsg"><p>İşlem gerçekleşmedi. Bir hata oluştu.</p></div></div>
    <div id="warning"><div class="message warning"><p><?php echo @$HataSebep; ?></p></div></div>
		
    <h2>Firma Bilgileri</h2>
		<form id="bilgi" action="" method="post">
		  <div class="textbox left">
			 <h2>Kurumsal Bilgiler</h2>
			
			 <div class="textbox_content">
        <p><label>Firma Adı:</label><br /><input type="text" size="100" class="text ad" name="name" value="<?php echo @$sonuc[0]['name']; ?>" /></p>
        <p><label>Ticari Ünvan:</label><br /><input type="text" size="100" class="text" name="fullname" value="<?php echo @$sonuc[0]['fullname']; ?>" /></p>
        <p><label>Slogan:</label><br /><input type="text" size="100" class="text" name="slogan" value="<?php echo @$sonuc[0]['slogan']; ?>"/></p>
			  <table cellpadding="0" cellspacing="0" width="100%" class="sortable">
				  <thead>
					 <tr>
						<th>Vergi Dairesi</th>
            <th>Vergi No</th>
					 </tr>
				  </thead>
				  <tbody>
					 <tr>
						<td><input type="text" size="30" class="text" name="taxoffice" value="<?php echo @$sonuc[0]['taxoffice']; ?>" /></td>
            <td><input type="text" size="30" class="text" name="taxnumber" value="<?php echo @$sonuc[0]['taxnumber']; ?>" /></td>
					</tr>
         </tbody>
        </table>                 
			 </div>
		  </div>
      <div class="textbox right">
        <h2>Kaydet</h2>        
        <div class="textbox_content">
          <p>
          	<input type="hidden" name="d" id="d" value="<?php echo @$sonuc[0]['id']; ?>"/><br />
            <input type="submit" class="submit" value="Kaydet" />
            <input type="submit" class="submit disabled" disabled="disabled" value="İptal" />
          </p>
        </div>      
      </div>
		  <div class="textbox left">
			 <h2>İletişim Bilgileri</h2>
			
			 <div class="textbox_content">
        <p><label>Adres:</label><br /><textarea rows="4" cols="103" name="address" id="address"><?php echo @$sonuc[0]['address']; ?></textarea></p>
			  <table cellpadding="0" cellspacing="0" width="100%" class="sortable">
				  <tbody>
					 <tr>
						<th>İlçe</th>
            <th>İl</th>
					 </tr>          
					 <tr>
						<td><input type="text" size="30" class="text" name="county" value="<?php echo @$sonuc[0]['county']; ?>" /></td>
            <td><input type="text" size="30" class="text" name="city" value="<?php echo @$sonuc[0]['city']; ?>" /></td>
					 </tr>
					 <tr>
						<th>Telefon</th>
            <th>Telefon (Ek)</th>
					 </tr>
					 <tr>
						<td><input type="text" id="tel" size="30" class="text" name="phone" value="<?php echo @$sonuc[0]['phone']; ?>" /></td>
            <td><input type="text" id="tel2" size="30" class="text" name="phoneother" value="<?php echo @$sonuc[0]['phoneother']; ?>" /></td>
					 </tr>
					 <tr>
						<th>Faks</th>
            <th>GSM</th>
					 </tr>
					 <tr>
						<td><input type="text" id="faks" size="30" class="text" name="fax" value="<?php echo @$sonuc[0]['fax']; ?>" /></td>
            <td><input type="text" id="gsm" size="30" class="text" name="gsm" value="<?php echo @$sonuc[0]['gsm']; ?>" /></td>
					 </tr>                               
         </tbody>
        </table>
        <p><label>Mail Adresi:</label><br /><input type="text" size="100" class="text" name="mail" value="<?php echo @$sonuc[0]['mail']; ?>" /></p>                 
			 </div>
		  </div>            
		</form>
  </div>
</body>
</html>

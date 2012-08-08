<?php
require_once '../config.php';
if ((!isset($_SESSION['logged'])) || (@$_SESSION['logged'] != 'yes')) {
    header("Location: index.php");
    die;
}
//print_r($_POST);
require_once 'inc/functions.php';
require_once 'inc/seo.php';
require_once 'inc/sayfalama.php';

if (isset($_GET['duzelt'])) {
    $id = $_GET['duzelt'];
    if (!is_numeric($id)) {
        $id = 1;
    }
    $DuzenleSonuc = duzelt("*", 'productcategories', $id);

    $frontKontrol = $DuzenleSonuc[0]['front'];
    if ($frontKontrol == 1) {
        $check = ' checked="checked"';
    } else {
        $check = '';
    }
}
if (isset($_GET['sil']) && is_numeric($_GET['sil'])) {
    $id = $_GET['sil'];
}
if (isset($_POST['category']) || (isset($_GET['sil'])) || isset($_POST['toplusil'])) {
    $mid = @$_POST['mid'];
	$level = 0;
    $category = @$_POST['category'];
	$slug = slug($category);
    $description = @$_POST['description'];
    $image = @$_POST['image'];
	$image = str_replace($SITE_ADRESI."/","",$image);
    $front = @$_POST['front'];

    if (!empty($front)) {
        $front = 1;
    } else {
        $front = 0;
    }

    class UrunKategori {

        public $VeriKont;

        public function __construct() {
            global $db;
            $this->db = $db;
        }

        public function kategoriEkle($mid="", $level, $slug="", $category, $description="", $image="", $front="") {
            if ($category == "") {
                $_SESSION['var'] = 'Lütfen kategori adını giriniz!';
                $this->VeriKont = false;
            } else if (($mid == "000000000000") && (isset($category))) {//eger ust kategori tanimlandiysa
                $sql = "SELECT `category` FROM productcategories WHERE `category` = :category";
                $sth = $this->db->prepare($sql);
                $sth->bindValue(':category', $category);
                $sth->execute();
                $sonuc = $sth->fetchAll();
                $say = $sth->rowCount();
                if ($say >= 1) {
                    $_SESSION['var'] = "Daha önce " . $sonuc[0]['category'] . " isimli bir kategori eklemişsiniz.";
                    $this->VeriKont = false;
                } else {
                    $sql = "INSERT INTO productcategories (
                              mid,  
                              level,
							  slug,
							  category, 
                              description, 
                              image,
                              front)
                            VALUES (
                              :mid,  
                              :level,
							  :slug,
							  :category, 
                              :description, 
                              :image,
                              :front)";
                    $sth = $this->db->prepare($sql);
                    $sth->bindValue(':mid', '0');
                    $sth->bindValue(':level', $level);
					$sth->bindValue(':slug', $slug);
					$sth->bindValue(':category', $category);
                    $sth->bindValue(':description', $description);
                    $sth->bindValue(':image', $image);
                    $sth->bindValue(':front', $front);
                    $this->db->query("SET NAMES 'utf8'");
                    if ($sth->execute()) {
                    unset($_SESSION['var']);
                    $_SESSION['var'] = 'Kategori başarıyla eklendi!';
                    $this->VeriKont = true;
                    }
                }
                return $this->VeriKont;
            } else if (($mid != "000000000000") && (isset($category))) {
                $sql = "SELECT `mid`,`category` FROM productcategories WHERE `category` = :category AND `mid` = :mid";
                $sth = $this->db->prepare($sql);
                $sth->bindValue(':mid', $mid);
                $sth->bindValue(':category', $category);
                $sth->execute();
                $sonuc = $sth->fetchAll();
                $say = $sth->rowCount();
                if ($say >= 1) {
                    $_SESSION['var'] = "Daha önce $category adında bir kategori eklemişsiniz.";
                    $this->VeriKont = false;
                } else {
                    $sql = "INSERT INTO productcategories (
                              mid, 
                              level,
							  slug,
							  category, 
                              description, 
                              image,
                              front)
                            VALUES (
                              :mid,  
                              :level,
							  :slug,
							  :category, 
                              :description, 
                              :image,
                              :front)";
                    $sth = $this->db->prepare($sql);
                    $sth->bindValue(':mid', $mid);
                    $sth->bindValue(':level', $level);
					$sth->bindValue(':slug', $slug);
					$sth->bindValue(':category', $category);
                    $sth->bindValue(':description', $description);
                    $sth->bindValue(':image', $image);
                    $sth->bindValue(':front', $front);
                    $this->db->query("SET NAMES 'utf8'");

                    if ($sth->execute()) {
                        unset($_SESSION['var']);
                        $_SESSION['var'] = 'Kategori başarıyla eklendi!';
                        $this->VeriKont = true;
                    } else {
                        unset($_SESSION['var']);
                        $_SESSION['var'] = 'Kategori eklenirken bir hata oluştu!';
                        $this->VeriKont = false;
                    }
                    return $this->VeriKont;
                }
            }
        }

        public function kategoriDuzenle($id, $mid="", $level, $slug="", $category, $description="", $image="", $front="") {
            if ($category == "") {
                $_SESSION['var'] = "Lütfen kategori adını giriniz!";
                $this->VeriKont = false;
            }
            if ((isset($category))) {
                $sql = "UPDATE productcategories SET 
                          mid = :mid,  
                          level = :level,
						  slug = :slug,
						  category = :category, 
                          description = :description, 
                          image = :image,
                          front = :front 
                        WHERE id = :id";
                $sth = $this->db->prepare($sql);
                $sth->bindValue(':id', $id);
                $sth->bindValue(':mid', $mid);
                $sth->bindValue(':level', $level);
				$sth->bindValue(':slug', $slug);
				$sth->bindValue(':category', $category);
                $sth->bindValue(':description', $description);
                $sth->bindValue(':image', $image);
                $sth->bindValue(':front', $front);
                $this->db->query("SET NAMES 'utf8'");
                $sth->execute();
                $sonuc = $sth->fetchAll();
                $say = $sth->rowCount();
                if ($say >= 1) {
                    unset($_SESSION['var']);
                    $_SESSION['var'] = 'Kategori başarıyla düzenlendi!';
                    $this->VeriKont = true;
                } else {
                    $_SESSION['var'] = 'Kategori düzenlerken bir hata oluştu!';
                    $this->VeriKont = false;
                }
                return $this->VeriKont;
            }
        }

        public function kategoriSil($id, $ilkid='') {
            if ($ilkid != '') {
                $idtut = $ilkid;
            }
            $tablo = 'productcategories';
            $updateTablog = 'products';
            $updateSet = 'category';
            global $db;

            $sql = "UPDATE products SET category = replace(category, '-1-,', '') WHERE category LIKE :ids;UPDATE products SET category = replace(category, :ids1, '-1-,') WHERE category LIKE :ids";

            $sth = $this->db->prepare($sql);
            $search_cat1 = "-" . $id . "-,";
            $search_cat = "%-" . $id . "-,%";
            $sth->bindValue(':ids1', $search_cat1);
            $sth->bindValue(':ids', $search_cat);
            //$sth->bindValue(':id', $id);
            if ($sth->execute()) {
                $_SESSION['var'] = 'Kategori başarıyla silindi!';
            }

            $sql = "SELECT * FROM $tablo WHERE mid = :id";

            $sth = $this->db->prepare($sql);
            $sth->bindValue(':id', $id);
            $sth->execute();

            while ($sonuc = $sth->fetchAll()) {
                foreach ($sonuc as $record) {

                    $yaziVarMiSql = "SELECT id FROM products WHERE category LIKE :id";
                    $yaziVarMiid = "%-" . $record["id"] . "-,%";
                    $sth2 = $this->db->prepare($yaziVarMiSql);
                    $sth2->bindValue(':id', $yaziVarMiid);
                    $sth2->execute();
                    $sonuc2 = $sth2->fetchAll();
                    $say = count($sonuc2);

                    if ($say >= 1) {
                        /* Burada alt kategoriler silinirken, alt kategoride yazı varsa komut bitiriliyor.
                          Ancak ilk basta secilen kategori silinemeyecegi icin burada silindi. */
                        //UPDATE products SET category = replace(category,'-2-,', '') WHERE category LIKE '%-2-,%';
                        $sql3 = "DELETE FROM $tablo WHERE id = :id;UPDATE productcategories SET mid = '0' WHERE id = :id2;";
                        $sth = $this->db->prepare($sql3);
                        $search_cat1 = "-" . $idtut . "-,";
                        $search_cat = "%-" . $idtut . "-,%";
                        $sth->bindValue(':ids1', $search_cat1);
                        $sth->bindValue(':ids', $search_cat);
                        $sth->bindValue(':id', $idtut);
                        $sth->bindValue(':id2', $record["id"]);
                        $sth->execute();

                        //die;
                    } else {
                        $sql2 = "DELETE FROM $tablo WHERE id = :id;UPDATE products SET category = replace(category, :ids1, '') WHERE category LIKE :ids";
                        $search_cat1 = "-" . $idtut . "-,";
                        $search_cat = "%-" . $idtut . "-,%";
                        $sth->bindValue(':ids1', $search_cat1);
                        $sth->bindValue(':ids', $search_cat);
                        $sth = $this->db->prepare($sql2);
                        $sth->bindValue(':id', $record["id"]);
                        $sth->execute();
                    }
                    self::kategoriSil($record["id"]);
                }
            }

            $sql3 = "DELETE FROM $tablo WHERE id = :id;";
            $sth = $this->db->prepare($sql3);
            $sth->bindValue(':id', $id);
            $sth->execute();
        }

    }

    $Kategori = new UrunKategori;
    if (isset($_GET['sil']) && is_numeric($_GET['sil'])) {
        $Kategori->kategoriSil($id, $id);
        header("Location: product-categories.php");
    } else {
        if (isset($_POST['toplusil']) && isset($_POST['tut'])) {
            $idler = $_POST['tut'];
            foreach ($idler as $yeniID) {
                $Kategori->kategoriSil($yeniID, $yeniID);
                header("Location: product-categories.php");
            }
        }

        if ((isset($_GET['duzelt'])) && ($_GET['duzelt'] != "")) {
            $Kategori->kategoriDuzenle($id, $mid, $level, $slug, $category, $description, $image, $front);
            header("Location: product-categories.php?duzelt=$id&islem=1");
        } else {
            $Kategori->kategoriEkle($mid, $level, $slug, $category, $description, $image, $front);
        }
    }
}
$sayfalamaLimit = 20;
$sayfaSayisi = sayfalama('productcategories');

$TumKategoriler = SayfaIcerik('productcategories');
$TumKategorilerSay = count($TumKategoriler);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=7" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Ürün Kategorileri | Herkobi CMS Yönetim Paneli</title>
        <meta name="description" content="." />
        <meta name="keywords" content="." />
        <style type="text/css" media="all">
            @import url("css/style.css");
        </style>
        <?php
        if (isset($_POST['category'])) {
            if ($Kategori->VeriKont) {
                echo "<style type=\"text/css\" media=\"all\">#success {display: block;}</style>";
            } else {
                echo "<style type=\"text/css\" media=\"all\">#error {display: block;}</style>";
                if (isset($_SESSION['var'])) {
                    $HataSebep = $_SESSION['var'];
                    unset($_SESSION['var']);
                    echo "<style type=\"text/css\" media=\"all\">#warning {display: block;}</style>";
                }
            }
        }
        if (isset($_GET['duzelt']) && (isset($_GET['islem']))) {
            echo "<style type=\"text/css\" media=\"all\">#success {display: block;}</style>";
        }
        ?>
        <!-- elFinder -->
        <script src="elfinder/js/jquery-1.6.1.min.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript" src="js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/custom.js"></script>
        <script type="text/javascript" src="js/jquery.tablesorter.js"></script>
        <script src="elfinder/js/jquery-ui-1.8.13.custom.min.js" type="text/javascript" charset="utf-8"></script>

        <link rel="stylesheet" href="elfinder/css/smoothness/jquery-ui-1.8.13.custom.css" type="text/css" media="screen" title="no title" charset="utf-8">	
            <link rel="stylesheet" href="elfinder/css/elfinder.css" type="text/css" media="screen" title="no title" charset="utf-8">

                <script src="elfinder/js/elFinder.js" type="text/javascript" charset="utf-8"></script>
                <script src="elfinder/js/elFinder.view.js" type="text/javascript" charset="utf-8"></script>
                <script src="elfinder/js/elFinder.ui.js" type="text/javascript" charset="utf-8"></script>
                <script src="elfinder/js/elFinder.quickLook.js" type="text/javascript" charset="utf-8"></script>
                <script src="elfinder/js/elFinder.eventsManager.js" type="text/javascript" charset="utf-8"></script>

                <script src="elfinder/js/i18n/elfinder.tr.js" type="text/javascript" charset="utf-8"></script>
                <script type="text/javascript" charset="utf-8">
                    $().ready(function() {
                        var opt = {      // Must change variable name
                            url : 'elfinder/connectors/php/connector.php',
                            lang : 'tr',
                            editorCallback : function(url) {document.getElementById('field').value=url;},    // Must change the form field id
                            closeOnEditorCallback : true,
                            docked : false,
                            dialog : { title : 'Dosya Yöneticisi', height: 500 },
                        }

                        $('#open').click(function() {                        // Must change the button's id
                            $('#finder_browse').elfinder(opt)                // Must update the form field id
                            $('#finder_browse').elfinder($(this).attr('id'));   // Must update the form field id
                        })
                    });

                </script>  
                <!-- elFinder -->  

                <!--[if lt IE 9]>
                <style type="text/css" media="all"> @import url("css/ie.css"); </style>
                <![endif]-->
                </head>
                <body>
                    <div id="header">
                        <h1><a href="admin.php">HERKOBİ</a></h1>
                        <div class="userprofile">
                            <ul>
                                <li><a href="user.php"><img src="images/avatar.gif" alt="" /> admin</a></li>
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
                            <li><a href="#"><strong><img src="images/nav/product.png" alt="" /> Ürünler</strong></a>
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
                            <li><a href="#" class="collapse"><img src="images/nav/settings.png" alt="" /> Ayarlar</a>
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
                            <a href="admin.php">Başlangıç</a> &raquo; <a href="products.php">Ürünler</a> &raquo; <a href="product-categories.php">Ürün Kategorileri</a>
                        </div>		
                        <!-- .breadcrumb ends -->

                        <div id="success"><div class="message success"><p><?php echo @$_SESSION['var']; ?></p></div></div>
                        <div id="error"><div class="message errormsg"><p>İşlem gerçekleşmedi. Bir hata oluştu.</p></div></div>
                        <div id="warning"><div class="message warning"><p><?php echo @$HataSebep; ?></p></div></div>

                        <h2>Ürün Kategorisi Ekle</h2>

                        <div class="textbox half kleft">
                            <?php 
                            if(isset($_GET['duzelt']))
                                { ?>
                            <form id="bilgi" action="product-categories.php?duzelt=<?php echo $_GET['duzelt']; ?>" method="post">
                                
                                <?php } else{ ?>
                                <form id="bilgi" action="product-categories.php" method="post">
                                    <?php } ?>
                                <h2>Ürün Kategorisi Bilgileri</h2>
                                
                                <div class="textbox_content">
                                    <p><label>Kategori Adı:</label><br /><input type="text" value="<?php echo @$DuzenleSonuc[0]['category']; ?>" name="category" size="70" class="text" /></p>
                                    <p>
                                        <label>Ana Kategori:</label>
                                        <select class="styled" name="mid">
                                            <option selected="selected" value="000000000000">Kategoriler</option>
                                            <?php
                                            $sql = "SELECT `id`,`category` FROM productcategories ORDER BY `id` ASC";
                                            $sth = $db->prepare($sql);
                                            $db->query("SET NAMES 'utf8'");
                                            $sth->execute();
                                            $sonuc = $sth->fetchAll();
                                            $say = count($sonuc);
                                            for ($i = 0; $i < $say; $i++) {
                                                if (@$sonuc[$i]['id'] == @$DuzenleSonuc[0]['mid']) {
                                                    echo '<option selected value="' . @$sonuc[$i]['id'] . '">' . @$sonuc[$i]['category'] . '</option>' . "\n";
                                                } else {
                                                    echo '<option value="' . @$sonuc[$i]['id'] . '">' . @$sonuc[$i]['category'] . '</option>' . "\n";
                                                }
                                            }
                                            ?>
                                        </select>        
                                    </p>        
                                    <p class="fileupload">
                                        <label>Kategori Resmi:</label>
                                        <div id="finder_browse"></div>
                                        <input type="text" id="field" name="image" value="<?php echo @$DuzenleSonuc[0]['image']; ?>" />
                                        <input type="button" id="open" class="file" value="Resim Seç" />
                                    </p>
                                    <p><label>Kategori Açıklaması:</label><br /><textarea rows="7" name="description" id="description" cols="73"><?php echo @$DuzenleSonuc[0]['description']; ?></textarea></p>
                                    <p><input type="checkbox" <?php echo @$check; ?> name="front" value="1" />&nbsp;Ana Sayfada göster..<br />
                                        Eğer seçilirse ve temanız destekliyorsa, kategori ana sayfada gösterilecektir.
                                    </p>			 
                                </div>

                                <div class="clear"></div>

                                <div class="textbox_content">
                                    <p>
                                        <input type="submit" class="submit" value="KAYDET" />
                                        <input type="reset" class="submit disabled" value="İptal" />
                                    </p>
                                </div>      
                            </form>
                        </div>
                        <div class="textbox half kright">
                            <h2>Ürün Kategorileri</h2>
                            <div class="textbox_content">
                                <table cellpadding="0" cellspacing="0" width="100%" class="sortable">
                                    <thead>
                                        <tr>
                                            <th width="10"><input type="checkbox" class="check_all" /></th>
                                            <th>Kategori Adı</th>
                                            <th>Ana Kategori</th>
                                            <th>Düzenle</th>
                                            <th>Sil</th>
                                        </tr>
                                    </thead>
                                    <i>
                                        *: <?php echo $TumKategoriler[0]["2"]; ?> isimli kategori silinemez kategoridir. Ancak ismini değiştirebilirsiniz.
                                    </i>
                                    <tbody>
                                        <form action="product-categories.php" method="post">
                                            <?php
                                            $disabled = '';
                                            $mid = 'Yok';
                                            $main_cat=$TumKategoriler[0]["2"];
                                            for ($i = 0; $i < $TumKategorilerSay; $i++) {
                                                if ($TumKategoriler[$i]["0"] == 1) {
                                                    $disabled = 'disabled="disabled"';
                                                    $silme='';
                                                }
                                                else{
                                                    $silme = '<a href="product-categories.php?sil=' . $TumKategoriler[$i]["0"] . '" onclick="return confirm(\'Sime işlemi sonunda '. addslashes($TumKategoriler[$i]["2"]) .' kategorisine ait bütün ürünler '.$main_cat.' olacaktır. \n Onaylıyor musunuz?\')"><img src="images/close.png" alt="Delete" title="Delete" /></a>';
                                                }
                                                if (!empty($TumKategoriler[$i]["category"])) {
                                                    $mid = $TumKategoriler[$i]["category"];
                                                }
                                                echo '
					<tr>
						<td><input ' . $disabled . ' type="checkbox" name="tut[]" value="' . $TumKategoriler[$i]["0"] . '" /></td>
						<td><strong><a href="product-categories.php?duzelt=' . $TumKategoriler[$i]["0"] . '">' . $TumKategoriler[$i]["2"] . '</a></strong></td>
						<td>' . $mid . '</td>
						<td><a href="?duzelt=' . $TumKategoriler[$i]["0"] . '">Düzenle</a></td>
						<td class="delete">'.$silme.'</td>
					</tr>
						 ';
                                                if ($mid != 'Yok') {/* Eger daha once Yok yazilmadiysa yok ataniyor geri. Cunku Ard arda yok yok yazabilir. */
                                                    $mid = 'Yok';
                                                }
                                                $disabled = '';
                                                $silme='';
                                            }
                                            ?>
                                    </tbody>
                                </table>

                                <div class="tableactions">
                                    <select name="toplusil">
                                        <option value="sil">Sil</option>
                                    </select>

                                    <input type="submit" class="submit tiny" value="Tamam" onclick="return confirm('Sime işlemi sonunda silinen kategoriye ait bütün ürünlerin kategorisi <?php echo $main_cat; ?> olacaktır.\n Onaylıyor musunuz?')"/>
                                    </form>
                                </div>		<!-- .tableactions ends -->

                                <div class="table_pagination right">
                                    <?php
                                    oklar();
                                    ?>
                                </div>     
                            </div>
                        </div>
                    </div>
                </body>
                </html>

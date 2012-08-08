<?php
require_once '../config.php';
if ((!isset($_SESSION['logged'])) || (@$_SESSION['logged'] != 'yes')) {
    header("Location: index.php");
    die;
}

require_once 'inc/functions.php';
require_once 'inc/seo.php';
include_once 'inc/sayfalama.php';

if (isset($_GET['duzelt'])) {
    $id = $_GET['duzelt'];

    if (!is_numeric($id)) {
        $id = 1;
    }
    $DuzenleSonuc = duzelt('id, mid, level, slug, category, description', 'postcategories', $id);
}
if (isset($_GET['sil'])) {
    $id = $_GET['sil'];
}
if (isset($_POST['category']) || (isset($_GET['sil']))) {
    $level = 0;
	$category = @$_POST['category'];
	$slug = slug($category);
    $mid = @$_POST['mid'];
    $description = @$_POST['description'];

    class Kategori {

        public $VeriKont;

        public function __construct() {
            global $db;
            $this->db = $db;
        }

        public function kategoriEkle($mid="", $level, $slug="", $category, $description="") {
            if ($category == "") {
                $_SESSION['var'] = 'Lütfen kategori adını giriniz!';
                $this->VeriKont = false;
            } else if (($mid == "Yok") && (isset($category))) {
                $sql = "SELECT `category` FROM postcategories WHERE `category` = :category";
                $sth = $this->db->prepare($sql);
                $sth->bindValue(':category', $category);
                $sth->execute();
                $sonuc = $sth->fetchAll();
                $say = $sth->rowCount();
                if ($say >= 1) {
                    $_SESSION['var'] = "Bu isimde kategoriniz mevcut.";
                    $this->VeriKont = false;
                } else {
                    $sql = "INSERT INTO postcategories 
                                    (mid,
									level,
									slug,
                                    category,
                                    description)
                                    VALUES 
                                    (:mid,
									:level,
									:slug,
                                    :category,
                                    :description)";
                    $sth = $this->db->prepare($sql);
                    $sth->bindValue(':mid', '0');
					$sth->bindValue(':level', $level);
					$sth->bindValue(':slug', $slug);
                    $sth->bindValue(':category', $category);
                    $sth->bindValue(':description', $description);
                    if ($sth->execute()) {
                        $this->VeriKont = true;
                    }
                }
                return $this->VeriKont;
            } else if (($mid != "Yok") && (isset($category))) {
                $sql = "SELECT `category` FROM postcategories WHERE mid = :mid AND `category` = :category";
                $sth = $this->db->prepare($sql);
                $sth->bindValue(':mid', $mid);
                $sth->bindValue(':category', $category);
                $sth->execute();
                $sonuc = $sth->fetchAll();
                $say = $sth->rowCount();
                if ($say >= 1) {
                    $_SESSION['var'] = "Bu isimde kategoriniz mevcut.";
                    $this->VeriKont = false;
                } else {
                    $sql = "INSERT INTO postcategories (
                              mid,
							  level,
							  slug,
                              category, 
                              description)
                            VALUES (
                              :mid,
							  :level,
							  :slug,
                              :category, 
                              :description)";
                    $sth = $this->db->prepare($sql);
                    $sth->bindValue(':mid', $mid);
					$sth->bindValue(':level', $level);
					$sth->bindValue(':slug', $slug);
                    $sth->bindValue(':category', $category);
                    $sth->bindValue(':description', $description);
                    $this->db->query("SET NAMES 'utf8'");

                    if ($sth->execute()) {
                        $this->VeriKont = true;
                    } else {
                        $this->VeriKont = false;
                    }
                    return $this->VeriKont;
                }
            }
        }

        public function kategoriDuzenle($id, $mid="", $level, $slug="", $category, $description="") {
            if ($category == "") {
                $_SESSION['var'] = 'Lütfen kategori adını giriniz!';
                $this->VeriKont = false;
            } else {
                $sql = "UPDATE postcategories SET 
                          mid = :mid,
						  level = :level,
						  slug = :slug,
                          category = :category, 
                          description = :description 
                          WHERE id = :id";
                $sth = $this->db->prepare($sql);
                $sth->bindValue(':id', $id);
                $sth->bindValue(':mid', $mid);
				$sth->bindValue(':level', $level);
				$sth->bindValue(':slug', $slug);
                $sth->bindValue(':category', $category);
                $sth->bindValue(':description', $description);
                $this->db->query("SET NAMES 'utf8'");
                $sth->execute();
                $sonuc = $sth->fetchAll();
                $say = $sth->rowCount();
                if ($say >= 1) {
                    $this->VeriKont = true;
                } else {
                    $this->VeriKont = false;
                }
                return $this->VeriKont;
            }
        }

        public function kategoriSil($id) {
            $sql = "DELETE FROM postcategories WHERE id = :id;UPDATE posts SET cid='1' WHERE cid = :id";
            $sth = $this->db->prepare($sql);

            $this->db->query("SET NAMES 'utf8'");

            $sth->bindValue(':id', $id);
            $sth->execute();
        }

    }

    $Veri = new Kategori;
    if (isset($_GET['sil']) && is_numeric($_GET['sil'])) {
        $Veri->kategoriSil($id);
        header("Location: post-categories.php");
    } else {
        if (isset($_POST['toplusil'])) {
            foreach ($_POST['tut'] as $id) {
                if (is_numeric($id)) {
                    $Veri->kategoriSil($id);
                }
            }
            header("Location: post-categories.php");
        }

        if ((isset($_GET['duzelt'])) && ($_GET['duzelt'] != "")) {
            $Veri->kategoriDuzenle($id, $mid, $level, $slug, $category, $description);
            header("Location: post-categories.php");
        } else {
            $Veri->kategoriEkle($mid, $level, $slug, $category, $description);
            header("Location: post-categories.php");
        }
    }
}
$sayfaSayisi = Sayfalama('postcategories');
$TumSayfalar = SayfaIcerik('postcategories');
$TumSayfalarSay = count($TumSayfalar);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=7" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Yazı Kategorileri | Herkobi CMS Yönetim Paneli</title>
        <meta name="description" content="." />
        <meta name="keywords" content="." />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/custom.js"></script>
        <style type="text/css" media="all">
            @import url("css/style.css");
        </style>
        <!--[if lt IE 9]>
        <style type="text/css" media="all"> @import url("css/ie.css"); </style>
        <![endif]-->

        <?php
        if (isset($_POST['category'])) {
            if ($Veri->VeriKont) {
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
        ?>

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
                <li><a href="#"><strong><img src="images/nav/rss.png" alt="" /> Yazılar</strong></a>
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
                <a href="admin.php">Başlangıç</a> &raquo; <a href="posts.php">Yazılar</a> &raquo; <a href="post-categories.php">Yazı Kategorisi Ekle</a>
            </div>		<!-- .breadcrumb ends -->

            <div id="success"><div class="message success"><p>Yazı kategorisi başarıyla kayıt edildi.</p></div></div>
            <div id="error"><div class="message errormsg"><p>İşlem gerçekleşmedi. Bir hata oluştu.</p></div></div>
            <div id="warning"><div class="message warning"><p><?php echo @$HataSebep; ?></p></div></div>

            <h2>Yazı Kategorisi Ekle</h2>

            <div class="textbox half kleft">
                <form id="bilgi" action="" method="post">
                    <h2>Kategori Bilgileri</h2>

                    <div class="textbox_content">
                        <p><label>Kategori Adı:</label>
                            <br />
                            <input type="text" name="category" value="<?php echo @$DuzenleSonuc[0]['category']; ?>" size="70" class="text" />
                        </p>
                        <p>
                            <label>Üst Kategori:</label>
                            <select name="mid" class="styled">
                                <option selected="selected" value="Yok">Üst kategori seçin</option>
                                <?php
                                $sql = "SELECT `id`,`category` FROM postcategories ORDER BY `category` ASC";
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
                            <br />
                        </p>        
                        <p>
                            <label>Kategori Açıklaması:</label>
                            <br />
                            <textarea rows="7" name="description" id="description" cols="73"><?php echo @$DuzenleSonuc[0]['description']; ?></textarea>
                        </p>
                    </div>

                    <div class="clear"></div>

                    <div class="textbox_content">
                        <p>
                            <input type="submit" class="submit" value="KAYDET" />
                            <input type="submit" class="submit disabled" disabled="disabled" value="İptal" />
                        </p>
                    </div>      
                </form>
            </div>
            <div class="textbox half kright">
                <h2>Yazı Kategorileri</h2>
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
                            *: <?php echo $TumSayfalar[0]["category"]; ?> isimli kategori silinemez kategoridir. Ancak ismini değiştirebilirsiniz.
                        </i>
                        <tbody>
                            <form action="" method="post">
                                <?php
                                $disabled = '';
                                $mid = 'Yok';
                                $main_cat=$TumSayfalar[0]["category"];
                                for ($i = 0; $i < $TumSayfalarSay; $i++) {
                                    if ($TumSayfalar[$i]["id"] == 1) {
                                        $disabled = 'disabled="disabled"';
                                        $silme = '';
                                    } else {
                                        $silme = '<a href="post-categories.php?sil=' . $TumSayfalar[$i]["id"] . '" onclick="return confirm(\'Sime işlemi sonunda ' . addslashes($TumSayfalar[$i]["category"]) . ' kategorisine ait bütün yazıların kategorisi ' . $main_cat . ' olacaktır. \n Onaylıyor musunuz?\')"><img src="images/close.png" alt="Delete" title="Delete" /></a>';
                                    }
                                    if ($TumSayfalar[$i]['2'] != '') {
                                        $mid = $TumSayfalar[$i]['2'];
                                    }
                                    echo '
						<tr>
							<td><input ' . $disabled . ' type="checkbox" name="tut[]" value="' . $TumSayfalar[$i]["id"] . '" /></td>
							<td><strong><a href="post-categories.php?duzelt=' . $TumSayfalar[$i]["id"] . '">' . $TumSayfalar[$i]["category"] . '</a></strong></td>
							<td>' . $mid . '</td>
							<td><a href="post-categories.php?duzelt=' . $TumSayfalar[$i]["id"] . '">Düzenle</a></td>
							<td class="delete">'.$silme.'</td>
						</tr>
							 ';
                                    if ($mid != 'Yok') {
                                        $mid = 'Yok';
                                    }
                                    $disabled = '';
                                    $silme = '';
                                }
                                ?>
                        </tbody>
                    </table>

                    <div class="tableactions">
                        <select name="toplusil">
                            <option value="sil">Sil</option>
                        </select>

                        <input type="submit" class="submit tiny" value="Tamam" onclick="return confirm('Sime işlemi sonunda silinen kategoriye ait bütün yazıların kategorisi <?php echo $main_cat; ?> olacaktır.\n Onaylıyor musunuz?')"/>
                        </form>
                    </div>		<!-- .tableactions ends -->

                    <div class="table_pagination right">
                        <?php oklar(); ?>
                    </div>		<!-- .pagination ends -->        
                </div>
            </div>
        </div>
    </body>
</html>

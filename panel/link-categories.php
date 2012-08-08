<?php
require_once '../config.php';
if ((!isset($_SESSION['logged'])) || (@$_SESSION['logged'] != 'yes')) {
    header("Location: index.php");
    die;
}
require_once 'inc/functions.php';
require_once 'inc/sayfalama.php';

if (isset($_GET['duzelt'])) {
    $id = $_GET['duzelt'];

    if (!is_numeric($id)) {
        $id = 1;
    }
    $DuzenleSonuc = duzelt('id, category', 'linkcategories', $id);
}
if (isset($_GET['sil']) && is_numeric($_GET['sil'])) {
    $id = $_GET['sil'];
}
if (isset($_POST['category']) || (isset($_GET['sil'])) || (isset($_POST['toplusil']))) {
    $category = @$_POST['category'];

    class LinkKategori {

        public $VeriKont;

        public function __construct() {
            global $db;
            $this->db = $db;
        }

        public function kategoriEkle($category) {
            if ($category == "") {
                $_SESSION['var'] = 'Lütfen kategori adını giriniz!';
                $this->VeriKont = false;
            } else if (isset($category)) {
                $sql = "SELECT `category` FROM linkcategories WHERE `category` = :category";
                $sth = $this->db->prepare($sql);
                $sth->bindValue(':category', $category);
                $sth->execute();
                $sonuc = $sth->fetchAll();
                $say = $sth->rowCount();
                if ($say >= 1) {
                    $_SESSION['var'] = "Bu isimde kategoriniz mevcut.";
                    $this->VeriKont = false;
                } else {
                    $sql = "INSERT INTO linkcategories (
                              category)
                            VALUES (
                              :category)";
                    $sth = $this->db->prepare($sql);
                    $sth->bindValue(':category', $category);
                    $this->db->query("SET NAMES 'utf8'");
                    if ($sth->execute()) {
                        unset($_SESSION['var']);
                        $_SESSION['var'] = 'Link kategorisi başarıyla eklendi!';
                        $this->VeriKont = true;
                    } else {
                        unset($_SESSION['var']);
                        $_SESSION['var'] = 'Link kategorisi ekleme başarısız!';
                        $this->VeriKont = false;
                    }
                    return $this->VeriKont;
                }
            }
        }

        public function kategoriDuzenle($id, $category) {
            if ($category == "") {
                $_SESSION['var'] = 'Lütfen kategori adını giriniz!';
                $this->VeriKont = false;
            } else {
                $sql = "UPDATE linkcategories SET  
                          category = :category 
                          WHERE id = :id";
                $sth = $this->db->prepare($sql);
                $sth->bindValue(':id', $id);
                $sth->bindValue(':category', $category);
                $this->db->query("SET NAMES 'utf8'");
                $sth->execute();
                $sonuc = $sth->fetchAll();
                $say = $sth->rowCount();
                if ($say >= 1) {
                    unset($_SESSION['var']);
                    $_SESSION['var'] = 'Link başarıyla düzenlendi!';
                    $this->VeriKont = true;
                } else {
                    unset($_SESSION['var']);
                    $_SESSION['var'] = 'Link düzenleme başarısız!';
                    $this->VeriKont = false;
                }
                return $this->VeriKont;
            }
        }

        public function kategoriSil($id) {
            //Önce ön tanımlı kategoriye çeviriyoruz bu kategorideki linkleri
            //Daha sonra da kategoriyi siliyoruz
            if ($id != 1) {
                $cat = 1;
                $sql = "UPDATE links SET category = :cat WHERE category = :id;DELETE FROM linkcategories WHERE id=:id;";
                $sth = $this->db->prepare($sql);
                $this->db->query("SET NAMES 'utf8'");
                $sth->bindValue(':id', $id);
                $sth->bindValue(':cat', $cat);
                $sth->execute();
            }
        }

    }

    $Veri = new LinkKategori;
    if (isset($_GET['sil']) && is_numeric($_GET['sil'])) {
        $Veri->kategoriSil($id);
        header("Location: link-categories.php");
    } else {
        if (isset($_POST['toplusil'])) {
            foreach ($_POST['tut'] as $id) {
                if (is_numeric($id)) {
                    $Veri->kategoriSil($id);
                }
            }
            header("Location: link-categories.php");
        }
        if ((isset($_GET['duzelt'])) && ($_GET['duzelt'] != "")) {
            $Veri->kategoriDuzenle($id, $category);
            header("Location: link-categories.php?duzelt=$id&islem=1");
        } else {
            $Veri->kategoriEkle($category);
        }
    }
}

$sql = "SELECT COUNT( id ) FROM linkcategories";
$sth = $db->prepare($sql);
$sth->execute();
$dbSayi = $sth->fetch();

$sayfalamaLimit = 20;

$sayfaSayisi = ceil($dbSayi[0] / $sayfalamaLimit);

if (!isset($_GET['s'])) {
    $sayfalama = 1;
} else {
    $sayfalama = $_GET['s'];
    if (!is_numeric($sayfalama)) {
        $sayfalama = 1;
    }
}

$kacta = (($sayfalama * $sayfalamaLimit) - $sayfalamaLimit);

$sql =
        "
    SELECT id, category
    FROM linkcategories
    ORDER BY `linkcategories`.`id` ASC 
    LIMIT $kacta , $sayfalamaLimit";

$sth = $db->prepare($sql);

$db->query("SET NAMES 'utf8'");
$sth->execute();
$TumSayfalar = $sth->fetchAll();
$TumSayfalarSay = count($TumSayfalar);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=7" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Link Kategorileri | Herkobi CMS Yönetim Paneli</title>
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
        if (isset($_GET['duzelt']) && (isset($_GET['islem'])) || (isset($_GET['sil']))) {
            echo "<style type=\"text/css\" media=\"all\">#success {display: block;}</style>";
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
                <li><a href="#"><strong><img src="images/nav/links.png" alt="" /> Linkler</strong></a>
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
                <a href="admin.php">Başlangıç</a> &raquo; <a href="links.php">Linkler</a> &raquo; <a href="link-categories.php">Link Kategorisi Ekle</a>
            </div>		<!-- .breadcrumb ends -->

            <div id="success"><div class="message success"><p><?php echo @$_SESSION['var']; ?></p></div></div>
            <div id="error"><div class="message errormsg"><p>İşlem gerçekleşmedi. Bir hata oluştu.</p></div></div>
            <div id="warning"><div class="message warning"><p><?php echo @$HataSebep; ?></p></div></div>

            <h2>Link Kategorileri</h2>

            <div class="textbox half kleft">
                <form id="bilgi" action="" method="post">
                    <h2>Kategori Bilgileri</h2>

                    <div class="textbox_content">
                        <p><label>Kategori Adı:</label><br /><input type="text" name="category" size="70" value="<?php echo @$DuzenleSonuc[0]['category']; ?>" class="text" /></p>        
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
                <h2>Kategoriler</h2>
                <div class="textbox_content">
                    <table cellpadding="0" cellspacing="0" width="100%" class="sortable">
                        <thead>
                            <tr>
                                <th width="10"><input type="checkbox" class="check_all" /></th>
                                <th>Kategori Adı</th>
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
                                $main_category = $TumSayfalar[0]["category"]; //Değişmeyen kategori adımız confirmation için lazım...
                                for ($i = 0; $i < $TumSayfalarSay; $i++) {
                                    if ($TumSayfalar[$i]["id"] == 1) {
                                        $disabled = 'disabled="disabled"';
                                        $class = "";
                                    } else {
                                        $class = 'class="lc"';
                                    }
                                    if ($TumSayfalar[$i]["id"] != 1) {
                                        echo '
						<tr>
							<td><input ' . $disabled . ' type="checkbox" name="tut[]" value="' . $TumSayfalar[$i]["id"] . '" /></td>
							<td><strong><a href="link-categories.php?duzelt=' . $TumSayfalar[$i]["id"] . '">' . $TumSayfalar[$i]["category"] . '</a></strong></td>
							<td><a href="link-categories.php?duzelt=' . $TumSayfalar[$i]["id"] . '">Düzenle</a></td>
							<td class="delete"><a href="link-categories.php?sil=' . $TumSayfalar[$i]["id"] . '" onclick="return confirm(\'Sime işlemi sonunda '. addslashes($TumSayfalar[$i]["category"]) .' kategorisindeki bütün linkler '. addslashes($main_category) .' kategorisine taşınacaktır. Onaylıyor musunuz?\')"><img src="images/close.png" alt="Delete" title="Delete" /></a></td>
						</tr>
							 ';
                                    } else {
                                        echo '
						<tr>
							<td><input ' . $disabled . ' type="checkbox" name="tut[]" value="' . $TumSayfalar[$i]["id"] . '" /></td>
							<td><strong><a href="link-categories.php?duzelt=' . $TumSayfalar[$i]["id"] . '">' . $TumSayfalar[$i]["category"] . '</a></strong></td>
							<td><a href="link-categories.php?duzelt=' . $TumSayfalar[$i]["id"] . '">Düzenle</a></td>
							<td class="delete"> </td>
						</tr>
							 ';
                                    }
                                    $disabled = '';
                                }
                                ?>
                        </tbody>
                    </table>
                    <div class="tableactions">
                        <select name="toplusil">
                            <option value="sil">Sil</option>
                        </select>
                        <input type="submit" class="submit tiny" value="Tamam" />
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

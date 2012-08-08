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
    $DuzenleSonuc = duzelt('id, link, category, icon, url', 'links', $id);
}
if (isset($_GET['sil']) && is_numeric($_GET['sil'])) {
    $id = $_GET['sil'];
}
if (isset($_POST['link']) && (isset($_POST['url'])) || isset($_GET['sil']) || isset($_POST['toplusil'])) {
    $link = @$_POST['link'];
    $category = @$_POST['category'];
    $icon = @$_POST['icon'];
	$icon = str_replace($SITE_ADRESI."/","",$icon);
    $url = @$_POST['url'];

    if ($category == "Yok") {
        $category = "1";
    }

    class Link {

        public $VeriKont;

        public function __construct() {
            global $db;
            $this->db = $db;
        }

        public function linkEkle($link, $category="", $icon="", $url) {
            if ($link == "" || $url == "") {
                $_SESSION['var'] = 'Lütfen link adını ve adresini giriniz!';
                $this->VeriKont = false;
            } else {
                $sql = "SELECT `link` FROM links WHERE `link` = :link";
                $sth = $this->db->prepare($sql);
                $sth->bindValue(':link', $link);
                $sth->execute();
                $sonuc = $sth->fetchAll();
                $say = $sth->rowCount();
                if ($say >= 1) {
                    $_SESSION['var'] = "Bu isimde linkiniz mevcuttur.";
                    $this->VeriKont = false;
                } else {
                    $sql = "INSERT INTO links (
                              link,
                              category,
                              icon,
                              url)
                            VALUES (
                              :link,
                              :category,
                              :icon,
                              :url)";
                    $sth = $this->db->prepare($sql);
                    $sth->bindValue(':link', $link);
                    $sth->bindValue(':category', $category);
                    $sth->bindValue(':icon', $icon);
                    $sth->bindValue(':url', $url);
                    $this->db->query("SET NAMES 'utf8'");

                    if ($sth->execute()) {
                        unset($_SESSION['var']);
                        $_SESSION['var'] = 'Link başarıyla eklendi!';
                        $this->VeriKont = true;
                    } else {
                        unset($_SESSION['var']);
                        $_SESSION['var'] = 'Link ekleme başarısız!';
                        $this->VeriKont = false;
                    }
                    return $this->VeriKont;
                }
            }
        }

        public function linkDuzenle($id, $link, $category, $icon, $url) {
            if ($link == "" || $url == "") {
                $_SESSION['var'] = 'Lütfen link adını ve adresini giriniz!';
                $this->VeriKont = false;
                } else {
                $sql = "UPDATE links SET  
                          link = :link,
                          category = :category,
                          icon = :icon,
                          url = :url 
                          WHERE id = :id";
                $sth = $this->db->prepare($sql);
                $sth->bindValue(':id', $id);
                $sth->bindValue(':link', $link);
                $sth->bindValue(':category', $category);
                $sth->bindValue(':icon', $icon);
                $sth->bindValue(':url', $url);
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
        /*
        public function linkSil($id) {
            foreach($_POST['tut'] as $id){
                if (!is_numeric($id)) {
                    $id = null;
                }
                $sql = "DELETE FROM links WHERE id = :id";
                $sth = $this->db->prepare($sql);

                $this->db->query("SET NAMES 'utf8'");

                $sth->bindValue(':id', $id);
                $sth->execute();
                if ($sth->execute()) {
                    $this->VeriKont = true;
                } else {
                    $this->VeriKont = false;
                }
                return $this->VeriKont;
            }
        }
        */
        public function TeklinkSil($id) {
            $sql = "DELETE FROM links WHERE id = :id";
            $sth = $this->db->prepare($sql);
            $this->db->query("SET NAMES 'utf8'");
            $sth->bindValue(':id', $id);
            $sth->execute();
            if ($sth->execute()) {
                unset($_SESSION['var']);
                $_SESSION['var'] = 'Link silme işlemi başarılı!';
                $this->VeriKont = true;
            } else {
                unset($_SESSION['var']);
                $_SESSION['var'] = 'Link silme işlemi başarısız!';
                $this->VeriKont = false;
            }
            return $this->VeriKont;
        }

    }

    $Veri = new Link;
    if (isset($_GET['sil']) && is_numeric($_GET['sil'])) {
        $Veri->TeklinkSil($id);
        header("Location: links.php");
    } else {
        if (isset($_POST['toplusil'])) {
            foreach($_POST['tut'] as $id){
                if (is_numeric($id)) {
                $Veri->TeklinkSil($id);
                }
            }
            header("Location: links.php");
        }
        if ((isset($_GET['duzelt'])) && ($_GET['duzelt'] != "")) {
            $Veri->linkDuzenle($id, $link, $category, $icon, $url);
            header("Location: links.php?duzelt=$id&islem=1");
        } else {
            $Veri->linkEkle($link, $category, $icon, $url);
        }
    }
}

$sql = "SELECT COUNT( id ) FROM links";
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

$sql ="SELECT u.id, u.link, uk.category
    FROM links AS u
    LEFT JOIN linkcategories AS uk ON (u.category = uk.id)
    ORDER BY `u`.`id` ASC 
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
        <title>Linkler | Herkobi CMS Yönetim Paneli</title>
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
        if (isset($_POST['link']) && (isset($_POST['url']))) {
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

        <!-- elFinder -->
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
                            <a href="admin.php">Başlangıç</a> &raquo; <a href="links.php">Linkler</a>
                        </div>		<!-- .breadcrumb ends -->

                        <div id="success"><div class="message success"><p><?php echo @$_SESSION['var']; ?></p></div></div>
                        <div id="error"><div class="message errormsg"><p>İşlem gerçekleşmedi. Bir hata oluştu.</p></div></div>
                        <div id="warning"><div class="message warning"><p><?php echo @$HataSebep; ?></p></div></div>

                        <h2>Link Bilgileri</h2>

                        <div class="textbox half kleft">
                            <form id="bilgi" action="" method="post">
                                <h2>Link Bilgileri</h2>

                                <div class="textbox_content">
                                    <p><label>Link Adı:</label><br /><input type="text" name="link" size="70" value="<?php echo @$DuzenleSonuc[0]['link']; ?>" class="text" /></p>
                                    <p><label>Kategorisi</label><br />
                                        <select class="styled" name="category">
                                            <?php
                                            $sql = "SELECT * FROM linkcategories";
                                            $sth = $db->prepare($sql);
                                            $db->query("SET NAMES 'utf8'");
                                            $sth->execute();
                                            $sonuc = $sth->fetchAll();
                                            $say = count($sonuc);
                                            for ($i = 0; $i < $say; $i++) {
                                                if ($sonuc[$i]['id'] == @$DuzenleSonuc[0]['category']) {
                                                    echo '<option selected value="' . $sonuc[$i]['id'] . '">' . $sonuc[$i]['category'] . '</option>' . "\n";
                                                } else {
                                                    echo '<option value="' . $sonuc[$i]['id'] . '">' . $sonuc[$i]['category'] . '</option>' . "\n";
                                                }
                                            }
                                            ?>
                                        </select>        
                                    </p>
                                    <p class="fileupload">
                                        <label>Link İkonu:</label>
                                        <div id="finder_browse"></div>
                                        <input type="text" id="field" name="icon" value="<?php echo @$DuzenleSonuc[0]['icon']; ?>" />
                                        <input type="button" id="open" class="file" value="Resim Seç" />
                                    </p>        
                                    <p><label>Link Adresi:</label><br /><input type="text" name="url" size="70" value="<?php echo @$DuzenleSonuc[0]['url']; ?>" class="text" /></p>
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
                            <h2>Linkler</h2>
                            <div class="textbox_content">
                                <table cellpadding="0" cellspacing="0" width="100%" class="sortable">
                                    <thead>
                                        <tr>
                                            <th width="10"><input type="checkbox" class="check_all" /></th>
                                            <th>Link Adı</th>
                                            <th>Kategorisi</th>
                                            <th>Düzenle</th>
                                            <th>Sil</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <form action="" method="post">
                                            <?php
                                            for ($i = 0; $i < $TumSayfalarSay; $i++) {
                                                echo '
	                    <tr>
	                      <td><input type="checkbox" name="tut[]" value="' . @$TumSayfalar[$i]["id"] . '" /></td>
	                      <td><strong><a href="links.php?duzelt=' . @$TumSayfalar[$i]["id"] . '">' . @$TumSayfalar[$i]["link"] . '</a></strong></td>
                        <td><strong>' . @$TumSayfalar[$i]["category"] . '</td>
	                      <td><a href="links.php?duzelt=' . @$TumSayfalar[$i]["id"] . '">Düzenle</a></td>
	                      <td class="delete"><a href="?sil=' . @$TumSayfalar[$i]["id"] . '"><img src="images/close.png" alt="Delete" title="Delete" /></a></td>
	                    </tr>
	                    ';
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

<?php
require_once'../config.php';
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
    $DuzenleSonuc = duzelt('*', 'galleries', $id);
}
if (isset($_GET['sil']) && is_numeric($_GET['sil'])) {
    $id = $_GET['sil'];
}
if (isset($_POST['album']) || isset($_POST['toplusil']) || isset($_POST['sil'])) {
    $level = 0;
	$album = @$_POST['album'];
	$slug = slug($album);
    $description = @$_POST['description'];
    $image = @$_POST['image'];
	$image = str_replace($SITE_ADRESI."/","",$image);

    class Galeri {

        public $VeriKont;

        public function __construct() {
            global $db;
            $this->db = $db;
        }

        public function galeriEkle($level, $slug="", $album, $description="", $image) {
            if ($album == "") {
                unset($_SESSION['var']);
                $_SESSION['var'] = "Lütfen albüm adını giriniz!";
                $this->VeriKont = false;
            } else if ($image == "") {
                unset($_SESSION['var']);
                $_SESSION['var'] = "Lütfen albüm kapak resmi yükleyiniz!";
                $this->VeriKont = false;
            } else {
                $sql = "SELECT `album` FROM galleries WHERE `album` = :album";
                $sth = $this->db->prepare($sql);
                $sth->bindValue(':album', $album);
                $sth->execute();
                $sonuc = $sth->fetchAll();
                $say = $sth->rowCount();
                if ($say >= 1) {
                    unset($_SESSION['var']);
                    $_SESSION['var'] = "Daha önce " . $album . " adında bir albüm eklemişsiniz.";
                    $this->VeriKont = false;
                } else {
                    $sql = "
                    INSERT INTO galleries
		     (level,slug,album,description,image)
                    VALUES
                      (:level,:slug,:album,:description,:image)";
                    $sth = $this->db->prepare($sql);
                    $sth->bindValue(':level', $level);
					$sth->bindValue(':slug', $slug);
					$sth->bindValue(':album', $album);
                    $sth->bindValue(':description', $description);
                    $sth->bindValue(':image', $image);
                    $this->db->query("SET NAMES 'utf8'");

                    if ($sth->execute()) {
                        $this->last = $this->db->lastInsertId();
                        unset($_SESSION['var']);
                        $_SESSION['var'] = 'Galeri başarıyla eklendi!';
                        $this->VeriKont = true;
                    } else {
                        unset($_SESSION['var']);
                        $_SESSION['var'] = 'Galeri ekleme başarısız!';
                        $this->VeriKont = false;
                    }
                    return $this->VeriKont;
                }
            }
        }

        public function galeriDuzenle($id, $level, $slug="", $album, $description="", $image) {
            if ($album == "") {
                unset($_SESSION['var']);
                $_SESSION['var'] = "Lütfen albüm adını giriniz!";
                $this->VeriKont = false;
            } else if ($image == "") {
                unset($_SESSION['var']);
                $_SESSION['var'] = "Lütfen albüm kapak resmi yükleyiniz!";
                $this->VeriKont = false;
            } else {
                $sql = "UPDATE galleries 
                SET
                  level = :level,
				  slug = :slug,
				  album = :album,
                  description = :description,
                  image = :image
                  WHERE id = :id";
                $sth = $this->db->prepare($sql);
                $sth->bindValue(':id', $id);
                $sth->bindValue(':level', $level);
				$sth->bindValue(':slug', $slug);
				$sth->bindValue(':album', $album);
                $sth->bindValue(':description', $description);
                $sth->bindValue(':image', $image);
                $this->db->query("SET NAMES 'utf8'");
                $sth->execute();
                $say = $sth->rowCount();
                if ($say >= 1) {
                    unset($_SESSION['var']);
                    $_SESSION['var'] = 'Galeri başarıyla düzenlendi!';
                    $this->VeriKont = true;
                } else {
                    unset($_SESSION['var']);
                    $_SESSION['var'] = 'Galeri düzenleme başarısız!';
                    $this->VeriKont = false;
                }
                return $this->VeriKont;
            }
        }

        /*
          public function galeriSil($id) {
          $tut = explode(',', $id);
          $say = count($tut) - 1;
          for ($i = 0; $i < $say; $i++) {
          if (!is_numeric($tut[$i])) {
          $tut[$i] = null;
          }
          $url = "galleries.php?id=" . $tut[$i];
          $sql = "DELETE FROM galleries WHERE id = :id;";
          $sth = $this->db->prepare($sql);

          $sth->bindValue(':id', $tut[$i]);

          $sth->execute();
          }
          }
         */

        public function TekGaleriSil($id) {
            $sql = "DELETE FROM galleries WHERE id = :id";
            $sth = $this->db->prepare($sql);
            $this->db->query("SET NAMES 'utf8'");
            $sth->bindValue(':id', $id);
            $sth->execute();
            if ($sth->execute()) {
                unset($_SESSION['var']);
                $_SESSION['var'] = 'Galeri silme işlemi başarılı!';
                $this->VeriKont = true;
            } else {
                unset($_SESSION['var']);
                $_SESSION['var'] = 'Galeri silme işlemi başarısız!';
                $this->VeriKont = false;
            }
            return $this->VeriKont;
        }

    }

    $Veri = new Galeri;
    if (isset($_GET['sil']) && is_numeric($_GET['sil'])) {
        $Veri->TekGaleriSil($id);
        header("Location: galleries.php");
    } else {
        if (isset($_POST['toplusil'])) {
            foreach ($_POST['tut'] as $id) {
                if (is_numeric($id)) {
                    $Veri->TekGaleriSil($id);
                }
            }
            header("Location: galleries.php");
        }
        if ((isset($_GET['duzelt'])) && ($_GET['duzelt'] != "")) {
            $Veri->galeriDuzenle($id, $level, $slug, $album, $description, $image);
            header("Location: galleries.php?duzelt=$id&islem=1");
        } else {
            $Veri->galeriEkle($level, $slug, $album, $description, $image);
        }
    }
}

$sayfaSayisi = sayfalama('galleries');
$TumAlbumler = SayfaIcerik('galleries');
$TumAlbumlerSay = count($TumAlbumler);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=7" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Galeriler | Herkobi CMS Yönetim Paneli</title>
        <meta name="description" content="." />
        <meta name="keywords" content="." />
        <style type="text/css" media="all">
            @import url("css/style.css");
        </style>
        <?php
        if (isset($_POST['album'])) {
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
                            <a href="admin.php">Başlangıç</a> &raquo; <a href="galleries.php">Galeriler</a>
                        </div>		<!-- .breadcrumb ends -->

                        <div id="success"><div class="message success"><p><?php echo @$_SESSION['var']; ?></p></div></div>
                        <div id="error"><div class="message errormsg"><p>Hata oluştu, lütfen tekrar deneyiniz.</p></div></div>
                        <div id="warning"><div class="message warning"><p><?php echo @$HataSebep; ?></p></div></div>

                        <h2>Albüm Ekle</h2>		
                        <div class="textbox half kleft">
                            <form id="bilgi" action="" method="post">
                                <h2>Albüm Bilgileri</h2>
                                <div class="textbox_content">
                                    <p><label>Albüm Adı:</label><br /><input type="text" size="70" class="text" name="album" value="<?php echo @$DuzenleSonuc[0]['album']; ?>"/></p>       
                                    <p><label>Albüm Hakkında:</label><br /><textarea rows="7" cols="73" name="description"><?php echo @$DuzenleSonuc[0]['description']; ?></textarea></p>
                                    <p class="fileupload">
                                        <label>Albüm Kapak Resmi Ekle:</label>
                                        <div id="finder_browse"></div>
                                        <input type="text" id="field" name="image" value="<?php echo @$DuzenleSonuc[0]['image']; ?>" />
                                        <input type="button" id="open" class="file" value="Resim Seç" />
                                        </p>
                                        <?php
                                        if (isset($_GET['duzelt']) && $DuzenleSonuc[0]['image'] != "") {
                                            ?>
                                            <p><label>Mevcut Kapak Resmi:</label><br /></p>
                                            <p><img src="<?php echo $SITE_ADRESI; ?>/<?php echo @$DuzenleSonuc[0]['image']; ?>" /></p>
                                            <?php
                                        }
                                        ?>
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
                            <h2>Albümler</h2>
                            <div class="textbox_content">
                                <table cellpadding="0" cellspacing="0" width="100%" class="sortable">
                                    <thead>
                                        <tr>
                                            <th width="10"><input type="checkbox" class="check_all" /></th>
                                            <th>Albüm Adı</th>
                                            <th>Düzenle</th>
                                            <th>Sil</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <form action="" method="post">

                                            <?php
                                            for ($i = 0; $i < $TumAlbumlerSay; $i++) {
                                                echo '
					              <tr>
					                <td><input type="checkbox" name="tut[]" value=' . $TumAlbumler[$i]["id"] . ' /></td>
					                <td><strong><a href="photos.php?duzelt=' . $TumAlbumler[$i]["id"] . '">' . $TumAlbumler[$i]["album"] . '</a></strong></td>
					                <td><a href="?duzelt=' . $TumAlbumler[$i]["id"] . '">Düzenle</a></td>
					                <td class="delete"><a class="al" alt="' . $TumAlbumler[$i]["id"] . '" href="#"><img src="images/close.png" alt="' . $TumAlbumler[$i]["id"] . '" title="Delete" /></a></td>
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
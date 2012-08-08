<?php
include_once '../config.php';
if ((!isset($_SESSION['logged'])) || (@$_SESSION['logged'] != 'yes')) {
    header("Location: index.php");
    die;
}
require_once "inc/seo.php";

$mesaj = "";
if (isset($_GET['duzelt']) && ($_GET['duzelt'] != "")) {
    $gallery = @$_GET['duzelt'];
    if (!is_numeric($gallery)) {
        $gallery = 1;
    }

    $sql = "SELECT id, image FROM photos WHERE gallery = :gallery";
    $sth = $db->prepare($sql);
    $sth->bindValue(':gallery', $gallery);
    $db->query("SET NAMES 'utf8'");
    $sth->execute();

    $TumGaleriler = $sth->fetchAll();
    $TumGalerilerSay = count($TumGaleriler);
}

if (isset($_POST['description']) && (isset($_POST['image'])) && isset($_GET['duzelt']) && ($_GET['duzelt'] != "")) {

    $level = 0;
	$description = @$_POST['description'];
	$slug = slug($description);
    $image = @$_POST['image'];
	$image = str_replace($SITE_ADRESI."/","",$image);

    class Resim {

        public $VeriKont;

        public function __construct() {
            global $db, $SITE_ADRESI;
            $this->db = $db;
            $this->SITE_ADRESI = $SITE_ADRESI;
        }

        public function resimEkle($level, $slug="", $gallery, $description="", $image) {
            $current_page = current_url();
            if ($gallery == "" || $image == "") {
                //$_SESSION['var'] = "Lütfen resim galerisi ve resim adresini doğru belirtiniz!";
                $this->VeriKont = false;
                $current_page .= "&hata=2";
                header("Location: $current_page");
            } else {
                //$image = $this->SITE_ADRESI.'/'.$image;
                $sql = "SELECT `image` FROM photos WHERE `image` = :image AND gallery = :gallery";
                $sth = $this->db->prepare($sql);
                $sth->bindValue(':image', $image);
                $sth->bindValue(':gallery', $gallery);
                $sth->execute();
                $sonuc = $sth->fetchAll();
                $say = $sth->rowCount();
                if ($say >= 1) {
                    $this->VeriKont = false;
                    $current_page .= "&hata=1";
                    header("Location: $current_page");
                } else {
                    $sql = "INSERT INTO photos (
                              level,
							  slug,
							  gallery, 
                              description, 
                              image)
                            VALUES (
                              :level,
							  :slug,
							  :gallery, 
                              :description, 
                              :image)";
                    $sth = $this->db->prepare($sql);
                    $sth->bindValue(':level', $level);
					$sth->bindValue(':slug', $slug);
					$sth->bindValue(':gallery', $gallery);
                    $sth->bindValue(':description', $description);
                    $sth->bindValue(':image', $image);
                    $this->db->query("SET NAMES 'utf8'");
                    if ($sth->execute()) {
                        $this->VeriKont = true;
                        $current_page .= "&durum=1";
                        header("Location: $current_page");
                    } else {
                        $this->VeriKont = false;
                    }
                    return $this->VeriKont;
                }
            }
        }

    }

    $Veri = new Resim;

    $Veri->resimEkle($level, $slug, $gallery, $description, $image);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=7" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Resim Ekle | Herkobi CMS Yönetim Paneli</title>
        <meta name="description" content="." />
        <meta name="keywords" content="." />

        <?php
        /*
          if (isset($_POST['description']) && (isset($_POST['image'])) && isset($_GET['duzelt']) && ($_GET['duzelt'] != "")) {
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
         * 
         */
        //Hata Kontrol ve post adresi düzenleme
        $post_url = current_url(); //form post url
        if (isset($_GET['hata']) || isset($_GET['durum']) || isset($_GET['sil'])) {
            if (isset($_GET['hata'])){
            if ($_GET['hata'] > 1) {
                $mesaj = "Lütfen resim galerisi ve resim adresini doğru belirtiniz!"; //eksik post
            } if ($_GET['hata'] < 2) {
                $mesaj = "Bu galeriye bu fotoğraf daha önce eklenmiş."; //bu resim bu galeride var
            }
            }
            if (isset($_GET['durum'])) {//hata yok
                $mesaj = "Fotoğraf başarılı bir şekilde galeriye eklendi.";
            }
            if (isset($_GET['sil'])) {
                if ($_GET['sil'] < 2) {//hata yok
                    $mesaj = "Fotoğraf başarılı bir şekilde kaldırıldı.";
                }
                if ($_GET['sil'] > 1) {//hata var
                    $mesaj = "Fotoğraf kaldırılamadı.";
                }
            }
            $post_url = str_replace("&durum=1", "", $post_url);
            $post_url = str_replace("&hata=1", "", $post_url);
            $post_url = str_replace("&sil=1", "", $post_url);
            $post_url = str_replace("&sil=2", "", $post_url);
            $post_url = str_replace($PANEL_ADRESI . "/", "", $post_url);
        }
        //Hata Kontrol ve post adresi düzenleme biter
        ?>
        <!-- elFinder -->
        <script src="elfinder/js/jquery-1.6.1.min.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript" src="js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/custom.js"></script>
        <script src="elfinder/js/jquery-ui-1.8.13.custom.min.js" type="text/javascript" charset="utf-8"></script>

        <link rel="stylesheet" href="elfinder/css/smoothness/jquery-ui-1.8.13.custom.css" type="text/css" media="screen" title="no title" charset="utf-8">	
            <link rel="stylesheet" href="elfinder/css/elfinder.css" type="text/css" media="screen" title="no title" charset="utf-8">
                <script type="text/javascript" src="js/jquery.fancybox.js"></script>

                <style type="text/css" media="all">
                    @import url("css/style.css");
                    @import url("css/jquery.fancybox.css");
                </style>
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
                            dialog : { title : 'Dosya Yöneticisi', height: 500 }
                        }

                        $('#open').click(function() {                        // Must change the button's id
                            $('#finder_browse').elfinder(opt)                // Must update the form field id
                            $('#finder_browse').elfinder($(this).attr('id'));   // Must update the form field id
                        })                
                    });

                </script>  
                <script type="text/javascript">
                    $().ready(function() {
                        $("a.modal").fancybox({
                            'transitionIn'	:	'elastic',
                            'transitionOut'	:	'elastic',
                            'speedIn'		:	600, 
                            'speedOut'		:	200, 
                            'overlayShow'	:	true,
                            'titlePosition'	:       'over'
                        });
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
                            <a href="admin.php">Başlangıç</a> &raquo; <a href="galleries.php">Galeriler</a> &raquo; <a href="photos.php">Resim Ekle</a> 
                        </div>		<!-- .breadcrumb ends -->
                        <?php if (isset($_GET['durum'])) { ?>
                            <div id="success" style="display: block;"><div class="message success"><p><?php echo $mesaj; ?></p></div></div>
                            <?php
                        }
                        if (isset($_GET['hata'])) {
                            ?>
                            <div id="error" style="display: block;"><div class="message errormsg"><p>Hata oluştu, lütfen tekrar deneyiniz.</p></div></div>
                            <div id="warning" style="display: block;"><div class="message warning"><p><?php echo $mesaj; ?></p></div></div>
                            <?php
                        }
                        if (isset($_GET['sil'])) {
                            if ($_GET['sil'] > 1) {
                                ?>
                                <div id="error" style="display: block;"><div class="message errormsg"><p>Hata oluştu, lütfen tekrar deneyiniz.</p></div></div>
                                <div id="warning" style="display: block;"><div class="message warning"><p><?php echo $mesaj; ?></p></div></div>
                                <?php
                            }
                            if ($_GET['sil'] < 2) {
                                ?>
                                <div id="success" style="display: block;"><div class="message success"><p><?php echo $mesaj; ?></p></div></div>
                                <?php
                            }
                        }
                        ?>
                        <h2>Resim Ekle</h2>
                        <form action="<?php echo $post_url; ?>" method="post">
                            <div class="textbox left">
                                <h2>Resim Bilgileri</h2>

                                <div class="textbox_content">
                                    <p class="fileupload">
                                        <label>Resim Ekle:</label>
                                        <div id="finder_browse"></div>
                                        <input type="text" id="field" name="image" value="" />
                                        <input type="button" id="open" class="file" value="Resim Seç" />            
                                    </p>
                                    <p><label>Resim Yazısı:</label><br /><input type="text" size="100" class="text" name="description" /></p>         
                                </div>
                            </div>

                            <div class="textbox right">
                                <h2>Kaydet</h2>

                                <div class="textbox_content">
                                    <p>
                                        <input type="submit" class="submit" value="Kaydet" />
                                        <input type="submit" class="submit disabled" disabled="disabled" value="İptal" />
                                    </p>
                                </div>      
                            </div>      
                        </form>

                        <div class="textbox left">
                            <h2>Galeri Resimleri</h2>

                            <div class="textbox_content">
                                <ul class="imglist">
                                    <?php
                                    for ($i = 0; $i < $TumGalerilerSay; $i++) {
                                        echo '
                    <li>
                      <img src="'.$SITE_ADRESI."/".$TumGaleriler[$i]["image"] . '" alt="" />
                      <ul>
                        <li class="view"><a href="'.$SITE_ADRESI."/".$TumGaleriler[$i]["image"] . '" class="modal" rel="gallery">Göster</a></li>
                        <li class="delete"><a class="ph" alt="' . $TumGaleriler[$i]["id"] . '" ana="'.$_GET["duzelt"].'" href="#">Sil</a></li>
                      </ul>
                    </li>
                ';
                                    }
                                    ?>                                             
                                </ul>                
                            </div>
                        </div>		
                    </div>
                </body>
                </html>

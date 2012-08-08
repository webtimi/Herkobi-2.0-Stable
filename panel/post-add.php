<?php
require_once '../config.php';
if ((!isset($_SESSION['logged'])) || (@$_SESSION['logged'] != 'yes')) {
    header("Location: index.php");
    die;
}

require_once 'inc/functions.php';
require_once 'inc/seo.php';

if (isset($_GET['duzelt'])) {
    $id = $_GET['duzelt'];
    if (!is_numeric($id)) {
        $id = 1;
    }
    $DuzenleSonuc = duzelt('*', 'posts', $id);
}

if (isset($_POST['post']) && (isset($_POST['content']))) {
    $level = 0;
	$post = @$_POST['post'];
	$slug = slug($post);
    $summary = @$_POST['summary'];
    $content = @$_POST['content'];
    $image = @$_POST['image'];
	$image = str_replace($SITE_ADRESI."/","",$image);
    $gallery = @$_POST['gallery'];
    $cid = @$_POST['cid'];
    $title = @$_POST['title'];
    $metadesc = @$_POST['metadesc'];
    $metatags = @$_POST['metatags'];

    if ($cid == "yok") {
        $cid = "1";
    }

    if ($title == "") {
        $title = $post;
    }

    if ($metadesc == "") {
        $content = trim(strip_tags($content));
        $metadesc = trim(mb_substr($content, 0, 160, 'UTF-8'));
    }

    class Haber {

        public $VeriKont;

        public function __construct() {
            global $db;
            $this->db = $db;
        }

        public function haberEkle($cid="", $level, $slug="", $post, $summary="", $content, $image="", $gallery="", $title="", $metadesc="", $metatags="") {
            if ($post == "" || $content == "") {
                $_SESSION['var'] = 'Yazı başlığını ve içeriğini giriniz!';
                $this->VeriKont = false;
            } else {
                $sql = "SELECT `cid`,`post` FROM posts WHERE `cid` = :cid AND `post` = :post";
                $sth = $this->db->prepare($sql);
                $sth->bindValue(':cid', $cid);
                $sth->bindValue(':post', $post);
                $sth->execute();
                $sonuc = $sth->fetchAll();
                $say = $sth->rowCount();
                if ($say >= 1) {
                    $_SESSION['var'] = 'Bu başlıkta daha önce yazı eklemişsiniz.';
                    $this->VeriKont = false;
                } else {
                    $sql = "INSERT INTO posts (
                              cid,
							  level,
							  slug,
                              post, 
                              summary, 
                              content, 
                              image,
                              gallery, 
                              title, 
                              metadesc, 
                              metatags, 
                              date)
                            VALUES (
                              :cid, 
                              :level,
							  :slug,
							  :post, 
                              :summary, 
                              :content, 
                              :image,
                              :gallery, 
                              :title, 
                              :metadesc, 
                              :metatags, 
                              NOW())";
                    $sth = $this->db->prepare($sql);
                    $sth->bindValue(':cid', $cid);
					$sth->bindValue(':level', $level);
					$sth->bindValue(':slug', $slug);
                    $sth->bindValue(':post', $post);
                    $sth->bindValue(':summary', $summary);
                    $sth->bindValue(':content', $content);
                    $sth->bindValue(':image', $image);
                    $sth->bindValue(':gallery', $gallery);
                    $sth->bindValue(':title', $title);
                    $sth->bindValue(':metadesc', $metadesc);
                    $sth->bindValue(':metatags', $metatags);
                    $this->db->query("SET NAMES 'utf8'");

                    if ($sth->execute()) {
                        $this->last = $this->db->lastInsertId();
                        $this->VeriKont = true;
                    } else {
                        $this->VeriKont = false;
                    }
                    return $this->VeriKont;
                }
            }
        }

        public function haberDuzenle($id, $cid="", $level, $slug="", $post, $summary="", $content, $image="", $gallery="", $title="", $metadesc="", $metatags="") {
            if ($post == "" || $content == "") {
                $_SESSION['var'] = 'Yazı başlığını ve içeriğini giriniz!';
                $this->VeriKont = false;
            }
            if ($cid == "") {
                $cid = "1";
            } else {
                $sql = "UPDATE posts SET 
                          cid = :cid, 
                          level = :level,
						  slug = :slug,
						  post = :post, 
                          summary = :summary,  
                          content = :content, 
                          image = :image,
                          gallery = :gallery, 
                          title = :title, 
                          metadesc = :metadesc, 
                          metatags = :metatags, 
                          date = NOW() 
                          WHERE id = :id";
                $sth = $this->db->prepare($sql);
                $sth->bindValue(':id', $id);
                $sth->bindValue(':cid', $cid);
				$sth->bindValue(':level', $level);
				$sth->bindValue(':slug', $slug);
                $sth->bindValue(':post', $post);
                $sth->bindValue(':summary', $summary);
                $sth->bindValue(':content', $content);
                $sth->bindValue(':image', $image);
                $sth->bindValue(':gallery', $gallery);
                $sth->bindValue(':title', $title);
                $sth->bindValue(':metadesc', $metadesc);
                $sth->bindValue(':metatags', $metatags);
                $this->db->query("SET NAMES 'utf8'");
                $sth->execute();
                $say = $sth->rowCount();
                if ($say == 1) {
                    $this->VeriKont = true;
                } else {
                    $this->VeriKont = false;
                }
                return $this->VeriKont;
            }
        }

    }

    $Veri = new Haber;

    if ((isset($_GET['duzelt'])) && ($_GET['duzelt'] != "")) {
        if ($content == "" || $post == "") {
            unset($_SESSION['var']);
            $_SESSION['var'] = 'Yazı başlığı ve içerik alanları zorunludur!';
            header("Location: post-add.php?duzelt=$id&hata=1");
        } else {
            $Veri->haberDuzenle($id, $cid, $level, $slug, $post, $summary, $content, $image, $gallery, $title, $metadesc, $metatags);
            header("Location: posts.php");
        }
    } else {
        if ($content == "" || $post == "") {
            unset($_SESSION['var']);
            $_SESSION['var'] = 'Yazı başlığı ve içerik alanları zorunludur!';
            header("Location: post-add.php?hata=1");
        } else {
            $Veri->haberEkle($cid, $level, $slug, $post, $summary, $content, $image, $gallery, $title, $metadesc, $metatags);
            header("Location: posts.php");
        }
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=7" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Yazı Ekle | Herkobi CMS Yönetim Paneli</title>
        <meta name="description" content="." />
        <meta name="keywords" content="." />
        <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
        <style type="text/css" media="all">
            @import url("css/style.css");
        </style>

        <?php
        if (isset($_POST['post']) && (isset($_POST['content']))) {
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

        <!-- elFinder -->
        <script src="elfinder/js/jquery-1.6.1.min.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript" src="js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/custom.js"></script>
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
                            <a href="admin.php">Başlangıç</a> &raquo; <a href="posts.php">Yazılar</a> &raquo; <a href="post-add.php">Yazı Ekle</a>
                        </div>		<!-- .breadcrumb ends -->

                        <div id="success"><div class="message success"><p>Yazı başarıyla kayıt edildi.</p></div></div>
                        <div id="error"><div class="message errormsg"><p>İşlem gerçekleşmedi. Bir hata oluştu.</p></div></div>
                        <div id="warning"><div class="message warning"><p><?php echo @$HataSebep; ?></p></div></div>

                        <h2>Yazı Ekle</h2>

                        <form id="bilgi" action="" method="post">
                            <div class="textbox left">
                                <h2>Yazı İçeriği</h2>

                                <div class="textbox_content">
                                    <p><label>Yazı Adı:</label><br /><input type="text" value="<?php echo @$DuzenleSonuc[0]['post']; ?>" name="post" size="100" class="text" /></p>        
                                    <p><label>Yazı Özeti:</label><br /><textarea rows="4" id="summary" name="summary" cols="103"><?php echo @$DuzenleSonuc[0]['summary']; ?></textarea></p>
                                    <p><label>Yazı İçeriği (Zorunlu alan):</label><br /><textarea id="postcontent" name="content"><?php echo @$DuzenleSonuc[0]['content']; ?></textarea></p>
                                    <script type="text/javascript">
                                        CKEDITOR.replace('postcontent',
                                        {
                                            width : 650+'px',
                                            height : 280+'px',
                                            uiColor : '#9AB8F3',
                                            name : 'postcontent2',
                                            filebrowserBrowseUrl : '<?php echo $PANEL_ADRESI; ?>/elfinder.php'
                                        });
                                    </script> 
                                </div>
                            </div>

                            <div class="textbox right">
                                <h2>Kaydet</h2>

                                <div class="textbox_content">
                                    <p>
                                        <input type="submit" class="submit" value="YAYINLA" />
                                        <input type="reset" class="submit disabled" value="İptal" />

                                    </p>
                                </div>      
                            </div>
                            <div class="textbox right">
                                <h2>Yazı Bilgileri</h2>
                                <div class="textbox_content">
                                    <p>
                                        <label>Kategori:</label>
                                        <select class="styled" name="cid">
                                            <option selected="selected" value="yok">Kategori seçin</option>>
                                            <?php
                                            $sql = "SELECT `id`,`category` FROM postcategories ORDER BY `category` DESC";
                                            $sth = $db->prepare($sql);
                                            $db->query("SET NAMES 'utf8'");
                                            $sth->execute();
                                            $sonuc = $sth->fetchAll();
                                            $say = count($sonuc);
                                            for ($i = 0; $i < $say; $i++) {
                                                if ($sonuc[$i]['id'] == @$DuzenleSonuc[0]['cid']) {
                                                    echo '<option selected value="' . $sonuc[$i]['id'] . '">' . $sonuc[$i]['category'] . '</option>' . "\n";
                                                } else {
                                                    echo '<option value="' . $sonuc[$i]['id'] . '">' . $sonuc[$i]['category'] . '</option>' . "\n";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </p>        
                                    <p class="fileupload">
                                        <label>Resim Seçiniz:</label>
                                        <div id="finder_browse"></div>
                                        <input type="text" id="field" name="image" value="<?php echo @$DuzenleSonuc[0]['image']; ?>" />
                                        <input type="button" id="open" class="file" value="Resim Seç" />
                                    </p>
                                    <p>
                                        <label>Albüm Ekle:</label>
                                        <select name="gallery" class="styled">
                                            <option selected="selected" value="Yok">Albüm Seçiniz</option>
                                            <?php
                                            $sql = "SELECT `id`,`album` FROM galleries ORDER BY `id` DESC";
                                            $sth = $db->prepare($sql);
                                            $db->query("SET NAMES 'utf8'");
                                            $sth->execute();
                                            $sonuc = $sth->fetchAll();
                                            $say = count($sonuc);
                                            for ($i = 0; $i < $say; $i++) {
                                                if (@$sonuc[$i]['id'] == @$DuzenleSonuc[0]['gallery']) {
                                                    echo '<option selected value="' . @$sonuc[$i]['id'] . '">' . @$sonuc[$i]['album'] . '</option>' . "\n";
                                                } else {
                                                    echo '<option value="' . @$sonuc[$i]['id'] . '">' . @$sonuc[$i]['album'] . '</option>' . "\n";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </p>            
                                </div>
                            </div>
                            <div class="clear"></div>
                            <div class="textbox left">
                                <h2>Arama Motoru Bilgileri</h2>
                                <div class="textbox_content">
                                    <p><label>Yazı Başlığı:</label><br /><input type="text" value="<?php echo @$DuzenleSonuc[0]['title']; ?>" name="title" size="100" class="text" /></p>        
                                    <p><label>Yazı İçerik Özeti: <small>En fazla 160 karakter giriniz</small></label><br /><textarea id="metadesc" name="metadesc" rows="4" cols="103"><?php echo @$DuzenleSonuc[0]['metadesc']; ?></textarea></p>
                                    <p><label>Anahtar Kelimeler: <small>Virgülle ayırarak birden çok anahtar kelime girebilirsiniz</small></label><br /><input type="text" value="<?php echo @$DuzenleSonuc[0]['metatags']; ?>" name="metatags" size="100" class="text" /></p>
                                </div>
                            </div>      
                        </form>
                    </div>
                </body>
                </html>
<?php
if (isset($_GET['hata'])) {
    ?>
<script type="text/javascript">alert('Yazı başlığı ve içerik alanları zorunludur!');</script>
<?php
}
?>
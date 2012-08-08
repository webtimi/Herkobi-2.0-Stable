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
    $DuzenleSonuc = duzelt("*", "pages", $id);
}
if (isset($_POST['page']) && (isset($_POST['content']))) {
    $date = date("Y-m-d", time());
    $mid = @$_POST['mid'];
	$level = 0;
    $page = @$_POST['page'];
	$slug = slug($page);
    $summary = @$_POST['summary'];
    $content = @$_POST['content'];
    $image = @$_POST['image'];
	$image = str_replace($SITE_ADRESI."/","",$image);
    $gallery = @$_POST['gallery'];
    $title = @$_POST['title'];
    $metadesc = @$_POST['metadesc'];
    $metatags = @$_POST['metatags'];
    if ($mid == "Yok") {
        $mid = "0";
    }

    if ($title == "") {
        $title = $page;
    }

    if ($metadesc == "") {
        $content = trim(strip_tags($content));
        $metadesc = trim(mb_substr($content, 0, 160, 'UTF-8'));
    }

    class Sayfa {

        public $VeriKont;

        public function __construct() {
            global $db;
            $this->db = $db;
            //$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Error handling
        }

        public function sayfaEkle($mid="", $level, $slug="", $page, $summary="", $content, $image="", $gallery="", $title="", $metadesc="", $metatags="", $date) {
            if ($page == "" || $content == "") {
                $_SESSION['var'] = 'Yazı başlığını ve içeriğini giriniz!';
                $this->VeriKont = false;
            } else {
                $sql = "SELECT `page` FROM pages WHERE `page` = :page";
                $sth = $this->db->prepare($sql);
                $sth->bindValue(':page', $page);
                $sth->execute();
                $sonuc = $sth->fetchAll();
                $say = $sth->rowCount();
                if ($say >= 1) {
                    $_SESSION['var'] = 'Bu başlıkta daha önce yazı eklemişsiniz.';
                    $this->VeriKont = false;
                } else {
                    $sql = "INSERT INTO pages (
                              mid,
							  level,
							  slug,
                              page, 
                              summary, 
                              content, 
                              image,
                              gallery,
                              title, 
                              metadesc, 
                              metatags, 
                              date)
                            VALUES (
                              :mid,
							  :level,
							  :slug,
                              :page, 
                              :summary, 
                              :content, 
                              :image,
                              :gallery, 
                              :title, 
                              :metadesc, 
                              :metatags, 
                              :date)";
                    $sth = $this->db->prepare($sql);
                    $sth->bindValue(':mid', $mid);
                    $sth->bindValue(':level', $level);
					$sth->bindValue(':slug', $slug);
					$sth->bindValue(':page', $page);
                    $sth->bindValue(':summary', $summary);
                    $sth->bindValue(':content', $content);
                    $sth->bindValue(':image', $image);
                    $sth->bindValue(':gallery', $gallery);
                    $sth->bindValue(':title', $title);
                    $sth->bindValue(':metadesc', $metadesc);
                    $sth->bindValue(':metatags', $metatags);
                    $sth->bindValue(':date', $date);
                    $this->db->query("SET NAMES 'utf8'");

                    if ($sth->execute()) {
                        $this->last = $this->db->lastInsertId();
                        unset($_SESSION['var']);
                        $_SESSION['var'] = 'Sayfa başarıyla eklendi!';
                        $this->VeriKont = true;
                    } else {
                        unset($_SESSION['var']);
                        $_SESSION['var'] = 'Sayfa ekelemde hata!';
                        $this->VeriKont = false;
                    }
                    return $this->VeriKont;
                }
            }
        }

        public function sayfaDuzenle($id, $mid, $level, $slug="", $page, $summary="", $content, $image="", $gallery="", $title="", $metadesc="", $metatags="", $date="") {
            if ($page == "" || $content == "") {
                $_SESSION['var'] = 'Lütfen sayfa adı ve içeriğini giriniz!';
                $this->VeriKont = false;
            } else {
                $date = date("Y-m-d", time());
                $sql = "UPDATE pages SET
		            	mid = :mid,
						level = :level,
						slug = :slug,
		            	page = :page,
		            	summary = :summary,
		            	content = :content,
		            	image = :image,
                        gallery = :gallery,
		            	title = :title,
		            	metadesc = :metadesc,
		            	metatags = :metatags,
                                date = :date
	            		WHERE id = :id";
                $sth = $this->db->prepare($sql);
                $sth->bindValue(':id', $id);
                $sth->bindValue(':mid', $mid);
				$sth->bindValue(':level', $level);
				$sth->bindValue(':slug', $slug);
                $sth->bindValue(':page', $page);
                $sth->bindValue(':summary', $summary);
                $sth->bindValue(':content', $content);
                $sth->bindValue(':image', $image);
                $sth->bindValue(':gallery', $gallery);
                $sth->bindValue(':title', $title);
                $sth->bindValue(':metadesc', $metadesc);
                $sth->bindValue(':metatags', $metatags);
                $sth->bindValue(':date', $date);
                $this->db->query("SET NAMES 'utf8'");
                if ($sth->execute()) {
                    unset($_SESSION['var']);
                    $_SESSION['var'] = 'Sayfa başarıyla düzenlendi!';
                    $this->VeriKont = true;
                } else {
                    unset($_SESSION['var']);
                    $_SESSION['var'] = 'Sayfa düzenlenirken hata oluştu!';
                    $this->VeriKont = false;
                }
                return $this->VeriKont;
            }
        }

    }

    $Veri = new Sayfa;
    //$Veri->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if ((isset($_GET['duzelt'])) && ($_GET['duzelt'] != "")) {
        if ($content == "" || $page == "") {
            unset($_SESSION['var']);
            $_SESSION['var'] = 'Sayfa başlığı ve içerik alanları zorunludur!';
            header("Location: page-add.php?duzelt=$id&hata=1");
        } else {
            $date = date("Y-m-d", time());
            $Veri->sayfaDuzenle($id, $mid, $level, $slug, $page, $summary, $content, $image, $gallery, $title, $metadesc, $metatags, $date);
            if ($Veri->VeriKont) {
                header("Location: page-add.php?duzelt=$id&islem=1");
            }
        }
    } else {
        if ($content == "" || $page == "") {
            unset($_SESSION['var']);
            $_SESSION['var'] = 'Sayfa başlığı ve içerik alanları zorunludur!';
            header("Location: page-add.php?hata=1");
        } else {
            //sayfaEkle($mid="", $page, $summary="", $content, $image="", $gallery="", $title="", $metadesc="", $metatags="", $date="")
            $Veri->sayfaEkle($mid, $level, $slug, $page, $summary, $content, $image, $gallery, $title, $metadesc, $metatags, $date);
            header("Location: pages.php");
        }
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=7" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Sayfa Ekle | Herkobi CMS Yönetim Paneli</title>
        <meta name="description" content="." />
        <meta name="keywords" content="." />
        <meta http-equiv="pragma" content="no-cache">
            <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
            <style type="text/css" media="all">	
                @import url("css/style.css");
            </style>

            <?php
            if (isset($_POST['page']) && (isset($_POST['content']))) {
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
            if (isset($_SESSION['var'])) {
                $HataSebep = $_SESSION['var'];
                unset($_SESSION['var']);
                echo "<style type=\"text/css\" media=\"all\">#error {display: block;}</style>";
                echo "<style type=\"text/css\" media=\"all\">#warning {display: block;}</style>";
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
                                <li><a href="#"><strong><img src="images/nav/pages.png" alt="" /> Sayfalar</strong></a>
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
                                <a href="admin.php">Başlangıç</a> &raquo; <a href="pages.php">Sayfalar</a> &raquo; <a href="page-add.php">Sayfa Ekle</a>
                            </div>		
                            <!-- .breadcrumb ends -->
                            <div id="success"><div class="message success"><p><?php echo @$HataSebep; ?></p></div></div>
                            <div id="error"><div class="message errormsg"><p>İşlem gerçekleşmedi. Bir hata oluştu.</p></div></div>
                            <div id="warning"><div class="message warning"><p><?php echo @$HataSebep; ?></p></div></div>

                            <h2>Sayfa Ekle</h2>

                            <form id="bilgi" action="" method="post">
                                <div class="textbox left">
                                    <h2>Sayfa İçeriği</h2>

                                    <div class="textbox_content">
                                        <p><label>Sayfa Adı:</label><br /><input type="text" value="<?php echo @$DuzenleSonuc[0]['page']; ?>" size="100" class="text" name="page" id="page" /></p>        
                                        <p><label>Sayfa Özeti:</label><br /><textarea rows="4" cols="103" name="summary" id="summary"><?php echo @$DuzenleSonuc[0]['summary']; ?></textarea></p>
                                        <p><label>Sayfa İçeriği: (Zorunlu alan)</label><br /><textarea id="text" name="content"><?php echo @$DuzenleSonuc[0]['content']; ?></textarea></p>
                                        <script type="text/javascript">
                                            CKEDITOR.replace('text',
                                            {
                                                width : 650+'px',
                                                height : 280+'px',
                                                uiColor : '#9AB8F3',
                                                name : 'text2',
                                                filebrowserBrowseUrl : '<?php echo $PANEL_ADRESI; ?>/elfinder.php'
                                            });
                                        </script>
                                    </div>
                                </div>         

                                <div class="textbox right">
                                    <h2>Kaydet</h2>
                                    <div id="hata"></div>
                                    <div class="textbox_content">
                                        <p>
                                            <input type="submit" class="submit" value="YAYINLA" />
                                            <input type="reset" class="submit disabled" value="İptal" />            
                                        </p>
                                    </div>       
                                </div>
                                <div class="textbox right">
                                    <h2>Sayfa Bilgileri</h2>

                                    <div class="textbox_content">
                                        <p>
                                            <label>Üst Sayfa:</label>
                                            <select name="mid" class="styled">
                                                <option selected="selected" value="Yok">Üst sayfa seçin</option>
                                                <?php
                                                $sql = "SELECT `id`,`page` FROM pages ORDER BY `page` ASC";
                                                $sth = $db->prepare($sql);
                                                $db->query("SET NAMES 'utf8'");
                                                $sth->execute();
                                                $sonuc = $sth->fetchAll();
                                                $say = count($sonuc);
                                                for ($i = 0; $i < $say; $i++) {
                                                    if (@$sonuc[$i]['id'] == @$DuzenleSonuc[0]['mid']) {
                                                        echo '<option selected value="' . @$sonuc[$i]['id'] . '">' . @$sonuc[$i]['page'] . '</option>' . "\n";
                                                    } else {
                                                        echo '<option value="' . @$sonuc[$i]['id'] . '">' . @$sonuc[$i]['page'] . '</option>' . "\n";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </p>        
                                        <p class="fileupload"><label>Resim Seçiniz:</label>
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
                                        <p><label>Sayfa Başlığı:</label><br /><input type="text" value="<?php echo @$DuzenleSonuc[0]['title']; ?>" size="100" class="text" name="title" /></p>        
                                        <p><label>Sayfa İçerik Özeti: <small>En fazla 160 karakter giriniz</small></label><br /><textarea rows="4" cols="103" id="metadesc" name="metadesc"><?php echo @$DuzenleSonuc[0]['metadesc']; ?></textarea></p>
                                        <p><label>Anahtar Kelimeler: <small>Virgülle ayırarak birden çok anahtar kelime girebilirsiniz</small></label><br /><input type="text" value="<?php echo @$DuzenleSonuc[0]['metatags']; ?>" size="100" class="text" name="metatags"/></p>
                                    </div>
                                </div>      
                            </form>
                        </div>
                    </body>
                    </html>
<?php
if (isset($_GET['hata'])) {
    ?>
<script type="text/javascript">alert('Sayfa başlığı ve içerik alanları zorunludur!');</script>
<?php
}
?>
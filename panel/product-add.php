<?php
require_once'../config.php';
if ((!isset($_SESSION['logged'])) || (@$_SESSION['logged'] != 'yes')) {
    header("Location: index.php");
    die;
}
require_once 'inc/functions.php';
require_once 'inc/seo.php';
require_once 'inc/sayfalama.php';

if (isset($_GET['duzelt'])) {
    $id = $_GET['duzelt'];

    if (!is_numeric($id)) {
        $id = 1;
    }
    $DuzenleSonuc = duzelt("*", 'products', $id);

    $bol = explode(',', $DuzenleSonuc[0]['category']);
    $bolSay = count($bol) - 1;


    for ($k = 0; $k < $bolSay; $k++) {
        $katNo[] = str_replace('-', '', $bol[$k]);
    }

    $katNoSay = count($katNo);
}
$categoryTut = '';
if (isset($_POST['product']) && (isset($_POST['content']))) {
    $level = 0;
	$product = @$_POST['product'];
	$slug = slug($product);
    $code = @$_POST['code'];
    if (!isset($_POST['category'])) {
        $category = '-1-,';
    } else {
        $category = @$_POST['category'];
    }
    $content = @$_POST['content'];
    $brand = @$_POST['brand'];
    $price = @$_POST['price'];
    $currency = @$_POST['currency'];
    $image = @$_POST['image'];
	$image = str_replace($SITE_ADRESI."/","",$image);
    $image1 = @$_POST['image1'];
	$image1 = str_replace($SITE_ADRESI."/","",$image1);
    $image2 = @$_POST['image2'];
	$image2 = str_replace($SITE_ADRESI."/","",$image2);
    $image3 = @$_POST['image3'];
	$image3 = str_replace($SITE_ADRESI."/","",$image3);
    $image4 = @$_POST['image4'];
	$image4 = str_replace($SITE_ADRESI."/","",$image4);
    $title = @$_POST['title'];
    $metadesc = @$_POST['metadesc'];
    $metatags = @$_POST['metatags'];
    $publish = @$_POST['k']; //Eklenen ürün taslak mı kontrolü            

    if (isset($_POST['category'])) {
        foreach ($category as $NewKat_id) {
            @$categoryTut .= '-' . $NewKat_id . '-,';
        }

        $category = $categoryTut;
    }

    if (!isset($category) || ($category == "")) {
        $category = '-1-,';
    }

    if ($title == "") {
        $title = $product;
    }

    if ($metadesc == "") {
        $content = trim(strip_tags($content));
        $metadesc = trim(mb_substr($content, 0, 160, 'UTF-8'));
    }

    class Urun {

        public $VeriKont;

        public function __construct() {
            global $db;
            $this->db = $db;
        }

        public function urunEkle($publish, $level, $slug="", $product, $category="", $brand="", $content="", $code="", $price="", $currency="", $image="", $image1="", $image2="", $image3="", $image4="", $title="", $metadesc="", $metatags="") {
            if ($product == "" || $content == "") {
                $_SESSION['var'] = "Lütfen ürün adını ve içeriğini giriniz!";
                $this->VeriKont = false;
            } else if (isset($product)) {
                $sql = "SELECT category FROM products WHERE product = :product AND category = :category";
                $sth = $this->db->prepare($sql);
                $sth->bindValue(':product', $product);
                $sth->bindValue(':category', $category);
                $sth->execute();
                $sonuc = $sth->fetchAll();
                $say = $sth->rowCount();
                if ($say >= 1) {
                    $_SESSION['var'] = "Daha önce " . $product . " adında bir ürün eklemişsiniz.";
                    $this->VeriKont = false;
                } else {
                    $sql = "INSERT INTO products (
                              publish,
                              level,
							  slug,
							  product,
                              category,
                              brand,
                              content,
                              code,
                              price,
                              currency,
                              image,
                              image1,
                              image2,
                              image3,
                              image4,
                              title,
                              metadesc,
                              metatags)
                            VALUES (
                              :publish,
                              :level,
							  :slug,
							  :product,
                              :category,
                              :brand,
                              :content,
                              :code,
                              :price,
                              :currency,
                              :image,
                              :image1,
                              :image2,
                              :image3,
                              :image4,
                              :title,
                              :metadesc,
                              :metatags)";
                    $sth = $this->db->prepare($sql);
                    $sth->bindValue(':publish', $publish);
                    $sth->bindValue(':level', $level);
					$sth->bindValue(':slug', $slug);
					$sth->bindValue(':product', $product);
                    $sth->bindValue(':category', $category);
                    $sth->bindValue(':brand', $brand);
                    $sth->bindValue(':content', $content);
                    $sth->bindValue(':code', $code);
                    $sth->bindValue(':price', $price);
                    $sth->bindValue(':currency', $currency);
                    $sth->bindValue(':image', $image);
                    $sth->bindValue(':image1', $image1);
                    $sth->bindValue(':image2', $image2);
                    $sth->bindValue(':image3', $image3);
                    $sth->bindValue(':image4', $image4);
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

        public function urunDuzenle($id, $publish, $level, $slug, $product, $category="", $brand="", $content="", $code="", $price="", $currency="", $image="", $image1="", $image2="", $image3="", $image4="", $title="", $metadesc="", $metatags="") {
            if ($product == "" || $content == "") {
                $_SESSION['var'] = "Lütfen ürün adını ve içeriğini giriniz!";
                $this->VeriKont = false;
            } else if (isset($product)) {
                $sql = "SELECT id FROM products WHERE product = :product AND category = :category AND id != :id";
                $sth = $this->db->prepare($sql);
                $sth->bindValue(':product', $product);
                $sth->bindValue(':category', $category);
                $sth->bindValue(':id', $id);
                $sth->execute();
                $sonuc = $sth->fetchAll();
                $say = $sth->rowCount();
                if ($say >= 1) {
                    $_SESSION['var'] = "Daha önce " . $product . " adında bir ürün eklemişsiniz.";
                    $this->VeriKont = false;
                } else {
                    $sql = "UPDATE products SET
                          publish = :publish,
						  level = :level,
						  slug = :slug,
                          product = :product,
                          category = :category,
                          brand = :brand,
                          content = :content,
                          code = :code,
                          price = :price,
                          currency = :currency,
                          image = :image,
                          image1 = :image1,
                          image2 = :image2,
                          image3 = :image3,
                          image4 = :image4,
                          title = :title,
                          metadesc = :metadesc,
                          metatags = :metatags                
                        WHERE id = :id";
                    $sth = $this->db->prepare($sql);
                    $sth->bindValue(':id', $id);
                    $sth->bindValue(':publish', $publish);
					$sth->bindValue(':level', $level);
					$sth->bindValue(':slug', $slug);
                    $sth->bindValue(':product', $product);
                    $sth->bindValue(':category', $category);
                    $sth->bindValue(':brand', $brand);
                    $sth->bindValue(':content', $content);
                    $sth->bindValue(':code', $code);
                    $sth->bindValue(':price', $price);
                    $sth->bindValue(':currency', $currency);
                    $sth->bindValue(':image', $image);
                    $sth->bindValue(':image1', $image1);
                    $sth->bindValue(':image2', $image2);
                    $sth->bindValue(':image3', $image3);
                    $sth->bindValue(':image4', $image4);
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
                        echo mysql_error();
                    }
                    return $this->VeriKont;
                }
            }
        }

    }

    $Veri = new Urun;

    if ((isset($_GET['duzelt'])) && ($_GET['duzelt'] != "")) {
        if ($content == "" || $product == "") {
            unset($_SESSION['var']);
            $_SESSION['var'] = 'Yazı başlığı ve içerik alanları zorunludur!';
            header("Location: product-add.php?duzelt=$id&hata=1");
        } else {
            $Veri->urunDuzenle($id, $publish, $level, $slug, $product, $category, $brand, $content, $code, $price, $currency, $image, $image1, $image2, $image3, $image4, $title, $metadesc, $metatags);
            header("Location: products.php");
        }
    } else {
        if ($content == "" || $product == "") {
            unset($_SESSION['var']);
            $_SESSION['var'] = 'Yazı başlığı ve içerik alanları zorunludur!';
            header("Location: product-add.php?hata=1");
        } else {
            $Veri->urunEkle($publish, $level, $slug, $product, $category, $brand, $content, $code, $price, $currency, $image, $image1, $image2, $image3, $image4, $title, $metadesc, $metatags);
            header("Location: products.php");
        }
    }
}
$sql = "
	SELECT DISTINCT id, brand
	FROM  brands
	";

$sth = $db->prepare($sql);

$db->query("SET NAMES 'utf8'");
$sth->execute();
$TumMarkalar = $sth->fetchAll();
$TumMarkalarSay = count($TumMarkalar);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=7" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Ürün Ekle | Herkobi CMS Yönetim Paneli</title>
        <meta name="description" content="." />
        <meta name="keywords" content="." />
        <style type="text/css" media="all">
            @import url("css/style.css");
        </style>

        <?php
        if ((isset($_POST['product'])) && (isset($_POST['content']))) {
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
        <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
        <script type="text/javascript" src="js/custom.js"></script>
        <script type="text/javascript" src="js/jquery-ui.min.js"></script>
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
                            editorCallback : function(url) {field.value=url;},    // Must change the form field id
                            closeOnEditorCallback : true,
                            docked : false,
                            dialog : { title : 'Dosya Yöneticisi', height: 500 },
                        }

                        $('#open').click(function() {                        // Must change the button's id
                            $('#finder_browse').elfinder(opt)                // Must update the form field id
                            $('#finder_browse').elfinder($(this).attr('id'));   // Must update the form field id
                        })
                    });
                    $(document).ready(function(){
                        $('.taslak').click(function(){
                            $('#k').val("Taslak");
                        });
                    })
                </script>  
                <script type="text/javascript" charset="utf-8">
                    $().ready(function() {
                        var opt = {      // Must change variable name
                            url : 'elfinder/connectors/php/connector.php',
                            lang : 'tr',
                            editorCallback : function(url) {field1.value=url;},    // Must change the form field id
                            closeOnEditorCallback : true,
                            docked : false,
                            dialog : { title : 'Dosya Yöneticisi', height: 500 },
                        }
                        $('#open1').click(function() {                        // Must change the button's id
                            $('#finder_browse1').elfinder(opt)                // Must update the form field id
                            $('#finder_browse1').elfinder($(this).attr('id'));   // Must update the form field id
                        })
                    });
                </script>  
                <script type="text/javascript" charset="utf-8">
                    $().ready(function() {
                        var opt = {      // Must change variable name
                            url : 'elfinder/connectors/php/connector.php',
                            lang : 'tr',
                            editorCallback : function(url) {field2.value=url;},    // Must change the form field id
                            closeOnEditorCallback : true,
                            docked : false,
                            dialog : { title : 'Dosya Yöneticisi', height: 500 },
                        }
                        $('#open2').click(function() {                        // Must change the button's id
                            $('#finder_browse2').elfinder(opt)                // Must update the form field id
                            $('#finder_browse2').elfinder($(this).attr('id'));   // Must update the form field id
                        })
                    });
                </script>  
                <script type="text/javascript" charset="utf-8">
                    $().ready(function() {
                        var opt = {      // Must change variable name
                            url : 'elfinder/connectors/php/connector.php',
                            lang : 'tr',
                            editorCallback : function(url) {field3.value=url;},    // Must change the form field id
                            closeOnEditorCallback : true,
                            docked : false,
                            dialog : { title : 'Dosya Yöneticisi', height: 500 },
                        }
                        $('#open3').click(function() {                        // Must change the button's id
                            $('#finder_browse3').elfinder(opt)                // Must update the form field id
                            $('#finder_browse3').elfinder($(this).attr('id'));   // Must update the form field id
                        })
                    });
                </script>  
                <script type="text/javascript" charset="utf-8">
                    $().ready(function() {
                        var opt = {      // Must change variable name
                            url : 'elfinder/connectors/php/connector.php',
                            lang : 'tr',
                            editorCallback : function(url) {field4.value=url;},    // Must change the form field id
                            closeOnEditorCallback : true,
                            docked : false,
                            dialog : { title : 'Dosya Yöneticisi', height: 500 },
                        }
                        $('#open4').click(function() {                        // Must change the button's id
                            $('#finder_browse4').elfinder(opt)                // Must update the form field id
                            $('#finder_browse4').elfinder($(this).attr('id'));   // Must update the form field id
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
                            <a href="admin.php">Başlangıç</a> &raquo; <a href="products.php">Ürünler</a> &raquo; <a href="product-add.php">Ürün Ekle</a>
                        </div>		<!-- .breadcrumb ends -->

                        <div id="success"><div class="message success"><p>Ürün başarıyla kayıt edildi.</p></div></div>
                        <div id="error"><div class="message errormsg"><p>İşlem gerçekleşmedi. Bir hata oluştu.</p></div></div>
                        <div id="warning"><div class="message warning"><p><?php echo @$HataSebep; ?></p></div></div>

                        <h2>Ürün Ekle</h2>

                        <form id="bilgi" action="" method="post">
                            <div class="textbox left">
                                <h2>Ürün İçeriği</h2>

                                <div class="textbox_content">
                                    <p><label>Ürün Adı:</label><br /><input type="text" name="product" size="100" class="text" value="<?php echo @$DuzenleSonuc[0]['product']; ?>" /></p>
                                    <table cellpadding="0" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Ürün Kodu</th>
                                                <th>Fiyatı</th>
                                                <th>Para Birimi</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td><input type="text" name="code" size="17" class="text" value="<?php echo @$DuzenleSonuc[0]['code']; ?>" /></td>
                                                <td><input type="text" name="price" size="7" class="text" value="<?php echo @$DuzenleSonuc[0]['price']; ?>" /></td>
                                                <td>
                                                    <p>
                                                        <select name="currency">
                                                            <option value="TL">Türk Lirası (TL)</option>
                                                            <option value="&#36;">Dolar (&#36;)</option>
                                                            <option value="&euro;">Euro (&euro;)</option>
                                                        </select>
                                                    </p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <p><label>Ürün İçeriği:</label><br /><textarea id="text" name="content"><?php echo @$DuzenleSonuc[0]['content']; ?></textarea></p>
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

                                <div class="textbox_content">
                                    <p>
                                        <input type="hidden" name="k" id="k" value="Yayınlandı" />
                                        <input type="submit" class="submit taslak" value="Taslak Olarak Kaydet" />
                                        <input type="submit" class="submit disabled" disabled="disabled" value="İptal" />
                                        <input type="submit" class="submit" value="YAYINLA" />          
                                    </p>
                                </div>      
                            </div>      
                            <div class="textbox right">
                                <h2>Ürün Bilgileri</h2>

                                <div class="textbox_content">
                                    <h4>Kategoriler</h4>
                                    <hr />
                                    <table cellpadding="0" cellspacing="0" width="100%" class="sortable">
                                        <thead>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $katlar = '';
                                            echo '<div style="height: 10em; width: 21em; overflow: auto;">';

                                            function sonuc($id, $onek= 1) {
                                                global $db, $katNo, $katNoSay, $katlar, $DuzenleSonuc;

                                                $sql = "SELECT id, mid, category FROM productcategories WHERE mid = :id";
                                                $sth = $db->prepare($sql);
                                                $sth->bindValue(':id', $id);
                                                $sth->execute();

                                                foreach ($sth->fetchAll() as $aa) {
                                                    if (!empty($aa)) {
                                                        echo str_repeat('&nbsp;', $onek);
                                                        $gelenID = $aa['id'];
                                                        $gelenKatAdi = $aa['category'];
                                                        $checked = '';
                                                        for ($j = 0; $j < $katNoSay; $j++) {
                                                            if ($katNo[$j] == $gelenID) {
                                                                $checked = 'checked = "checked"';
                                                            }
                                                        }
                                                        $katlar .='<input ' . $checked . ' type="checkbox" id="' . $gelenKatAdi . '" name="category[]" value="' . $gelenID . '" /> ';

                                                        $checked = '';
                                                        $katlar .='<label for="' . $gelenKatAdi . '">' . $gelenKatAdi . '</label>' . "\n<br />";
                                                        echo $katlar . "\n";
                                                        $katlar = ''; //Kategoriler listelendikten sonra degisken bosaltildi.
                                                        sonuc($aa['id'], ($onek + 1));
                                                    }
                                                }
                                            }

                                            sonuc(0);
                                            echo '</div>';
                                            ?>
                                        </tbody>
                                    </table>
                                    <hr />
                                    <h4>Markalar</h4>
                                    <hr />
                                    <p>
                                        <select name="brand">
                                            <option value="yok">Lütfen marka seçiniz.</option>
                                            <?php
                                            //print_r($DuzenleSonuc);
                                            if ((isset($_GET['duzelt'])) && ($_GET['duzelt'] != "")) {//Eger duzeltme islemi yapiliyorsa, veritabanındaki secili markayı göstermek icin yapildi
                                                for ($i = 0; $i < $TumMarkalarSay; $i++) {
                                                    if (@$TumMarkalar[$i]["id"] == @$DuzenleSonuc[0]['brand']) {
                                                        echo '<option selected="selected" value="' . @$TumMarkalar[$i]["id"] . '">' . @$TumMarkalar[$i]["brand"] . '</option>' . "\n";
                                                    } else {
                                                        echo '<option value="' . @$TumMarkalar[$i]["id"] . '">' . @$TumMarkalar[$i]["brand"] . '</option>' . "\n";
                                                    }
                                                }
                                            } else {
                                                for ($i = 0; $i < $TumMarkalarSay; $i++) {
                                                    echo '<option value="' . @$TumMarkalar[$i]["id"] . '">' . @$TumMarkalar[$i]["brand"] . '</option>' . "\n";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </p>          
                                </div>
                            </div>      
                            <div class="textbox left">
                                <h2>Ürün Resimleri</h2>

                                <div class="textbox_content">        
                                    <p class="fileupload">
                                        <label>Ürün Ana Resmi:</label>
                                        <div id="finder_browse"></div>
                                        <input type="text" id="field" name="image" value="<?php echo @$DuzenleSonuc[0]['image']; ?>" />
                                        <input type="button" name="open" id="open" class="file" value="Resim Seç" />  
                                        <?php if ($DuzenleSonuc[0]['image']) { ?>
                                            <br />
                                            <img src="<?php echo $SITE_ADRESI; ?>/<?php echo @$DuzenleSonuc[0]['image']; ?>" name="birinci" />
                                        <?php } ?>
                                    </p>
                                    <hr />
                                    <p class="fileupload">
                                        <label>Ürün Resmi:</label>
                                        <div id="finder_browse1"></div>
                                        <input type="text" id="field1" name="image1" value="<?php echo @$DuzenleSonuc[0]['image1']; ?>" />
                                        <input type="button" name="open1" id="open1" class="file" value="Resim Seç" />
                                        <?php if ($DuzenleSonuc[0]['image1']) { ?>
                                            <br />
                                            <img src="<?php echo $SITE_ADRESI; ?>/<?php echo @$DuzenleSonuc[0]['image1']; ?>" name="ikinci" />
                                        <?php } ?>
                                    </p>
                                    <p class="fileupload">
                                        <label>Ürün Resmi:</label>
                                        <div id="finder_browse2"></div>
                                        <input type="text" id="field2" name="image2" value="<?php echo @$DuzenleSonuc[0]['image2']; ?>" />
                                        <input type="button" id="open2" class="file" value="Resim Seç" />
                                        <?php if ($DuzenleSonuc[0]['image2']) { ?>
                                            <br />
                                            <img src="<?php echo $SITE_ADRESI; ?>/<?php echo @$DuzenleSonuc[0]['image2']; ?>" name="ucuncu" />
                                        <?php } ?>
                                    </p>
                                    <p class="fileupload">
                                        <label>Ürün Resmi:</label>
                                        <div id="finder_browse3"></div>
                                        <input type="text" id="field3" name="image3" value="<?php echo @$DuzenleSonuc[0]['image3']; ?>" />
                                        <input type="button" id="open3" class="file" value="Resim Seç" />
                                        <?php if ($DuzenleSonuc[0]['image3']) { ?>
                                            <br />
                                            <img src="<?php echo $SITE_ADRESI; ?>/<?php echo @$DuzenleSonuc[0]['image3']; ?>" name="dorduncu" />
                                        <?php } ?>
                                    </p>
                                    <p class="fileupload">
                                        <label>Ürün Resmi:</label>
                                        <div id="finder_browse4"></div>
                                        <input type="text" id="field4" name="image4" value="<?php echo @$DuzenleSonuc[0]['image4']; ?>" />
                                        <input type="button" id="open4" class="file" value="Resim Seç" />
                                        <?php if ($DuzenleSonuc[0]['image4']) { ?>
                                            <br />
                                            <img src="<?php echo $SITE_ADRESI; ?>/<?php echo @$DuzenleSonuc[0]['image4']; ?>" name="besinci" />
                                        <?php } ?>

                                    </p>                                    
                                </div>
                            </div>      
                            <div class="textbox left">
                                <h2>Arama Motoru Bilgileri</h2>
                                <div class="textbox_content">
                                    <p><label>Ürün Başlığı:</label><br /><input type="text" name="title" size="100" class="text" value="<?php echo @$DuzenleSonuc[0]['title']; ?>" /></p>        
                                    <p><label>Ürün İçerik Özeti: <small>En fazla 160 karakter giriniz</small></label><br /><textarea rows="4" id="metadesc" name="metadesc" cols="103"><?php echo @$DuzenleSonuc[0]['metadesc']; ?></textarea></p>
                                    <p><label>Anahtar Kelimeler: <small>Virgülle ayırarak birden çok anahtar kelime girebilirsiniz</small></label><br /><input type="text" name="metatags" size="100" class="text" value="<?php echo @$DuzenleSonuc[0]['metatags']; ?>" /></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </body>
                </html>
                <?php
                if (isset($_GET['hata'])) {
                    ?>
                    <script type="text/javascript">alert('Ürün başlığı ve içerik alanları zorunludur!');</script>
                    <?php
                }
                ?>
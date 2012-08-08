<?php
include_once '../config.php';
if ((!isset($_SESSION['logged'])) || (@$_SESSION['logged'] != 'yes')) {
    header("Location: index.php");
    die;
}

include_once 'inc/sayfalama.php';
if (isset($_GET['sil'])) {
    $id = $_GET['sil'];
}

class Haber {

    public $VeriKont;

    public function __construct() {
        global $db;
        $this->db = $db;
    }

    public function HaberSil($id) {
        $url = "posts.php?id=" . $id;
        $sql = "DELETE FROM posts WHERE id = :id";
        $sth = $this->db->prepare($sql);
        $this->db->query("SET NAMES 'utf8'");
        $sth->bindValue(':id', $id);
        $sth->execute();
    }

}

$Sil = new Haber;

if (isset($_POST['toplusil']) && (isset($_POST['tut']))) {
    foreach ($_POST['tut'] as $id) {
        if (is_numeric($id)) {
            $Sil->HaberSil($id);
        }
    }
    header("Location: posts.php");
}
if (isset($_GET['sil']) && is_numeric($_GET['sil'])) {
    $Sil->HaberSil($id);
    header("Location: posts.php");
}
$TumYazilar = SayfaIcerik('posts');
$TumYazilarSay = count($TumYazilar);

$sayfaSayisi = sayfalama('posts');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=7" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Yazılar | Herkobi CMS Yönetim Paneli</title>
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
                <a href="admin.php">Başlangıç</a> &raquo; <a href="posts.php">Yazılar</a>
            </div>		<!-- .breadcrumb ends -->

            <h2>Yazılar</h2>

            <form action="" method="post">					
                <table cellpadding="0" cellspacing="0" width="100%" class="sortable">
                    <thead>
                        <tr>
                            <th width="10"><input type="checkbox" class="check_all" /></th>
                            <th>Yazı Başlığı</th>
                            <th>Kategori</th>
                            <th>Kayıt Tarihi</th>
                            <th>Düzenle</th>
                            <th>Sil</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        for ($i = 0; $i < $TumYazilarSay; $i++) {
                            echo '
						<tr>
						<td><input type="checkbox" name="tut[]" value="' . $TumYazilar[$i]["id"] . '" /></td>
						<td><strong><a href="post-add.php?duzelt=' . $TumYazilar[$i]["id"] . '">' . $TumYazilar[$i]["post"] . '</a></strong></td>
						<td>' . $TumYazilar[$i]["category"] . '</td>
						<td>' . $TumYazilar[$i]["date"] . '</td>
						<td><a href="post-add.php?duzelt=' . $TumYazilar[$i]["id"] . '">Düzenle</a></td>
						<td class="delete"><a href="?sil=' . $TumYazilar[$i]["id"] . '" onclick="return confirm(\'İçerik silme işlemini \n Onaylıyor musunuz?\')"><img src="images/close.png" alt="Delete" title="Delete" /></a></td>
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
                    <input type="submit" class="submit tiny" value="İşlemi Gerçekleştir" onclick="return confirm('Seçilen içerikler silinecektir.\n Onaylıyor musunuz?')"/>
                </div>		<!-- .tableactions ends -->
                <div class="table_pagination right">
                    <?php oklar(); ?>
                </div>		<!-- .pagination ends -->
            </form>    	
        </div>
    </body>
</html>

<?php
include_once '../config.php';
if ((!isset($_SESSION['logged'])) || (@$_SESSION['logged'] != 'yes')) {
    header("Location: index.php");
    die;
}

include_once 'inc/sayfalama.php';

if (isset($_GET['sil']) && is_numeric($_GET['sil'])) {
    $id = $_GET['sil'];
}

class Sayfa {

    public $VeriKont;

    public function __construct() {
        global $db;
        $this->db = $db;
    }

    public function SayfaSil($id) {
        $url = "pages.php?id=" . $id;
        $sql = "DELETE FROM pages WHERE id = :id";
        $sth = $this->db->prepare($sql);
        $sth->bindValue(':id', $id);
        $sth->execute();
    }

}

$Sil = new Sayfa;
if (isset($_GET['sil']) && is_numeric($_GET['sil'])) {
    $Sil->SayfaSil($id);
    header("Location: pages.php");
} else {
    if (isset($_POST['toplusil'])) {
        foreach ($_POST['tut'] as $id) {
            if (is_numeric($id)) {
                $Sil->SayfaSil($id);
            }
        }
        header("Location: pages.php");
    }
}
$TumSayfalar = SayfaIcerik('pages');
$TumSayfalarSay = count($TumSayfalar);

$sayfaSayisi = sayfalama('pages');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=7" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Sayfalar | Herkobi CMS Yönetim Paneli</title>
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
                        <li><a href="markalar.php">Markalar</a></li>
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
                <a href="admin.php">Başlangıç</a> &raquo; <a href="pages.php">Sayfalar</a>
            </div>		<!-- .breadcrumb ends -->

            <h2>Sayfalar</h2>
            <form action="" method="post">					
                <table cellpadding="0" cellspacing="0" width="100%" class="sortable">
                    <thead>
                        <tr>
                            <th width="10"><input type="checkbox" class="check_all" /></th>
                            <th>Sayfa Adı</th>
                            <th>Üst Sayfa</th>
                            <th>Kayıt Tarihi</th>
                            <th>Düzenle</th>
                            <th>Sil</th>
                        </tr>
                    </thead>				
                    <tbody>
                        <?php
                        $mid = 'Yok';
                        for ($i = 0; $i < $TumSayfalarSay; $i++) {
                            if ($TumSayfalar[$i]["page"] != "") {
                                $mid = $TumSayfalar[$i]["page"];
                            }
                            echo '
							<tr>
								<td><input type="checkbox" name="tut[]" value="' . $TumSayfalar[$i]["0"] . '" " /></td>
								<td><strong><a href="page-add.php?duzelt=' . $TumSayfalar[$i]["0"] . '">' . $TumSayfalar[$i]["2"] . '</a></strong></td>
								<td>' . $mid . '</td>
								<td>' . $TumSayfalar[$i]["3"] . '</td>
								<td><a href="page-add.php?duzelt=' . $TumSayfalar[$i]["0"] . '">Düzenle</a></td>
								<td class="delete"><a href="pages.php?sil=' . $TumSayfalar[$i]["0"] . '" onclick="return confirm(\'Sime işlemi. \n Onaylıyor musunuz?\')"><img src="images/close.png" alt="Delete" title="Delete" /></a></td>
							</tr>
							  ';
                            if ($mid != 'Yok') {
                                $mid = 'Yok';
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <div class="tableactions">
                    <select name="toplusil">
                        <option value="sil">Sil</option>
                    </select>
                    <input type="submit" class="submit tiny" value="İşlemi Gerçekleştir" />
                </div>		<!-- .tableactions ends -->
                <div class="table_pagination right">
                    <?php oklar(); ?>
                </div>		<!-- .pagination ends -->
            </form>    	
        </div>
    </body>
</html>

<?php
include_once '../config.php';
if ((!isset($_SESSION['logged'])) || (@$_SESSION['logged'] != 'yes')) {
    header("Location: index.php");
    die;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=7" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Herkobi CMS Yönetim Paneli</title>
        <meta name="description" content="." />
        <meta name="keywords" content="." />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/custom.js"></script>
        <script type="text/javascript" src="js/jquery.tweet.js"></script>
        <style type="text/css" media="all">
            @import url("css/style.css");
            @import url("css/jquery.tweet.css");
        </style>
        <!--[if lt IE 9]>
        <style type="text/css" media="all"> @import url("css/ie.css"); </style>
        <![endif]-->
        <script type="text/javascript">
            function randomString(length) {
                var chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz'.split('');
                var str = '';
                for (var i = 0; i < length; i++) {
                    str += chars[Math.floor(Math.random() * chars.length)];
                }
                return str;
            }
            var rnd = randomString(8);

            jQuery(function($) {
                $(".rnd").replaceWith(rnd);


                $(".tweetler .code").hide().each(function(i,e){
                    $(e).before($().
                        click(function(ev) {
                        $(e).slideToggle();
                        $(this).hide();
                        ev.preventDefault();
                    }));

                }).each(function(i, e){ eval($(e).text()); });
            });
        </script>
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
                <li><a href="admin.php"><strong><img src="images/nav/dashboard.png" alt="" /> Başlangıç</a></strong></li>
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
                <a href="admin.php">Başlangıç</a>
            </div>		<!-- .breadcrumb ends -->
            <?php
            #Sayfalar
            $sql_pages = "SELECT * FROM pages";
            $sth_pages = $db->prepare($sql_pages);
            $sth_pages->execute();
            $sonuc_pages = $sth_pages->fetchAll();
            $sayi_sayfa = count($sonuc_pages);

            #Ürünler
            $sql_products = "SELECT * FROM products";
            $sth_products = $db->prepare($sql_products);
            $sth_products->execute();
            $sonuc_urun = $sth_products->fetchAll();
            $sayi_urun = count($sonuc_urun);

            #Yazılar
            $sql_posts = "SELECT * FROM posts";
            $sth_posts = $db->prepare($sql_posts);
            $sth_posts->execute();
            $sonuc_posts = $sth_posts->fetchAll();
            $sayi_posts = count($sonuc_posts);

            #Kategoriler
            $sql_cats = "SELECT * FROM  `productcategories`";
            $sth_cats = $db->prepare($sql_cats);
            $sth_cats->execute();
            $sonuc_cats = $sth_cats->fetchAll();
            $sayi_cats = count($sonuc_cats);
            ?>
            <div class="textbox mlhalf kleft">
                <h2>Durum</h2>
                <table width="100%">
                    <tr>
                        <td><b> <?php echo $sayi_sayfa; ?> Sayfa </b></td>
                        <td><b> <?php echo $sayi_urun; ?> Ürün </b></td>
                    </tr>
                    <tr>
                        <td><b> <?php echo $sayi_posts; ?> Yazı </b></td>
                        <td><b> <?php echo $sayi_cats; ?> Kategori </b></td>
                    </tr>          
                </table>
            </div>
            <div class="textbox mhalf kright">
                <h2>Son Twittler</h2>
                <div class="tweetler">
                    <pre class="code">
      jQuery(function($){
        $(".tweet").tweet({
          join_text: "auto",
          username: "herkobicms",
          avatar_size: 32,
          count: 10,
          auto_join_text_default: "",
          auto_join_text_ed: "",
          auto_join_text_ing: "",
          auto_join_text_reply: "",
          auto_join_text_url: "",
          loading_text: "loading tweets..."
        });
      });
                    </pre>
                    <div class='tweet query'></div>
                </div>      
            </div>	
        </div>

    </body>
</html>
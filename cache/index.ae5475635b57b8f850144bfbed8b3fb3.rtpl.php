<?php if(!class_exists('raintpl')){exit;}?><!DOCTYPE html>
<html class="no-js">
    <head>
        <title><?php echo $title;?></title>
        <meta charset="UTF-8"/>
        <meta
            name="keywords"
            content="<?php echo $metatags;?>"
        />
        <meta
            name="description"
            content="<?php echo $metadesc;?>"
        />

        <!-- ie 8 ve alt versiyonları için html5 ile gelen etiketlerin çalışması için -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <link type="text/css" rel="stylesheet" href="tpl/styles/style.css" />

        <script type="text/javascript" src="tpl/scripts/modernizr-1.7.min.js"></script>
        <script type="text/javascript" src="tpl/scripts/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="tpl/scripts/jquery.nivo.slider.pack.js"></script>
        <script type="text/javascript" src="tpl/scripts/antepfistigi.js"></script>
    </head>
    <body>
        <div id="wrapper">
            <header id="masthead">
                <a href="index.php" id="logo"><img src="tpl/images/logo.png" alt="Antep Fıstığı" width="249" height="56" /></a>
            </header>		
            <nav id="main-nav">
                <ul class="group">
                    <li><a href="index.php">ANASAYFA</a></li>
                    <li><a href="products.php">ÜRÜNLER</a></li>
                    <li><a href="page.php?id=2">ANTEP FISTIĞI</a></li>
                    <li><a href="page.php?id=10">ÖZEL PAKET</a></li>
					<li><a href="posts.php">DUYURULAR</a></li>
					<li><a href="galleries.php">GALERİLER</a></li>
                    <li><a href="contact.php">İLETİŞİM</a></li>
                </ul>
            </nav>
            <section id="content">
                <div id="tagline">
                    <?php $counter1=-1; if( isset($slide) && is_array($slide) && sizeof($slide) ) foreach( $slide as $key1 => $value1 ){ $counter1++; ?>
					<a href="<?php echo $value1["url"];?>"><img src="<?php echo $value1["image"];?>" /></a>
					<?php } ?>
                </div>
                <div id="products">
                    <article class="group">
                        <h3>YENİ ÜRÜNLER</h3>
						<?php $counter1=-1; if( isset($newproducts) && is_array($newproducts) && sizeof($newproducts) ) foreach( $newproducts as $key1 => $value1 ){ $counter1++; ?>
                        <p class="product">
                            <a href="product.php?id=<?php echo $value1["id"];?>" title="<?php echo $value1["product"];?>"><?php echo $value1["product"];?></a>
							<img src="<?php echo $value1["image"];?>" alt="<?php echo $value1["product"];?>" title="<?php echo $value1["product"];?>" />
                            <span class="price"><?php echo $value1["price"];?> <?php echo $value1["currency"];?></span>
                        </p>
						<?php } ?>
                    </article>
                    <article class="group">
                        <h3>KATEGORİLER</h3>
						<?php $counter1=-1; if( isset($frontcategories) && is_array($frontcategories) && sizeof($frontcategories) ) foreach( $frontcategories as $key1 => $value1 ){ $counter1++; ?>
                        <p class="category">
                            <a href="products.php?id=<?php echo $value1["id"];?>" title="<?php echo $value1["category"];?>"><?php echo $value1["category"];?></a>
                            <img src="<?php echo $value1["image"];?>" />
                        </p>
						<?php } ?>
                    </article>					
                </div>
                <aside id="product-sidebar">
                    <section class="box">
                        <h3 class="right">TELEFON İLE SİPARİŞ</h3>
                        <img src="tpl/images/telefon.png" />
                    </section>
					<section class="box red group">
                        <h3>ÖZEL PAKET</h3>
                        <p class="product">
                            <a href="page.php?id=10" title="Özel Hazırlanmış Paket">Özel Hazırlanmış Paket</a>
                            <img src="tpl/images/fistik.jpg" />
							<span class="price">45 TL</span>
                        </p>
                    </section>
                </aside>
            </section>
            <aside id="sidebar">
                <section class="box">
                    <h3 class="left">ÜRÜN KATEGORİSİ</h3>
                    <ul class="nav">
						<?php $counter1=-1; if( isset($productcategories) && is_array($productcategories) && sizeof($productcategories) ) foreach( $productcategories as $key1 => $value1 ){ $counter1++; ?>
                        <li><a href="products.php?id=<?php echo $value1["id"];?>"><?php echo $value1["category"];?></a></li>
						<?php } ?>
                    </ul>
                </section>
                <section class="box">
                    <h3 class="left">HAKKIMIZDA</h3>
                    <ul class="nav">
                        <?php $counter1=-1; if( isset($pages) && is_array($pages) && sizeof($pages) ) foreach( $pages as $key1 => $value1 ){ $counter1++; ?>
						<li><a href="page.php?id=<?php echo $value1["id"];?>"><?php echo $value1["page"];?></a></li>
						<?php } ?>
                    </ul>
                </section>
                <section class="box">
                    <h3 class="left">ÇEŞİTLİ BAĞLANTILAR</h3>
                    <ul class="nav">
						<?php echo links(1); ?>
                    </ul>
                </section>
                <section class="box">
                    <h3 class="left">HAKKINDA</h3>
					<p><?php echo $home;?></p>
                </section>				
            </aside>
            <div id="push" class="group"></div>
        </div>
        <footer id="mastfoot" class="group">
            <p id="disclaimer"><?php echo $name;?> Copyright &copy; <?php echo date('Y'); ?></p>
            <p id="copyright"><?php echo $footer;?></p>
        </footer>
	</body>
</html>
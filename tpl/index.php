<!DOCTYPE html>
<html class="no-js">
    <head>
        <title>{$title}</title>
        <meta charset="UTF-8"/>
        <meta
            name="keywords"
            content="{$metatags}"
        />
        <meta
            name="description"
            content="{$metadesc}"
        />

        <!-- ie 8 ve alt versiyonları için html5 ile gelen etiketlerin çalışması için -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <link type="text/css" rel="stylesheet" href="styles/style.css" />

        <script type="text/javascript" src="scripts/modernizr-1.7.min.js"></script>
        <script type="text/javascript" src="scripts/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="scripts/jquery.nivo.slider.pack.js"></script>
        <script type="text/javascript" src="scripts/antepfistigi.js"></script>
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
                    {loop="slide"}
					<a href="{$value.url}"><img src="{$value.image}" /></a>
					{/loop}
                </div>
                <div id="products">
                    <article class="group">
                        <h3>YENİ ÜRÜNLER</h3>
						{loop="newproducts"}
                        <p class="product">
                            <a href="product.php?id={$value.id}" title="{$value.product}">{$value.product}</a>
							<img src="{$value.image}" alt="{$value.product}" title="{$value.product}" />
                            <span class="price">{$value.price} {$value.currency}</span>
                        </p>
						{/loop}
                    </article>
                    <article class="group">
                        <h3>KATEGORİLER</h3>
						{loop="frontcategories"}
                        <p class="category">
                            <a href="products.php?id={$value.id}" title="{$value.category}">{$value.category}</a>
                            <img src="{$value.image}" />
                        </p>
						{/loop}
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
						{loop="productcategories"}
                        <li><a href="products.php?id={$value.id}">{$value.category}</a></li>
						{/loop}
                    </ul>
                </section>
                <section class="box">
                    <h3 class="left">HAKKIMIZDA</h3>
                    <ul class="nav">
                        {loop="pages"}
						<li><a href="page.php?id={$value.id}">{$value.page}</a></li>
						{/loop}
                    </ul>
                </section>
                <section class="box">
                    <h3 class="left">ÇEŞİTLİ BAĞLANTILAR</h3>
                    <ul class="nav">
						{function="links(1)"}
                    </ul>
                </section>
                <section class="box">
                    <h3 class="left">HAKKINDA</h3>
					<p>{$home}</p>
                </section>				
            </aside>
            <div id="push" class="group"></div>
        </div>
        <footer id="mastfoot" class="group">
            <p id="disclaimer">{$name} Copyright &copy; <?php echo date('Y'); ?></p>
            <p id="copyright">{$footer}</p>
        </footer>
	</body>
</html>
<!DOCTYPE html><html class="no-js">    <head>        <title>{$title}</title>        <meta charset="UTF-8"/>        <meta            name="keywords"            content="{$metatags}"        />        <meta            name="description"            content="{$metadesc}"        />        <!-- ie 8 ve alt versiyonları için html5 ile gelen etiketlerin çalışması için -->        <!--[if lt IE 9]>            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>        <![endif]-->        <link type="text/css" rel="stylesheet" href="styles/style.css" />        <script type="text/javascript" src="scripts/modernizr-1.7.min.js"></script>        <script type="text/javascript" src="scripts/jquery-1.7.2.min.js"></script>        <script type="text/javascript" src="scripts/jquery.nivo.slider.pack.js"></script>        <script type="text/javascript" src="scripts/antepfistigi.js"></script>				<!-- İletişim Formu Eklentisi -->		<script type="text/javascript" src="scripts/mailform.js"></script>		    </head>    <body>        <div id="wrapper">            <header id="masthead">                <a href="index.php" id="logo"><img src="tpl/images/logo.png" alt="Antep Fıstığı" width="249" height="56" /></a>            </header>		            <nav id="main-nav">                <ul class="group">                    <li><a href="index.php">ANASAYFA</a></li>                    <li><a href="products.php">ÜRÜNLER</a></li>                    <li><a href="page.php?id=2">ANTEP FISTIĞI</a></li>                    <li><a href="page.php?id=10">ÖZEL PAKET</a></li>					<li><a href="posts.php">DUYURULAR</a></li>
					<li><a href="galleries.php">GALERİLER</a></li>                    <li><a href="contact.php">İLETİŞİM</a></li>                </ul>            </nav>            <section id="content">                <div id="page">
					<h3>Firma Bilgileri</h3>
					<table cellpadding="5" cellspacing="5" border="0">
						<tbody>
							<tr>
								<td>Firma Adı</td>
								<td>{$fullname}</td>
							</tr>
							<tr>
								<td>Vergi Dairesi</td>
								<td>{$taxoffice}</td>
							</tr>
							<tr>
								<td>Vergi No</td>
								<td>{$taxnumber}</td>
							</tr>							
						</tbody>
					</table>
					<h3>İletişim Bilgileri</h3>
					<table cellpadding="5" cellspacing="5" border="0">
						<tbody>
							<tr>
								<td>Adres</td>
								<td>{$address}</td>
							</tr>
							<tr>
								<td>İlçe</td>
								<td>{$county}</td>
							</tr>
							<tr>
								<td>İl</td>
								<td>{$city}</td>
							</tr>
							<tr>
								<td>Telefon</td>
								<td>{$phone}</td>
							</tr>							
						</tbody>
					</table>					<h3>İletişim Formu</h3>					<form action="form.php" method="post" id="contactform">					<table cellpadding="5" cellspacing="5" border="0">						<tbody>							<tr>								<td>İsim</td>								<td><input type="text" name="name" id="name" value="" /></td>							</tr>							<tr>								<td>E-Mail</td>								<td><input type="text" name="email" id="email" value="" /></td>							</tr>							<tr>								<td>Mesaj</td>								<td><textarea cols="40" rows="8" name="message" id="message"></textarea></td>							</tr>							<tr>								<td></td>								<td><input type="submit" value="Gönder" /></td>							</tr>						</tbody>					</table>										</form>                </div>                <aside id="product-sidebar">                    <section class="box">                        <h3 class="right">TELEFON İLE SİPARİŞ</h3>                        <img src="images/telefon.png" />                    </section>					<section class="box red group">                        <h3>ÖZEL PAKET</h3>                        <p class="product">                            <a href="page.php?id=10" title="Özel Hazırlanmış Paket">Özel Hazırlanmış Paket</a>                            <img src="tpl/images/fistik.jpg" />							<span class="price">45 TL</span>                        </p>                    </section>                </aside>            </section>            <aside id="sidebar">                <section class="box">                    <h3 class="left">ÜRÜN KATEGORİSİ</h3>                    <ul class="nav">						{loop="productcategories"}                        <li><a href="products.php?id={$value.id}">{$value.category}</a></li>						{/loop}                    </ul>                </section>                <section class="box">                    <h3 class="left">HAKKIMIZDA</h3>                    <ul class="nav">                        {loop="pages"}						<li><a href="page.php?id={$value.id}">{$value.page}</a></li>						{/loop}                    </ul>                </section>            </aside>            <div id="push" class="group"></div>        </div>        <footer id="mastfoot" class="group">            <p id="disclaimer">{$name} Copyright &copy; <?php echo date('Y'); ?></p>            <p id="copyright">{$footer}</p>        </footer>		    </body></html>
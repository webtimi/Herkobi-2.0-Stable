-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Anamakine: localhost
-- Üretim Zamanı: 16 Tem 2012, 11:22:02
-- Sunucu sürümü: 5.5.16
-- PHP Sürümü: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Veritabanı: `hkv2`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Tablo döküm verisi `admin`
--

INSERT INTO `admin` (`id`, `user`, `password`) VALUES
(1, 'panel', 'c4ca4238a0b923820dcc509a6f75849b');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `brands`
--

CREATE TABLE IF NOT EXISTS `brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` int(11) NOT NULL,
  `slug` text NOT NULL,
  `brand` text NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `galleries`
--

CREATE TABLE IF NOT EXISTS `galleries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` int(11) NOT NULL,
  `slug` text NOT NULL,
  `album` text NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Tablo döküm verisi `galleries`
--

INSERT INTO `galleries` (`id`, `level`, `slug`, `album`, `description`, `image`) VALUES
(3, 0, 'web-sitemiz', 'Web Sitemiz', '', 'uploads/galeriler/tema.png');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `info`
--

CREATE TABLE IF NOT EXISTS `info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `fullname` text NOT NULL,
  `slogan` text NOT NULL,
  `address` text NOT NULL,
  `county` text NOT NULL,
  `city` text NOT NULL,
  `taxoffice` text NOT NULL,
  `taxnumber` varchar(64) NOT NULL,
  `phone` varchar(64) NOT NULL,
  `phoneother` varchar(64) NOT NULL,
  `fax` varchar(64) NOT NULL,
  `gsm` varchar(64) NOT NULL,
  `mail` varchar(225) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `info`
--

INSERT INTO `info` (`id`, `name`, `fullname`, `slogan`, `address`, `county`, `city`, `taxoffice`, `taxnumber`, `phone`, `phoneother`, `fax`, `gsm`, `mail`) VALUES
(1, 'BS İnternet Hizmetleri', 'BS İnternet Web Tasarım Reklam ve Pazarlama Hizmetleri', '', 'Doğanbey Mah. Burçin 3 İşhanı Kat: 9 No:902 Fomara', 'Osmangazi', 'Bursa', 'Vergi Dairesi', '00000000000', '02242216442', '', '', '', 'sakarya.bulent@gmail.com');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `linkcategories`
--

CREATE TABLE IF NOT EXISTS `linkcategories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` text NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Tablo döküm verisi `linkcategories`
--

INSERT INTO `linkcategories` (`id`, `category`) VALUES
(1, 'Linkler');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `links`
--

CREATE TABLE IF NOT EXISTS `links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link` text NOT NULL,
  `category` int(11) NOT NULL,
  `icon` text NOT NULL,
  `url` text NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Tablo döküm verisi `links`
--

INSERT INTO `links` (`id`, `link`, `category`, `icon`, `url`) VALUES
(1, 'BS İnternet Hizmetleri', 1, '', 'http://www.bs-internet.com'),
(2, 'Herkobi CMS', 1, '', 'http://www.herkobi.com'),
(3, 'PSD UP', 1, '', 'http://www.psdup.com'),
(4, 'Antep Fıstığı Araştırma Müdürlüğü', 1, '', 'http://www.antepfistigiarastirma.gov.tr/');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mid` text NOT NULL,
  `level` int(11) NOT NULL,
  `slug` text NOT NULL,
  `page` text NOT NULL,
  `summary` text NOT NULL,
  `content` text NOT NULL,
  `image` text NOT NULL,
  `gallery` int(11) NOT NULL,
  `title` text NOT NULL,
  `metadesc` text NOT NULL,
  `metatags` text NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Tablo döküm verisi `pages`
--

INSERT INTO `pages` (`id`, `mid`, `level`, `slug`, `page`, `summary`, `content`, `image`, `gallery`, `title`, `metadesc`, `metatags`, `date`) VALUES
(1, '0', 0, 'hakkimizda', 'Hakkımızda', 'Quisque ut condimentum elit. Mauris a est eget justo dapibus malesuada non vitae orci. Nam id commodo enim. Fusce quis lorem non ligula tincidunt sodales ut nec purus.', '<p>\r\n	Quisque ut condimentum elit. Mauris a est eget justo dapibus malesuada non vitae orci. Nam id commodo enim. Fusce quis lorem non ligula tincidunt sodales ut nec purus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ipsum massa, fringilla et blandit eu, vulputate quis arcu.</p>\r\n<p>\r\n	Aenean eu lorem id sem tristique feugiat at blandit nulla. Praesent varius lectus id dui tincidunt euismod volutpat diam egestas. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p>\r\n<p>\r\n	Aenean sed lectus nec metus blandit porta. Integer pharetra venenatis tellus quis accumsan. Suspendisse potenti. Nam pulvinar vehicula purus sed varius. Curabitur hendrerit sollicitudin velit quis fermentum. Vestibulum ornare est vitae nisi eleifend sed porttitor nisl porttitor. Aenean nec ipsum nulla, gravida tristique orci. Sed porta lectus a turpis feugiat vitae accumsan ante feugiat.</p>\r\n<p>\r\n	Praesent lacus eros, porta in vulputate a, posuere et velit. Morbi a sapien mauris, eget facilisis est. Integer suscipit neque sit amet est condimentum vestibulum. Mauris a diam sapien. Maecenas adipiscing ultricies justo, sit amet laoreet libero ullamcorper et. Aenean leo purus, feugiat vitae pharetra at, porttitor sit amet enim. Nullam congue lacus sit amet ipsum cursus placerat.</p>\r\n', 'uploads/sayfalar/tema.png', 1, 'Hakkımızda', 'Hakkımızda', '', '2012-06-25'),
(2, '0', 0, 'antep-fistigi', 'Antep Fıstığı', 'Antep fıstığı (Pistacia vera), sakız ağacıgiller (Anacardiaceae) familyasından yenebilen kabuklu bir meyve ve bunun ağacına verilen ad. ', '<p>\r\n	<img alt="Antep Fıstığı" src="http://hk.connect16.com/uploads/sayfalar/fistik.jpg" style="border-width: 0px; border-style: solid; margin: 5px; float: left; width: 110px; height: 100px; " />Antep fıstığı (Pistacia vera), sakız ağacıgiller (Anacardiaceae) familyasından yenebilen kabuklu bir meyve ve bunun ağacına verilen ad. Bu ağaç adını en çok yetiştiği kentlerden olan Gaziantep''ten alır. Antep fıstığı ağacından yetişir, yağlı, ince kabukludur.</p>\r\n<p>\r\n	Tatlıcılıkta ve eczacılıkta öksürük şurubu yapımında kullanılır. Lezzetli tohumları sevilerek tüketilir.</p>\r\n<p>\r\n	Antep fıstığının anavatanı Türkiye, İran ve Türkmenistan''dır. Dünya''da Antep fıstığının en çok yetiştiği ülkeler, sırasıyla İran, ABD ve Türkiye''dir. Türkiye''de ise en çok Şanlıurfa, Gaziantep, Kahramanmaraş illerinde yetişir.</p>\r\n<p>\r\n	Antep fıstığının 4 çeşidi vardır. Bunlardan "İran fıstığı" denilen tür, en çok yetiştirilenidir. İran fıstığının meyveleri diğer hepsinden daha iridir.</p>\r\n<p>\r\n	Bilgiler <a href="http://tr.wikipedia.org/wiki/Antep_f%C4%B1st%C4%B1%C4%9F%C4%B1">Wikipedia''dan</a> alınmıştır.</p>\r\n', '', 0, 'Vizyonumuz', 'Vizyonumuz', '', '2012-06-25'),
(10, '0', 0, 'ozel-paket', 'Özel Paket', '', '<p>\r\n	Tüm ürünlerimizden bir araya getirilmiş ve özel günlerinizde servis etmeniz amacıyla hazırlanmış bu özel paketimiz ile tüm fıstık çerez ihtiyacınızı karşılarsınız.</p>\r\n<p>\r\n	Paket içeriği</p>\r\n<ul>\r\n	<li>\r\n		500 gr antep fıstığı</li>\r\n	<li>\r\n		300 gram fındık içi</li>\r\n	<li>\r\n		200 gram boz iç</li>\r\n	<li>\r\n		300 gram meverdi</li>\r\n	<li>\r\n		100 kırmızı iç</li>\r\n</ul>\r\n', 'uploads/sayfalar/ozelpaket.png', 0, 'ÖZEL PAKET', 'ÖZEL PAKET', '', '2012-06-25');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` int(11) NOT NULL,
  `slug` text NOT NULL,
  `gallery` int(11) NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Tablo döküm verisi `photos`
--

INSERT INTO `photos` (`id`, `level`, `slug`, `gallery`, `description`, `image`) VALUES
(18, 0, 'urun-detay-sayfamiz', 3, 'Ürün detay sayfamız', 'uploads/galeriler/urun.png'),
(15, 0, 'ana-sayfa', 3, 'Ana Sayfa', 'uploads/galeriler/anasayfa.png'),
(16, 0, 'duyurular-sayfasi', 3, 'Duyurular Sayfası ', 'uploads/galeriler/duyurular.png'),
(17, 0, 'sabit-sayfalarimiz', 3, 'Sabit sayfalarımız', 'uploads/galeriler/sayfa.png'),
(19, 0, 'urunler-sayfamiz', 3, 'Ürünler sayfamız', 'uploads/galeriler/urunler.png');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `postcategories`
--

CREATE TABLE IF NOT EXISTS `postcategories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mid` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `slug` text NOT NULL,
  `category` varchar(255) NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Tablo döküm verisi `postcategories`
--

INSERT INTO `postcategories` (`id`, `mid`, `level`, `slug`, `category`, `description`) VALUES
(1, 0, 0, 'genel-duyurular', 'Genel Duyurular', ''),
(18, 0, 0, 'mali-duyurular', 'Mali Duyurular', 'Finansal bilgiler'),
(20, 0, 0, 'insan-kaynaklari-duyurulari', 'İnsan Kaynakları Duyuruları', '');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `slug` text NOT NULL,
  `post` text NOT NULL,
  `summary` text NOT NULL,
  `content` text NOT NULL,
  `image` text NOT NULL,
  `gallery` int(11) NOT NULL,
  `title` text NOT NULL,
  `metadesc` text NOT NULL,
  `metatags` text NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Tablo döküm verisi `posts`
--

INSERT INTO `posts` (`id`, `cid`, `level`, `slug`, `post`, `summary`, `content`, `image`, `gallery`, `title`, `metadesc`, `metatags`, `date`) VALUES
(1, 1, 0, 'web-sitemiz-yayinda', 'Web Sitemiz Yayında', 'Etiam non convallis metus. Vestibulum ut quam eget mauris pulvinar ultrices sit amet ut justo. Maecenas aliquet dapibus ultricies. Ut at augue eu massa dictum ornare.\r\n', '<p>\r\n	Sed eget lorem egestas velit rutrum tempor. In molestie felis in lectus bibendum semper. In et ante nisi, pretium commodo nulla. Quisque congue consequat eleifend. Suspendisse eleifend velit in ipsum dapibus nec euismod nunc iaculis. Etiam venenatis pellentesque condimentum. Nunc sed elit risus. Suspendisse arcu sapien, ornare lacinia tincidunt id, aliquam ut felis. Sed in eros vel augue ultricies suscipit. Morbi vehicula aliquet mi, eu feugiat nibh suscipit quis. Suspendisse et nulla sem. Sed nec sapien leo, ac auctor arcu.</p>\r\n', 'uploads/yazilar/tema.png', 0, 'Web Sitemiz Yayında', 'Sed eget lorem egestas velit rutrum tempor. In molestie felis in lectus bibendum semper. In et ante nisi, pretium commodo nulla.\r\n\r\n	Quisque congue consequat el', '', '2012-06-25'),
(2, 18, 0, '2012-yili-ilk-ceyrek-raporlari', '2012 Yılı İlk Çeyrek Raporları', '2012 Yılı İlk Çeyrek Raporları', '<p>\r\n	2012 Yılı İlk Çeyrek Raporları</p>\r\n', 'uploads/yazilar/fistik.jpg', 0, '2012 Yılı İlk Çeyrek Raporları', '2012 Yılı İlk Çeyrek Raporları', '', '2012-06-25'),
(3, 18, 0, '2012-yili-ikinci-ceyrek-raporlari', '2012 Yılı İkinci Çeyrek Raporları', '', '<p>\r\n	2012 Yılı İkinci Çeyrek Raporları</p>\r\n', '', 0, '2012 Yılı İkinci Çeyrek Raporları', '2012 Yılı İkinci Çeyrek Raporları', '', '2012-06-25');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `productcategories`
--

CREATE TABLE IF NOT EXISTS `productcategories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mid` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `slug` text NOT NULL,
  `category` text NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `front` varchar(1) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Tablo döküm verisi `productcategories`
--

INSERT INTO `productcategories` (`id`, `mid`, `level`, `slug`, `category`, `description`, `image`, `front`) VALUES
(1, 0, 0, 'antep-fistigi', 'Antep Fıstığı', 'Antep Fıstığı', 'uploads/urunler/fistik.jpg', '1'),
(2, 0, 0, 'kirmizi-ic-antep-fistigi', 'Kırmızı İç Antep Fıstığı', 'Kırmızı İç Antep Fıstığı', 'uploads/urunler/fistik.jpg', '1'),
(3, 0, 0, 'gul-ic-meverdi-antep-fistigi', 'Gül İç (Meverdi) Antep Fıstığı', 'Gül İç (Meverdi) Antep Fıstığı', 'uploads/urunler/fistik.jpg', '1'),
(4, 0, 0, 'boz-ic-antep-fistigi', 'Boz İç Antep Fıstığı', 'Boz İç Antep Fıstığı', 'uploads/urunler/fistik.jpg', '1'),
(5, 0, 0, 'yesil-firik-antep-fistigi', 'Yeşil (Firik) Antep Fıstığı', 'Yeşil (Firik) Antep Fıstığı', 'uploads/urunler/fistik.jpg', '1'),
(6, 0, 0, 'kavrulmus-antep-fistik', 'Kavrulmuş Antep Fıstık', 'Kavrulmuş Antep Fıstık', 'uploads/urunler/fistik.jpg', '1'),
(7, 0, 0, '', 'Yerli Badem İçi', 'Yerli Badem İçi', 'uploads/urunler/fistik.jpg', '1'),
(8, 0, 0, 'ithal-badem-ici', 'İthal Badem İçi', 'İthal Badem İçi', 'uploads/urunler/fistik.jpg', '1'),
(9, 0, 0, 'findik-ici', 'Fındık İçi', 'Fındık İçi', 'uploads/urunler/fistik.jpg', '1');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `publish` varchar(11) NOT NULL,
  `level` int(11) NOT NULL,
  `slug` text NOT NULL,
  `product` text NOT NULL,
  `category` text NOT NULL,
  `brand` int(11) NOT NULL,
  `content` text NOT NULL,
  `code` varchar(255) NOT NULL,
  `price` varchar(11) NOT NULL,
  `currency` varchar(5) NOT NULL,
  `image` text NOT NULL,
  `image1` text NOT NULL,
  `image2` text NOT NULL,
  `image3` text NOT NULL,
  `image4` text NOT NULL,
  `title` text NOT NULL,
  `metadesc` text NOT NULL,
  `metatags` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Tablo döküm verisi `products`
--

INSERT INTO `products` (`id`, `publish`, `level`, `slug`, `product`, `category`, `brand`, `content`, `code`, `price`, `currency`, `image`, `image1`, `image2`, `image3`, `image4`, `title`, `metadesc`, `metatags`) VALUES
(1, 'Yayınlandı', 0, '1-kglik-antep-fistigi', '1 KG''lık Antep Fıstığı', '-1-,', 0, '<p>\r\n	Özel olarak paketlenmiş taze antep fıstığı.</p>\r\n<p>\r\n	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum adipiscing, sapien nec vulputate blandit, mi urna pellentesque orci, sed pellentesque sapien sapien sed enim.</p>\r\n<p>\r\n	Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aliquam elit mauris, dapibus a tempus quis, ultricies porta urna. Ut at risus at quam pulvinar interdum. Nullam interdum, lectus sed gravida ultricies, purus elit ullamcorper libero, at euismod leo lacus quis nulla.</p>\r\n<p>\r\n	Curabitur convallis ligula rutrum eros convallis lacinia. Morbi eros magna, interdum at posuere ut, faucibus ut felis. Nullam et justo ac tellus placerat blandit. In varius, justo vitae sodales pulvinar, ipsum lacus porttitor eros, vel vehicula quam magna ac massa.&nbsp;</p>\r\n<p>\r\n	Vestibulum sed arcu vel est iaculis sollicitudin quis eu augue. Aliquam ultrices neque in tortor venenatis id dignissim justo semper. Nulla nec dolor nisi. Nulla facilisi. Sed consectetur auctor lorem, nec molestie eros scelerisque eget. Integer suscipit sem eget lacus congue convallis.</p>\r\n', 'AF1KG', '100', 'TL', 'uploads/urunler/fistik.jpg', '', '', '', '', 'Sony Vaio F Serisi VPCF23L1E', 'Eğlence için Tasarlandı \r\n\r\n	Blu-ray Disc™ oynatıcı ve Full HD VAIO Plus Ekran ile HD''yi keşfedin\r\n\r\n	\r\n		Muhteşem ayrıntılarla dolu Full HD ile eğlenceyi yaşay', ''),
(2, 'Yayınlandı', 0, '5-kglik-antep-fistigi', '5 KG''lık Antep Fıstığı', '-1-,', 0, '<p>\r\n	Hijyenik ortamlarda özel olarak hazırlanmış 5 KG''lık antep fıstığı.</p>\r\n', 'AF5KG', '75', 'TL', 'uploads/urunler/fistik.jpg', '', '', '', '', '5 KG''lık Antep Fıstığı', 'Hijyenik ortamlarda özel olarak hazırlanmış 5 KG''lık antep fıstığı.', ''),
(3, 'Yayınlandı', 0, '1-kglik-meverdi', '1 KG''lık Meverdi', '-3-,-7-,', 0, '<p>\r\n	Hijyenik ortamlarda paketlenmiş, özel kutusunda 1 KG2lık Meverdi.</p>\r\n', '1KGMEVERDI', '25', 'TL', 'uploads/urunler/fistik.jpg', '', '', '', '', '1 KG''lık Meverdi', 'Hijyenik ortamlarda paketlenmiş, özel kutusunda 1 KG2lık Meverdi.', '');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `metadesc` text NOT NULL,
  `metatags` text NOT NULL,
  `category` int(11) NOT NULL,
  `newproducts` int(11) NOT NULL,
  `latestposts` int(11) NOT NULL,
  `posts` int(11) NOT NULL,
  `products` int(11) NOT NULL,
  `home` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `settings`
--

INSERT INTO `settings` (`id`, `title`, `metadesc`, `metatags`, `category`, `newproducts`, `latestposts`, `posts`, `products`, `home`) VALUES
(1, 'Herkobi İçerik Yönetim Sistemi', 'Herkobi CMS', 'herkobi, cms, içerik yönetim sistemi', 9, 3, 4, 10, 20, 'Bu site Herkobi CMS ile oluşturulmuştur. Site üzerinden herhangi bir satış veya benzeri işlem yapılmaktadır. Oluşturulan tema Herkobi CMS''nin özelliklerini göstermek amacıyla yayınlanmış, ürünlerde bu amaçla girilmiştir.');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `slide`
--

CREATE TABLE IF NOT EXISTS `slide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `url` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Tablo döküm verisi `slide`
--

INSERT INTO `slide` (`id`, `description`, `image`, `url`) VALUES
(12, '', 'uploads/slide/tagline-01.png', ''),
(13, '', 'uploads/slide/tagline-02.png', ''),
(14, '', 'uploads/slide/tagline-03.png', ''),
(15, '', 'uploads/slide/tagline-04.png', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

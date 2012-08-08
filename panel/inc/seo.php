<?php 

	function slug($title = "") {
		//değiştirelecek türkçe karakterler
		$TR = array('ç', 'Ç', 'ı', 'İ', 'ş', 'Ş', 'ğ', 'Ğ', 'ö', 'Ö', 'ü', 'Ü', 'I');
		$EN = array('c', 'c', 'i', 'i', 's', 's', 'g', 'g', 'o', 'o', 'u', 'u', 'i');
		
		//türkçe karakterleri değiştirir
		$title = str_replace($TR, $EN, $title);
		
		//tüm karakterleri küçülür
		$title = mb_strtolower($title, 'UTF-8');
		
		// a'dan z'ye olan harfler, 0'dan 9 a kadar sayılar, tire (), boşluk ve alt çizgi ()
		// dışındaki tüm karakteri siler
		$title = preg_replace('#[^-a-zA-Z0-9 ]#', '', $title);
		
		//cümle aralarındaki fazla boşluğu kaldırır
		$title = trim($title);
		
		//cümle aralarındaki boşluğun yerine tire () koyar
		$title = preg_replace('#[-_ ]+#', '-', $title);
		
		return $title;
	}

?>

<?php
	/* Genel Ayarlar */
	include "config.php";
	
	$sql = "SELECT mail FROM info";
	$sth = $db->prepare($sql);
	$db->query("SET NAMES 'UTF8'");
	$sth->execute();
	$result = $sth->fetchAll();
  
		$mail = $result[0]['mail'];
		
	
	$toemail = $mail;
	$name = $_POST['name'];
	$email = $_POST['email'];
	$message = $_POST['message'];
	$subject = "Yeni Mesaj: $name <$email>";	
	
	if(mail($toemail, $subject, $message, 'From: ' . $email)) {
		echo 'Mesajınız için teşekkür ederiz. En kısa sürede sizinle irtibata geçeceğiz.';
	} else {
		echo 'Mesaj gönderilirken bir hata oluştu, lütfen tekrar deneyiniz.';
	}
?>
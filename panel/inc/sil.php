<?php

include("../../config.php");
if ((!isset($_SESSION['logged'])) || (@$_SESSION['logged'] != 'yes')) {
    header("Location: ../index.php");
    die;
}

function sil($id, $tablo) {
    global $db;

    if ($tablo == 1) {
        $sql = "DELETE FROM pages WHERE id = :id";
    } else if ($tablo == 2) {
        $sql = "DELETE FROM postcategories WHERE id=:id;UPDATE posts SET cid='1' WHERE cid=:id";
    } else if ($tablo == 3) {
        $sql = "DELETE FROM posts WHERE id = :id";
    } else if ($tablo == 4) {
        $sql = "DELETE FROM brands WHERE id = :id";
    } else if ($tablo == 5) {
        $sql = "DELETE FROM products WHERE id = :id";
    } else if ($tablo == 6) {
        $sql = "DELETE FROM galleries WHERE id = :id";
    } else if ($tablo == 7) {
        $sql = "DELETE FROM linkcategories WHERE id = :id";
    } else if ($tablo == 8) {
        $sql = "DELETE FROM links WHERE id = :id";
    } else if ($tablo == 9) {
        $sql = "SELECT COUNT( id ) FROM admin";
        $sth = $db->prepare($sql);
        $sth->execute();
        $sonuc = $sth->fetchAll();

        if ($sonuc[0][0] != 1) {
            $sql = "DELETE FROM admin WHERE id = :id";
            $sth = $db->prepare($sql);
            $sth->bindValue(':id', $id);
            if ($sth->execute()) {
                echo "basarili";
            } else {
                echo "basarisiz";
            }
        }
        return;
    } else if ($tablo == 10) {
        $sql = "DELETE FROM `photos` WHERE id = :id";
    } else if ($tablo == 11) {
        $sql = "DELETE FROM slide WHERE id = :id";
    }

    $sth = $db->prepare($sql);
    $sth->bindValue(':id', $id);
    if ($sth->execute()) {
        echo "basarili";
    } else {
        echo "basarisiz";
    }
}

$silID = strip_tags($_POST['id']);
$silTable = strip_tags($_POST['n']);

sil($silID, $silTable);
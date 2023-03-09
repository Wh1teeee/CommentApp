<?php

session_start();
if(!isset($_SESSION['korisnik_id'])) {
    header('Location: ../login.php');
    die();
}

if(empty($_POST['naslov']) || empty($_POST['sadrzaj']))
{
    header('Location: ../prijavljen.php');
}

require_once __DIR__ . '/../tabele/Komentar.php';

$id = Komentar::unesiKomentar($_POST['naslov'],$_POST['sadrzaj'],$_SESSION['korisnik_id']);
if($id > 0) {
    //header('Location: ../prijavljen.php');
    //die();
    $komentar = Komentar::komentar_za_id($id);
    $komentar->korisnik = $komentar->korisnik();
    $komentar->created_at = date('d.m.Y. H:i',strtotime($komentar->created_at));
    $komentar->novi = 'true';
    echo json_encode($komentar);
 } else {
    header('Location: ../prijavljen.php?error=komentar');
    die();
 }

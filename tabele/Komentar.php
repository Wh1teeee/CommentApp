<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/Database.php';
require_once __DIR__ . '/Korisnik.php';

class Komentar {
    public $id;
    public $naslov;
    public $sadrzaj;
    public $created_at;
    public $korisnik_id;

    public function korisnik() {
        return Korisnik::korisnik_za_id($this->korisnik_id);
    }

    public static function unesiKomentar($naslov,$sadrzaj,$korisnik_id) {
        
        $database = Database::getInstance();
        $database->insert('Komentar','INSERT INTO komentari (naslov, sadrzaj, korisnik_id) VALUES (:naslov,:sadrzaj,:korisnik_id);',
        [
            ':naslov' => $naslov,
            ':sadrzaj' => $sadrzaj,
            ':korisnik_id' => $korisnik_id
        ]);

        $id = $database->lastInsertId();
        return $id;
    }

    public static function izmeni_komentar($naslov,$sadrzaj,$korisnik_id,$komentar_id) {
        $database = Database::getInstance();
        $database->update('Komentar','UPDATE komentari SET naslov = :naslov , sadrzaj = :sadrzaj WHERE id = :id AND korisnik_id=:korisnik_id', 
        [
            ':naslov' => $naslov,
            ':sadrzaj' => $sadrzaj,
            ':id' => $komentar_id,
            ':korisnik_id' => $korisnik_id
        ]);
        return $komentar_id;
    }

    public static function svi_komentari() {
        $database = Database::getInstance();
        $komentari = $database->select('Komentar','SELECT * FROM komentari ORDER BY created_at DESC');
        return $komentari;
    }

    public static function obrisi_komentar($id) {

        $database = Database::getInstance();
        $database->delete('DELETE FROM komentari WHERE id = :id',
        [
            ':id' => $id
        ]);
    }

    public static function komentar_za_id($id) {

        $database = Database::getInstance();
        $komentari = $database->select('Komentar', 'SELECT * FROM komentari WHERE id=:id',
        [
            ':id' => $id
        ]);

        foreach($komentari as $komentar) {
            return $komentar;
        }
        return null;
        
    }
}

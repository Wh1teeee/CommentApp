<?php
require_once __DIR__ . '/includes_provera/da_li_je_prijavljen.php';
require_once __DIR__ . '/tabele/Komentar.php';
$komentari = Komentar::svi_komentari();
$korisnik = Korisnik::korisnik_za_id($_SESSION['korisnik_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Prijavljen korisnik</title>
    <link rel="stylesheet" href="stil.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="jquery-3.6.3.min.js"></script>
    <script>
        function izmena_komentara(forma) {
                $('#ostavi_komentar>input[name="naslov"]').val(forma.find('input[name="naslov"]').val());

                $('#ostavi_komentar>textarea[name="sadrzaj"]').val(forma.find('input[name="sadrzaj"]').val());

                $('#ostavi_komentar>input[name="komentar_id"]').val(forma.find('input[name="komentar_id"]').val());

                $('#ostavi_komentar').attr('action',forma.attr('action'));
        }
        $(function() {
            $('#ostavi_komentar').on('submit',function(e) {
                e.preventDefault();
                var form = $(this);
                $.ajax({
                    url : form.attr('action'),
                    method: form.attr('method'),
                    data: {
                        'naslov': $('[name="naslov"]').val(),
                        'sadrzaj':$('[name="sadrzaj"]').val(),
                        'komentar_id':$('[name="komentar_id"]').val(),
                        'korisnik_id': '<?= $_SESSION['korisnik_id'] ?>'
                    },
                    dataType: 'json',
                    success: function(komentar) {
                        console.log(komentar);
                        if(komentar.novi === 'true' && komentar.korisnik.tip_korisnika_id == 1) {
                            $('.komentar:first-of-type').before(
                                
                                '<div class="komentar">' +
                                    '<h2>'+ komentar.created_at + 
                                    '<form action="logika/obrisi_komentar.php" method="post" class="obrisi_komentar">'+ 
                                    '<input type="hidden" name="komentar_id" value="'+komentar.id+'">'+
                                    '<input type="submit" class="btn btn-primary" value="Obrisi">'+
                                    '</form>'+
                                    '<form action="logika/izmeni_komentar.php" method="post" class="izmeni_komentar">' +
                                    '<input type="hidden" name="komentar_id" value="'+ komentar.id+'"> '+
                                    '<input type="hidden" name="naslov" value="'+komentar.naslov+'">'+
                                    '<input type="hidden" name="sadrzaj" value="'+komentar.sadrzaj+'">'+
                                    '<input type="submit" class="btn btn-primary" value="Izmeni">'+
                                    '</form>'+
                                    '</h2>' +
                                    '<h3>'+ komentar.korisnik.email + '</h3>' +
                                    '<h1>'+ komentar.naslov + '</h1>'+
                                    '<p>'+ komentar.sadrzaj +'</p>' +
                                '<hr>' +
                                '</div>'
                            );
                            $('.komentar:first .izmeni_komentar').on('submit',function(e) {
                            e.preventDefault();
                            var forma = $(this);
                            izmena_komentara(forma);
                            });
                            $('.komentar:first .obrisi_komentar').on('submit',function(e) {
                                e.preventDefault();
                                var form = $(this);
                                $.ajax({
                                    url: form.attr('action'),
                                    method: form.attr('method'),
                                    data: {
                                        'komentar_id': form.find('[name="komentar_id"]').val()
                                    },
                                    dataType: 'json',
                                    success : function(odgovor) {
                                        console.log(odgovor);
                                        form.parent().parent().remove();
                                    },
                                    error: function(odgovor) {
                                        console.log(odgovor);
                                    }
                                });
                            });
                        } else if(komentar.novi === 'true') {
                            $('.komentar:first-of-type').before(
                                
                                '<div class="komentar">' +
                                    '<h2>'+ komentar.created_at + 
                                    '<form action="logika/izmeni_komentar.php" method="post" class="izmeni_komentar">' +
                                    '<input type="hidden" name="komentar_id" value="'+ komentar.id+'"> '+
                                    '<input type="hidden" name="naslov" value="'+komentar.naslov+'">'+
                                    '<input type="hidden" name="sadrzaj" value="'+komentar.sadrzaj+'">'+
                                    '<input type="submit" class="btn btn-primary" value="Izmeni">'+
                                    '</form>'+
                                    '</h2>' +
                                    '<h3>'+ komentar.korisnik.email + '</h3>' +
                                    '<h1>'+ komentar.naslov + '</h1>'+
                                    '<p>'+ komentar.sadrzaj +'</p>' +
                                '<hr>' +
                                '</div>'
                            );
                            $('.komentar:first .izmeni_komentar').on('submit',function(e) {
                            e.preventDefault();
                            var forma = $(this);
                            izmena_komentara(forma);
                        });
                        } else {
                            var kom_el = $('.izmeni_komentar input[value="'+komentar.id+'"]').parent().parent().parent();
                            kom_el.find('h1').html($('[name="naslov"]').val());
                            kom_el.find('p').html($('[name="sadrzaj"]').val());
                            form.attr('action','logika/postavi_komentar.php');
                        }
                        form.find('input,textarea').val('');
                    },
                    error: function(odgovor) {
                        console.log(odgovor);
                    }
                });
            });

            $('.obrisi_komentar').on('submit',function(e) {
                e.preventDefault();
                var form = $(this);
                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    data: {
                        'komentar_id': form.find('[name="komentar_id"]').val()
                    },
                    dataType: 'json',
                    success : function(odgovor) {
                        console.log(odgovor);
                        form.parent().parent().remove();
                    },
                    error: function(odgovor) {
                        console.log(odgovor);
                    }
                });
            });
            $('.izmeni_komentar').on('submit',function(e) {
                e.preventDefault();
                var forma = $(this);
                izmena_komentara(forma);
            });
        });
    </script>
</head>
<body class="pozadina">
    <a class="btn btn-primary" style="padding:10px 10px; margin:5px 5px 5px 5px;" href="logika/logout.php">Odjavi se</a>
    <hr>
    <form method="post" action="logika/postavi_komentar.php" id="ostavi_komentar">
        <input type="text" name="naslov" placeholder="Unesite naslov" class="unos"><br>
        <textarea name="sadrzaj" placeholder="Unesite komentar" class="unos"></textarea>
        <input type="hidden" name="komentar_id" ><br>
        <button type="submit" class="btn btn-primary" style="width:20%; margin:5px 5px 5px 5px;">Posalji komentar</button>
    </form>
    <hr>
    <?php foreach($komentari as $komentar): ?>
        <div class="komentar">
            <h2><?= date('d.m.Y. H:i',strtotime($komentar->created_at)) ?>
            <?php if($korisnik->tip_korisnika()->naziv_tipa === 'administrator'): ?>
                <form action="logika/obrisi_komentar.php" method="post" class="obrisi_komentar"> 
                    <input type="hidden"  name="komentar_id" value="<?= $komentar->id ?>">
                    <input type="submit" value="Obrisi" class="btn btn-primary">
                </form>
            <?php endif ?>
            <?php if($korisnik->id == $komentar->korisnik_id || $korisnik->tip_korisnika()->naziv_tipa === 'administrator'): ?>
                <form action="logika/izmeni_komentar.php" method="post" class="izmeni_komentar"> 
                    <input type="hidden" name="komentar_id" value="<?= $komentar->id ?>">
                    <input type="hidden" name="naslov" value="<?= $komentar->naslov?>">
                    <input type="hidden" name="sadrzaj" value="<?=$komentar->sadrzaj?>">
                    <input type="submit" class="btn btn-primary" value="Izmeni">
                </form>
            <?php endif ?>
            </h2>
            <h3><?= $komentar->korisnik()->email ?></h3>
            <h1><?= $komentar->naslov ?></h1>
            <p><?= $komentar->sadrzaj ?></p>
        <hr>
        </div>
        
    <?php endforeach ?>
</body>
</html>
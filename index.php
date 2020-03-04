<?php
function sifreleCoz($islem, $metin, $sifre) {
    $output = false;
    $metod = "AES-256-CBC";
    $secret_key = $sifre;
    $secret_iv = '123456';

    $key = hash('sha256', $secret_key);

    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ( $islem == 'sifrele' ) {
        $output = openssl_encrypt($metin, $metod, $key, 0, $iv);
        $output = base64_encode($output);
    } else if( $islem == 'coz' ) {
        $output = openssl_decrypt(base64_decode($metin), $metod, $key, 0, $iv);
    }
    return $output;
}


$kontrol = 0;
if (isset($_POST['sifrele'])){
    $metin = sifreleCoz('sifrele',$_POST['metin'],$_POST['sifre']);
    $kontrol = 1;
} elseif (isset($_POST['sifre_coz'])){
    $metin1 = sifreleCoz('coz',$_POST['metin1'],$_POST['sifre1']);
    $kontrol = 2;
}

?>
<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="favicon.png" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Veri Şifreleme & Çözme</title>
</head>
<body style="background: antiquewhite;">
    <div class="col-md-12 text-center mt-3" style="font-size: 35px;font-weight: bold;">Veri Şifreleme & Çözme</div>
    <div class="col-md-8 mt-5" style="margin: auto;margin-bottom: 150px;">
        <?php
            if ($kontrol==1){
                echo '<div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Şifreli Metin</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <label>Şifreli Metin:</label>
                                <textarea class="form-control"  rows="10">
                                    '.$metin.'
                                </textarea>
                                <p></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Kapat</button>
                            </div>
                        </div>
            
                    </div>
                </div>';
            } elseif ($kontrol==2){
                echo '<div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Çözülen Metin</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <label>Çözülen Metin:</label>
                                <textarea class="form-control"  rows="10">
                                    '.$metin1.'
                                </textarea>
                                <p></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Kapat</button>
                            </div>
                        </div>
            
                    </div>
                </div>';
            }
        ?>

        <form action="index.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="exampleFormControlTextarea1" style="font-weight: bold;">Şifrelenecek Metin</label>
                <textarea class="form-control" name="metin" placeholder="Şifrelenecek metini giriniz" id="exampleFormControlTextarea1" rows="10"></textarea>
                <label for="sifre" style="font-weight: bold;">Key</label><br>
                <input type="password" name="sifre" id="sifre" placeholder="Key giriniz">
            </div>
            <button type="submit" name="sifrele" class="btn btn-primary">Şifrele</button>
        </form>

        <form action="index.php" method="post" enctype="multipart/form-data" class="mt-5">
            <div class="form-group">
                <label for="exampleFormControlTextarea1" style="font-weight: bold;">Şifrelenmiş Metin</label>
                <textarea class="form-control" name="metin1" placeholder="Şifrelenmiş metini giriniz" id="exampleFormControlTextarea1" rows="10"></textarea>
                <label for="sifre" style="font-weight: bold;">Key</label><br>
                <input type="password" name="sifre1" id="sifre" placeholder="Key giriniz">
            </div>
            <button type="submit" name="sifre_coz" class="btn btn-primary">Şifre Çöz</button>
        </form>
    </div>
<section class="bg-dark text-white fixed-bottom">
    <div class="row">
        <div class="col-md-6">
            Hiçbir mucit, kendisi için bir icat yapmaz. ~ Bill Gates
        </div>
        <div class="col-md-6 text-right">
            Abdurrahman Gazi
        </div>
    </div>
</section>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(function () {
        $('#myModal').modal('show');
    });
</script>
</html>

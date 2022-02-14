<?php
ob_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "Frameworks/PHPMailer/src/Exception.php"; // dosyayi kurdugunuz alan 
require "Frameworks/PHPMailer/src/PHPMailer.php";// dosyayi kurdugunuz alan 
require "Frameworks/PHPMailer/src/SMTP.php";// dosyayi kurdugunuz alan 
require_once("Ayarlar/ayar.php");// ayar dosyasini kurdugunuz alan Site Email Adresi/Sifresi/HostAdresi gibi degiskenleri cekiyoruz
require_once("Ayarlar/fonksiyonlar.php"); // Guvenlik fonksiyonlarimizi cektigimiz alan 




if (isset($_POST["IsimSoyisim"])) {
    $GelenIsimSoyisim     =    Guvenlik($_POST["IsimSoyisim"]);
} else {
    $GelenIsimSoyisim     =    "";
}

if (isset($_POST["Email"])) {
    $GelenEmail           =    Guvenlik($_POST["Email"]);
} else {
    $GelenEmail           =    "";
}

if (isset($_POST["Telefon"])) {
    $GelenTelefon         =    Guvenlik($_POST["Telefon"]);
} else {
    $GelenTelefon         =    "";
}


if (isset($_POST["Mesaj"])) {
    $GelenMesaj           =    Guvenlik($_POST["Mesaj"]);
} else {
    $GelenMesaj           =    "";
}
if( ($GelenIsimSoyisim!="") and ($GelenEmail!="") and ($GelenMesaj!="") and ($GelenTelefon!="") ){
            $mail = new PHPMailer(true);
            try {
                $mail->SMTPDebug            = 0;                                                                               //Enable verbose debug output
                $mail->isSMTP();                                                                                    //Send using SMTP
                $mail->Host                 = DonusumleriGeriDondur($SiteEmailHostAdresi);                                    //Set the SMTP server to send through
                $mail->SMTPAuth             = true;                                                                           //Enable SMTP authentication
                $mail->CharSet              = "UTF-8";                                                                         //Enable SMTP authentication
                $mail->Username             = DonusumleriGeriDondur($SiteEmailAdresi);                                        //SMTP username
                $mail->Password             = DonusumleriGeriDondur($SiteEmailSifresi);                                       //SMTP password
                $mail->SMTPSecure           = 'tls';                                                                          //Enable implicit TLS encryption
                $mail->Port                 = 587;                                                                            //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                $mail->SMTPOptions          = array(
                                                    'ssl' => array(
                                                        'verify_peer' => false,
                                                        'verify_peer_name' => false,
                                                        'allow_self_signed' => true,
                                                    )
                            );
                $mail->setFrom(DonusumleriGeriDondur($SiteEmailAdresi), $SiteAdi);
                $mail->addAddress(DonusumleriGeriDondur($SiteEmailAdresi), $SiteAdi);                               //Add a recipient
                $mail->addReplyTo($GelenEmail, $GelenIsimSoyisim);
                $mail->isHTML(true);                                                                                //Set email format to HTML
                $mail->Subject = DonusumleriGeriDondur($GelenIsimSoyisim) . " Kullanicisinin " . DonusumleriGeriDondur($SiteAdi) . " sitesinden gonderdigi mesaj Formu";
                            
                $mail->msgHTML($GelenMesaj);
                $mail->send();
                
                header("Location:xxxxxxxxx"); // Mail Gonderildi 
            }
            catch (Exception $e) {
                echo 
                header("Location:xxxxx"); // Mail gonderilemedi
                exit();
            }
                

}else{
    header("Location:xxxxx"); //Bos deger
    exit();
}

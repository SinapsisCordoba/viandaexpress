<?php
date_default_timezone_set('America/Argentina/Cordoba');

function connectarDB($sql){
    $servername = "mysql.hostinger.com.ar";
    $username = "u796671539_sga";
    $password = "u796671539_sga";
    $dbname = "u796671539_sga";
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8");
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}

function seguridadSQL($variable){
    $variable = str_replace(',', '-', $variable);
    $variable = str_replace(';', '-', $variable);
    $variable = str_replace('=', '-', $variable);
    $variable = str_replace('"', '-', $variable);
    $variable = str_replace('(', '-', $variable);
    $variable = str_replace(')', '-', $variable);
    $variable = str_replace('INSERT', '-', $variable);
    $variable = str_replace('UPDATE', '-', $variable);
    $variable = str_replace('DELETE', '-', $variable);
    $variable = str_replace('ALTER', '-', $variable);
    return $variable;
}

function enviarEmail($para, $asunto, $mensaje){
    $headers = "From: info@sinapsiscordoba.com";
    mail($para,$asunto,$mensaje,$headers);
}
?>
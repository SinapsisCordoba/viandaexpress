<?php
function connectarDB($sql){
    $servername = "localhost";
    $username = "root";
    $password = "Uur5ryw5.17";
    $dbname = "viandaexpress";
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
?>
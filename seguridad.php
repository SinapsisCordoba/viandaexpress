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
?>
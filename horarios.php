<?php
$servername = "localhost";
$username = "root";
$password = "Uur5ryw5.17";
$dbname = "viandaexpress";
$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "SELECT * FROM `horarios` WHERE `sucursal` = " . $_GET['suc'];
$result = $conn->query($sql);
$string = "[";
while($row = $result->fetch_assoc()) {
    if($string != "["){
        $string .= ", ";
    }
    $string .= '"' . mb_strimwidth($row['horario'], 0, 5) . '"';
}
$string .= "]";
echo $string;
?>

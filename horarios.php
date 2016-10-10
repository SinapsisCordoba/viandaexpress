<?php
    include 'seguridad.php';
?>
<?php
$sql = "SELECT * FROM `horarios` WHERE `sucursal` = " . $_GET['suc'];
$result = connectarDB($sql);
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

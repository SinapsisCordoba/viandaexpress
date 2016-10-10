<?php
    include 'seguridad.php';
    session_start();
    if(!$_SESSION['tipo_usuario']=="admin"){
        header("Location: login.php");
    }
?>
<html>
    <head>
        <title>Pedidos</title>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width'>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <script src="js/jquery2.2.0.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="col-lg-6" style="height: 40%; margin-top: 10px;">
                <a href="verPedidos.php" class="btn btn-primary" style="width:100%; height:100%; font-size:50px; white-space: normal;">Ver Pedidos</a>
            </div>
            <div class="col-lg-6" style="height: 40%; margin-top: 10px;">
                <a href="sucursales.php" class="btn btn-success" style="width:100%; height:100%;  font-size:50px; white-space: normal;">Sucursales</a>
            </div>
            <div class="col-lg-6" style="height: 40%; margin-top: 40px;">
                <a href="ventas.php" class="btn btn-danger" style="width:100%; height:100%;  font-size:50px; white-space: normal;">Ventas</a>
            </div>
            <div class="col-lg-6" style="height: 40%; margin-top:40px;">
                <a href="menus.php" class="btn btn-warning" style="width:100%; height:100%;  font-size:50px; white-space: normal;">Menus</a>
            </div>
            <div class="col-lg-12" style="margin-top:20px;">
                <a href="logout.php" class="btn btn-default" style="width:100%;"><i class="fa fa-arrow-left"></i> Salir</a>
            </div>
        </div>
    </body>
</html>
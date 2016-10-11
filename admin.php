<?php
    include 'seguridad.php';
    session_start();
    if(!$_SESSION['tipo_usuario']=="admin"){
        header("Location: login.php");
    }
?>
<?php
    if(!empty($_POST)){
        $antPass = seguridadSQL($_POST['antPass']);
        $nuevaPass = seguridadSQL($_POST['nuevaPass']);
        $rePass = seguridadSQL($_POST['rePass']);
        $sql = "SELECT COUNT(*) AS 'cuenta' FROM `admin` WHERE `usuario` = '" . $_SESSION['sucursal']  . "' AND `password` = MD5('" . $antPass  . "')";
        $result = connectarDB($sql);
        $cuenta = $result->fetch_assoc()['cuenta'];
        if(!$cuenta == 1){
            echo "Error: No se autorizó el cambio de contraseña.";
        }
        else{
            if($nuevaPass == $rePass){
                $sql = "UPDATE `admin` SET `password`=MD5('$nuevaPass') WHERE `usuario`='" . $_SESSION['sucursal'] . "'";
                $result = connectarDB($sql);
                echo "Contraseña cambiada.";
            }
            else{
                echo "Error: Las contraseñas no coinciden.";
            }
        }
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
            <form method="post" class="form-inline">
                <div class="col-lg-2" style="margin-top:20px;" class="input-group">
                    <a href="logout.php" class="btn btn-default" style="width:100%;"><i class="fa fa-arrow-left"></i> Salir</a>
                </div>
                <div class="col-lg-3" style="margin-top:20px;" class="input-group">
                    <input class="form-control" name="antPass" required type="password" placeholder="Contraseña Actual" style="width:100%;">
                </div>
                <div class="col-lg-3" style="margin-top:20px;" class="input-group">
                    <input class="form-control" name="nuevaPass" required type="password" placeholder="Contraseña Nueva" style="width:100%;">
                </div>
                <div class="col-lg-3" style="margin-top:20px;" class="input-group">
                    <input class="form-control" name="rePass" required type="password" placeholder="Repita Contraseña" style="width:100%;">
                </div>
                <div class="col-lg-1" style="margin-top:20px;" class="input-group">
                    <button class="btn btn-default" type="submit">Enviar</button>
                </div>
            </form>
        </div>
    </body>
</html>
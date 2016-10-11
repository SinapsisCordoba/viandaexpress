<?php
    include 'seguridad.php';
?>
<?php
    if(!empty($_POST)){
        $nombre = seguridadSQL($_POST['txtusuario']);
        $pass = seguridadSQL($_POST['txtpassword']);
        if($nombre=="admin"){
            $sql = "SELECT COUNT(*) AS 'cuenta' FROM `admin` WHERE `usuario` = '" . $nombre  . "' AND `password` = MD5('" . $pass  . "')";
            $url = "admin.php";
            $tipoUsuario = "admin";
        }
        else{
            $sql = ("SELECT COUNT(*) AS 'cuenta' FROM `sucursales` WHERE `id`='" . $nombre  . "' AND `password` = MD5('" . $pass  . "')");
            $url = "verPedidosSucursal.php";
            $tipoUsuario = "sucursal";
        }
        $result = connectarDB($sql);
        $cuenta = $result->fetch_assoc()['cuenta'];
        if(!$cuenta == 1){
            echo "Error: No se autorizó su ingreso.";
        }
        else{
            session_start([
                'cookie_lifetime' => 86400,
            ]);
            $_SESSION['tipo_usuario']  = $tipoUsuario;
            $_SESSION['sucursal']  = $nombre;
            header("Location: " . $url);
            die();
        }
    }
    ?>
    <html>
        <head>
            <title>Login</title>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width'>
            <meta charset="utf-8">
            <link rel="stylesheet" href="css/bootstrap.min.css">
            <link rel="stylesheet" href="css/font-awesome.min.css">
            <script src="js/jquery2.2.0.min.js"></script>
            <script src="js/bootstrap.min.js"></script>
        </head>
        <body>
            <form method='POST'>
                <div class="col-lg-4 col-lg-offset-4" style="text-align:center; margin-top:2%;">
                    <h3>Sistema de Pedidos On-Line!</h3>
                    <br><br>
                    <h3>Vianda Express</h3>
                    <div class="col-lg-12 input-group" style="margin-top:20%;">
                        <label>Seleccione su Nombre de Usuario:</label>
                        <select name="txtusuario" class="form-control">
                            <?php
                                $sql = "SELECT * FROM `admin` WHERE 1";
                                $result = connectarDB($sql);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['usuario'] . "'>" . $row['usuario'] . "</option>";
                                    }
                                }
                                else{echo 'No hay resultados.';}
                                $sql = "SELECT * FROM `sucursales` WHERE 1";
                                $result = connectarDB($sql);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['direccion'] . "</option>";
                                    }
                                }
                                else{echo 'No hay resultados.';}
                           ?>   
                        </select>
                    </div>
                    <div class="col-lg-12 input-group" style="margin-top:10%;">
                        <label>Ingrese su Contraseña:</label>
                        <input type="password" name="txtpassword" class="form-control" required>
                    </div>
                    <div class="col-lg-12 input-group">
                        <button type="submit" class="btn btn-primary" style="width:100%; margin-top:10%;">Ingresar</button>
                    </div>
                </div>
            </form>
        </body>
    </html>
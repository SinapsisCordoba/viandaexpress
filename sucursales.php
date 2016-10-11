<?php
    include 'seguridad.php';
    session_start();
    if(!$_SESSION['tipo_usuario']=="admin"){
        header("Location: login.php");
    }
    date_default_timezone_set('America/Argentina/Cordoba');
?>
<?php
    if(!empty($_POST)){
        $sql;
        if(isset($_POST['direccion'])){
            //foreach ($_POST as $key => $value) {
            //    echo $key . ": " . $value;
            //}
            if($_POST['id-sucursal'] == ""){
                $sql = "INSERT INTO `sucursales`(`direccion`, `password`) VALUES (\"" . $_POST['direccion'] . "\", MD5(\"" . $_POST['password'] . "\"))";
            }
            else{
                $sql = "UPDATE `sucursales` SET `direccion`=\"" . $_POST['direccion'] . "\",`password`=MD5(\"" . $_POST['password'] . "\") WHERE `id`=" . $_POST['id-sucursal'];
            }
        }
        if(isset($_POST['eliminarSucursal'])){
            $sql = "DELETE FROM `sucursales` WHERE `id`=" . $_POST['eliminarSucursal'];
        }
        $result = connectarDB($sql);
    }
?>
<html>
    <head>
        <title>Sucursales</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/datatables.min.css"/>
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <script src="js/jquery2.2.0.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/datatables.min.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
                $('#pedidos').DataTable( {
                    "language": {
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible en esta tabla",
                    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }
            } );
        } );
		</script>
    </head>
    <body>
        <div class="container" style="margin-top:20px; width: 98%;">
            <div class="col-lg-12">
                <div class="col-lg-6" style="margin-bottom:20px;">
                    <a href="admin.php" class="btn btn-danger" style="height:35px;"><i class="fa fa-arrow-left"></i></a>
                    <a href="javascript:void(0)" class="btn btn-primary" onclick="verForm()"><i class="fa fa-plus"></i> Crear Nueva Sucursal</a>
                </div>
                <div class="col-lg-6" style="margin-bottom:20px; display:none;" id="form-sucursales">
                    <form method="post">
                        <div class="col-lg-5">
                            <div class="input-group">
                                <label for="direccion">Dirección</label>
                                <input type="text" class="form-control" placeholder="Ingrese la Dirección" name="direccion" id="direccion" required>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="input-group">
                                <label for="password">Contraseña de Acceso</label>
                                <input type="password" class="form-control" name="password" id="password" required placeholder="Ingrese la Nueva Contraseña">
                            </div>
                        </div>
                        <input type="hidden" id="id-sucursal" name="id-sucursal">
                        <div class="col-lg-2">
                            <div class="input-group">
                                <button type="submit" class="btn btn-primary" style="margin-top:25px;">Enviar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <table class="table table-striped" id="pedidos">
                <thead>
                    <tr>
                        <th>Sucursal Nº</th>
                        <th>Dirección</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT * FROM `sucursales` WHERE 1";
                        $result = connectarDB($sql);
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['direccion']  . "</td>";
                            echo "<td>
                            <form method='post' class='form-inline'>
                            <a href='javascript:void(0)' class='btn btn-success' onclick=\"modificar('" . $row['id'] . "', '" . $row['direccion'] . "')\">Modificar</a>
                            <input type='hidden' name='eliminarSucursal' value='" . $row['id'] . "'>
                            <button type='submit' class='btn btn-danger'>Eliminar</button>
                            <a href='horariosSucursal.php?sucursal=" . $row['id'] . "' class='btn btn-warning'>Modificar</a>
                            </form></td></tr>";
                        }
                   ?>   
                </tbody>
            </table>
        </div>
        <script>
            function verForm() {
                document.getElementById("id-sucursal").value = "";
                document.getElementById("direccion").value = "";
                document.getElementById("password").value = "";
                if (document.getElementById("form-sucursales").style.display == "none"){
                    document.getElementById("form-sucursales").style.display = "block";
                }
                else{
                    document.getElementById("form-sucursales").style.display = "none";
                }
            }
            function modificar(id, direccion){
                document.getElementById("id-sucursal").value = id;
                document.getElementById("direccion").value = direccion;
                document.getElementById("password").value = "";
                document.getElementById("form-sucursales").style.display = "block";
            }
        </script>
    </body>
</html>
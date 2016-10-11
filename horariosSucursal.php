<?php
    include 'seguridad.php';
    session_start();
    if(!$_SESSION['tipo_usuario']=="admin"){
        header("Location: login.php");
    }
?>
<?php
    if(!empty($_POST)){
        $sql;
        if(isset($_POST['horario'])){
            $sql = "INSERT INTO `horarios`(`sucursal`, `horario`) VALUES (\"" . $_GET['sucursal'] . "\", \"" . $_POST['horario'] . "\")";
        }
        if(isset($_POST['eliminarHorario'])){
            $sql = "DELETE FROM `horarios` WHERE `id`=" . $_POST['eliminarHorario'];
        }
        $result = connectarDB($sql);
    }
?>
<html>
    <head>
        <title>Horario de Sucursal</title>
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
                    <a href="sucursales.php" class="btn btn-danger" style="height:35px;"><i class="fa fa-arrow-left"></i></a>
                    <a href="javascript:void(0)" class="btn btn-primary" onclick="verForm()"><i class="fa fa-plus"></i> Crear Nuevo</a>
                </div>
                <div class="col-lg-6" style="margin-bottom:20px; display:none;" id="form-sucursales">
                    <form method="post">
                        <div class="col-lg-5">
                            <div class="input-group">
                                <label for="direccion">Horario</label>
                                <input type="text" class="form-control" placeholder="00:00" name="horario" id="horario" required value="00:00">
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
                        <th>Horario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT * FROM `horarios` WHERE `sucursal`=" . $_GET['sucursal'];
                        $result = connectarDB($sql);
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                            <td>" . mb_strimwidth($row['horario'], 0, 5)  . "</td>";
                            echo "<td>
                            <form method='post' class='form-inline'>
                            <input type='hidden' name='eliminarHorario' value='" . $row['id'] . "'>
                            <button type='submit' class='btn btn-danger'>Eliminar</button>
                            </form></td></tr>";
                        }
                   ?>   
                </tbody>
            </table>
        </div>
        <script>
            function verForm() {
                if (document.getElementById("form-sucursales").style.display == "none"){
                    document.getElementById("form-sucursales").style.display = "block";
                }
                else{
                    document.getElementById("form-sucursales").style.display = "none";
                }
            }
        </script>
    </body>
</html>
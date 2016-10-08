<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php
    // Estados de pedidos posibles:
    // 0 - Espera, 1 - Confirmado/en elaboración, 2 - Para ser entregado
    // 3 - Entregado, 4 - Cancelado
    if(!empty($_POST)){
        $servername = "localhost";
        $username = "root";
        $password = "Uur5ryw5.17";
        $dbname = "viandaexpress";
        $conn = new mysqli($servername, $username, $password, $dbname);
        $conn->set_charset("utf8");
        if(isset($_POST['menu-id'])){
            $sql = "SELECT * FROM `menu` WHERE `id`=" . $_POST['menu-id'];
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()) {
                if((int)$_POST['cant-menus'] <= (int)$row['stock']){
                    $cantTotal = (int)$row['stock'] - (int)$_POST['cant-menus'];
                    $sql = "UPDATE `menu` SET `stock`=" . $cantTotal . " WHERE `id`=" . $_POST['menu-id'];
                    $resultado = $conn->query($sql);
                    $total = (float)$_POST['cant-menus']*(float)$row['precio'];
                    $sql = "INSERT INTO `ventasAdicionales`(`total`, `cantMenus`) VALUES (\"" . $total . "\",\"" . $_POST['cant-menus'] . "\")";
                    $resultado = $conn->query($sql);
                }
                else{echo "<script>alert(Error: Stock insuficiente para la venta);</script>";}
            }
        }
        else{
            if(isset($_POST['preparacion'])){
                $estadoNuevo = 1;
            }
            if(isset($_POST['entregar'])){
                $estadoNuevo = 2;
            }
            if(isset($_POST['entregado'])){
                $estadoNuevo = 3;
            }
            if(isset($_POST['cancelar'])){
                $estadoNuevo = 4;
            }
            $sql = "UPDATE `pedido` SET `estado` = " . $estadoNuevo . " WHERE `id`= " . $_POST['pedido'];
            $result = $conn->query($sql);
        }
        $conn->close();
    }
?>
<html>
    <head>
        <title>Pedidos</title>
        <meta charset="utf-8">
<!--        <meta http-equiv="refresh" content="10">-->
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
                });
            });
		</script>
    </head>
    <body>
        <div class="col-lg-12">
            <div class="col-lg-6" style="margin-bottom:20px;">
                <a href="javascript:void(0)" class="btn btn-primary" onclick="verForm()"><i class="fa fa-plus"></i> Nueva Venta Por Mostrador</a>
            </div>
            <div class="col-lg-6" id="venta-mostrador" style="display:none;">
                <form method="post" class="form-inline">
                    <div class="col-lg-5 input-group">
                        <label>Menú Vendido Por Mostrador:</label>
                        <select name="menu-id" class="form-control">
                            <?php
                                $servername = "localhost";
                                $username = "root";
                                $password = "Uur5ryw5.17";
                                $dbname = "viandaexpress";
                                $conn = new mysqli($servername, $username, $password, $dbname);
                                $sql = "SELECT * FROM `menu` WHERE DATE(`fecha`)=CURDATE()";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . " (Stock: " . $row['stock'] . ")</option>";
                                    }
                                }
                                else{echo 'No hay resultados.';}
                           ?>   
                        </select>
                    </div>
                    <div class="col-lg-5 input-group">
                        <label>Cantidad:</label>
                        <input type="text" name="cant-menus" class="form-control">
                    </div>
                        <button type="submit" class="btn btn-primary" style="margin-top:25px;">Enviar</button>
                </form>
            </div>
        </div>
        <div class="container" style="margin-top:20px; width: 98%;">
            <table class="table table-striped" id="pedidos">
                <thead>
                    <tr>
                        <th>Marca Temporal</th>
                        <th>Pedido Nº</th>
                        <th>Cliente</th>
                        <th>Pedido</th>
                        <th>¿Envío?</th>
                        <th>Hora</th>
                        <th>Total</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $servername = "localhost";
                        $username = "root";
                        $password = "Uur5ryw5.17";
                        $dbname = "viandaexpress";
                        $conn = new mysqli($servername, $username, $password, $dbname);
                        $conn->set_charset("utf8");
                        $sql = "SELECT `id`, `total`, `cliente_nombre`, `cliente_telefono`, `cliente_direccion`, `cliente_email`, `envio`, `pedido`, `cantidad_menus`, `hora`, `estado`, TIME(`marca_temporal`) FROM `pedido` WHERE DATE(`marca_temporal`) = CURDATE() ORDER BY `marca_temporal` DESC ";
                        $result = $conn->query($sql);
                        while($row = $result->fetch_assoc()) {
                            $envio = "No";
                            if($row['envio'] == 1){$envio = "Sí";}
                            echo "<tr>
                            <td>" . mb_strimwidth($row['TIME(`marca_temporal`)'], 0, 5) . "</td>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['cliente_nombre'] . "<br />" . $row['cliente_direccion'] . "<br />" . $row['cliente_telefono'] . "</td>
                            <td>
                                " . str_replace("\n","<br />",$row['pedido']) . "
                            </td>
                            <td>" . $envio . "</td>
                            <td>" . mb_strimwidth($row['hora'], 0, 5) . "</td>
                            <td>$ " . $row['total'] . "</td>";
                            if($row['estado']==0){
                                $estado = "Esperando Confirmación...</p>
                                <button type='submit' name='preparacion' class='btn btn-warning' style='margin-right:10px;'>En Preparación</a>
                                <button type='submit' name='cancelar' class='btn btn-danger'>Cancelar</a>";
                            }
                            if($row['estado']==1){
                                $estado = "En preparación...</p>
                                <button type='submit' name='entregar' class='btn btn-primary' style='margin-right:10px;'>Para Entregar</a>
                                <button type='submit' name='cancelar' class='btn btn-danger'>Cancelar</a>";
                            }
                            if($row['estado']==2){
                                $estado = "Listo P/Entrega</p>
                                <button type='submit' name='entregado' class='btn btn-success' style='margin-right:10px;'>Entregado</a>
                                <button type='submit' name='cancelar' class='btn btn-danger'>Cancelar</a>";
                            }
                            if($row['estado']==3){
                                $estado = "Entregado</p>";
                            }
                            if($row['estado']==4){
                                $estado = "Cancelado</p>";
                            }
                            echo "<td>
                            <form method='post' class='form-inline'><input type='hidden' name='pedido' value='" . $row['id'] . "'><p>" . $estado . "</form></td></tr>";
                        }
                   ?>   
                </tbody>
            </table>
        </div>
        <script>
            function verForm() {
                if (document.getElementById("venta-mostrador").style.display == "none"){
                    document.getElementById("venta-mostrador").style.display = "block";
                }
                else{
                    document.getElementById("venta-mostrador").style.display = "none";
                }
            }
        </script>
    </body>
</html>
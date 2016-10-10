<?php
    include 'seguridad.php';
?>
<?php
    function createDateRangeArray($strDateFrom,$strDateTo){
        $aryRange=array();
        $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2), substr($strDateFrom,8,2),substr($strDateFrom,0,4));
        $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));
        if ($iDateTo>=$iDateFrom){
            array_push($aryRange,date('Y-m-d',$iDateFrom));
            while ($iDateFrom<$iDateTo){
                $iDateFrom+=86400;
                array_push($aryRange,date('Y-m-d',$iDateFrom));
            }
        }
        return $aryRange;
    }
    $sucursal;
    if(!empty($_POST)){
        $sql;
        if(isset($_POST['fechaI']) && isset($_POST['fechaF'])){
            $fechaInicio = strftime("%Y-%m-%d", strtotime(str_replace('/', '-', $_POST['fechaI'])));
            $fechaFinal = strftime("%Y-%m-%d", strtotime(str_replace('/', '-', $_POST['fechaF'])));
            $sql = "SELECT * FROM `pedido` WHERE DATE(`marca_temporal`) BETWEEN '" . $fechaInicio . "' AND '" . $fechaFinal;
            $sucursal = $_POST['sucursal'];
            if(!$sucursal == '-'){
                $sql .= "' AND `sucursal`=" . $sucursal;
            }
            $fechas = createDateRangeArray($fechaInicio,$fechaFinal);
        }
    }
    else{
        $sql = "SELECT * FROM `pedido` WHERE DATE(`marca_temporal`)=CURDATE()";
        $fechaInicio = date("Y-m-d");
        $fechaFinal = date("Y-m-d");
        $fechas = createDateRangeArray($fechaInicio,$fechaFinal);
    }
    $result = connectarDB($sql);
    $fechaInicio = strftime("%d/%m/%Y", strtotime(str_replace('/', '-', $fechaInicio)));
    $fechaFinal = strftime("%d/%m/%Y", strtotime(str_replace('/', '-', $fechaFinal)));
?>
<html>
    <head>
        <title>Ventas</title>
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
            <div class="col-lg-12" style="margin-bottom:20px;">
                <form method="post">
                    <div class="col-lg-1">
                        <a href="admin.php" class="btn btn-danger" style="height:35px; margin-top:25px;"><i class="fa fa-arrow-left"></i></a>
                    </div>
                    <div class="col-lg-3">
                        <div class="input-group">
                            <label for="fecha">Desde</label>
                            <input type="date" class="form-control" name="fechaI" required placeholder="01/01/2000" value="<?php echo $fechaInicio; ?>">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="input-group">
                            <label for="fecha">Hasta</label>
                            <input type="date" class="form-control" name="fechaF" required placeholder="01/01/2000" value="<?php echo $fechaFinal; ?>">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <label for="fecha">Sucursal</label>
                        <div class="input-group" style="width:100%;">
                            <select name="sucursal" class="form-control" style="width:100%;">
                                <?php
                                    $select = "<option value='-'";
                                    if($sucursal == "-"){
                                        $select .= " selected ";
                                    }
                                    $select .= ">Todas</option>";
                                    $sql = "SELECT * FROM `sucursales` WHERE 1";
                                    $result = connectarDB($sql);
                                    while($row = $result->fetch_assoc()) {
                                        $select .= "<option value='" . $row['id'] . "'";
                                        if($sucursal == $row['id']){
                                            $select .= " selected ";
                                        }
                                        $select .= ">" . $row['direccion'] . "</option>";
                                    }
                                    echo $select;
                               ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <div class="input-group">
                            <button type="submit" class="btn btn-primary" style="margin-top:25px;">Cargar</button>
                        </div>
                    </div>
                </form>
            </div>
            <table class="table table-striped" id="pedidos">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Cantidad de Pedidos</th>
                        <th>Cantidad de Menús</th>
                        <th>Dinero Equivalente</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>05/10/2016</td>
                        <td>5</td>
                        <td>15</td>
                        <td>$1500.00</td>
                    </tr>
                    <tr>
                        <td>05/10/2016</td>
                        <td>5</td>
                        <td>15</td>
                        <td>$1500.00</td>
                    </tr>
                    <tr>
                        <td>05/10/2016</td>
                        <td>5</td>
                        <td>15</td>
                        <td>$1500.00</td>
                    </tr>
                    <tr>
                        <td>05/10/2016</td>
                        <td>5</td>
                        <td>15</td>
                        <td>$1500.00</td>
                    </tr>
                    <tr>
                        <td>05/10/2016</td>
                        <td>5</td>
                        <td>15</td>
                        <td>$1500.00</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td><b>Total</b></td>
                        <td><b>25</b></td>
                        <td><b>75</b></td>
                        <td><b>$7500.00</b></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </body>
</html>
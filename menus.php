<html>
    <head>
        <title>Menus</title>
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
                <div class="col-lg-2" style="margin-bottom:20px;">
                    <a href="javascript:void(0)" class="btn btn-primary" onclick="verForm()"><i class="fa fa-plus"></i> Crear Nuevo Menú</a>
                </div>
                <div class="col-lg-10" style="margin-bottom:20px; display:none;" id="form-menus">
                    <form method="post">
                        <div class="col-lg-3">
                            <div class="input-group">
                                <label for="direccion">Nombre</label>
                                <input type="text" class="form-control" placeholder="Ingrese el Nombre" name="nombre" id="nombre" required>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="input-group">
                                <label for="fecha">Fecha</label>
                                <input type="text" class="form-control" name="fecha" id="fecha" required placeholder="Ingrese la Fecha" value="5/10/2016">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <label for="fecha">Precio</label>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">$</span>
                                <input type="text" class="form-control" name="precio" id="precio" required placeholder="0.00" value="0.00" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="input-group">
                                <label for="fecha">Stock</label>
                                <input type="number" class="form-control" name="stock" id="stock" required placeholder="Stock" value="0">
                            </div>
                        </div>
                        <input type="hidden" id="id-menu" name="id-menu">
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
                        <th>Nombre</th>
                        <th>Fecha</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Milanesa</td>
                        <td>22/09/2016</td>
                        <td>$ 50,00</td>
                        <td>300</td>
                        <td>
                            <form method="post" class="form-inline">
                                <a href="javascript:void(0)" class="btn btn-success" onclick="modificar('1', 'Milanesa', '22/09/2016', '50.00', '300')">Modificar</a>
                                <input type="hidden" name="eliminarMenu" value="1">
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <script>
            function verForm() {
                document.getElementById("id-menu").value = "";
                document.getElementById("nombre").value = "";
                document.getElementById("fecha").value = "5/10/2016";
                document.getElementById("precio").value = "0.00";
                document.getElementById("stock").value = "0";
                if (document.getElementById("form-menus").style.display == "none"){
                    document.getElementById("form-menus").style.display = "block";
                }
                else{
                    document.getElementById("form-menus").style.display = "none";
                }
            }
            function modificar(id, nombre, fecha, precio, stock){
                document.getElementById("id-menu").value = id;
                document.getElementById("nombre").value = nombre;
                document.getElementById("fecha").value = fecha;
                document.getElementById("precio").value = precio;
                document.getElementById("stock").value = stock;
                document.getElementById("form-menus").style.display = "block";
            }
        </script>
    </body>
</html>
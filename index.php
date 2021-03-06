<?php
    include 'seguridad.php';
?>
<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
date_default_timezone_set('America/Buenos_Aires');
?>
<?php
    $exito = 0;
    if(!empty($_POST)){
        $sucursal = seguridadSQL($_POST['sucursal']);
        $cliente_nombre = seguridadSQL($_POST['nombre']);
        $cliente_telefono = seguridadSQL($_POST['telefono']);
        $cliente_direccion = seguridadSQL($_POST['direccion']);
        $cliente_email = seguridadSQL($_POST['email']);
        $pedido = seguridadSQL($_POST['pedidoStr']);
        $hora = seguridadSQL($_POST['hora']);
        $envio = 0;
        if(isset($_POST['envio'])){
            $envio = 1;
        }
        $sql = "SELECT * FROM menu where DATE(`fecha`)=CURDATE()";
        $result = connectarDB($sql);
        $k = 1;
        $stockSuficiente = 0;
        $cantidadMenuTotal = 0;
        $precio = 0;
        while($row = $result->fetch_assoc()) {
            $menuName = 'menu' . $k;
            if((int)$row['stock'] >= (int)$_POST[$menuName]){
                $cantidadMenuTotal += $_POST[$menuName];
                $precio += (seguridadSQL($_POST[$menuName]) * $row['precio']);
            }
            else{
                $stockSuficiente = 1;
            }
            $k++;
        }
        if($stockSuficiente == 0){
            if($cantidadMenuTotal == 0){
                echo "<script>alert('Error: No ha seleccionado ningún producto.');</script>";
            }
            else{
                if($_POST['hora'] > date('H:i')){
                    $k = 1;
                    while($row = $result->fetch_assoc()) {
                        $menuName = 'menu' . $k;
                        $nuevoStock = (int)$row['stock'] - (int)seguridadSQL($_POST[$menuName]);
                        $sql = "UPDATE `menu` SET `stock` = " . $nuevoStock . " WHERE `id` = " . seguridadSQL($_POST[$menuName]);
                        $result = connectarDB($sql);
                        $k++;
                    }
                    $sql = "INSERT INTO pedido (sucursal, total, cliente_nombre, cliente_telefono, cliente_direccion, cliente_email, envio, pedido, cantidad_menus, hora) VALUES ($sucursal, $precio, '$cliente_nombre', '$cliente_telefono', '$cliente_direccion', '$cliente_email', $envio, '$pedido', $cantidadMenuTotal, '$hora')";
                    $conexion = connectarDB($sql);
                    if ($conexion === TRUE) {
                        $exito = 1;
                        $sql = "SELECT MAX(`id`) AS 'id' FROM `pedido` WHERE 1";
                        $last_id = connectarDB($sql);
                    } else {
                        echo "Error: Ha ocurrido un error interno del servidor. Vuelva a intentarlo o espere e inténtelo mas tarde.";
                    }
                }
                else{
                    echo "<script>alert('Error: La hora seleccionada ya ha transcurrido. " . date('H:i') . " ');</script>";
                }
            }
        }
        else{
            echo "<script>alert('Error: Stock insuficiente.');</script>";
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
       <base target="_top">
       <meta charset="utf-8">
       <title>Nuevo Pedido</title> 
       <meta name="viewport" content="width=device-width, initial-scale=1.0" />
       <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        
       <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
       <link rel="stylesheet" href="css/materialize.min.css">
        
       <script src="js/jquery2.2.0.min.js"></script>
       <script src="js/materialize.min.js"></script>
       <script src="https://apis.google.com/js/api.js?onload=onApiLoad"></script>
  </head>
  <body style="background:#eeeeee;">
      
      <?php
      if($exito == 1){
          echo "<div id='modal1' class='modal'>
              <div class='modal-content'>
                  <h4 style='color:green;'>Pedido Confirmado!</h4>
                  <p><b>Atención: </b> Recibirá un correo electrónico para confirmar su pedido y luego otro cuando se termine de preparar y esté listo para retirar/enviar.</p>
                  <h3>Su número de pedido es: " . $last_id->fetch_assoc()['id'] . "</h3>
              </div>
              <div class='modal-footer'>
                <a href='#!' class='modal-action modal-close waves-effect waves-light btn green'>Ok!</a>
              </div>
          </div>
          <script>
              $('#modal1').openModal();
          </script>";
      }
      ?>
    
    <form method="post" class="main" id="form" style="max-width: 400px;margin: 40px auto;" accept-charset="utf-8">
       <div id="forminner">
          <div class="row">
            <div class="col s12">
              <h5 class="center-align teal-text" style="color:#DB4437!important;">Cargar Pedido On-Line!</h5>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12">
              <input id="nombre" type="text" name="nombre" required="" aria-required="true">
              <label for="nombre">Nombre y Apellido</label>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12">
              <input id="telefono" type="text" name="telefono" required="" aria-required="true">
              <label for="telefono">Teléfono</label>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12">
              <input id="direccion" type="text" name="direccion" required="" aria-required="true">
              <label for="direccion">Dirección</label>
            </div>
          </div>
           
           <div class="row">
               <p style="text-align:justify;"><b>Atención: </b> Recibirá un correo electrónico para confirmar su pedido y luego otro cuando se termine de preparar y esté listo para retirar/enviar.</p>
            <div class="input-field col s12">
              <input id="email" type="email" name="email" required="" aria-required="true">
              <label for="email">E-mail</label>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12">
              <input id="envio" type="checkbox" name="envio" aria-required="true">
              <label for="envio">¿Desea Envío a Domicilio?</label>
            </div>
          </div>
           
           <div class="row" style="margin-top:50px;">
               Sucursal:
                <div class="input-field col s12">
                  <select id="sucursal" name="sucursal" onchange="getHorarios()">
           <?php
                $sql = "SELECT * FROM `sucursales` WHERE 1";
                $result = connectarDB($sql);
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['direccion'] . "</option>";
                }
           ?>
                  </select>
                </div>
          </div>
           
           <div class="row" >
            Hora Aproximada (Envío o Retiro)
            <div class="input-field col s12">
              <select id="hora" name="hora" class="browser-default" required></select>
            </div>
          </div>
           
        <?php
        $sql = "SELECT * FROM menu where DATE(`fecha`)=CURDATE()";
        $result = connectarDB($sql);

        if ($result->num_rows > 0) {
            $i = 1;
            $scriptPedido = "";
            $scriptPrecio = "";
            while($row = $result->fetch_assoc()) {
                $opciones = "";
                for ($j = 0; $j <= $row['stock']; $j++) {
                    $opciones .= "<option value='" . $j . "'>" . $j . "</option>\n";
                }
                echo "<div class='row'>
                        Menú " . $i . ": " . $row['nombre'] . " $" . $row['precio'] . 
                        "<div class='input-field col s12'>
                          <select id='menu" . $i . "' name='menu" . $i . "' onchange='cargarPedido()' data-menu='" . $row['nombre'] . "' data-precio='" . $row['precio'] . "'>"
                            . $opciones .
                          "</select>
                        </div>
                      </div>";
                $scriptPedido .= "pedido += '- ';
                pedido += document.getElementById('menu" . $i . "').value + ' ';
                pedido += $('#menu" . $i . "').attr('data-menu') + ': $';
                pedido += (parseFloat($('#menu" . $i . "').attr('data-precio')) * parseFloat(document.getElementById('menu" . $i . "').value));
                pedido += '\\n';";
                $scriptPrecio .= "
                precioTotal += (parseFloat($('#menu" . $i . "').attr('data-precio')) * parseFloat(document.getElementById('menu" . $i . "').value));\n";
                $i++;
            }
        }          
            else {
                echo "No hay Resultados de menús para el día de hoy.";
        }
        ?> 
           
        <h5 class="center-align teal-text" style="color:#DB4437!important;">Confirme su Pedido</h5>
          <div class="row">
            <div class="input-field col s12">
              <textarea id="pedidoStr" name="pedidoStr" class="materialize-textarea" required readonly style="height:100px;"></textarea>
                <label for="total">Menus:</label>
            </div>
        </div>
           
           <div class="row">
            <div class="input-field col s12">
              <input id="total" type="text" readonly>
              <label for="total">Precio Total: $</label>
            </div>
          </div>

           <div class="row">
              <div class="input-field col s6">
                <button class="waves-effect waves-light btn submit-btn" style="background-color:#DB4437;" type="submit">Enviar</button>
              </div>   
           </div>
      </div>
    </form>
    <script>
        $(document).ready(function() {
            $('select').material_select();
            cargarPedido();
            getHorarios();
        });
        
        function cargarPedido() {
            <?php
            echo "var pedido = '';";
            echo $scriptPedido;
            
            echo "document.getElementById('pedidoStr').value = pedido;";
            
            echo "var precioTotal = 0.00;";
            echo $scriptPrecio;
            
            echo "document.getElementById('total').value = precioTotal.toFixed(2);";
            ?>
        }
        
        function readTextFile(file, callback) {
            var rawFile = new XMLHttpRequest();
            rawFile.overrideMimeType("application/json");
            rawFile.open("GET", file, true);
            rawFile.onreadystatechange = function() {
                if (rawFile.readyState === 4 && rawFile.status == "200") {
                    callback(rawFile.responseText);
                }
            }
            rawFile.send(null);
        }
        
        function getHorarios(){
            var sucursal = document.getElementById('sucursal');
            <?php
            echo "var url = 'http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "horarios.php?suc=' + sucursal.value;";
            ?>
            readTextFile(url, function(text){
                var data = JSON.parse(text);
                $("#hora").empty();
                var arrayLength = data.length;
                for (var i = 0; i < arrayLength; i++) {
                    $('#hora').append('<option value="' + data[i] + '">' + data[i] + '</option>').val('whatever');
                }
            });
        }
    </script>
  </body>
</html>
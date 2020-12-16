<?php
   //session_start();
    include('includes/conexion.php');
   include('includes/sesion.php');
    if (!$_SESSION['user_name']) {
        header('location: index.php');
    }
    $result=mysqli_query($con, "select * from fact_users where user_name='$user_name'")or die('Error en la sesion');
    $products=mysqli_query($con, "select * from fact_products ")or die('Error en la sesion');

    $row=mysqli_fetch_array($result);
    //$num_row = mysqli_num_rows($row);

    //$users_row=mysqli_fetch_array($users);

         if (isset($_GET['client_dni']) ) {
            $dni=$_GET['client_dni'];
            $client=mysqli_query($con, "select * from fact_clients where client_dni='$dni'")or die('Error en la sesion');
            $row_client=mysqli_fetch_array($client);


         }
      ?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="assets/bootstrap4/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
      integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
      crossorigin="anonymous" />
   <title>Facturacion Electronica</title>
</head>

<body>
   <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="menu_p.php">Stalin Ochoa</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
         aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarText">
         <ul class="navbar-nav mr-auto">
            <li class="nav-item ">
               <a class="nav-link" href="menu_user.php">Usuarios </a>
            </li>
            <li class="nav-item ">
               <a class="nav-link" href="registra_cliente.php">Clientes </a>
            </li>
            <li class="nav-item ">
               <a class="nav-link" href="registra_producto.php">Productos </a>
            </li>
            <li class="nav-item active">
               <a class="nav-link" href="verifica_cliente.php">Facturacion Electronica</a>
            </li>
            <li class="nav-item">
        <a class="btn btn-primary" href="facturas.php">Listar Facturas</a>
      </li>

         </ul>
         <span class="navbar-text">
            Bienvenido
            <?php echo $row['user_name']; ?>
         </span>
         <a class="btn btn-outline-danger btn-sm ml-4" href="functions/logout.php">Salir</a>

      </div>
   </nav>
   <div class="container-fluid p-5">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
         <li class="nav-item" role="presentation">
            <a class="nav-link active" id="factura-tab" data-toggle="tab" href="#factura" role="tab"
               aria-controls="home" aria-selected="true">GENERAR FACTURA</a>
         </li>
         <li class="nav-item" role="presentation">
            <a class="nav-link" id="consulta-tab" data-toggle="tab" href="#consulta" role="tab" aria-controls="profile"
               aria-selected="false">CONSULTAR FACTURA POR NUMERO</a>
         </li>
         <li class="nav-item" role="presentation">
            <a class="nav-link" id="cliente-tab" data-toggle="tab" href="#cliente" role="tab" aria-controls="cliente"
               aria-selected="false">CONSULTAR FACTURA POR CLIENTE</a>
         </li>
         <li class="nav-item" role="presentation">
            <a class="nav-link" id="regresar-tab" href="verifica_cliente.php" aria-controls="regresar"
               aria-selected="false">REGRESAR</a>
         </li>
      </ul>
      <br>
      <div class="tab-content" id="myTabContent">
         <div class="tab-pane fade show active" id="factura" role="tabpanel" aria-labelledby="factura-tab">
            <h3>Generacion de factura</h3>
            <input type="hidden" id="client_id" name="client_id" value="<?php echo $row_client['client_id']; ?>">
            <input type="hidden" id="client_dni" name="client_dni" value="<?php echo $row_client['client_dni']; ?>">
            <input type="hidden" id="user_id" name="user_id" value="<?php echo $row['user_id']; ?>">
            <div class="row">
               <div class="col-sm-6">
                  <table class="table table-striped table-hover table-sm">
                     <thead>
                        <tr>
                           <th>Cliente</th>
                           <th>Cedula</th>
                           <th>Direccion</th>
                           <th>Telefono</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <td>
                              <?php echo strtoupper($row_client['client_name'].' '.$row_client['client_surname']); ?>
                           </td>
                           <td>
                              <?php echo $row_client['client_dni']; ?>
                           </td>
                           <td>
                              <?php echo $row_client['client_address']; ?>
                           </td>
                           <td>
                              <?php echo $row_client['client_phone']; ?>
                           </td>
                        </tr>

                     </tbody>
                  </table>
               </div>
               <div class="col-sm-6">
                  <div class="form-group">
                     <label for="exampleFormControlSelect1">Productos</label>
                     <select class="form-control" id="product" name="product" onchange="buscarArticulo();">
                        <option value="">Seleccione un producto</option>
                        <?php 
                                    foreach ($products as $pro) { ?>
                        <option value="<?php echo $pro['product_id'];?>">
                           <?php echo $pro['product_description'].' ($'.$pro['product_price'].')';?>
                        </option>
                        <?php  } ?>

                     </select>
                  </div>
               </div>
            </div>
            <br>

            <div class="row">
               <div class="col-sm-12 ">
                  <div class="table-responsive text-xs">
                     <table class="table table-striped table-sm" id="tablaAgregarArticulos">
                        <thead>
                           <tr class="bg-primary text-white">
                              <th></th>
                              <th>CODIGO</th>
                              <th>PRODUCTO</th>
                              <th style="width: 10%;">CANTIDAD</th>
                              <th>P. UNIT</th>
                              <th>VALOR</th>
                           </tr>
                        </thead>
                        <tbody>

                        </tbody>
                     </table>
                  </div>

               </div>
            </div>
            <hr>
            <div class="row text-xs">
               <div class="col-sm-9"></div>
               <div class="col-sm-3 ">
                  <div class="form-group row my-2">
                     <label for="sub_total" class="col-sm-6 col-form-label"><strong>SUBTOTAL:</strong></label>
                     <div class="col-sm-6">
                        <div class="input-group">
                           <div class="input-group-prepend">
                              <span class="input-group-text "><i class="fas fa-dollar-sign text-xs"></i></span>
                           </div>
                           <input type="text" id="sub_total"
                              class="form-control form-control-sm bg-white text-xs  font-weight-bold" disabled
                              name="sub_total" required value="0">
                        </div>
                     </div>
                  </div>
                  <div class="form-group row my-2">
                     <label for="impuesto" class="col-sm-6 col-form-label"><strong>IVA:</strong></label>
                     <div class="col-sm-6">
                        <div class="input-group">
                           <div class="input-group-prepend">
                              <span class="input-group-text "><i class="fas fa-dollar-sign text-xs"></i></span>
                           </div>
                           <input type="text" id="impuesto"
                              class="form-control form-control-sm bg-white text-xs font-weight-bold" disabled
                              name="impuesto" required value="0">

                        </div>
                     </div>
                  </div>
                  <div class="form-group row my-2">
                     <label for="total" class="col-sm-6 col-form-label"><strong>TOTAL:</strong></label>
                     <div class="col-sm-6">
                        <div class="input-group">
                           <div class="input-group-prepend">
                              <span class="input-group-text "><i class="fas fa-dollar-sign text-xs"></i></span>
                           </div>

                           <input type="text" disabled id="total"
                              class="form-control form-control-sm bg-white text-xs font-weight-bold" name="total"
                              required value="0">
                        </div>
                     </div>
                  </div>
                  <div class="form-group row pt-4">
                     <div class="col-sm-12">
                        <button type="button" id="btnRealizaVenta" class="btn btn-success  btn-block"
                           onclick="realizaFactura();">
                           <span class="text">REALIZAR VENTA</span>
                        </button>
                     </div>
                  </div>
               </div>
            </div>
         </div>



         <div class="tab-pane fade" id="consulta" role="tabpanel" aria-labelledby="consulta-tab">
            <h3>Busqueda de factura por numero</h3>
               <div class="row">
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for="exampleInputEmail1">Busqueda de factura por numero</label>
                        <div class="input-group">
                           <input type="text" class="form-control" id="invoice_id" name="invoice_id" required  pattern="[0-9]+" 
                           placeholder="Ingrese un numero de factura que se pretende buscar">
                           <div class="input-group-append">
                              <button type="button" class="btn btn-primary" name="findClient" onclick="buscarFacturaPorNumero()">Verificar</button>
                           </div>
                        </div>
            
                     </div>
                  </div>
               </div>
               <div id="dataFactura"></div>
         </div>
         <div class="tab-pane fade" id="cliente" role="tabpanel" aria-labelledby="cliente-tab">
            <h3>Busqueda de factura por cliente</h3>
            <div class="row">
               <div class="col-sm-6">
                  <div class="form-group">
                     <label for="exampleInputEmail1">Busqueda de factura por Cedula o nombres de cliente</label>
                     <div class="input-group">
                        <input type="text" class="form-control" id="client" name="client" required 
                           placeholder="Ingrese un numero de cedula o nombres">
                        <div class="input-group-append">
                           <button type="button" class="btn btn-primary" name="findClient"
                              onclick="buscarFacturaPorCliente()">Verificar</button>
                        </div>
                     </div>
            
                  </div>
               </div>
            </div>
            <div id="dataFacturaClient"></div>
         </div>
      </div>
   </div>





   <script src="assets/jquery/jquery-3.5.1.slim.min.js"></script>
   <script src="assets/popper/popper.min.js"></script>
   <script src="assets/bootstrap4/js/bootstrap.bundle.min.js"></script>
   <script>
      $(document).ready(function () {
         setTimeout(function () {
            $(".alert").alert('close');
         }, 2000);
      });
      var subTotal = 0;
      var iva = 0;
      var arrayProductos = {};
      function buscarFacturaPorCliente() {
            var dir = $('#dir').val();
            var client = $('#client').val();
            //console.log(codigoEscaneado)
            if ((!client == "")) {
               $.ajax(
                  {
                     dataType: "html",
                     type: "POST",
                     url: "invoice/findByClient.php", // ruta donde se encuentra nuestro action que procesa la peticion XmlHttpRequest
                     data: "client=" + client, //Se añade el parametro de busqueda del medico
                     beforeSend: function (data) {

                     },
                     success: function (requestData) {//armar la tabla
                        //var data = requestData.data;
                        console.log(requestData)
                        if (requestData) {
                           $('#dataFacturaClient').html(requestData);
                        } else {

                        }

                     },
                     error: function (requestData, strError, strTipoError) {
                        console.error('error')
                     },
                     complete: function (requestData, exito) {
                     }
                  });

            } else {
               alert('Debe ingresar un numero de factura');
            }
         }
      function buscarFacturaPorNumero() {
            var dir = $('#dir').val();
            var invoice_id = $('#invoice_id').val();
            //console.log(codigoEscaneado)
            if ((!invoice_id == "")) {
               $.ajax(
                  {
                     dataType: "html",
                     type: "POST",
                     url: "invoice/findByNumber.php", // ruta donde se encuentra nuestro action que procesa la peticion XmlHttpRequest
                     data: "invoice_id=" + invoice_id, //Se añade el parametro de busqueda del medico
                     beforeSend: function (data) {

                     },
                     success: function (requestData) {//armar la tabla
                        //var data = requestData.data;
                        console.log(requestData)
                        if (requestData) {
                           $('#dataFactura').html(requestData);
                        } else {

                        }

                     },
                     error: function (requestData, strError, strTipoError) {
                        console.error('error')
                     },
                     complete: function (requestData, exito) {
                     }
                  });

            }else{
               alert('Debe ingresar un numero de factura');
            }
         }
      function buscarArticulo() {
         var dir = $('#dir').val();
         var product = $('#product').val();
         //console.log(codigoEscaneado)
         if ((!product == "")) {
            $.ajax(
               {
                  dataType: "json",
                  type: "POST",
                  url: "products/find.php", // ruta donde se encuentra nuestro action que procesa la peticion XmlHttpRequest
                  data: "product=" + product, //Se añade el parametro de busqueda del medico
                  beforeSend: function (data) {

                  },
                  success: function (requestData) {//armar la tabla
                     //var data = requestData.data;
                     //console.log(requestData)
                     if (requestData) {
                        console.log(requestData)
                        agregarArticulo(requestData);
                     } else {

                     }

                  },
                  error: function (requestData, strError, strTipoError) {
                     console.error('error')
                  },
                  complete: function (requestData, exito) {
                  }
               });

         }
      }
      function agregarArticulo(articulo) {
         if ($('#addId_' + articulo.product_id).length) { // si ya esta agregado advierto
            alert('El articulo ya se encuentra agregado!')
         } else { // si es nuevo agrego
            var tr = '';
            var btnEliminar = '<button type="button" id="proId_' + articulo.product_id + '" class="btn btn-danger btn-xs " onclick="eliminaArticulo(' + articulo.product_id + ');"><i class="fas fa-times "></i></button>';
            var inputId = '<input type="hidden" id="addId_' + articulo.product_id + '" value="' + articulo.product_id + '" />';
            var inputCantidad = '<input type="number" min="1"  step="1" class="form-control form-control-sm" id="addCant_' + articulo.product_id + '" value="1" onchange="cantxprecio(' + articulo.product_id + ',' + articulo.product_price + ');" />';
            //var inputStock = '<input type="hidden" id="proStock_' + articulo.pro_id + '" value="' + articulo.pro_stock + '" />';
            var inputTipo = '<input type="hidden" id="proImp_' + articulo.product_id + '" value="12" />';
            // var inputControl = '<input type="hidden" id="proControl_' + articulo.pro_id + '" value="' + articulo.control_stock + '" />';

            tr += '<tr>';
            tr += '<td>' + btnEliminar + inputId + inputTipo + '</td>';
            tr += '<td>' + articulo.product_id + '</td>';
            tr += '<td>' + articulo.product_description + '</td>';
            //tr += '<td><span class="badge badge-counter badge-dark text-xxs">' + articulo.pre_descripcion + '</span>&nbsp;<span class="badge badge-counter badge-dark text-xxs">' + articulo.modelo.toUpperCase() + '</span>&nbsp;<span class="badge badge-counter badge-dark text-xxs">' + articulo.color +'</span></td>';
            tr += '<td>' + inputCantidad + '</td>';
            tr += '<td  class="text-xs font-weight-bold">' + articulo.product_price + '</td>';
            tr += '<td id="addSub_' + articulo.product_id + '" class="text-xs font-weight-bold">' + articulo.product_price + '</td>';
            tr += '</tr>';
            $('#tablaAgregarArticulos tbody').append(tr);
            reCalcula(articulo.product_id, articulo.product_price);


         }

      }
      function reCalcula(pro_id, precioU) {
         //console.log(array)
         var precio = 0.0, cant = 0, value = 0;
         var total = $('#total').val();
         var tipo_impuesto = $('#proImp_' + pro_id).val();
         subTotal = 0;
         var iva = $('#impuesto').val();
         subTotal = parseFloat(subTotal);
         total = parseFloat(total);
         precioU = parseFloat(precioU);
         iva = parseFloat(iva);
         tipo_impuesto = parseInt(tipo_impuesto);

         cant = $('#addCant_' + pro_id).val();
         cant = parseFloat(cant);

         //precioU = $('#addSub_' + pro_id).text();
         precio = cant * precioU;

         //arrayPrecio[pro_id] = precio;
         arrayProductos[pro_id] = { 'cant': cant, 'precio': precio };

         // recorreo el JSON de objetos de acuerdo al producto ID
         for (pro_id in arrayProductos) {
            // Controlando que json realmente tenga esa propiedad
            if (arrayProductos.hasOwnProperty(pro_id)) {
               // Mostrando en pantalla la clave junto a su valor
               console.log(`Producto: ${pro_id}
Cant: ${arrayProductos[pro_id].cant}
Precio: ${arrayProductos[pro_id].precio}`);

               value = arrayProductos[pro_id].precio;
               subTotal += value;
               value = (Math.round(value * 100) / 100).toFixed(2);
               $('#addSub_' + pro_id).text(value);
            }
         }

         console.log('subtotal: ' + subTotal);
         console.log('------------------');
         //subTotal +=  + precio;
         if (tipo_impuesto == 12) {
            iva = iva + subTotal * 0.12;

         }

         total = subTotal + (subTotal * iva / 100);
         precio = (Math.round(precio * 100) / 100).toFixed(2);
         subTotal = (Math.round(subTotal * 100) / 100).toFixed(2);
         total = (Math.round(subTotal * 100) / 100).toFixed(2);
         iva = (Math.round(iva * 100) / 100).toFixed(2);

         //$('#addSub_' + pro_id).text(precio);


         $('#impuesto').val(iva);
         $('#sub_total').val((Math.round((subTotal - iva) * 100) / 100).toFixed(2));
         $('#total').val(total);
         $('#tituloTotalVenta').text('$ ' + total);
      }
      function cantxprecio(id, precioU) {
         var precio = 0.0;
         var cant = $('#addCant_' + id).val(); //2
         //console.log('cant ' + cant + ' stock: ' + stock)
         cant = parseFloat(cant);
         precio = cant * precioU; //2.10   
         precio = (Math.round(precio * 100) / 100).toFixed(2);
         $('#addSub_' + id).text(precio);
         reCalcula(id, precioU);



      }
      function eliminaArticulo(pro_id) {
         var total = $('#total').val();
         var valorArestar = $('#addSub_' + pro_id).text();
         valorArestar = parseFloat(valorArestar);
         delete arrayProductos[pro_id];
         $('#proId_' + pro_id).parent().parent().remove();

         subTotal = subTotal - valorArestar;
         total = subTotal + (subTotal * iva / 100);
         iva = subTotal * 0.12;
         subTotal = (Math.round(subTotal * 100) / 100).toFixed(2);
         iva = (Math.round(iva * 100) / 100).toFixed(2);
         total = (Math.round(subTotal * 100) / 100).toFixed(2);
         $('#sub_total').val(subTotal);
         $('#total').val(total);
         $('#impuesto').val(iva);
         $('#tituloTotalVenta').text('$' + total);
      }
      function realizaFactura() {
         var client_id = $('#client_id').val();
         var client_dni = $('#client_dni').val();
         var user_id = $('#user_id').val();
         var totalPagar = $('#total').val();
         var arrayProId = [];
         var arrayProCant = [];
         var arrayProPrecio = [];
         //alert(cliente)
         for (pro_id in arrayProductos) {
            // Controlando que json realmente tenga esa propiedad
            if (arrayProductos.hasOwnProperty(pro_id)) {
               arrayProId.push(pro_id);
               arrayProCant.push(arrayProductos[pro_id].cant);
               arrayProPrecio.push(arrayProductos[pro_id].precio);
            }
         }
         console.log(arrayProId.length);
         if (arrayProId.length<3) {
            alert(`Debe seleccionar al menos 3 productos.\nUsted seleccionó ${arrayProId.length} productos` );
         }else{
             $.ajax(
             {
                dataType: "html",
                type: "POST",
                url: "invoice/create.php", // ruta donde se encuentra nuestro action que procesa la peticion XmlHttpRequest
                data: "client_id=" + client_id + "&user_id=" + user_id + "&totalPagar=" + totalPagar
                   + "&arrayProId=" + arrayProId + "&arrayProCant=" + arrayProCant + "&arrayProPrecio=" + arrayProPrecio, //Se añade el parametro de busqueda del medico
                beforeSend: function (data) {
                   //$('#msgEfectivo').addClass('alert alert-info').html('Espere por favor mientras se envia un comprobante al correo del cliente!');

                },
                success: function (requestData) {//armar la tabla
                   //var data = requestData.data;
                   console.log(requestData);
                   //console.log(zeroFill(324, 5));

                   if (requestData != '') {
                      alert('Factura No: ' + zeroFill(requestData, 9) + ' generada exitosamente!.\n Espere mientras se envia un email al cliente');
                      window.location.href = "menu_factura.php?client_dni="+client_dni;

                      //Enviar el email con la factura
                      //enviaEmail(data.num_factura, cliente);

                      // guarda en el local storage cajafinal
                   } else {
                      alert('Ocurrio un error');
                   }

                },
                error: function (requestData, strError, strTipoError) {
                   console.log(strTipoError)
                },
                complete: function (requestData, exito) { //fin de la llamada ajax.

                }
             });

         }
         




      }
      function zeroFill(number, width) {
         width -= number.toString().length;
         if (width > 0) {
            return new Array(width + (/\./.test(number) ? 2 : 1)).join('0') + number;
         }
         return number + ""; // siempre devuelve tipo cadena
      }
   </script>
</body>

</html>

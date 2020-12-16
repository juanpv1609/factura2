<?php
   //session_start();
    include('includes/conexion.php');
   include('includes/sesion.php');
    if (!$_SESSION['user_name']) {
        header('location: index.php');
    }
    $result=mysqli_query($con, "select * from fact_users where user_name='$user_name'")or die('Error en la sesion');
    $row=mysqli_fetch_array($result);
    //$num_row = mysqli_num_rows($row);
    $clients=mysqli_query($con, "select * from fact_clients")or die('Error en la sesion');

    //$users_row=mysqli_fetch_array($users);

    ?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="assets/bootstrap4/css/bootstrap.min.css">
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
        <a class="nav-link active" href="registra_cliente.php">Clientes </a>
      </li>
      <li class="nav-item ">
        <a class="nav-link" href="registra_producto.php">Productos </a>
      </li>
      <li class="nav-item">
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
      <?php
      if (isset($_GET['msg']) && isset($_GET['status'])) {
          if ($_GET['status']=='ok') {
              echo '<div class="alert alert-success alert-dismissible fade show" role="alert">'.$_GET['msg'].'
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button></div>';
          } else {
              echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'.$_GET['msg'].'
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button></div>';
          }
      }
   ?>
      <div class="d-flex justify-content-between align-items-center ">
         <h3>Lista de clientes</h3>
         <div class="btn-group" role="group" aria-label="Basic example">
            <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModal"
               onclick="addClient()">Agregar</button>
         </div>
      </div>
      <br>

      <table class="table table-striped table-hover">
         <thead>
            <tr>
               <th>Nombres</th>
               <th>Apellidos</th>
               <th>Cedula</th>
               <th>Direccion</th>
               <th>Telefono</th>
               <th>Acciones</th>
            </tr>
         </thead>
         <tbody>
            <?php
         foreach ($clients as $item) { ?>
            <tr>
               <td>
                  <?php echo $item['client_name']; ?>
               </td>
               <td>
                  <?php echo $item['client_surname']; ?>
               </td>
               <td>
                  <?php echo $item['client_dni']; ?>
               </td>
               <td>
                  <?php echo $item['client_address']; ?>
               </td>
               <td>
                  <?php echo $item['client_phone']; ?>
               </td>
               <td>
                  <div class="btn-group" role="group" aria-label="Basic example">
                     <a type="button" href="clients/delete.php?client_id=<?php echo $item['client_id']; ?>"
                        class="btn btn-danger btn-sm">Eliminar</a>
                  </div>
               </td>
            </tr>

            <?php
         }  ?>
         </tbody>
      </table>
   </div>
   <!-- Modal -->
   <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog ">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Nuevo Cliente</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="form-group">
                           <label for="exampleInputEmail1">Cedula</label>
                           <div class="input-group">
                              <input type="text" class="form-control" id="client_dni1" name="client_dni1" required minlength="10"
                                 maxlength="10" pattern="[0-9]+" placeholder="Ingrese su cedula de identidad">
                              <div class="input-group-append">
                                 <button type="button" class="btn btn-primary" name="verifyDni" onclick="verificaCedula()">Verificar</button>
                              </div>
                           </div>
               
                        </div>
                     </div>
                  </div>
                  <div id="mensajeDni"></div>
               <form action="clients/add.php" id="formClient" method="post" role="form">
                  <input type="hidden" id="client_id" name="client_id">
                  <input type="hidden"  name="client_dni" id="client_dni">
                  <!-- <div class="row">
                     <div class="col-sm-12">
                        <div class="form-group">
                           <label for="exampleInputEmail1">Cedula</label>
                           <div class="input-group">
                              <input type="text" class="form-control" id="client_dni" name="client_dni" required minlength="10" maxlength="10" pattern="[0-9]+"
                                 placeholder="Ingrese su cedula de identidad">
                              <div class="input-group-append">
                                 <button type="submit"  class="btn btn-primary" name="verifyDni">Verificar</button>
                              </div>
                           </div>

                        </div>
                     </div>
                  </div> -->
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label for="exampleInputEmail1">Nombres</label>
                           <input type="text" class="form-control" id="client_name" name="client_name" required
                              placeholder="Ingrese su/s nombre/s" >
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label for="exampleInputEmail1">Apellidos</label>
                           <input type="text" class="form-control" id="client_surname" name="client_surname" required
                              placeholder="Ingrese su/s apellido/s">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label for="exampleInputEmail1">Direccion</label>
                           <input type="text" class="form-control" id="client_address" name="client_address" required
                              placeholder="Ingrese su direccion de domicilio">
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label for="exampleInputEmail1">Telefono</label>
                           <input type="text" class="form-control" id="client_phone" name="client_phone" required minlength="10" maxlength="10" pattern="[0-9]+"
                              placeholder="Ingrese su numero telefonico">
                        </div>
                     </div>
                  </div>
                  <hr>
                  <div class="d-flex justify-content-between">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                     <div id="accion">

                     </div>
                  </div>


               </form>
            </div>
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
      function verificaCedula() {
            var client_dni1 = $('#client_dni1').val();
            //console.log(codigoEscaneado)
            if ((!client_dni1 == "")) {
               $.ajax(
                  {
                     dataType: "html",
                     type: "POST",
                     url: "clients/verify_dni.php", // ruta donde se encuentra nuestro action que procesa la peticion XmlHttpRequest
                     data: "client_dni1=" + client_dni1, //Se añade el parametro de busqueda del medico
                     beforeSend: function (data) {

                     },
                     success: function (requestData) {//armar la tabla
                        //var data = requestData.data;
                        console.log(requestData)
                           $('#mensajeDni').html(requestData);
                        

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
      function addClient() {
         $('#formClient').trigger('reset');
         $('#accion').html(`<button type="submit" class="btn btn-primary" name="addClient" onclick="setDni()">Guardar</button>`);

         $('#exampleModal').modal({ show: true });
      }
      
      function setDni(){
         $('#client_dni').val($('#client_dni1').val());
         console.log($('#client_dni').val())

      }
   </script>
</body>

</html>

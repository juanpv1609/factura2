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
    $invoices=mysqli_query($con, "SELECT * FROM fact_invoice f
JOIN fact_clients c
ON c.client_id=f.client_id")or die('Error en la sesion');

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
        <a class="nav-link" href="registra_cliente.php">Clientes </a>
      </li>
      <li class="nav-item ">
        <a class="nav-link " href="registra_producto.php">Productos </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="verifica_cliente.php">Facturacion Electronica</a>
      </li>
      <li class="nav-item active">
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
         <h3>Lista de facturas generadas</h3>
         <div class="btn-group" role="group" aria-label="Basic example">
            <a href="verifica_cliente.php" class="btn btn-sm btn-success"
               >Nueva Factura</a>
         </div>
      </div>
      <br>

      <table class="table table-striped table-hover">
         <thead>
            <tr>
               <th>Num Factura</th>
               <th>Cliente</th>
               <th>Total</th>
               <th>Acciones</th>
            </tr>
         </thead>
         <tbody>
            <?php
         foreach ($invoices as $item) { ?>
            <tr>
               <td>
                  <?php echo str_pad($item['invoice_id'],10,"0",STR_PAD_LEFT); ?>
               </td>
               <td>
                  <?php echo strtoupper(($item['client_name'].' '.$item['client_surname'])); ?>
               </td>
               <td>
                  <?php echo number_format($item['invoice_amount'], 2, '.', ','); ?>
               </td>
               <td>
                  <div class="btn-group" role="group" aria-label="Basic example">
                     <button type="button" onclick='editInvoice(<?= json_encode($item); ?>)'
                        class="btn btn-warning btn-sm">Editar</button>
                     <a type="button" href="invoice/delete.php?invoice_id=<?php echo $item['invoice_id']; ?>"
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
               <h5 class="modal-title" id="exampleModalLabel">Editar Factura</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <form action="invoice/update.php" id="formInvoice" method="post" role="form">
                  <input type="hidden" id="invoice_id" name="invoice_id">
                  <input type="hidden" id="client_id" name="client_id">
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label for="client_name">Nombre Cliente</label>
                           <input type="text" class="form-control" id="client_name" name="client_name" required
                              placeholder="Ingrese el nombre del cliente a modificar" >
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="form-group">
                           <label for="client_surname">Apellido Cliente</label>
                           <input type="text" class="form-control" id="client_surname" name="client_surname" required
                              placeholder="Ingrese el apellido del cliente a modificar" >
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
      function editInvoice(invoice) {
         console.log((invoice));
         $('#invoice_id').val(invoice.invoice_id);
         $('#client_id').val(invoice.client_id);
         $('#client_name').val(invoice.client_name.toUpperCase());
         $('#client_surname').val(invoice.client_surname.toUpperCase());
         $('#accion').html(`<button type="submit" class="btn btn-primary" name="updateInvoice">Actualizar</button>`);

         $('#exampleModal').modal({ show: true });

      }
   </script>
</body>

</html>

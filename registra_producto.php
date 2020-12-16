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
    $products=mysqli_query($con, "select * from fact_products")or die('Error en la sesion');

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
        <a class="nav-link active" href="registra_producto.php">Productos </a>
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
         <h3>Lista de productos</h3>
         <div class="btn-group" role="group" aria-label="Basic example">
            <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModal"
               onclick="addProduct()">Agregar</button>
         </div>
      </div>
      <br>

      <table class="table table-striped table-hover">
         <thead>
            <tr>
               <th>Descripcion</th>
               <th>Precio</th>
               <th>Estado</th>
               <th>Acciones</th>
            </tr>
         </thead>
         <tbody>
            <?php
         foreach ($products as $item) { 
            $status=($item['product_status']==1) ? 'Disponible':'No disponible';?>
            <tr>
               <td>
                  <?php echo $item['product_description']; ?>
               </td>
               <td>
                  <?php echo number_format($item['product_price'],2,'.',','); ?>
               </td>
               <td>
                  <?php echo $status; ?>
               </td>
               <td>
                  <div class="btn-group" role="group" aria-label="Basic example">
                     <button type="button" onclick='editProduct(<?= json_encode($item); ?>)'
                        class="btn btn-warning btn-sm">Editar</button>
                     <a type="button" href="products/delete.php?product_id=<?php echo $item['product_id']; ?>"
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
               <h5 class="modal-title" id="exampleModalLabel">Nuevo Producto</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <form action="products/add.php" id="formProduct" method="post" role="form">
                  <input type="hidden" id="product_id" name="product_id">
                  <div class="row">
                     <div class="col-sm-12">
                        <div class="form-group">
                           <label for="exampleInputEmail1">Descripcion</label>
                           <textarea type="text" class="form-control" id="product_description" name="product_description" required
                              placeholder="Ingrese la descripcion" ></textarea>
                        </div>
                     </div>
                     <div class="col-sm-12">
                        <div class="form-group">
                           <label for="exampleInputEmail1">Precio</label>
                           <input type="text" class="form-control" id="product_price" name="product_price" required 
                              placeholder="Ingrese el precio unitario">
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
      function addProduct() {
         $('#formProduct').trigger('reset');
         $('#accion').html(`<button type="submit" class="btn btn-primary" name="addProduct" >Guardar</button>`);

         $('#exampleModal').modal({ show: true });
      }
      function editProduct(user) {
         console.log((user));
         $('#product_id').val(user.product_id);
         $('#product_description').val(user.product_description);
         $('#product_price').val(user.product_price);
         $('#accion').html(`<button type="submit" class="btn btn-primary" name="updateProduct">Actualizar</button>`);

         $('#exampleModal').modal({ show: true });

      }
   </script>
</body>

</html>

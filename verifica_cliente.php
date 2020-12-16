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
      <li class="nav-item active">
        <a class="nav-link" href="menu_user.php">Usuarios </a>
      </li>
      <li class="nav-item ">
        <a class="nav-link" href="registra_cliente.php">Clientes </a>
      </li>
      <li class="nav-item ">
        <a class="nav-link" href="registra_producto.php">Productos </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="verifica_cliente.php">Facturacion Electronica</a>
      </li>
      <li class="nav-item ">
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
   <form action="clients/find.php" id="formVerify" method="post" role="form">
                  <div class="row">
                     <div class="col-sm-4">
                        <div class="form-group">
                           <label for="exampleInputEmail1">Busqueda de cliente</label>
                           <div class="input-group">
                              <input type="text" class="form-control" id="client_dni" name="client_dni" required minlength="10"
                                 maxlength="10" pattern="[0-9]+" placeholder="Ingrese un numero de cedula">
                              <div class="input-group-append">
                                 <button type="submit" class="btn btn-primary" name="findClient">Verificar</button>
                              </div>
                           </div>
               
                        </div>
                     </div>
                  </div>
                  <div id="mensajeDni"></div>
               </form>
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
   </script>
</body>

</html>

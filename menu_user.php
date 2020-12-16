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
    $users=mysqli_query($con, "select * from fact_users as u join fact_users_profiles as p on p.profile_id=u.profile_id")or die('Error en la sesion');
    $profiles=mysqli_query($con, "select * from fact_users_profiles")or die('Error en la sesion');

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
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
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
      <li class="nav-item">
        <a class="btn btn-primary" href="facturas.php">Listar Facturas</a>
      </li>
      
    </ul>
    <span class="navbar-text">
      Bienvenido <?php echo $row['user_name']; ?>
    </span>
        <a class="btn btn-outline-danger btn-sm ml-4" href="functions/logout.php">Salir</a>
     
  </div>
</nav>
<div class="container-fluid p-5">
   <?php 
      if(isset($_GET['msg']) && isset($_GET['status'])){
         if ($_GET['status']=='ok') {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">'.$_GET['msg'].'
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button></div>';
         }else{
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'.$_GET['msg'].'
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button></div>';

         }
         
      }
   ?>
<div class="d-flex justify-content-between align-items-center ">
<h3>Lista de usuarios</h3>
<div class="btn-group" role="group" aria-label="Basic example">
   <button  class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModal" onclick="addUser()">Agregar</button>
   </div>
</div>
<br>
    
   <table class="table table-striped table-hover">
      <thead>
         <tr>
         <th>Usuario</th>
         <th>Correo</th>
         <th>Perfil</th>
         <th>Estado</th>
         <th>Acciones</th>
         </tr>
      </thead>
      <tbody>
         <?php
         foreach ($users as $item) {
             $status=($item['user_status']==1) ? 'Activo' : 'Inactivo'; ?>
            <tr>
            <td><?php echo $item['user_name']; ?></td>
            <td><?php echo $item['user_email']; ?></td>
            <td><?php echo $item['profile_name']; ?></td>
            <td><?php echo $status; ?></td>
            <td>
               <div class="btn-group" role="group" aria-label="Basic example">
                  <button type="button" onclick='editUser(<?= json_encode($item); ?>)' class="btn btn-warning btn-sm" >Editar</button>
                  <a type="button" href="users/delete.php?user_id=<?php echo $item['user_id']; ?>" class="btn btn-danger btn-sm" >Eliminar</a>
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
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <form action="users/add.php" method="post" role="form">
         <input type="hidden" id="user_id" name="user_id">
               <div class="form-group">
               <label for="exampleInputEmail1">Nombre de usuario</label>
               <input type="text" class="form-control" id="user_name"  name="user_name" required placeholder="Ingrese un nombre de usuario">
            </div>
            <div class="form-group">
               <label for="exampleInputEmail1">Correo electronico</label>
               <input type="email" class="form-control" id="user_email"  name="user_email" required placeholder="Ingrese un correo electronico">
            </div>
            <div class="form-group">
               <label for="exampleInputPassword1">Password</label>
               <input type="password" class="form-control" id="user_password" name="user_password" required placeholder="Ingrese su contraseña">
            </div>
            <div class="form-group">
            <label for="exampleFormControlSelect1">Perfil</label>
            <select class="form-control" id="profile_id" name="profile_id">
               <?php 
                  foreach ($profiles as $pro) { ?>
                    <option value="<?php echo $pro['profile_id'];?>"><?php echo $pro['profile_name'];?></option>
                 <?php  } ?>
               
            </select>
         </div>
         <hr>
         <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
         <div id="accion" >
            
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
      $(document).ready(function() {
         setTimeout(function() {
            $(".alert").alert('close');         
      },2000);
      });
      function addUser(){
         $('#user_id').val('');
         $('#user_name').val('');
         $('#user_email').val('');
         $('#user_password').val('');
         $('#profile_id').val('').change();
         $('#accion').html(`<button type="submit" class="btn btn-primary" name="addUser">Guardar</button>`);

        $('#exampleModal').modal({show:true});
      }
      function editUser(user){
         console.log((user));
         $('#user_id').val(user.user_id);
         $('#user_name').val(user.user_name);
         $('#user_email').val(user.user_email);
         $('#user_password').val(user.user_password);
         $('#profile_id').val(user.profile_id).change();
         $('#accion').html(`<button type="submit" class="btn btn-primary" name="updateUser">Actualizar</button>`);

        $('#exampleModal').modal({show:true});

      }
   </script>
</body>
</html>
<?php
session_start();
include('../includes/conexion.php');
     $user_id =  $_GET['user_id'];

     $sql="SELECT * FROM fact_users WHERE user_id=$user_id";
     $query = mysqli_query($con, $sql);
	   $row = mysqli_fetch_array($query);

      $msg='';
     $cadena='';

     if ($query) {
         $cadena += '<form action="users/add.php" method="post" role="form">
               <div class="form-group">
               <label for="exampleInputEmail1">Nombre de usuario</label>
               <input type="text" class="form-control" id="user_name"  name="user_name" value="'.$row['user_name'].'" required placeholder="Ingrese un nombre de usuario">
            </div>
            <div class="form-group">
               <label for="exampleInputEmail1">Correo electronico</label>
               <input type="email" class="form-control" id="user_email"  name="user_email" value="'.$row['user_email'].'" required placeholder="Ingrese un correo electronico">
            </div>
            <div class="form-group">
               <label for="exampleInputPassword1">Password</label>
               <input type="password" class="form-control" id="user_password" name="user_password" value="'.$row['user_password'].'" required placeholder="Ingrese su contraseña">
            </div>
            <div class="form-group">
            <label for="exampleFormControlSelect1">Perfil</label>
            <select class="form-control" id="profile_id" name="profile_id">';
                
                  foreach ($profiles as $pro) {
                  $cadena +=   '<option value="'.$pro['profile_id'].'">'.$pro['profile_name'].'</option>';
                  }
               
           $cadena += ' </select>
         </div>
         <hr>
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
         <button type="submit" class="btn btn-primary" name="addUser">Guardar</button>
      </form>';
     } else {
         echo 'No se encontro el usuario';
     }
      header('location:../menu_user.php?status='.$status.'&msg='.$msg);

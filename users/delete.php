<?php
session_start();
include('../includes/conexion.php');
     $user_id =  $_GET['user_id'];

     $sql="DELETE FROM fact_users WHERE user_id=$user_id";
     $query = mysqli_query($con, $sql);
      $msg='';
     $status='';

     if ($query) {
         $msg='Dato eliminado correctamente!';
         $status='ok';
     } else {
         $msg='No se pudo eliminar, error: '.mysqli_error($con);
         $status='fail';
     }
      header('location:../menu_user.php?status='.$status.'&msg='.$msg);


 

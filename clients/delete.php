<?php
session_start();
include('../includes/conexion.php');
     $client_id =  $_GET['client_id'];

     $sql="DELETE FROM fact_clients WHERE client_id=$client_id";
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
      header('location:../registra_cliente.php?status='.$status.'&msg='.$msg);


 

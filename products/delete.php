<?php
session_start();
include('../includes/conexion.php');
     $product_id =  $_GET['product_id'];

     $sql="DELETE FROM fact_products WHERE product_id=$product_id";
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
      header('location:../registra_producto.php?status='.$status.'&msg='.$msg);


 

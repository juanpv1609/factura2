<?php
session_start();
include('../includes/conexion.php');
     $invoice_id =  $_GET['invoice_id'];

     $sql="DELETE FROM fact_invoice WHERE invoice_id=$invoice_id";
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
      header('location:../facturas.php?status='.$status.'&msg='.$msg);

<?php
session_start();
include('../includes/conexion.php');
 if (isset($_POST['updateInvoice'])) {
     $invoice_id = mysqli_real_escape_string($con, $_POST['invoice_id']);
     $client_id = mysqli_real_escape_string($con, $_POST['client_id']);
     $client_name = mysqli_real_escape_string($con, $_POST['client_name']);
     $client_surname = mysqli_real_escape_string($con, $_POST['client_surname']);


     $sql="UPDATE fact_clients set client_name='$client_name', client_surname='$client_surname' 
            WHERE client_id=$client_id;";
     $query = mysqli_query($con, $sql);
    
     $msg='';
     $status='';

     if ($query) {
         $msg='Dato actualizado correctamente!';
         $status='ok';
     } else {
         $msg='No se pudo actualizar, error:'.mysqli_error($con);
         $status='fail';
     }
     header('location:../facturas.php?status='.$status.'&msg='.$msg);
 }

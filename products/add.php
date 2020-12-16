<?php
session_start();
include('../includes/conexion.php');
 if (isset($_POST['addProduct'])) {
     $product_description = mysqli_real_escape_string($con, $_POST['product_description']);
     $product_price = $_POST['product_price'];
    $product_price=number_format($product_price,2,".",",");
      $sql="INSERT INTO fact_products(product_description, product_price,product_status)
      VALUES ('$product_description',$product_price,1)";
     $query = mysqli_query($con, $sql);
    
     $msg='';
     $status='';

     if ($query) {
         $msg='Dato creado correctamente!';
         $status='ok';
     } else {
         $msg='No se pudo crear, error:'.mysqli_error($con);
         $status='fail';
     }
      header('location:../registra_producto.php?status='.$status.'&msg='.$msg);

 }else if (isset($_POST['updateProduct'])) {
    $product_id = mysqli_real_escape_string($con, $_POST['product_id']);
    $product_description = mysqli_real_escape_string($con, $_POST['product_description']);

     $product_price = $_POST['product_price'];
    $product_price=number_format($product_price, 2, ".", ",");


    $sql="UPDATE fact_products set product_description='$product_description', product_price=$product_price, product_status=1
            WHERE product_id=$product_id;";
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
    header('location:../registra_producto.php?status='.$status.'&msg='.$msg);
}


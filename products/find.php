<?php
session_start();
include('../includes/conexion.php');
     $product_id =  $_POST['product'];

     $sql="SELECT * FROM fact_products WHERE product_id=$product_id";
     $query = mysqli_query($con, $sql);
      if ($query->num_rows > 0) {
    while ($row = $query->fetch_assoc()) {
        {


            $array = array(
                'product_id' => $row["product_id"],
                'product_description' => $row["product_description"],
                'product_price' => $row["product_price"],
                );
                echo json_encode($array);
        }
    }
} else {
    echo 'Data Not Found';
}


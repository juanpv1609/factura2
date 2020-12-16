<?php
session_start();
include('../includes/conexion.php');
     $client_id =  $_POST['client_id'];
     $user_id =  $_POST['user_id'];
     $totalPagar =  $_POST['totalPagar'];
     $arrayProId =  $_POST['arrayProId'];
     $arrayProCant =  $_POST['arrayProCant'];
     $arrayProPrecio =  $_POST['arrayProPrecio'];

      $arrayProId = explode(',', $arrayProId);
      $arrayProCant = explode(',', $arrayProCant);
      $arrayProPrecio = explode(',', $arrayProPrecio);


     $sql_factura="INSERT INTO fact_invoice(client_id,user_id,invoice_date,invoice_amount)
     VALUES($client_id,$user_id,(SELECT NOW()),$totalPagar);";
     $result = mysqli_query($con, $sql_factura);

     $invoice_id=$con->insert_id;
      
      if ($result) {
          $sql_detalle ="INSERT INTO fact_invoice_details(invoice_id, product_id, product_quantity, price) VALUES ";
        for ($i=0; $i < count($arrayProId); $i++) {
            $sql_detalle .="(".$invoice_id.",".$arrayProId[$i].",".$arrayProCant[$i].",".$arrayProPrecio[$i]."), ";
        }
        $sql_detalle = substr($sql_detalle, 0, (strlen($sql_detalle)-2));
        $result_detalle = mysqli_query($con, $sql_detalle);
        echo $invoice_id;
      } else {
          echo '';
      }

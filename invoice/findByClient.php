<?php
session_start();
include('../includes/conexion.php');
     $client =  $_POST['client'];
$sql="SELECT * FROM fact_invoice AS i 
JOIN fact_clients AS c
ON c.client_id=i.client_id
JOIN fact_users AS u
ON u.user_id=i.user_id
WHERE c.client_dni='$client'
OR c.client_surname='$client'";

     $sql_products="SELECT * FROM fact_invoice AS i 
JOIN fact_invoice_details AS d
ON i.invoice_id=d.invoice_id
JOIN fact_clients AS c
ON c.client_id=i.client_id
JOIN fact_users AS u
ON u.user_id=i.user_id
JOIN fact_products AS p
ON p.product_id=d.product_id
WHERE c.client_dni='$client'
OR c.client_surname='$client'";
$cadena='';
     $query = mysqli_query($con, $sql);
     $query_products = mysqli_query($con, $sql_products);

     $row = mysqli_fetch_array($query);

      $factura_num=str_pad($row['invoice_id'], 9, "0", STR_PAD_LEFT);

        $cadena.='<table class="table  table-bordered table-sm dataTable text-dark" id="dataTableFactura" width="100%">
                <thead class="table-dark" >
                <tr>
                    <th>FACTURA</th>
                    <th>FECHA EMISION</th>
                    <th>DNI</th>
                    <th>CLIENTE</th>
                    <th>VENDEDOR</th>
                    <th>TOTAL<small>(USD)</small></th>
                </tr>
                </thead>
                <tbody>';
                if (is_array($query) || is_object($query)) {
                    foreach ($query as $row) {
                        $factura_num=str_pad($row['invoice_id'], 9, "0", STR_PAD_LEFT);

                         $cadena .= "<tr >";
    $cadena .= "<td>" . $factura_num . "</td>";
    $cadena .= "<td>" . $row['invoice_date'] . "</td>";
    $cadena .= "<td>" . $row['client_dni'] . "</td>";
    $cadena .= "<td>" . $row['client_name'] ." " . $row['client_surname'] ."</td>";
    $cadena .= "<td>" . $row['user_name'] . "</td>";
    $cadena .= "<td>$ " . number_format($row['invoice_amount'],2,'.',',') . "</td>";

    $cadena .= "</tr>";

                    }
                }
               

                $cadena .= "</tbody></table>";


        $cadena.='<table class="table  table-bordered table-sm dataTable text-dark" id="dataTableFactura" width="100%">
                <thead class="table-dark" >
                <tr>
                    <th>FACTURA</th>
                    <th>PRODUCTO</th>
                    <th>PRECIO UNITARIO</th>
                    <th>CANTIDAD</th>
                    <th>TOTAL<small>(USD)</small></th>
                </tr>
                </thead>
                <tbody>';
                if (is_array($query_products) || is_object($query_products)) {
                    foreach ($query_products as $item) {
                        $fact_num=str_pad($item['invoice_id'], 9, "0", STR_PAD_LEFT);

                        $cadena .= "<tr >";
                         $cadena .= "<td>" . $fact_num . "</td>";

                        $cadena .= "<td>" . $item['product_description'] . "</td>";

                        $cadena .= "<td>$ " . number_format($item['product_price'],2,'.',',') . "</td>";
                        $cadena .= "<td>" . $item['product_quantity'] . "</td>";
                        $cadena .= "<td>$ " . number_format($item['price'],2,'.',',') . "</td>";

                        $cadena .= "</tr>";


                        # code...
                    }
                }
                
                 $cadena .= "</tbody></table>";
                 echo $cadena;

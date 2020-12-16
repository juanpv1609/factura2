<?php
session_start();
include('../includes/conexion.php');
 if (isset($_POST['addClient'])) {
     $client_dni = mysqli_real_escape_string($con, $_POST['client_dni']);
     $client_name = mysqli_real_escape_string($con, $_POST['client_name']);
     $client_surname = mysqli_real_escape_string($con, $_POST['client_surname']);
     $client_address = mysqli_real_escape_string($con, $_POST['client_address']);
     $client_phone = mysqli_real_escape_string($con, $_POST['client_phone']);
    $sql="INSERT INTO fact_clients(client_dni,client_name,client_surname,client_address,client_phone)
      VALUES ('$client_dni','$client_name','$client_surname','$client_address','$client_phone')";
    $msg='';
                 $status='';

     /**
      * !Validacion cedula
      */
     $cod_provincias= array(
        1=>"AZUAY",
        2=>"BOLIVAR",
        3=>"CAÑAR",
        4=>"CARCHI",
        5=>"COTOPAXI",
        6=>"CHIMBORAZO",
        7=>"EL ORO",
        8=>"ESMERALDAS",
        9=>"GUAYAS",
        10=>"IMBABURA",
        11=>"LOJA",
        12=>"LOS RIOS",
        13=>"MANABI",
        14=>"MORONO SANTIAGO",
        15=>"NAPO",
        16=>"PASTAZA",
        17=>"PICHINCHA",
        18=>"TUNGURAHUA",
        19=>"ZAMORA CHINCHIPE",
        20=>"GALAPAGOS",
        21=>"SUCUMBIOS",
        22=>"ORELLANA",
        23=>"SANTO DOMINGO DE LOS TSACHILAS",
        24=>"SANTA ELENA",
    );
     $prov='';
     $client_dni = (string)$client_dni;
     $numero_provincia=substr($client_dni, 0, 2);
     $tercer_digito=$client_dni[2];
     $modulo10=null;
     $arrayCoeficientes = array(2,1,2,1,2,1,2,1,2);
     $digitoVerificador = (int)$client_dni[9];
     $digitosIniciales = str_split(substr($client_dni, 0, 9));
     $total = 0;
     foreach ($cod_provincias as $codigo=>$provincia) {
        if ($codigo==(int)$numero_provincia) {
            $prov=$provincia;
            break;
        }
    }

     foreach ($digitosIniciales as $key => $value) {
         $valorPosicion = ((int)$value * $arrayCoeficientes[$key]);

         if ($valorPosicion >= 10) {
             $valorPosicion = str_split($valorPosicion);
             $valorPosicion = array_sum($valorPosicion);
             $valorPosicion = (int)$valorPosicion;
         }

         $total = $total + $valorPosicion;
         $residuo =  $total % 10;

         if ($residuo == 0) {
             $modulo10 = 0;
         } else {
             $modulo10 = 10 - $residuo;
         }
     }

     if ($prov!='') { //codigo de provincia
         if ($tercer_digito >= 0 or $tercer_digito < 6) { //tecer digito
             if ($modulo10==$digitoVerificador) { //modulo 10 verificador
                
                 $query = mysqli_query($con, $sql);
                 
                 if ($query) {
                     $msg='Dato creado correctamente!';
                     $status='ok';
                 } else {
                     $msg='No se pudo crear, error:'.mysqli_error($con);
                     $status='fail';
                 }
                 //header('location:../registra_cliente.php?status='.$status.'&msg='.$msg);

                 echo '<script type="text/javascript">
                    alert("Cedula Valida, cedula de '.$provincia.'");
                    window.location.href="../registra_cliente.php?status='.$status.'&msg='.$msg.'";
                    </script>';
             } else {
                 echo'<script type="text/javascript">
                    alert("Cedula Invalida, no se comprobo el digito identificador");
                    window.location.href="../registra_cliente.php?status='.$status.'&msg='.$msg.'";
                    </script>';
             }
         } else {
             echo'<script type="text/javascript">
                    alert("Cedula Invalida, tercer dígito debe ser mayor o igual a 0 y menor a 6 para cédulas");
                    window.location.href="../registra_cliente.php?status='.$status.'&msg='.$msg.'";
                    </script>';
         }
     } else {
         echo'<script type="text/javascript">
                    alert("Cedula Invalida, Codigo de Provincia (dos primeros dígitos) no deben ser mayor a 24 ni menores a 0");
                    window.location.href="../registra_cliente.php?status='.$status.'&msg='.$msg.'";
                    </script>';
     }
 } elseif (isset($_POST['verifyDni'])) {
     $client_dni = mysqli_real_escape_string($con, $_POST['client_dni']);
   $msg='';
$status='';

     /**
      * !Validacion cedula
      */
     $cod_provincias= array(
        1=>"AZUAY",
        2=>"BOLIVAR",
        3=>"CAÑAR",
        4=>"CARCHI",
        5=>"COTOPAXI",
        6=>"CHIMBORAZO",
        7=>"EL ORO",
        8=>"ESMERALDAS",
        9=>"GUAYAS",
        10=>"IMBABURA",
        11=>"LOJA",
        12=>"LOS RIOS",
        13=>"MANABI",
        14=>"MORONO SANTIAGO",
        15=>"NAPO",
        16=>"PASTAZA",
        17=>"PICHINCHA",
        18=>"TUNGURAHUA",
        19=>"ZAMORA CHINCHIPE",
        20=>"GALAPAGOS",
        21=>"SUCUMBIOS",
        22=>"ORELLANA",
        23=>"SANTO DOMINGO DE LOS TSACHILAS",
        24=>"SANTA ELENA",
    );
     $prov='';
     $client_dni = (string)$client_dni;
     $numero_provincia=substr($client_dni, 0, 2);
     $tercer_digito=$client_dni[2];
     $modulo10=null;
     $arrayCoeficientes = array(2,1,2,1,2,1,2,1,2);
     $digitoVerificador = (int)$client_dni[9];
     $digitosIniciales = str_split(substr($client_dni, 0, 9));
     $total = 0;
     foreach ($cod_provincias as $codigo=>$provincia) {
         if ($codigo==(int)$numero_provincia) {
             $prov=$provincia;
             break;
         }
     }

     foreach ($digitosIniciales as $key => $value) {
         $valorPosicion = ((int)$value * $arrayCoeficientes[$key]);

         if ($valorPosicion >= 10) {
             $valorPosicion = str_split($valorPosicion);
             $valorPosicion = array_sum($valorPosicion);
             $valorPosicion = (int)$valorPosicion;
         }

         $total = $total + $valorPosicion;
         $residuo =  $total % 10;

         if ($residuo == 0) {
             $modulo10 = 0;
         } else {
             $modulo10 = 10 - $residuo;
         }
     }

     if ($prov!='') { //codigo de provincia
         if ($tercer_digito >= 0 or $tercer_digito < 6) { //tecer digito
             if ($modulo10==$digitoVerificador) { //modulo 10 verificador
                
                 $query = mysqli_query($con, $sql);
                 
                 if ($query) {
                     $msg='Dato creado correctamente!';
                     $status='ok';
                 } else {
                     $msg='No se pudo crear, error:'.mysqli_error($con);
                     $status='fail';
                 }
                 //header('location:../registra_cliente.php?status='.$status.'&msg='.$msg);

                 echo '<script type="text/javascript">
                    alert("Cedula Valida, cedula de '.$provincia.'");
                    window.location.href="../registra_cliente.php?status='.$status.'&msg='.$msg.'";
                    </script>';
             } else {
                 echo'<script type="text/javascript">
                    alert("Cedula Invalida, no se comprobo el digito identificador");
                    window.location.href="../registra_cliente.php?status='.$status.'&msg='.$msg.'";
                    </script>';
             }
         } else {
             echo'<script type="text/javascript">
                    alert("Cedula Invalida, tercer dígito debe ser mayor o igual a 0 y menor a 6 para cédulas");
                    window.location.href="../registra_cliente.php?status='.$status.'&msg='.$msg.'";
                    </script>';
         }
     } else {
         echo'<script type="text/javascript">
                    alert("Cedula Invalida, Codigo de Provincia (dos primeros dígitos) no deben ser mayor a 24 ni menores a 0");
                    window.location.href="../registra_cliente.php?status='.$status.'&msg='.$msg.'";
                    </script>';
     }

 }
 

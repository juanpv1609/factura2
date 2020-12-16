<?php
session_start();
include('../includes/conexion.php');
 if (isset($_POST['addUser'])) {
     $user_name = mysqli_real_escape_string($con, $_POST['user_name']);
     $user_email = mysqli_real_escape_string($con, $_POST['user_email']);
     $user_password = mysqli_real_escape_string($con, $_POST['user_password']);
     $profile_id = mysqli_real_escape_string($con, $_POST['profile_id']);

      $sql="INSERT INTO fact_users(user_name,user_email,user_password,profile_id,user_status)
      VALUES ('$user_name','$user_email',MD5('$user_password'),$profile_id,1)";
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
      header('location:../menu_user.php?status='.$status.'&msg='.$msg);

 }else if (isset($_POST['updateUser'])) {
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $user_name = mysqli_real_escape_string($con, $_POST['user_name']);

    $user_email = mysqli_real_escape_string($con, $_POST['user_email']);
    $user_password = mysqli_real_escape_string($con, $_POST['user_password']);
    $profile_id = mysqli_real_escape_string($con, $_POST['profile_id']);

    $sql="UPDATE fact_users set user_name='$user_name', user_email='$user_email', user_password=MD5('$user_password'), profile_id=$profile_id, user_status=1
            WHERE user_id=$user_id;";
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
    header('location:../menu_user.php?status='.$status.'&msg='.$msg);
}


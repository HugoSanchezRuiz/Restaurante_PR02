<?php
session_start();

include_once('./inc/conexion.php');

if (isset($_POST['id_mesa'])) {

    $id_mesa = $_POST['id_mesa'];
    try{
        mysqli_autocommit($conn,false);
        mysqli_begin_transaction($conn, MYSQLI_TRANS_START_READ_WRITE);

        $sql1 = "DELETE FROM tbl_ocupacion WHERE id_mesa = ?;";
        $stmt1 = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt1, $sql1);
        mysqli_stmt_bind_param($stmt1, "i", $id_mesa);
        mysqli_stmt_execute($stmt1);

        $sql2 = "DELETE FROM tbl_mesa WHERE id_mesa = ?;";
        $stmt2 = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt2, $sql2);
        mysqli_stmt_bind_param($stmt2, "i", $id_mesa);
        mysqli_stmt_execute($stmt2);

        mysqli_commit($conn);


        mysqli_stmt_close($stmt1);
        mysqli_stmt_close($stmt2);
        mysqli_close($conn);

        header('Location: ./mostrar_mesas.php');

    }catch (Exception $e){
            mysqli_rollback($conn);
            echo "Error: ".$e -> getMessage()."<br>";
    }

} else {

    header('Location:  ./index.php');
   
}
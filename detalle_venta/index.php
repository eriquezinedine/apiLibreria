<?php

include_once '../bd/BD.php';

header('Access-Control-Allow-Origin: *');
// header('content-type: application/json; charset=utf-8');


if($_SERVER['REQUEST_METHOD']=='GET'){
    if(isset($_GET['id_venta'])){
        $id = $_GET['id_venta'];
        $query= "SELECT
                    D.id_venta,
                    V.nombre,
                    T.deuda,
                    D.fecha_inicio,
                    D.precio,
                    D.cantidad
                FROM detalle_venta AS D 
                    INNER JOIN vendedor AS V
                ON D.id_vendedor = V.id_vendedor
                    INNER JOIN tipo_deuda T
                ON D.id_tipo_deuda = T.id_deuda
                WHERE D.id_venta = '$id'
                ";
        $resultado=metodoGet($query);
        echo json_encode($resultado->fetch(PDO::FETCH_ASSOC));
        // echo $resultado;
    }else{
        $query= "SELECT
                    D.id_venta,
                    V.nombre,
                    T.deuda,
                    D.fecha_inicio,
                    D.precio,
                    D.cantidad
                    -- (D.precio * D.cantidad) AS 'VENTA'
                FROM detalle_venta AS D 
                    INNER JOIN vendedor AS V
                ON D.id_vendedor = V.id_vendedor
                    INNER JOIN tipo_deuda T
                ON D.id_tipo_deuda = T.id_deuda
                ";
        $resultado=metodoGet($query);
        echo json_encode($resultado->fetchAll());
    }
    header("HTTP/1.1 200 OK");
    exit();
}

if($_POST['METHOD']=='POST'){
    unset($_POST['METHOD']);
    $fecha = $_POST['fecha'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $id_tipo_deuda = $_POST['id_tipo_deuda'];
    $id_vendedor = $_POST['id_vendedor'];
    $query="INSERT INTO 
        detalle_venta (
            id_venta,
            fecha,
            precio,
            cantidad,
            fecha_inicio,
            id_tipo_deuda,
            id_vendedor
        ) VALUES (
            NULL,
            '$fecha',
            '$precio',
            '$cantidad',
            '$fecha_inicio',
            '$id_tipo_deuda',
            '$id_vendedor'
        );";
    $queryAutoIncrement="select MAX(id_venta) as id from detalle_venta";
    $resultado=metodoPost($query, $queryAutoIncrement);
    echo json_encode($resultado);
    header("HTTP/1.1 200 OK");
    exit();
}

if($_POST['METHOD']=='PUT'){
    unset($_POST['METHOD']);
    $id_venta = $_POST['id_venta'];
    // $fecha = $_POST['fecha'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $fecha_inicio = $_POST['fecha_inicio'];
    // $id_tipo_deuda = $_POST['id_tipo_deuda'];
    // $id_vendedor = $_POST['id_vendedor'];
    $query="UPDATE detalle_venta 
            SET
                fecha_inicio='$fecha_inicio',
                precio= $precio,
                cantidad= $cantidad
            WHERE id_venta= $id_venta
            ";
    $resultado=metodoPut($query);
    echo json_encode($resultado);
    header("HTTP/1.1 200 OK");
    exit();
}

if($_POST['METHOD']=='DELETE'){
    unset($_POST['METHOD']);
    $id=$_POST['id_venta'];
    $query="DELETE FROM detalle_venta WHERE id_venta='$id'";
    $resultado=metodoDelete($query);
    echo json_encode($resultado);
    header("HTTP/1.1 200 OK");
    exit();
}

header("HTTP/1.1 400 Bad Request");


?>

<!-- ) VALUES (NULL, '1213', '2.5', '12', '2022-05-03', '1', '1');"; -->

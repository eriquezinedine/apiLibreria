<?php

include_once '../bd/BD.php';

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");



if($_SERVER['REQUEST_METHOD']=='GET'){
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $query= "select * from categoria where id = $id  ";
        $resultado=metodoGet($query);
        echo json_encode($resultado->fetch(PDO::FETCH_ASSOC));
        // echo $resultado;
    }else{
        $query="select * from categoria";
        $resultado=metodoGet($query);
        echo json_encode($resultado->fetchAll());
    }
    header("HTTP/1.1 200 OK");
    exit();
}

if($_POST['METHOD']=='POST'){
    unset($_POST['METHOD']);
    $nombre_categoria=$_POST['nombre_categoria'];
    $slug_categoria=$_POST['slug_categoria'];
    $query="insert into categoria(nombre_categoria,slug_categoria) values ('$nombre_categoria','$slug_categoria')";
    $queryAutoIncrement="select MAX(id) as id from categoria";
    $resultado=metodoPost($query, $queryAutoIncrement);
    echo json_encode($resultado);
    header("HTTP/1.1 200 OK");
    exit();
}


if($_POST['METHOD']=='PUT'){
    unset($_POST['METHOD']);
    $id=$_POST['id'];
    $nombre_categoria=$_POST['nombre_categoria'];
    $slug_categoria=$_POST['slug_categoria'];
    $query="UPDATE categoria SET nombre_categoria='$nombre_categoria', slug_categoria= '$slug_categoria' WHERE id='$id'";
    $resultado=metodoPut($query);
    echo json_encode($resultado);
    header("HTTP/1.1 200 OK");
    exit();
}

if($_POST['METHOD']=='DELETE'){
    unset($_POST['METHOD']);
    $id=$_POST['id'];
    $query="DELETE FROM categoria WHERE id=$id";
    $resultado=metodoDelete($query);
    echo json_encode($resultado);
    header("HTTP/1.1 200 OK");
    exit();
}

header("HTTP/1.1 400 Bad Request");


?>
<?php
/* Elimina registro seleccionado 
 * Creado por Tatiana Ortega
 * Fecha 14-10-2022
*/

//Archivo que contiene la conexion a la BD
include("conexion.php");

//Almacena el valor recibido ID del producto
$idProducto = $_GET['id_prod'];

//Elimina registro en BD de acuerdo al valor recibido de ID Producto
$eliminaSQL = $conexion->prepare("delete from productos where id_producto = ". $idProducto);      
if ($eliminaSQL -> execute()){
    //Retorna a la pagina inicial
    Header("Location:productos.php");
}

?>
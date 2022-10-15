<?php
    /* Configuracion de la conexion a la Base de datos 
     * Creado por Tatiana Ortega
     * Fecha 14-10-2022
    */

    //Datos para realizar la conexion
    $host ="localhost";
    $bd = "tienda_electronica";
    $password = "";
    $user = "root";

    //Control de excepciones
    try{
        //Conexion a la BD
        $conexion = new PDO("mysql:host=$host;dbname=$bd",$user,$password);       

    } catch ( Exception $ex) {
        echo $ex->getMessage();
    }

?>
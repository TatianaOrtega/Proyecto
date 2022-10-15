<?php
    /* Pagina principal muestra listado de productos 
     * Creado por Tatiana Ortega
     * Fecha 14-10-2022
    */

    //Conexion a la base de datos
    include("conexion.php");
    //Cabecera html 
    include("template/cabecera.php");

    //Sentencia consulta de productos    
    $consultaSQL = $conexion->prepare("select p.id_producto, p.nombre prod, p.modelo, p.serie, p.precio, m.nombre marca, s.nombre cat, fecha
                                       from productos p, marcas m, subcategorias s, categorias c
                                       where p.id_marca = m.id_marca
                                       and p.id_subcategoria = s.id_subcategoria
                                       and s.id_categoria = c.id_categoria" );
    //Ejecuta consulta y obtiene registros                                      
    $consultaSQL->execute();
    $listarProductos=$consultaSQL->fetchAll(PDO::FETCH_ASSOC);

        
?>

    <div class="container my-4">
    <table class="table">
    <thead>
        <tr>
        <th scope="col">    ID</th>
        <th scope="col">PRODUCTO</th>
        <th scope="col">MODELO</th>
        <th scope="col">SERIE</th>
        <th scope="col">PRECIO</th>
        <th scope="col">MARCA</th>
        <th scope="col">GRUPO</th>
        <th scope="col">FECHA</th>
        <th scope="col">ACCIONES</th>

        </tr>
    </thead>
    <tbody class="table-group-divider">
        <?php foreach($listarProductos as $producto)  { ?>
        <tr>
        <td><?php echo $producto['id_producto'] ?></td>
        <td><?php echo $producto['prod'] ?></td>
        <td><?php echo $producto['modelo'] ?></td>
        <td><?php echo $producto['serie'] ?></td>
        <td><?php echo "$".$producto['precio'] ?></td>
        <td><?php echo $producto['marca'] ?></td>
        <td><?php echo $producto['cat'] ?></td>
        <td><?php echo $producto['fecha'] ?></td>
        <td> 
            <!-- Botones editar y eliminar, se muestran por cada registro de la tabla-->       
            <a href="actualizar.php?id_prod=<?php echo $producto['id_producto'] ?>" class="btn btn-info">Editar</a>   
            <a href="eliminar.php?id_prod=<?php echo $producto['id_producto'] ?>" class="btn btn-danger" value = "Eliminar">Eliminar</a>           
        </td> 
        </tr>
        <?php } ?>        
    </tbody>
    </table>
    </div>
    
<?php    
    //Pie de pagina html
    include("template/pie.php");
?>


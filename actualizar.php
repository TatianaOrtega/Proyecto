<?php    
    /* Actualiza datos de productos de acuerdo a su ID
     * Creado por Tatiana Ortega
     * Fecha 14-10-2022
    */
    
    //LLamada al archivo que contiene la cabecera html
    include("template/cabecera.php");
    //Archivo que contiene la conexion a la BD
    include("conexion.php");

    //Almacena el valor recibido ID del producto
    $idProducto = $_GET['id_prod'];  

    $accion = (isset($_POST['accion']))?$_POST['accion']:"";

    //Inserta los datos en la tabla producto con los valores recibidos
    if($accion == "Actualizar"){
              
        $fecha = date('Y-m-d');
        //Obtiene la fecha actual

      $actualizaSQL = $conexion->prepare("update productos
                                        set nombre = '".$_POST['txtProducto']."',
                                            modelo = '".$_POST['txtModelo']."',
                                            serie = '".$_POST['txtSerie']."',
                                            precio = '".$_POST['txtPrecio']."',
                                            id_marca = '".$_POST['sltMarca']."',
                                            id_subcategoria = '".$_POST['sltSubcat']."',
                                            fecha = '".$fecha."'
                                            where id_producto = ".$idProducto);      
      
      if ($actualizaSQL -> execute()){
        echo "<script>alert('Actualización exitosa'); window.location.href='productos.php' </script>";        
      }
    }

    //Consulta el registro de acuerdo al Id producto
    $consultaSQL = $conexion->prepare("select p.nombre prod, p.modelo, p.serie, p.precio, m.id_marca marca, s.id_subcategoria cat
                                        from productos p, marcas m, subcategorias s, categorias c
                                        where p.id_marca = m.id_marca
                                        and p.id_subcategoria = s.id_subcategoria
                                        and s.id_categoria = c.id_categoria
                                        and p.id_producto = ".$idProducto);
    //Ejecuta consulta y carga los datos                                      
    $consultaSQL->execute();
    $producto=$consultaSQL->fetch(PDO::FETCH_LAZY);

    //Almacena los datos recuperados del producto para mostrarlos en las cajas de texto
    $txtProducto = $producto['prod'];
    $txtModelo = $producto['modelo'];
    $txtSerie = $producto['serie'];
    $txtPrecio = $producto['precio'];
    $txtMarca = $producto['marca'];
    $txtSubcat = $producto['cat'];
    
    //Consulta para obtener ID y nombres de marcas que se agregaran al select 
    $marcasSQL = $conexion->prepare("select id_marca, nombre from marcas" );
    $marcasSQL->execute();
    $listaMarcas=$marcasSQL->fetchAll(PDO::FETCH_ASSOC);

    //Consulta para obtener ID y nombres de subcategorias que se agregaran al select  
    $subcatSQL = $conexion->prepare("select id_subcategoria, nombre from subcategorias" );
    $subcatSQL->execute();
    $listaSubcat=$subcatSQL->fetchAll(PDO::FETCH_ASSOC);
    
?>

<div class="container my-4" >
<div class="col-lg-5 m-auto" >
<form method="POST" enctype="multipart/form-data">
  <fieldset>
    <legend>Actualizar Producto</legend>
    
    <div class="form-group">
      <label for="txtProducto" class="form-label mt-4">Producto</label>
      <input type="text" class="form-control" name="txtProducto" id="txtProducto" value="<?php echo $txtProducto?>" placeholder="Nombre del Producto">      
    </div>
    <div class="form-group">
      <label for="txtModelo" class="form-label mt-4">Modelo</label>
      <input type="text" class="form-control" name="txtModelo" id="txtModelo" value="<?php echo $txtModelo?>" placeholder="Modelo">
    </div>
    <div class="form-group">
      <label for="txtSerie" class="form-label mt-4">Serie</label>
      <input type="text" class="form-control" name="txtSerie" id="txtSerie" value="<?php echo $txtSerie?>" placeholder="Numero de Serie">
    </div>
    <div class="form-group">
      <label for="txtPrecio" class="form-label mt-4">Precio</label>
      <input type="text" class="form-control" name="txtPrecio" id="txtPrecio" value="<?php echo $txtPrecio?>" placeholder="$00.00">
    </div>    
    <div class="form-group">      
      <label for="sltMarca" class="form-label mt-4">Marca</label>
      <!-- Muestra Listado de marcas y asigna ID en el value -->
      <select class="form-select" name="sltMarca" id="sltMarca">
        <?php foreach($listaMarcas as $marca)  { ?>
        <option value="<?php echo $marca['id_marca'] ?>" <?php if ($marca['id_marca'] == $txtMarca){ ?> selected="selected"<?php } ?>  ><?php echo $marca['nombre'] ?></option>  
        <?php } ?>
      </select>
    </div>
    <div class="form-group">
      <label for="lblSubcat" class="form-label mt-4">Grupo</label>
      <!-- Muestra Listado de Subcategorias y asigna ID en el value -->
      <select class="form-select" name="sltSubcat" id="sltSubcat">
        <?php foreach($listaSubcat as $subcat)  { ?>
          <option value="<?php echo $subcat['id_subcategoria'] ?> " <?php if ($subcat['id_subcategoria'] == $txtSubcat){ ?> selected="selected"<?php } ?> ><?php echo $subcat['nombre'] ?></option> 
          <?php } ?> 
        </select>
    </div>    
    <br>
    <!-- Boton actualiza los datos -->
    <button type="submit" name="accion" class="btn btn-success" value="Actualizar">Actualizar</button>
  </fieldset>
</form>
</div>
</div>

<?php    
    include("template/pie.php");
?>


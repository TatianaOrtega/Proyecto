<?php    
    /* Ingresa datos de productos
     * Creado por Tatiana Ortega
     * Fecha 14-10-2022
    */
    
    //LLamada al archivo que contiene la cabecera html
    include("template/cabecera.php");
    //Archivo que contiene la conexion a la BD
    include("conexion.php");

    //Consulta para obtener ID y nombres de marcas que se agregaran al select 
    $marcasSQL = $conexion->prepare("select id_marca, nombre from marcas" );
    $marcasSQL->execute();
    $listaMarcas=$marcasSQL->fetchAll(PDO::FETCH_ASSOC);

    //Consulta para obtener ID y nombres de subcategorias que se agregaran al select  
    $subcatSQL = $conexion->prepare("select id_subcategoria, nombre from subcategorias" );
    $subcatSQL->execute();
    $listaSubcat=$subcatSQL->fetchAll(PDO::FETCH_ASSOC);

    
    //Obtiene los valores ingresados y los valida
    $producto = (isset($_POST['txtProducto']))?$_POST['txtProducto']:"";
    $modelo = (isset($_POST['txtModelo']))? $_POST['txtModelo']:"";
    $serie = (isset($_POST['txtSerie']))? $_POST['txtSerie']:"";
    $precio = (isset($_POST['txtPrecio']))? $_POST['txtPrecio']:"";
    $marca = (isset($_POST['sltMarca']))? $_POST['sltMarca']:"";
    $subcat = (isset($_POST['sltSubcat']))? $_POST['sltSubcat']:"";
    $accion = (isset($_POST['accion']))? $_POST['accion']:"";
    //Obtiene la fecha actual
    $fecha = date('Y-m-d');

    //Inserta los datos en la tabla producto con los valores recibidos
    if($accion == "Guardar"){
      if($producto !="" && $modelo !="" && $serie !="" && $precio !="" && $marca !="" && $subcat !=""){
        $insertaSQL = $conexion->prepare("insert into productos (nombre, modelo, serie, precio, id_marca, id_subcategoria, fecha)
                                        values ('".$producto."','".$modelo."','".$serie."','".$precio."','".$marca."','".$subcat."','".$fecha."')");      
        if ($insertaSQL -> execute()){
          echo "<script>alert('Datos ingresados correctamente');</script>";          
        }
      }else{
        echo "<script>alert('Debe ingresar todos los datos');</script>";
      }
      
      
    }  
    
?>

<div class="container my-4" >
<div class="col-lg-5 m-auto" >
<form method="POST" enctype="multipart/form-data">
  <fieldset>
    <legend>Ingresar Nuevo Producto</legend>
    
    <div class="form-group">
      <label for="txtProducto" class="form-label mt-4">Producto</label>
      <input type="text" class="form-control" name="txtProducto" id="txtProducto"  placeholder="Nombre del Producto">      
    </div>
    <div class="form-group">
      <label for="txtModelo" class="form-label mt-4">Modelo</label>
      <input type="text" class="form-control" name="txtModelo" id="txtModelo" placeholder="Modelo">
    </div>
    <div class="form-group">
      <label for="txtSerie" class="form-label mt-4">Serie</label>
      <input type="text" class="form-control" name="txtSerie" id="txtSerie" placeholder="Numero de Serie">
    </div>
    <div class="form-group">
      <label for="txtPrecio" class="form-label mt-4">Precio</label>
      <input type="text" class="form-control" name="txtPrecio" id="txtPrecio" placeholder="000.00">
    </div>    
    <div class="form-group">      
      <label for="sltMarca" class="form-label mt-4">Marca</label>
      <!-- Muestra Listado de marcas y asigna ID en el value -->
      <select class="form-select" name="sltMarca" id="sltMarca">
        <?php foreach($listaMarcas as $marca)  { ?>
        <option value="<?php echo $marca['id_marca'] ?>"><?php echo $marca['nombre'] ?></option>  
        <?php } ?>
      </select>
    </div>
    <div class="form-group">
      <label for="lblSubcat" class="form-label mt-4">Grupo</label>
      <!-- Muestra Listado de Subcategorias y asigna ID en el value -->
      <select class="form-select" name="sltSubcat" id="sltSubcat">
        <?php foreach($listaSubcat as $subcat)  { ?>
          <option value="<?php echo $subcat['id_subcategoria'] ?> "><?php echo $subcat['nombre'] ?></option> 
          <?php } ?> 
        </select>
    </div>    
    <br>
    <!-- Boton Guarda los datos -->
    <button type="submit" name="accion" class="btn btn-success" value="Guardar">Guardar</button>
  </fieldset>
</form>
</div>
</div>

<?php    
    include("template/pie.php");
?>


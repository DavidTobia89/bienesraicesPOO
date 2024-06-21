<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require '../../includes/app.php';


use App\Vendedor;


 // Crear el objeto
 $vendedor = new Vendedor();

 // Arreglo con mensajes de errores
 $errores = Vendedor::getErrores();

 // Ejecutar el código después de que el usuario envia el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   /** Crea una nueva instancia */
   $vendedor = new Vendedor($_POST['vendedor']);



   // Validar
   $errores = $vendedor->validar();

   if(empty($errores)) {
       $vendedor->guardar();
   }

   
}


incluirTemplate('header');

?>
    <main class="contenedor seccion">
        <h1>Registrar</h1>
        <a href="/bienesraices/admin/index.php" class="boton boton-verde">Volver</a>
        <?php foreach($errores as $error):?>
            <div class="alerta error">
            <?php echo $error ;?>
            </div>
            <?php endforeach;?>
        <form action="/bienesraices/admin/vendedores/crear.php" class="formulario" method="POST" >
      
            <?php include '../../includes/templates/formulario_vendedores.php'?> 
            <input type="submit" value="Registrar Vendedor" class="boton boton-verde">
        </form>
    </main>
    <?php

incluirTemplate('footer');

?>

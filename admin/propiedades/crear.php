<?php
require '../../includes/app.php';

use App\Propiedad;
use App\Vendedor;
// Importar Intervention Image
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

 // Crear el objeto
 $propiedad = new Propiedad;

 // Consultar para obtener los vendedores
 $vendedores = Vendedor::all();

 // Arreglo con mensajes de errores
 $errores = Propiedad::getErrores();

 // Ejecutar el código después de que el usuario envia el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    /** Crea una nueva instancia */
    $propiedad = new Propiedad($_POST['propiedad']);
    
    // Generar un nombre único
    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
   
    // Crear una instancia del ImageManager con el driver GD
    $manager = new ImageManager(new Driver());

    if ($_FILES['propiedad']['imagen']['tmp_name']) {
        // Leer la imagen desde el sistema de archivos
        $image = $manager->read($_FILES['propiedad']['tmp_name']['imagen']);

        // Redimensionar la imagen proporcionalmente a 800px de ancho
        $image->scale(width: 800);

        // Si deseas agregar una marca de agua, puedes hacerlo aquí
        // $image->place('path/to/watermark.png');

        // Guardar la imagen modificada
        

        $propiedad->setImagen($nombreImagen);
    }

    $errores = $propiedad->validar();
    debuguear( $errores);
    if (empty($errores)) {
        if (!is_dir(CARPETA_IMAGENES)) {
            mkdir(CARPETA_IMAGENES);
        }
        if ($_FILES['propiedad']['imagen']['tmp_name']) {
            $image->save(CARPETA_IMAGENES . $nombreImagen);
             
            }
        
        $propiedad->guardar();
        
    }
}


incluirTemplate('header');

?>
    <main class="contenedor seccion">
        <h1>Crear</h1>
        <a href="/bienesraices/admin/index.php" class="boton boton-verde">Volver</a>
        <?php foreach($errores as $error):?>
            <div class="alerta error">
            <?php echo $error ;?>
            </div>
            <?php endforeach;?>
        <form action="/bienesraices/admin/propiedades/crear.php" class="formulario" method="POST" enctype="multipart/form-data">
      
            <?php include '../../includes/templates/formulario_propiedades.php'?> 
            <input type="submit" value="Crear Propiedad" class="boton boton-verde">
        </form>
    </main>
    <?php

incluirTemplate('footer');

?>

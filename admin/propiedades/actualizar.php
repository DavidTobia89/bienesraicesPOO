<?php
require '../../includes/app.php';
use App\Propiedad;
use App\Vendedor;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


estaAutenticado();
//Validar que sea un ID valido
$id = $_GET['id']; // Usar corchetes en lugar de paréntesis
$id = filter_var($id, FILTER_VALIDATE_INT);
if (!$id) {
    header("Location: /bienesraices/admin/index.php");
    exit;
}

// Obtener los datos de la propiedad
$propiedad = Propiedad::find($id);

// Consultar para obtener los vendedores
$vendedores = Vendedor::all();

// Arreglo con mensajes de errores
$errores = Propiedad::getErrores();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conectar a la base de datos (asumiendo que $db es tu conexión)
    
    $args = $_POST['propiedad'];
    
    $propiedad->sincronizar($args);

    // Validar los datos del formulario
    $errores = $propiedad->validar();

    $manager = new ImageManager(new Driver());

    if (isset($_FILES['propiedad']['tmp_name']['imagen']) && $_FILES['propiedad']['tmp_name']['imagen']) {
        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

        // Leer la imagen desde el sistema de archivos
        $image = $manager->read($_FILES['propiedad']['tmp_name']['imagen']);

        // Redimensionar la imagen proporcionalmente a 800px de ancho
        $image->resize(800, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        // Si deseas agregar una marca de agua, puedes hacerlo aquí
        // $image->insert('path/to/watermark.png');

        // Guardar la imagen modificada
        $image->save(CARPETA_IMAGENES . $nombreImagen);

        // Establecer la imagen en la propiedad
        $propiedad->setImagen($nombreImagen);
    }

    if (empty($errores)) {
        if (isset($_FILES['propiedad']['tmp_name']['imagen']) && $_FILES['propiedad']['tmp_name']['imagen']) {
            // Guardar la imagen en el servidor
            $image->save(CARPETA_IMAGENES . $nombreImagen);
        }
        // Guardar la propiedad en la base de datos
        $propiedad->guardar();
    }
}

incluirTemplate('header');

?>
    <main class="contenedor seccion">
        <h1>Actualizar Propiedad</h1>
        <a href="/bienesraices/admin/index.php" class="boton boton-verde">Volver</a>
        <?php foreach($errores as $error):?>
            <div class="alerta error">
            <?php echo $error ;?>
            </div>
            <?php endforeach;?>
        <form class="formulario" method="POST" enctype="multipart/form-data">
            <?php include '../../includes/templates/formulario_propiedades.php'?> 
            
            <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
        </form>
    </main>
    <?php

incluirTemplate('footer');

?>

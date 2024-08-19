<?php

global $query;
require '../../includes/funciones.php';
$auth = estaAutenticado();

if(!$auth) {
    header('Location: /');
}

// Validar la URL por ID válido
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if(!$id) {
    header('Location: /admin');
}

// Base de datos
require '../../includes/config/database.php';
$db = conectarDB();

// Obtener los datos de los productos
$consulta = "SELECT * FROM productos WHERE id = {$id}";
$resultado = mysqli_query($db, $consulta);
$producto = mysqli_fetch_assoc($resultado);


// Arreglo con mensajes de errores
$errores = [];

$titulo = $producto['titulo'];
$precio = $producto['precio'];
$descripcion = $producto['descripcion'];
$imagenProducto = $producto['imagen'];

// Ejecutar el código después de que el usuario envia el formulario
if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $titulo = mysqli_real_escape_string( $db,  $_POST['titulo'] );
    $precio = mysqli_real_escape_string( $db,  $_POST['precio'] );
    $descripcion = mysqli_real_escape_string( $db,  $_POST['descripcion'] );

    // Asignar files hacia una variable
    $imagen = $_FILES['imagen'];

    if(!$titulo) {
        $errores[] = "Debes añadir un titulo";
    }

    if(!$precio) {
        $errores[] = 'El Precio es Obligatorio';
    }

    if( strlen( $descripcion ) < 50 ) {
        $errores[] = 'La descripción es obligatoria y debe tener al menos 50 caracteres';
    }


    // Validar por tamaño (1mb máximo)
    $medida = 1000 * 1000;
    if($imagen['size'] > $medida ) {
        $errores[] = 'La Imagen es muy pesada';
    }




    // Revisar que el array de errores este vacio

    if(empty($errores)) {

        // Crear carpeta
        $carpetaImagenes = '../../imagenes/';

        if(!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }

        $nombreImagen = '';

        // SUBIDA DE ARCHIVOS

        if($imagen['name']) {
            // Eliminar la imagen previa

            unlink($carpetaImagenes . $producto['imagen']);

            // // Generar un nombre único
            $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

            // // Subir la imagen
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen );
        } else {
            $nombreImagen = $producto['imagen'];
        }


        // Insertar en la base de datos
        $query = "UPDATE productos SET titulo = '{$titulo}', precio = '{$precio}', imagen = '{$nombreImagen}', descripcion = '{$descripcion}' WHERE id = {$id}";

        //echo "<pre>";
        //var_dump($query);
        //echo "</pre>";

        $resultado = mysqli_query($db, $query);

        if($resultado) {
            // Redireccionar al usuario.
            header('Location: /admin?resultado=2');
        }
    }




}



incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1> <b> Actualizar producto </b></h1>

    <a href="/admin" class="boton boton-azul">Volver</a>

    <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form class="formulario" method="POST" enctype="multipart/form-data">

        <div class="informacion">
        <fieldset class="izquierda">

            <label for="titulo">Titulo:</label>
            <input type="text" id="titulo" name="titulo" placeholder="Titulo producto" value="<?php echo $titulo; ?>">

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>

        </fieldset>

        <fieldset class="informacionDerecha">

        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" placeholder="Precio Producto" value="<?php echo $precio; ?>">

        <label for="imagen">Imagen:</label>
        <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

        <img src="/imagenes/<?php echo $imagenProducto; ?>" class="imagen-small">

        </fieldset>
        </div>

        <input type="submit" value="Actualizar Producto" class="boton boton-azul">
    </form>

</main>

<?php
incluirTemplate('footer');
?>
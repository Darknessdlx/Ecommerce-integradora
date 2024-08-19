<?php

require '../../includes/funciones.php';
$auth = estaAutenticado();

if(!$auth) {
    header('Location: /');
}

// Base de datos
require '../../includes/config/database.php';
$db = conectarDB();

    // Consultar para obtener los vendedores
//$consulta = "SELECT * FROM admin";
//$resultado = mysqli_query($db, $consulta);

// Arreglo con mensajes de errores
$errores = [];

$titulo = '';
$precio = '';
$descripcion = '';

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

    if(!$imagen['name'] || $imagen['error'] ) {
        $errores[] = 'La Imagen es Obligatoria';
    }

    // Validar por tamaño (1mb máximo)
    $medida = 1000 * 1000;


    if($imagen['size'] > $medida ) {
        $errores[] = 'La Imagen es muy pesada';
    }


    // echo "<pre>";
    // var_dump($errores);
    // echo "</pre>";


    // Revisar que el array de errores este vacio

    if(empty($errores)) {

        /** SUBIDA DE ARCHIVOS */

        // Crear carpeta
        $carpetaImagenes = '../../imagenes/';

        if(!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }

        // Generar un nombre único
        $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";


        // Subir la imagen
        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen );


        // Insertar en la base de datos
        $query = " INSERT INTO productos (titulo, precio, imagen, descripcion ) VALUES ( '$titulo', '$precio', '$nombreImagen', '$descripcion' ) ";

        // echo $query;

        $resultado = mysqli_query($db, $query);

        if($resultado) {
            // Redireccionar al usuario.
            header('Location: /admin?resultado=1');
        }
    }
}

incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Crear</h1>



    <a href="/admin" class="boton boton-azul">Volver</a>

    <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form class="formulario" method="POST" action="/admin/productos/crear.php" enctype="multipart/form-data">
        <fieldset>
            <legend>Información General</legend>

            <label for="titulo">Titulo:</label>
            <input type="text" id="titulo" name="titulo" placeholder="Titulo Producto" value="<?php echo $titulo; ?>">

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" placeholder="Precio Producto" value="<?php echo $precio; ?>">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>

        </fieldset>

        <input type="submit" value="Crear Producto" class="boton boton-azul">
    </form>

</main>

<?php
incluirTemplate('footer');
?>
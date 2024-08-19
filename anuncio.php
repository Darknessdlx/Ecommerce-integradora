<?php 

    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id) {
        header('Location: /');
    }

    // Importar la conexión
    require 'includes/config/database.php';
    $db = conectarDB();


    // consultar
    $query = "SELECT * FROM productos WHERE id = {$id}";

    // obtener resultado
    $resultado = mysqli_query($db, $query);

    if(!$resultado->num_rows) {
        header('Location: /');
    } 
    
    $producto = mysqli_fetch_assoc($resultado);


    require 'includes/funciones.php';
    incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-anuncio">
        <img loading="lazy" src="/imagenes/<?php echo $producto['imagen']; ?>" alt="imagen del producto">

        <h1> <b><?php echo $producto['titulo']; ?></b></h1>
        <div class="resumen-producto">
            <p class="precio">$<?php echo $producto['precio']; ?></p>

            <?php echo $producto['descripcion']; ?>
        </div>
    </main>

<?php 
    mysqli_close($db);

    incluirTemplate('footer');
?>
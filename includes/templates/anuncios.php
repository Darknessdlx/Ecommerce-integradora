<?php
// Importar la conexión

global $limite;
require __DIR__ . '/../config/database.php';
$db = conectarDB();


// consultar
$query = "SELECT * FROM productos LIMIT ${limite}";

// obtener resultado
$resultado = mysqli_query($db, $query);


?>

<div class="contenedor-anuncios">
        <?php while($producto = mysqli_fetch_assoc($resultado)): ?>
        <div class="anuncio">

            <img loading="lazy" src="/imagenes/<?php echo $producto['imagen']; ?>" alt="anuncio">

            <div class="contenido-anuncio">
                <h3><?php echo $producto['titulo']; ?></h3>
                <p class="precio">$<?php echo $producto['precio']; ?></p>


                <a href="/anuncio.php?id=<?php echo $producto['id']; ?>" class="boton-azul-block">
                    Ver Producto
                </a>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

<?php 

    // Cerrar la conexión
    mysqli_close($db);
?>
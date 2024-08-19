<?php 

    require '../includes/funciones.php';
    $auth = estaAutenticado();

    if(!$auth) {
        header('Location: /');
    }

    // Importar la conexión
    require '../includes/config/database.php';
    $db = conectarDB();

    // Escribir el Query
    $query = "SELECT * FROM productos";

    // Consultar la BD 
    $resultadoConsulta = mysqli_query($db, $query);


    // Muestra mensaje condicional
    $resultado = $_GET['resultado'] ?? null;


    

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if($id) {

            // Eliminar el archivo
            $query = "SELECT imagen FROM productos WHERE id = {$id}";

            $resultado = mysqli_query($db, $query);
            $producto = mysqli_fetch_assoc($resultado);
            
            unlink('../imagenes/' . $producto['imagen']);
    
            // Eliminar la producto
            $query = "DELETE FROM productos WHERE id = {$id}";
            $resultado = mysqli_query($db, $query);

            if($resultado) {
                header('location: /admin?resultado=3');
            }
        }

        
    }

    // Incluye un template

    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Administrador de Productos</h1>
        <?php if( intval( $resultado ) === 1): ?>
            <p class="alerta exito">Producto Creado Correctamente</p>
        <?php elseif( intval( $resultado ) === 2 ): ?>
            <p class="alerta exito">Producto Actualizado Correctamente</p>
        <?php elseif( intval( $resultado ) === 3 ): ?>
            <p class="alerta exito">Producto Eliminado Correctamente</p>
        <?php endif; ?>

        <a href="/admin/productos/crear.php" class="boton boton-azul">Nuevo Producto</a>


        <table class="tabla productos">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody> <!-- Mostrar los Resultados -->
                <?php while( $producto = mysqli_fetch_assoc($resultadoConsulta)): ?>
                <tr>
                    <td><?php echo $producto['id']; ?></td>
                    <td><?php echo $producto['titulo']; ?></td>
                    <td> <img src="/imagenes/<?php echo $producto['imagen']; ?>" class="imagen-tabla"> </td>
                    <td>$ <?php echo $producto['precio']; ?></td>
                    <td>
                        <form method="POST" class="w-100">

                            <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">

                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        
                        <a href="/admin/productos/actualizar.php?id=<?php echo $producto['id']; ?>" class="boton-azul-block">Actualizar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>

<?php 

    // Cerrar la conexion
    mysqli_close($db);

    incluirTemplate('footer');
?>
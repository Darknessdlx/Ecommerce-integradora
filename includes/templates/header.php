<?php
    if(!isset($_SESSION)) {
        session_start();
    }

    $auth = $_SESSION['login'] ?? false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FreshNotes</title>
    <link rel="stylesheet" href="/build/css/app.css">
</head>
<body>

<header class="header">
    <div class="contenedor contenido-header">
        <div class="barra">
            <a class="titulo-logo" href="/index.php">
                FreshNotes
            </a>

            <div class="mobile-menu">
                <img src="/build/img/barras.svg" alt="icono menu responsive">
            </div>

                <div class="derecha">
                    <nav class="navegacion">
                        <a href="/anuncios.php">Productos</a>
                        <a href="/nosotros.php">Nosotros</a>
                        <?php if(!$auth) : ?>
                            <a href="/login.php">Ingresar</a>
                        <?php else: ?>
                            <a href="/cerrar-sesion.php">Cerrar Sesión</a>
                            <a href="/admin/index.php">Administrar</a>
                        <?php endif; ?>
                    </nav>
                </div>

    </header>
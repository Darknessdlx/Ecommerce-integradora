<?php
    require 'includes/funciones.php';
    incluirTemplate('header');
?>

    <section class="Informacion seccion contenedor">
        <h2> Por que comprar libretas ecologicas?        </h2>

        <div class="unoindex">
            <p> Al escoger una libreta ecológica, estás haciendo una elección consciente por el planeta. Nuestras libretas están hechas con papel reciclado, lo que significa: </p>

                <p> <b> Menos árboles talados: </b> Contribuyes a la conservación de los bosques. </p>
                <p> <b> Menor consumo de agua y energía: </b> El proceso de reciclaje es más eficiente. </p>
                <p> <b> Disminución de la contaminación: </b> Ayudas a reducir tu huella de carbono. </p>
                <p> Además, nuestras libretas son duraderas, tienen un diseño elegante y son perfectas para tomar notas, dibujar o escribir tus ideas más creativas. </p>
            <img src="/src/img/foto_1.webp">
        </div>


    </section>

    <section class="seccion contenedor">
        <h2>Nuestro productos</h2>

        <?php

        $limite = 3;
        include 'includes/templates/anuncios.php';
        ?>

        <div class="alinear-derecha">
            <a href="anuncios.php" class="boton-azul">Ver Todas</a>
        </div>
    </section>

    <div class="contenedor seccion">
        <h1>Quienes somos</h1>

        <div class="iconos-nosotros">
            <div class="icono">
                <img src="build/img/icono1.svg" alt="Icono ecologia" loading="lazy">
                <h3>Ecologia</h3>
                <p>Creadores de libretas ecológicas. Transformamos el papel en un lienzo sostenible. Innovamos para un futuro verde, combinando diseño y conciencia ambiental en cada página.</p>
            </div>
            <div class="icono">
                <img src="build/img/icono2.svg" alt="Icono libreta" loading="lazy">
                <h3>Diferenciacion</h3>
                <p>Libretas ecológicas, diseñadas para inspirar. Elaboradas con materiales reciclados, cada página es una expresión de nuestro compromiso con el medio ambiente.</p>
            </div>
            <div class="icono">
                <img src="build/img/icono3.svg" alt="Icono innovacion" loading="lazy">
                <h3>Innovaccion</h3>
                <p>Unimos naturaleza e innovación en cada libreta. Papel reciclado, tintas vegetales y diseños inspiradores. Escribe tu historia con un toque ecológico.</p>
            </div>
        </div>
        <div class="alinear-derecha">
            <a href="nosotros.php" class="boton-azul">Mas sobre nosotros </a>
    </div>
<?php
    incluirTemplate('footer');
?>

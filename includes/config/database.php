<?php

function conectarDB() : mysqli {
    $db = new mysqli('localhost', 'root', '4D21dlxbba.', 'freshnotes_db');

    if(!$db) {
        echo "Error no se pudo conectar";
        exit;
    }

    return $db;

}
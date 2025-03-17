<?php
require 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mensaje = strtolower(trim($_POST['mensaje']));

    // Separar pregunta y respuesta si el usuario quiere enseñar al bot
    if (strpos($mensaje, "aprende:") === 0) {
        $partes = explode("|", substr($mensaje, 8), 2);
        if (count($partes) == 2) {
            $pregunta = strtolower(trim($partes[0]));
            $respuesta = trim($partes[1]);
            guardar_respuesta($pregunta, $respuesta);
            echo "¡Gracias! Ahora lo recordaré.";
        } else {
            echo "Para enseñarme usa el formato: aprende: pregunta | respuesta";
        }
    } else {
        // Buscar respuesta en la base de datos
        $respuesta = obtener_respuesta($mensaje);
        if (!$respuesta) {
            echo "No sé la respuesta. ¿Puedes enseñarme?";
        } else {
            echo $respuesta;
        }
    }
}
?>

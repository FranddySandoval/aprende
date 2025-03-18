<?php
require 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mensaje = strtolower(trim($_POST['mensaje']));

    // Verifica si el mensaje empieza con "aprende:" para enseñar al bot
    if (strpos($mensaje, 'aprende:') === 0) {
        // Extrae lo que viene después de "aprende:" y separa en pregunta y respuesta
        $contenido = substr($mensaje, 8);
        $partes = explode('|', $contenido, 2);

        if (count($partes) == 2) {
            $pregunta = strtolower(trim($partes[0]));
            $respuesta = trim($partes[1]);

            guardar_respuesta($pregunta, $respuesta);
            echo '¡Gracias! Ahora lo recordaré.';
        } else {
            echo 'Formato inválido. Usa: aprende: pregunta | respuesta';
        }
    } else {
        // Caso normal: buscar respuesta en la base de datos
        $respuesta = obtener_respuesta($mensaje);
        if (!$respuesta) {
            echo 'No sé la respuesta. ¿Puedes enseñarme?';
        } else {
            echo $respuesta;
        }
    }
}
?>

<?php
$db_file = 'chatbot.db';

function conectar_bd() {
    global $db_file;
    return new SQLite3($db_file);
}

function crear_bd() {
    $conn = conectar_bd();
    $conn->exec("CREATE TABLE IF NOT EXISTS respuestas (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        pregunta TEXT,
        respuesta TEXT
    )");
    $conn->close();
}

function guardar_respuesta($pregunta, $respuesta) {
    $conn = conectar_bd();
    $stmt = $conn->prepare("INSERT INTO respuestas (pregunta, respuesta) VALUES (?, ?)");
    $stmt->bindValue(1, $pregunta, SQLITE3_TEXT);
    $stmt->bindValue(2, $respuesta, SQLITE3_TEXT);
    $stmt->execute();
    $conn->close();
}

function obtener_respuesta($pregunta) {
    $conn = conectar_bd();
    $stmt = $conn->prepare("SELECT respuesta FROM respuestas WHERE pregunta = ?");
    $stmt->bindValue(1, $pregunta, SQLITE3_TEXT);
    $result = $stmt->execute();
    $fila = $result->fetchArray(SQLITE3_ASSOC);
    $conn->close();
    return $fila ? $fila['respuesta'] : null;
}

crear_bd();
?>

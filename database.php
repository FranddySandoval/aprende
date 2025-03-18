<?php
// Configura estos datos según tu servidor MySQL
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "chatbot";

// Conecta sin especificar la base de datos para crearla si no existe
function conectar_bd_sin_db() {
    global $servername, $username, $password;
    $conn = new mysqli($servername, $username, $password);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    return $conn;
}

// Crea la base de datos si no existe
function crear_base_de_datos() {
    global $dbname;
    $conn = conectar_bd_sin_db();
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    if (!$conn->query($sql)) {
        die("Error creando base de datos: " . $conn->error);
    }
    $conn->close();
}

// Conecta a la base de datos MySQL
function conectar_bd() {
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    return $conn;
}

// Crea la base de datos y la tabla 'respuestas' si no existen
function crear_bd() {
    crear_base_de_datos();
    $conn = conectar_bd();
    $sql = "CREATE TABLE IF NOT EXISTS respuestas (
                id INT AUTO_INCREMENT PRIMARY KEY,
                pregunta VARCHAR(255) NOT NULL,
                respuesta TEXT NOT NULL
            )";
    if (!$conn->query($sql)) {
        die("Error creando tabla: " . $conn->error);
    }
    $conn->close();
}

function guardar_respuesta($pregunta, $respuesta) {
    $conn = conectar_bd();
    $stmt = $conn->prepare("INSERT INTO respuestas (pregunta, respuesta) VALUES (?, ?)");
    if (!$stmt) {
        die("Error preparando consulta: " . $conn->error);
    }
    $stmt->bind_param("ss", $pregunta, $respuesta);
    $stmt->execute();
    if ($stmt->error) {
        die("Error ejecutando consulta: " . $stmt->error);
    }
    $stmt->close();
    $conn->close();
}

function obtener_respuesta($pregunta) {
    $conn = conectar_bd();
    $stmt = $conn->prepare("SELECT respuesta FROM respuestas WHERE pregunta = ?");
    if (!$stmt) {
        die("Error preparando consulta: " . $conn->error);
    }
    $stmt->bind_param("s", $pregunta);
    $stmt->execute();
    $stmt->bind_result($respuesta);
    if ($stmt->fetch()) {
        $stmt->close();
        $conn->close();
        return $respuesta;
    } else {
        $stmt->close();
        $conn->close();
        return null;
    }
}

// Crear la base de datos y la tabla
crear_bd();
?>

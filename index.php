<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Chatbot</h2>
    <div id="chatbox"></div>
    <input type="text" id="entrada" placeholder="Escribe un mensaje...">
    <button id="enviar">Enviar</button>

    <script>
        document.getElementById('enviar').addEventListener('click', function() {
            let entrada = document.getElementById('entrada').value;
            if (entrada.trim() !== '') {
                let chatbox = document.getElementById('chatbox');
                chatbox.innerHTML += '<p><strong>Tú:</strong> ' + entrada + '</p>';
                
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "procesar.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        chatbox.innerHTML += '<p><strong>Chatbot:</strong> ' + xhr.responseText + '</p>';
                        document.getElementById('entrada').value = '';
                    }
                };
                xhr.send("mensaje=" + encodeURIComponent(entrada));
            }
        });
    </script>
</body>
</html>

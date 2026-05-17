<?php

define('DB_HOST', '10.20.1.240');
define('DB_PORT', '3306');
define('DB_NAME', 'legado_digital');
define('DB_USER', 'ivanmc');
define('DB_PASS', 'Admin123!');

try {
    $pdo = new PDO(
        "mysql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME.";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

} catch (PDOException $e) {
    echo "<p style='color:red;'>Error conectando a la base de datos: " . $e->getMessage() . "</p>";
    exit;
}

$stmt = $pdo->query("SELECT * FROM articulos ORDER BY fecha_pub DESC");

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
} catch (PDOException $e) {
    echo "<h1>Fallo de conexión crítico</h1>";
    echo "Error de depuración: " . $e->getMessage();
    exit;
}
echo "<div id='articulos'>";

foreach ($stmt as $art) {

    $titulo = htmlspecialchars($art['titulo']);
    $autor = htmlspecialchars($art['autor'] ?: "Desconocido");
    $fecha = htmlspecialchars($art['fecha_pub']);
    $ruta  = htmlspecialchars($art['ruta_pdf']);
    $texto = htmlspecialchars($art['texto'] ?: "");

    echo "
    <div class='article-card'
         onclick=\"window.open('$ruta', '_blank')\">
    
        <h3>$titulo</h3>

        <div class='article-meta'>
          <div><strong>Autor:</strong> $autor</div>
          <div><strong>Fecha:</strong> $fecha</div>
        </div>

        <div class='article-text'>
          <p>$texto</p>
        </div>

        <p style='color:var(--gold-light);'>📄 Haz click para visualizar el documento</p>

    </div>
    ";
}

echo "</div>";

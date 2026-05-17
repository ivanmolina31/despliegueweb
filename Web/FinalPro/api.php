<?php
/**
 * Legado Digital S.A. — API REST
 * Conexión a BD remota MariaDB
 */

// ── CONFIGURACIÓN ────────────────────────────────────────────────
define('DB_HOST', '10.20.1.240');
define('DB_PORT', '3306');
define('DB_NAME', 'legado_digital');
define('DB_USER', 'ivanmc');
define('DB_PASS', 'Admin123!');

// ── CABECERAS ────────────────────────────────────────────────────
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

// ── CONEXIÓN ─────────────────────────────────────────────────────
$pdo = null;
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_TIMEOUT            => 5,
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error de conexión a la base de datos', 'details' => $e->getMessage()]);
    exit;
}

// ── ROUTER ───────────────────────────────────────────────────────
$action = $_GET['action'] ?? 'list';

try {
    switch ($action) {

        // ── LISTAR ARTÍCULOS ──────────────────────────────────────────
        case 'list':
            $q     = trim($_GET['q'] ?? '');
            $page  = max(1, intval($_GET['page'] ?? 1));
            $limit = min(100, max(1, intval($_GET['limit'] ?? 5)));
            $offset = ($page - 1) * $limit;

            $where  = [];
            $params = [];

            if ($q !== '') {
                $where[]      = '(titulo LIKE :q OR autor LIKE :q OR ruta_pdf LIKE :q)';
                $params[':q'] = '%' . $q . '%';
            }

            $whereSQL = empty($where) ? '' : 'WHERE ' . implode(' AND ', $where);

            // Contar total
            $countStmt = $pdo->prepare("SELECT COUNT(*) as total FROM articulos $whereSQL");
            $countStmt->execute($params);
            $total = (int) $countStmt->fetch()['total'];

            // Obtener resultados
            $stmt = $pdo->prepare("
                SELECT id, titulo, autor, fecha_pub, ruta_pdf
                FROM articulos
                $whereSQL
                ORDER BY fecha_pub DESC
                LIMIT :limit OFFSET :offset
            ");

            foreach ($params as $k => $v) {
                $stmt->bindValue($k, $v);
            }
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();

            echo json_encode([
                'exito'         => true,
                'articulos'     => $stmt->fetchAll(),
                'total'         => $total,
                'pagina'        => $page,
                'por_pagina'    => $limit,
                'total_paginas' => (int) ceil($total / $limit),
                'busqueda'      => $q,
            ]);
            break;

        // ── OBTENER ARTÍCULO ──────────────────────────────────────────
        case 'get':
            $id = intval($_GET['id'] ?? 0);
            if ($id <= 0) {
                http_response_code(400);
                echo json_encode(['error' => 'ID inválido']);
                break;
            }

            $stmt = $pdo->prepare("
                SELECT id, titulo, autor, fecha_pub, ruta_pdf
                FROM articulos
                WHERE id = :id
            ");
            $stmt->execute([':id' => $id]);
            $articulo = $stmt->fetch();

            if (!$articulo) {
                http_response_code(404);
                echo json_encode(['error' => 'Artículo no encontrado']);
                break;
            }

            echo json_encode([
                'exito'    => true,
                'articulo' => $articulo,
            ]);
            break;

        // ── ESTADÍSTICAS ─────────────────────────────────────────────
        case 'stats':
            $stmt = $pdo->query("SELECT COUNT(*) as total FROM articulos");
            $stats = $stmt->fetch();

            echo json_encode([
                'exito'          => true,
                'total_articulos' => (int) $stats['total'],
            ]);
            break;

        default:
            http_response_code(400);
            echo json_encode([
                'error' => 'Acción desconocida',
                'acciones_disponibles' => ['list', 'get', 'stats'],
            ]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al procesar la solicitud', 'details' => $e->getMessage()]);
}

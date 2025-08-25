<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

try {
    $host = $_POST['host'] ?? '';
    $port = $_POST['port'] ?? 3306;
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $database = $_POST['database'] ?? '';

    // Validate required fields
    if (empty($host) || empty($username) || empty($database)) {
        throw new Exception('Host, username, dan database harus diisi');
    }

    // Create DSN
    $dsn = "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4";
    
    // PDO options
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
    ];

    // Connect to database
    $pdo = new PDO($dsn, $username, $password, $options);
    
    $result = [
        'tables' => [],
        'views' => [],
        'triggers' => []
    ];

    // Get Tables
    $stmt = $pdo->prepare("
        SELECT 
            TABLE_NAME as name,
            IFNULL(TABLE_ROWS, 0) as table_rows,
            IFNULL(DATA_LENGTH, 0) as data_length,
            IFNULL(INDEX_LENGTH, 0) as index_length,
            IFNULL(TABLE_COMMENT, '') as comment
        FROM information_schema.TABLES 
        WHERE TABLE_SCHEMA = ? 
        AND TABLE_TYPE = 'BASE TABLE'
        ORDER BY TABLE_NAME
    ");
    $stmt->execute([$database]);
    $tables = $stmt->fetchAll();

    foreach ($tables as $table) {
        $result['tables'][] = [
            'name' => $table['name'],
            'rows' => (int)($table['table_rows'] ?? 0),
            'size' => (int)($table['data_length'] ?? 0) + (int)($table['index_length'] ?? 0),
            'comment' => $table['comment'] ?? ''
        ];
    }

    // Get Views
    $stmt = $pdo->prepare("
        SELECT 
            TABLE_NAME as name,
            VIEW_DEFINITION as definition,
            CHECK_OPTION,
            IS_UPDATABLE
        FROM information_schema.VIEWS 
        WHERE TABLE_SCHEMA = ?
        ORDER BY TABLE_NAME
    ");
    $stmt->execute([$database]);
    $views = $stmt->fetchAll();

    foreach ($views as $view) {
        $result['views'][] = [
            'name' => $view['name'],
            'definition' => $view['definition'],
            'check_option' => $view['CHECK_OPTION'],
            'is_updatable' => $view['IS_UPDATABLE']
        ];
    }

    // Get Triggers
    $stmt = $pdo->prepare("
        SELECT 
            TRIGGER_NAME as name,
            EVENT_MANIPULATION as event,
            EVENT_OBJECT_TABLE as table_name,
            ACTION_TIMING as timing,
            ACTION_STATEMENT as statement
        FROM information_schema.TRIGGERS 
        WHERE TRIGGER_SCHEMA = ?
        ORDER BY EVENT_OBJECT_TABLE, TRIGGER_NAME
    ");
    $stmt->execute([$database]);
    $triggers = $stmt->fetchAll();

    foreach ($triggers as $trigger) {
        $result['triggers'][] = [
            'name' => $trigger['name'],
            'event' => $trigger['event'],
            'table' => $trigger['table_name'],
            'timing' => $trigger['timing'],
            'statement' => $trigger['statement']
        ];
    }

    // Get Stored Procedures
    $stmt = $pdo->prepare("
        SELECT 
            ROUTINE_NAME as name,
            ROUTINE_TYPE as type,
            DATA_TYPE as data_type,
            ROUTINE_DEFINITION as definition
        FROM information_schema.ROUTINES 
        WHERE ROUTINE_SCHEMA = ?
        AND ROUTINE_TYPE = 'PROCEDURE'
        ORDER BY ROUTINE_NAME
    ");
    $stmt->execute([$database]);
    $procedures = $stmt->fetchAll();

    $result['procedures'] = [];
    foreach ($procedures as $procedure) {
        $result['procedures'][] = [
            'name' => $procedure['name'],
            'type' => $procedure['type'],
            'data_type' => $procedure['data_type'],
            'definition' => $procedure['definition']
        ];
    }

    // Get Functions
    $stmt = $pdo->prepare("
        SELECT 
            ROUTINE_NAME as name,
            ROUTINE_TYPE as type,
            DATA_TYPE as data_type,
            ROUTINE_DEFINITION as definition
        FROM information_schema.ROUTINES 
        WHERE ROUTINE_SCHEMA = ? 
        AND ROUTINE_TYPE = 'FUNCTION'
        ORDER BY ROUTINE_NAME
    ");
    $stmt->execute([$database]);
    $functions = $stmt->fetchAll();

    $result['functions'] = [];
    foreach ($functions as $function) {
        $result['functions'][] = [
            'name' => $function['name'],
            'type' => $function['type'],
            'data_type' => $function['data_type'],
            'definition' => $function['definition']
        ];
    }

    echo json_encode([
        'success' => true,
        'message' => 'Objek database berhasil dimuat',
        'data' => $result
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Gagal mengambil objek database: ' . $e->getMessage()
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
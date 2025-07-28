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

    // Test connection
    $pdo = new PDO($dsn, $username, $password, $options);
    
    // Test if we can query the database
    $stmt = $pdo->query("SELECT DATABASE() as current_db, VERSION() as version");
    $result = $stmt->fetch();
    
    echo json_encode([
        'success' => true,
        'message' => 'Koneksi berhasil',
        'data' => [
            'database' => $result['current_db'],
            'version' => $result['version']
        ]
    ]);

} catch (PDOException $e) {
    $errorMessage = 'Koneksi database gagal';
    
    // Provide more specific error messages
    if (strpos($e->getMessage(), 'Access denied') !== false) {
        $errorMessage = 'Username atau password salah';
    } elseif (strpos($e->getMessage(), 'Unknown database') !== false) {
        $errorMessage = 'Database tidak ditemukan';
    } elseif (strpos($e->getMessage(), 'Connection refused') !== false) {
        $errorMessage = 'Tidak dapat terhubung ke server database';
    } elseif (strpos($e->getMessage(), 'Unknown MySQL server host') !== false) {
        $errorMessage = 'Host database tidak ditemukan';
    }
    
    echo json_encode([
        'success' => false,
        'message' => $errorMessage,
        'error' => $e->getMessage()
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
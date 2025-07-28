<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../classes/BackupGenerator.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

try {
    // Get JSON input
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (!$data) {
        throw new Exception('Invalid JSON data');
    }

    $connection = $data['connection'] ?? [];
    $objects = $data['objects'] ?? [];
    $options = $data['options'] ?? [];

    // Validate required data
    if (empty($connection['host']) || empty($connection['username']) || empty($connection['database'])) {
        throw new Exception('Data koneksi tidak lengkap');
    }

    // Create backup generator
    $generator = new BackupGenerator($connection);
    
    // Set options
    $generator->setIncludeStructure($options['includeStructure'] ?? true);
    $generator->setIncludeData($options['includeData'] ?? true);
    $generator->setTableDataOptions($options['tableDataOptions'] ?? []);

    // Generate backup
    $filename = $generator->generateBackup($objects);

    echo json_encode([
        'success' => true,
        'message' => 'Backup berhasil dibuat',
        'filename' => $filename,
        'size' => filesize('../downloads/' . $filename)
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
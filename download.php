<?php
/**
 * Secure file download handler for MySQL Backup Tool
 */

require_once 'config/config.php';

// Check if filename is provided
if (!isset($_GET['file']) || empty($_GET['file'])) {
    http_response_code(400);
    die('File parameter is required');
}

$filename = $_GET['file'];

// Sanitize filename
$filename = basename($filename);

// Check if file extension is allowed
if (!isAllowedExtension($filename)) {
    http_response_code(403);
    die('File type not allowed');
}

// Construct full file path
$filepath = BACKUP_DIR . $filename;

// Check if file exists
if (!file_exists($filepath)) {
    http_response_code(404);
    die('File not found');
}

// Check if file is readable
if (!is_readable($filepath)) {
    http_response_code(403);
    die('File not accessible');
}

// Get file info
$filesize = filesize($filepath);
$mimeType = getFileMimeType($filename);

// Security check - ensure file is within backup directory
$realBackupDir = realpath(BACKUP_DIR);
$realFilePath = realpath($filepath);

if (strpos($realFilePath, $realBackupDir) !== 0) {
    http_response_code(403);
    die('Access denied');
}

// Set headers for file download
header('Content-Type: ' . $mimeType);
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Length: ' . $filesize);
header('Cache-Control: no-cache, must-revalidate');
header('Expires: 0');
header('Pragma: public');

// Prevent execution timeout for large files
set_time_limit(0);

// Output file content
if ($filesize > 10 * 1024 * 1024) { // Files larger than 10MB
    // Stream large files in chunks
    $handle = fopen($filepath, 'rb');
    if ($handle === false) {
        http_response_code(500);
        die('Cannot open file');
    }
    
    while (!feof($handle)) {
        echo fread($handle, 8192); // 8KB chunks
        flush();
        
        // Check if client disconnected
        if (connection_aborted()) {
            break;
        }
    }
    
    fclose($handle);
} else {
    // Small files can be output directly
    readfile($filepath);
}

// Log download (optional)
if (LOG_ERRORS) {
    $logMessage = date('Y-m-d H:i:s') . " - Downloaded: {$filename} (" . formatBytes($filesize) . ")" . PHP_EOL;
    file_put_contents(dirname(ERROR_LOG_FILE) . '/download.log', $logMessage, FILE_APPEND | LOCK_EX);
}

exit;
?>
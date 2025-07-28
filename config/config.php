<?php
/**
 * Configuration file for MySQL Backup Tool
 */

// Application settings
define('APP_NAME', 'MySQL Database Backup Tool');
define('APP_VERSION', '1.0.0');
define('APP_AUTHOR', 'Herliansyah');

// File settings
define('BACKUP_DIR', __DIR__ . '/../downloads/');
define('MAX_FILE_SIZE', 100 * 1024 * 1024); // 100MB
define('ALLOWED_EXTENSIONS', ['sql', 'zip']);

// Database settings
define('DEFAULT_PORT', 3306);
define('CONNECTION_TIMEOUT', 30);
define('MAX_EXECUTION_TIME', 300); // 5 minutes

// Security settings
define('ENABLE_DEBUG', false);
define('LOG_ERRORS', true);
define('ERROR_LOG_FILE', __DIR__ . '/../logs/error.log');

// UI settings
define('ITEMS_PER_PAGE', 25);
define('MAX_ROWS_LIMIT', 100000);

// Backup settings
define('DEFAULT_INCLUDE_STRUCTURE', true);
define('DEFAULT_INCLUDE_DATA', true);
define('BACKUP_FILENAME_FORMAT', 'backup_{database}_{timestamp}.sql');

// Memory and time limits
ini_set('memory_limit', '512M');
ini_set('max_execution_time', MAX_EXECUTION_TIME);

// Error reporting
if (ENABLE_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Create necessary directories
$directories = [
    BACKUP_DIR,
    dirname(ERROR_LOG_FILE)
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

/**
 * Log error messages
 */
function logError($message, $file = __FILE__, $line = __LINE__) {
    if (LOG_ERRORS) {
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[{$timestamp}] Error in {$file}:{$line} - {$message}" . PHP_EOL;
        file_put_contents(ERROR_LOG_FILE, $logMessage, FILE_APPEND | LOCK_EX);
    }
}

/**
 * Format bytes to human readable format
 */
function formatBytes($bytes, $precision = 2) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    
    for ($i = 0; $bytes > 1024; $i++) {
        $bytes /= 1024;
    }
    
    return round($bytes, $precision) . ' ' . $units[$i];
}

/**
 * Sanitize filename
 */
function sanitizeFilename($filename) {
    // Remove special characters
    $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);
    
    // Remove multiple underscores
    $filename = preg_replace('/_+/', '_', $filename);
    
    // Trim underscores from start and end
    $filename = trim($filename, '_');
    
    return $filename;
}

/**
 * Generate secure filename
 */
function generateBackupFilename($database) {
    $timestamp = date('Y-m-d_H-i-s');
    $database = sanitizeFilename($database);
    
    return str_replace(
        ['{database}', '{timestamp}'],
        [$database, $timestamp],
        BACKUP_FILENAME_FORMAT
    );
}

/**
 * Check if file extension is allowed
 */
function isAllowedExtension($filename) {
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    return in_array($extension, ALLOWED_EXTENSIONS);
}

/**
 * Get file MIME type
 */
function getFileMimeType($filename) {
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    
    $mimeTypes = [
        'sql' => 'application/sql',
        'zip' => 'application/zip',
        'txt' => 'text/plain'
    ];
    
    return $mimeTypes[$extension] ?? 'application/octet-stream';
}
?>
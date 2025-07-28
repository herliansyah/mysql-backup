<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MySQL Backup Tool - Installation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .install-container {
            max-width: 800px;
            margin: 50px auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .install-header {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .install-body {
            padding: 40px;
        }
        .check-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        .check-item:last-child {
            border-bottom: none;
        }
        .status-ok {
            color: #059669;
        }
        .status-error {
            color: #dc2626;
        }
        .status-warning {
            color: #d97706;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="install-container">
            <div class="install-header">
                <h1><i class="fas fa-database"></i> MySQL Backup Tool</h1>
                <p class="mb-0">Installation & System Check</p>
            </div>
            <div class="install-body">
                <?php
                $checks = [];
                $allPassed = true;

                // Check PHP version
                $phpVersion = phpversion();
                $phpOk = version_compare($phpVersion, '7.4.0', '>=');
                $checks[] = [
                    'name' => 'PHP Version',
                    'status' => $phpOk,
                    'message' => $phpOk ? "PHP {$phpVersion} ✓" : "PHP {$phpVersion} (Required: 7.4+)",
                    'required' => true
                ];
                if (!$phpOk) $allPassed = false;

                // Check PDO extension
                $pdoOk = extension_loaded('pdo');
                $checks[] = [
                    'name' => 'PDO Extension',
                    'status' => $pdoOk,
                    'message' => $pdoOk ? 'Available ✓' : 'Not available',
                    'required' => true
                ];
                if (!$pdoOk) $allPassed = false;

                // Check PDO MySQL
                $pdoMysqlOk = extension_loaded('pdo_mysql');
                $checks[] = [
                    'name' => 'PDO MySQL Extension',
                    'status' => $pdoMysqlOk,
                    'message' => $pdoMysqlOk ? 'Available ✓' : 'Not available',
                    'required' => true
                ];
                if (!$pdoMysqlOk) $allPassed = false;

                // Check JSON extension
                $jsonOk = extension_loaded('json');
                $checks[] = [
                    'name' => 'JSON Extension',
                    'status' => $jsonOk,
                    'message' => $jsonOk ? 'Available ✓' : 'Not available',
                    'required' => true
                ];
                if (!$jsonOk) $allPassed = false;

                // Check file permissions
                $directories = ['downloads', 'logs'];
                foreach ($directories as $dir) {
                    if (!is_dir($dir)) {
                        mkdir($dir, 0755, true);
                    }
                    $writable = is_writable($dir);
                    $checks[] = [
                        'name' => "Directory: {$dir}/",
                        'status' => $writable,
                        'message' => $writable ? 'Writable ✓' : 'Not writable',
                        'required' => true
                    ];
                    if (!$writable) $allPassed = false;
                }

                // Check memory limit
                $memoryLimit = ini_get('memory_limit');
                $memoryBytes = $this->convertToBytes($memoryLimit);
                $memoryOk = $memoryBytes >= 128 * 1024 * 1024; // 128MB
                $checks[] = [
                    'name' => 'Memory Limit',
                    'status' => $memoryOk,
                    'message' => $memoryOk ? "{$memoryLimit} ✓" : "{$memoryLimit} (Recommended: 128M+)",
                    'required' => false
                ];

                // Check max execution time
                $maxTime = ini_get('max_execution_time');
                $timeOk = $maxTime == 0 || $maxTime >= 60;
                $checks[] = [
                    'name' => 'Max Execution Time',
                    'status' => $timeOk,
                    'message' => $timeOk ? "{$maxTime}s ✓" : "{$maxTime}s (Recommended: 60s+)",
                    'required' => false
                ];

                function convertToBytes($value) {
                    $value = trim($value);
                    $last = strtolower($value[strlen($value)-1]);
                    $value = (int) $value;
                    switch($last) {
                        case 'g': $value *= 1024;
                        case 'm': $value *= 1024;
                        case 'k': $value *= 1024;
                    }
                    return $value;
                }
                ?>

                <h3>System Requirements Check</h3>
                <div class="mt-4">
                    <?php foreach ($checks as $check): ?>
                        <div class="check-item">
                            <div>
                                <strong><?= $check['name'] ?></strong>
                                <?php if (!$check['required']): ?>
                                    <small class="text-muted">(Optional)</small>
                                <?php endif; ?>
                            </div>
                            <div class="<?= $check['status'] ? 'status-ok' : ($check['required'] ? 'status-error' : 'status-warning') ?>">
                                <i class="fas <?= $check['status'] ? 'fa-check-circle' : 'fa-times-circle' ?>"></i>
                                <?= $check['message'] ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if ($allPassed): ?>
                    <div class="alert alert-success mt-4">
                        <h5><i class="fas fa-check-circle"></i> Installation Ready!</h5>
                        <p class="mb-0">All system requirements are met. You can now use the MySQL Backup Tool.</p>
                    </div>
                    
                    <div class="mt-4">
                        <h5>Quick Start Guide:</h5>
                        <ol>
                            <li>Access the main application: <a href="index.php" class="btn btn-sm btn-primary">Open Backup Tool</a></li>
                            <li>Test with sample database: <a href="examples/sample-database.sql" class="btn btn-sm btn-outline-secondary">Download Sample DB</a></li>
                            <li>Read documentation: <a href="README.md" class="btn btn-sm btn-outline-info">View README</a></li>
                        </ol>
                    </div>

                    <div class="mt-4">
                        <h5>Sample Database Setup:</h5>
                        <p>To test the backup tool, you can import the sample database:</p>
                        <pre class="bg-light p-3 rounded"><code>mysql -u username -p < examples/sample-database.sql</code></pre>
                    </div>

                <?php else: ?>
                    <div class="alert alert-danger mt-4">
                        <h5><i class="fas fa-exclamation-triangle"></i> Installation Issues</h5>
                        <p>Please fix the issues above before using the MySQL Backup Tool.</p>
                    </div>

                    <div class="mt-4">
                        <h5>Common Solutions:</h5>
                        <ul>
                            <li><strong>PHP Extensions:</strong> Install missing extensions via your package manager or hosting control panel</li>
                            <li><strong>Directory Permissions:</strong> Run <code>chmod 755 downloads/ logs/</code></li>
                            <li><strong>Memory Limit:</strong> Increase in php.ini: <code>memory_limit = 256M</code></li>
                            <li><strong>Execution Time:</strong> Increase in php.ini: <code>max_execution_time = 300</code></li>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="mt-5 pt-4 border-top">
                    <h5>Application Information:</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li><strong>Version:</strong> 1.0.0</li>
                                <li><strong>PHP Version:</strong> <?= $phpVersion ?></li>
                                <li><strong>Server:</strong> <?= $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' ?></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li><strong>Memory Limit:</strong> <?= ini_get('memory_limit') ?></li>
                                <li><strong>Max Execution:</strong> <?= ini_get('max_execution_time') ?>s</li>
                                <li><strong>Upload Max:</strong> <?= ini_get('upload_max_filesize') ?></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="index.php" class="btn btn-primary btn-lg">
                        <i class="fas fa-arrow-right"></i> Continue to Application
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
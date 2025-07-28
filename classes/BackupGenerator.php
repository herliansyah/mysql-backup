<?php

class BackupGenerator {
    private $pdo;
    private $database;
    private $includeStructure = true;
    private $includeData = true;
    private $compressBackup = false;
    private $tableDataOptions = [];
    private $output = '';

    public function __construct($connection) {
        $this->database = $connection['database'];
        $this->connect($connection);
    }

    private function connect($connection) {
        $host = $connection['host'];
        $port = $connection['port'] ?? 3306;
        $username = $connection['username'];
        $password = $connection['password'];
        $database = $connection['database'];

        $dsn = "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4";
        
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ];

        $this->pdo = new PDO($dsn, $username, $password, $options);
    }

    public function setIncludeStructure($include) {
        $this->includeStructure = $include;
    }

    public function setIncludeData($include) {
        $this->includeData = $include;
    }

    public function setTableDataOptions($options) {
        $this->tableDataOptions = $options;
    }

    public function setCompressBackup($compress) {
        $this->compressBackup = $compress;
    }

    public function generateBackup($objects) {
        $this->output = '';
        
        // Add header
        $this->addHeader();

        // Disable foreign key checks
        $this->addLine("SET FOREIGN_KEY_CHECKS = 0;");
        $this->addLine("SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';");
        $this->addLine("SET AUTOCOMMIT = 0;");
        $this->addLine("START TRANSACTION;");
        $this->addLine("SET time_zone = '+00:00';");
        $this->addLine("");

        // Process tables
        if (!empty($objects['tables'])) {
            $this->addLine("-- --------------------------------------------------------");
            $this->addLine("-- Tables");
            $this->addLine("-- --------------------------------------------------------");
            $this->addLine("");

            foreach ($objects['tables'] as $table) {
                $this->processTable($table);
            }
        }

        // Process views
        if (!empty($objects['views'])) {
            $this->addLine("-- --------------------------------------------------------");
            $this->addLine("-- Views");
            $this->addLine("-- --------------------------------------------------------");
            $this->addLine("");

            foreach ($objects['views'] as $view) {
                $this->processView($view);
            }
        }

        // Process triggers
        if (!empty($objects['triggers'])) {
            $this->addLine("-- --------------------------------------------------------");
            $this->addLine("-- Triggers");
            $this->addLine("-- --------------------------------------------------------");
            $this->addLine("");

            foreach ($objects['triggers'] as $trigger) {
                $this->processTrigger($trigger);
            }
        }

        // Process procedures and functions
        if (!empty($objects['procedures'])) {
            $this->addLine("-- --------------------------------------------------------");
            $this->addLine("-- Stored Procedures");
            $this->addLine("-- --------------------------------------------------------");
            $this->addLine("");

            foreach ($objects['procedures'] as $procedure) {
                $this->processProcedure($procedure);
            }
        }

        if (!empty($objects['functions'])) {
            $this->addLine("-- --------------------------------------------------------");
            $this->addLine("-- Functions");
            $this->addLine("-- --------------------------------------------------------");
            $this->addLine("");

            foreach ($objects['functions'] as $function) {
                $this->processFunction($function);
            }
        }

        // Re-enable foreign key checks
        $this->addLine("SET FOREIGN_KEY_CHECKS = 1;");
        $this->addLine("COMMIT;");

        // Save to file
        return $this->saveToFile();
    }

    private function addHeader() {
        $this->addLine("-- MySQL Database Backup");
        $this->addLine("-- Generated on: " . date('Y-m-d H:i:s'));
        $this->addLine("-- Database: " . $this->database);
        $this->addLine("-- --------------------------------------------------------");
        $this->addLine("");
    }

    private function processTable($tableName) {
        $this->addLine("-- Table structure for table `{$tableName}`");
        $this->addLine("--");
        $this->addLine("");

        if ($this->includeStructure) {
            // Drop table if exists
            $this->addLine("DROP TABLE IF EXISTS `{$tableName}`;");

            // Get create table statement
            $stmt = $this->pdo->prepare("SHOW CREATE TABLE `{$tableName}`");
            $stmt->execute();
            $result = $stmt->fetch();
            
            if ($result) {
                $createTable = $result['Create Table'];
                $this->addLine($createTable . ";");
                $this->addLine("");
            }
        }

        if ($this->includeData) {
            $this->addLine("-- Dumping data for table `{$tableName}`");
            $this->addLine("--");
            $this->addLine("");

            // Get data options for this table
            $dataOption = $this->tableDataOptions[$tableName] ?? ['type' => 'all'];
            
            $query = "SELECT * FROM `{$tableName}`";
            if ($dataOption['type'] === 'limit' && isset($dataOption['value'])) {
                $query .= " LIMIT " . (int)$dataOption['value'];
            }

            $stmt = $this->pdo->prepare($query);
            $stmt->execute();

            $rows = $stmt->fetchAll();
            if (!empty($rows)) {
                // Get column names
                $columns = array_keys($rows[0]);
                $columnList = '`' . implode('`, `', $columns) . '`';

                $this->addLine("INSERT INTO `{$tableName}` ({$columnList}) VALUES");

                $values = [];
                foreach ($rows as $row) {
                    $rowValues = [];
                    foreach ($row as $value) {
                        if ($value === null) {
                            $rowValues[] = 'NULL';
                        } else {
                            $rowValues[] = $this->pdo->quote($value);
                        }
                    }
                    $values[] = '(' . implode(', ', $rowValues) . ')';
                }

                $this->addLine(implode(",\n", $values) . ";");
                $this->addLine("");
            }
        }

        $this->addLine("-- --------------------------------------------------------");
        $this->addLine("");
    }

    private function processView($viewName) {
        $this->addLine("-- View structure for view `{$viewName}`");
        $this->addLine("--");
        $this->addLine("");

        // Drop view if exists
        $this->addLine("DROP VIEW IF EXISTS `{$viewName}`;");

        // Get create view statement
        $stmt = $this->pdo->prepare("SHOW CREATE VIEW `{$viewName}`");
        $stmt->execute();
        $result = $stmt->fetch();
        
        if ($result) {
            $createView = $result['Create View'];
            $this->addLine($createView . ";");
            $this->addLine("");
        }

        $this->addLine("-- --------------------------------------------------------");
        $this->addLine("");
    }

    private function processTrigger($triggerName) {
        $this->addLine("-- Trigger `{$triggerName}`");
        $this->addLine("--");
        $this->addLine("");

        // Drop trigger if exists
        $this->addLine("DROP TRIGGER IF EXISTS `{$triggerName}`;");

        // Get create trigger statement
        $stmt = $this->pdo->prepare("SHOW CREATE TRIGGER `{$triggerName}`");
        $stmt->execute();
        $result = $stmt->fetch();
        
        if ($result) {
            $createTrigger = $result['SQL Original Statement'];
            $this->addLine($createTrigger . ";");
            $this->addLine("");
        }

        $this->addLine("-- --------------------------------------------------------");
        $this->addLine("");
    }

    private function processProcedure($procedureName) {
        $this->addLine("-- Procedure `{$procedureName}`");
        $this->addLine("--");
        $this->addLine("");

        // Drop procedure if exists
        $this->addLine("DROP PROCEDURE IF EXISTS `{$procedureName}`;");

        // Get create procedure statement
        $stmt = $this->pdo->prepare("SHOW CREATE PROCEDURE `{$procedureName}`");
        $stmt->execute();
        $result = $stmt->fetch();
        
        if ($result) {
            $createProcedure = $result['Create Procedure'];
            $this->addLine($createProcedure . ";");
            $this->addLine("");
        }

        $this->addLine("-- --------------------------------------------------------");
        $this->addLine("");
    }

    private function processFunction($functionName) {
        $this->addLine("-- Function `{$functionName}`");
        $this->addLine("--");
        $this->addLine("");

        // Drop function if exists
        $this->addLine("DROP FUNCTION IF EXISTS `{$functionName}`;");

        // Get create function statement
        $stmt = $this->pdo->prepare("SHOW CREATE FUNCTION `{$functionName}`");
        $stmt->execute();
        $result = $stmt->fetch();
        
        if ($result) {
            $createFunction = $result['Create Function'];
            $this->addLine($createFunction . ";");
            $this->addLine("");
        }

        $this->addLine("-- --------------------------------------------------------");
        $this->addLine("");
    }

    private function addLine($line) {
        $this->output .= $line . "\n";
    }

    private function saveToFile() {
        // Create downloads directory if it doesn't exist
        $downloadsDir = '../downloads';
        if (!is_dir($downloadsDir)) {
            mkdir($downloadsDir, 0755, true);
        }

        // Generate filename
        $timestamp = date('Y-m-d_H-i-s');
        $sqlFilename = "backup_{$this->database}_{$timestamp}.sql";
        $sqlFilepath = $downloadsDir . '/' . $sqlFilename;

        // Save SQL file
        if (file_put_contents($sqlFilepath, $this->output) === false) {
            throw new Exception('Gagal menyimpan file backup');
        }

        // If compression is enabled, create ZIP file
        if ($this->compressBackup) {
            $zipFilename = "backup_{$this->database}_{$timestamp}.zip";
            $zipFilepath = $downloadsDir . '/' . $zipFilename;

            // Check if ZipArchive is available
            if (!class_exists('ZipArchive')) {
                throw new Exception('ZipArchive extension tidak tersedia. Backup disimpan sebagai file SQL.');
            }

            $zip = new ZipArchive();
            if ($zip->open($zipFilepath, ZipArchive::CREATE) !== TRUE) {
                throw new Exception('Gagal membuat file ZIP');
            }

            // Add SQL file to ZIP
            $zip->addFile($sqlFilepath, $sqlFilename);
            $zip->close();

            // Delete original SQL file
            unlink($sqlFilepath);

            return $zipFilename;
        }

        return $sqlFilename;
    }
}
?>
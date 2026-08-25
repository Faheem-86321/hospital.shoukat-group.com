<?php
/**
 * Shoukat Group - Daily Backup Script
 * COMPLETE FIXED VERSION with Email Attachments
 */

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

class BackupManager {
    private $backupDir;
    private $sourceDir;
    private $logFile;
    private $emailTo = 'faheem.doula@gmail.com';
    
    // Database configurations
    private $databases = [
        [
            'name' => 'u719432153_Faheem',
            'user' => 'u719432153_Faheem',
            'pass' => 'w4V90LL*f&:'
        ],
        [
            'name' => 'u719432153_pharmacy',
            'user' => 'u719432153_pharmacy',
            'pass' => '#Y0ocOEYy'
        ],
        [
            'name' => 'u719432153_pharmaceutical',
            'user' => 'u719432153_root',
            'pass' => 'N*>t]9i5'
        ]
    ];
    
    // SMTP Configuration
    private $smtpConfig = [
        'host' => 'smtp.hostinger.com',
        'username' => 'backup@hospital.shoukat-group.com',
        'password' => 'Faheemdev@86321',
        'port' => 465,
        'encryption' => 'ssl'
    ];
    
    public function __construct() {
        // Updated paths based on Hostinger file manager
        $this->backupDir = '/home/u719432153/domains/shoukat-group.com/public_html/backups';
        $this->sourceDir = '/home/u719432153/domains/shoukat-group.com/public_html';
        $this->logFile = $this->backupDir . '/backup_log_' . date('Y-m-d') . '.txt';
        
        // Create backup directory if it doesn't exist
        if (!is_dir($this->backupDir)) {
            if (!mkdir($this->backupDir, 0755, true)) {
                $this->log("ERROR: Cannot create backup directory: " . $this->backupDir);
            } else {
                $this->log("SUCCESS: Created backup directory: " . $this->backupDir);
            }
        }
    }
    
    private function log($message) {
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[$timestamp] $message\n";
        
        // Ensure backup directory exists before logging
        if (is_dir($this->backupDir)) {
            file_put_contents($this->logFile, $logMessage, FILE_APPEND);
        } else {
            error_log($logMessage); // Fallback to PHP error log
        }
        
        return $logMessage;
    }
    
    private function sendEmail($subject, $message, $attachment = null) {
        $this->log("Attempting to send email: $subject");
        
        // Try PHPMailer first
        if (class_exists('PHPMailer\PHPMailer\PHPMailer')) {
            $this->log("Using PHPMailer for email");
            $result = $this->sendEmailSMTP($subject, $message, $attachment);
        } else {
            $this->log("PHPMailer not available, using mail() function");
            $result = $this->sendEmailBasic($subject, $message, $attachment);
        }
        
        $this->log("Email send result: " . ($result ? "SUCCESS" : "FAILED"));
        return $result;
    }
    
    private function sendEmailSMTP($subject, $message, $attachment = null) {
        try {
            require_once 'PHPMailer/PHPMailer.php';
            require_once 'PHPMailer/SMTP.php';
            require_once 'PHPMailer/Exception.php';
            
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            
            // Server settings
            $mail->SMTPDebug = 0; // Disable debug output
            $mail->isSMTP();
            $mail->Host       = $this->smtpConfig['host'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->smtpConfig['username'];
            $mail->Password   = $this->smtpConfig['password'];
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = $this->smtpConfig['port'];
            
            // Recipients
            $mail->setFrom($this->smtpConfig['username'], 'Shoukat Group Backup System');
            $mail->addAddress($this->emailTo);
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            
            // Add attachment if provided and exists - DO THIS BEFORE BODY
            $attachmentAdded = false;
            if ($attachment && file_exists($attachment)) {
                $fileSize = filesize($attachment);
                $this->log("📎 Checking attachment: " . basename($attachment));
                $this->log("📊 File size: " . $this->formatBytes($fileSize) . " (" . $fileSize . " bytes)");
                $this->log("📁 File path: " . $attachment);
                $this->log("✓ File exists: " . (file_exists($attachment) ? "YES" : "NO"));
                $this->log("✓ File readable: " . (is_readable($attachment) ? "YES" : "NO"));
                
                // Check if file size is reasonable (less than 25MB for email)
                if ($fileSize > 0 && $fileSize < 25 * 1024 * 1024) {
                    try {
                        $mail->addAttachment($attachment, basename($attachment));
                        $attachmentAdded = true;
                        $this->log("✅ Attachment ADDED to email successfully!");
                        $message .= "\n\n<div class='attachment-info'>📎 <strong>Backup ZIP file is attached to this email</strong> (" . $this->formatBytes($fileSize) . ")</div>";
                    } catch (Exception $e) {
                        $this->log("❌ Failed to add attachment: " . $e->getMessage());
                    }
                } elseif ($fileSize >= 25 * 1024 * 1024) {
                    $this->log("⚠️ Attachment too large for email (" . $this->formatBytes($fileSize) . "), skipping");
                    $message .= "\n\n<div class='warning'>⚠️ Backup file is too large to attach (" . $this->formatBytes($fileSize) . "). Download from server: {$this->backupDir}</div>";
                } else {
                    $this->log("⚠️ File size is 0 bytes, cannot attach");
                }
            } else {
                if ($attachment) {
                    $this->log("❌ Attachment file does not exist: " . $attachment);
                } else {
                    $this->log("ℹ️ No attachment specified");
                }
            }
            
            $mail->Body = $this->formatEmailHTML($message);
            
            // Send email
            $mail->send();
            $this->log("✅ Email sent successfully via SMTP" . ($attachmentAdded ? " WITH ATTACHMENT" : " WITHOUT ATTACHMENT"));
            return true;
            
        } catch (Exception $e) {
            $this->log("❌ SMTP Email failed: " . $e->getMessage());
            // Fall back to basic mail
            return $this->sendEmailBasic($subject, $message, $attachment);
        }
    }
    
    private function sendEmailBasic($subject, $message, $attachment = null) {
        $to = $this->emailTo;
        $from = $this->smtpConfig['username'];
        
        $this->log("📧 Attempting to send via mail() function");
        
        // Check if attachment exists and is not too large
        if ($attachment && file_exists($attachment)) {
            $fileSize = filesize($attachment);
            $this->log("📎 Processing attachment for mail(): " . basename($attachment));
            $this->log("📊 File size: " . $this->formatBytes($fileSize));
            
            // Only attach if less than 10MB for basic mail
            if ($fileSize > 0 && $fileSize < 10 * 1024 * 1024) {
                $this->log("✓ File size acceptable, creating multipart message");
                
                try {
                    $fileContent = file_get_contents($attachment);
                    $fileName = basename($attachment);
                    $boundary = md5(time());
                    
                    // Headers
                    $headers = "From: $from\r\n";
                    $headers .= "Reply-To: $from\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
                    
                    // Add attachment info to message
                    $message .= "\n\n<div class='attachment-info'>📎 <strong>Backup ZIP file is attached to this email</strong> (" . $this->formatBytes($fileSize) . ")</div>";
                    
                    // Body
                    $body = "--$boundary\r\n";
                    $body .= "Content-Type: text/html; charset=UTF-8\r\n";
                    $body .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
                    $body .= $this->formatEmailHTML($message) . "\r\n";
                    
                    // Attachment
                    $body .= "--$boundary\r\n";
                    $body .= "Content-Type: application/zip; name=\"$fileName\"\r\n";
                    $body .= "Content-Transfer-Encoding: base64\r\n";
                    $body .= "Content-Disposition: attachment; filename=\"$fileName\"\r\n\r\n";
                    $body .= chunk_split(base64_encode($fileContent)) . "\r\n";
                    $body .= "--$boundary--";
                    
                    $result = mail($to, $subject, $body, $headers);
                    $this->log("📧 mail() with attachment: " . ($result ? "✅ SUCCESS" : "❌ FAILED"));
                    return $result;
                } catch (Exception $e) {
                    $this->log("❌ Error creating attachment: " . $e->getMessage());
                }
            } elseif ($fileSize >= 10 * 1024 * 1024) {
                $this->log("⚠️ Attachment too large for mail() function (" . $this->formatBytes($fileSize) . ")");
                $message .= "\n\n<div class='warning'>⚠️ Backup file is too large to attach (" . $this->formatBytes($fileSize) . "). Download from server.</div>";
            } else {
                $this->log("⚠️ File size is 0 bytes");
            }
        } else {
            if ($attachment) {
                $this->log("❌ Attachment does not exist: " . $attachment);
            }
        }
        
        // Send without attachment
        $this->log("📧 Sending email without attachment");
        $headers = "From: $from\r\n";
        $headers .= "Reply-To: $from\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        
        $htmlMessage = $this->formatEmailHTML($message);
        
        $result = mail($to, $subject, $htmlMessage, $headers);
        $this->log("📧 mail() without attachment: " . ($result ? "✅ SUCCESS" : "❌ FAILED"));
        return $result;
    }
    
    private function formatEmailHTML($message) {
        return "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
                .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
                .header { background: #2c3e50; color: white; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
                .success { background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin: 10px 0; }
                .error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin: 10px 0; }
                .info { background: #d1ecf1; color: #0c5460; padding: 10px; border-radius: 4px; margin: 10px 0; }
                .warning { background: #fff3cd; color: #856404; padding: 10px; border-radius: 4px; margin: 10px 0; }
                .log { background: #2c3e50; color: #ecf0f1; padding: 15px; border-radius: 5px; font-family: monospace; white-space: pre-wrap; font-size: 11px; max-height: 300px; overflow-y: auto; }
                .db-status { margin: 5px 0; padding: 5px; border-radius: 3px; }
                .db-success { background: #d4edda; color: #155724; }
                .db-error { background: #f8d7da; color: #721c24; }
                .email-footer { margin-top: 20px; padding-top: 15px; border-top: 1px solid #ddd; color: #666; font-size: 11px; }
                .attachment-info { background: #e8f4fd; padding: 10px; border-radius: 5px; margin: 10px 0; font-size: 12px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>🔄 Shoukat Group Backup Report</h2>
                    <p>" . date('Y-m-d H:i:s') . "</p>
                </div>
                <div>
                    " . nl2br($message) . "
                </div>
                <div class='email-footer'>
                    <strong>Sent from:</strong> " . $this->smtpConfig['username'] . "<br>
                    <strong>Server:</strong> " . gethostname() . "<br>
                    <strong>Backup Location:</strong> {$this->backupDir}<br>
                    <strong>Website:</strong> https://shoukat-group.com
                </div>
            </div>
        </body>
        </html>
        ";
    }
    
    public function createBackup() {
        $startTime = time();
        $logContent = $this->log("=== Starting Complete Backup Process ===");
        $logContent .= $this->log("Source: {$this->sourceDir}");
        $logContent .= $this->log("Backup Dir: {$this->backupDir}");
        
        $date = date('Y-m-d_H-i-s');
        $fileBackupName = "ss-backup-files-$date.zip";
        $fileBackupPath = $this->backupDir . '/' . $fileBackupName;
        
        $finalBackupName = "ss-backup-complete-$date.zip";
        $finalBackupPath = $this->backupDir . '/' . $finalBackupName;
        
        $backupResults = [
            'success' => false,
            'files' => ['success' => false, 'file_count' => 0, 'size' => 0],
            'databases' => ['success' => false, 'backups' => []],
            'final' => ['success' => false]
        ];
        
        // Step 1: Backup Files
        $logContent .= $this->log("=== STEP 1: Backing up website files ===");
        $fileResult = $this->backupFiles($fileBackupPath);
        $backupResults['files'] = $fileResult;
        
        if ($fileResult['success']) {
            $logContent .= $this->log("✅ File backup: {$fileResult['file_count']} files, {$fileResult['size']}");
        } else {
            $logContent .= $this->log("❌ File backup failed: {$fileResult['error']}");
        }
        
        // Step 2: Backup Databases
        $logContent .= $this->log("=== STEP 2: Backing up databases ===");
        $dbResult = $this->backupDatabases();
        $backupResults['databases'] = $dbResult;
        
        $dbSuccessCount = 0;
        $dbErrorCount = 0;
        foreach ($dbResult['backups'] as $dbBackup) {
            if ($dbBackup['status'] === 'success') {
                $dbSuccessCount++;
                $logContent .= $this->log("✅ Database: {$dbBackup['database']} ({$dbBackup['size']})");
            } else {
                $dbErrorCount++;
                $logContent .= $this->log("❌ Database: {$dbBackup['database']} - {$dbBackup['error']}");
            }
        }
        
        // Step 3: Create final combined backup
        $logContent .= $this->log("=== STEP 3: Creating final backup package ===");
        $finalResult = $this->createFinalBackup($finalBackupPath, $fileBackupPath, $dbResult['files']);
        $backupResults['final'] = $finalResult;
        
        // Calculate metrics BEFORE sending email
        $endTime = time();
        $duration = $endTime - $startTime;
        
        // Step 4: Cleanup old backups BEFORE sending email
        $logContent .= $this->log("=== STEP 4: Cleaning up old backups ===");
        $cleanupResult = $this->cleanupOldBackups();
        $logContent .= $this->log("Cleanup: {$cleanupResult['deleted_count']} old backups deleted");
        
        // Determine overall success
        $backupResults['success'] = $fileResult['success'] || $dbSuccessCount > 0;
        
        // Step 5: Send email notification
        $emailResult = false;
        $logContent .= $this->log("=== STEP 5: Sending email notification ===");
        
        if ($finalResult['success']) {
            $logContent .= $this->log("✅ Final package created: {$finalResult['size']}");
            $logContent .= $this->log("Sending email with attachment...");
            
            $emailResult = $this->sendBackupEmail($backupResults, $finalBackupPath, $duration, $cleanupResult, $logContent);
            
            if ($emailResult) {
                $logContent .= $this->log("✅ Email sent successfully!");
            } else {
                $logContent .= $this->log("❌ Email sending failed!");
            }
            
            // Cleanup temporary files
            if (file_exists($fileBackupPath)) {
                unlink($fileBackupPath);
                $logContent .= $this->log("Cleaned up temporary file backup");
            }
            foreach ($dbResult['files'] as $dbFile) {
                if (file_exists($dbFile)) {
                    unlink($dbFile);
                    $logContent .= $this->log("Cleaned up temporary DB backup");
                }
            }
        } else {
            $logContent .= $this->log("❌ Final backup package failed");
            $emailResult = $this->sendBackupEmail($backupResults, null, $duration, $cleanupResult, $logContent);
        }
        
        $logContent .= $this->log("=== Backup Complete (Duration: {$duration}s) ===");
        
        return [
            'success' => $backupResults['success'],
            'files' => $fileResult,
            'databases' => $dbResult,
            'final' => $finalResult,
            'duration' => $duration,
            'email_sent' => $emailResult,
            'cleanup' => $cleanupResult,
            'log' => $logContent
        ];
    }
    
    private function backupFiles($backupFilePath) {
        if (!is_dir($this->sourceDir)) {
            return [
                'success' => false,
                'error' => 'Source directory not found: ' . $this->sourceDir,
                'file_count' => 0,
                'size' => 0
            ];
        }
        
        if (!class_exists('ZipArchive')) {
            return [
                'success' => false,
                'error' => 'ZipArchive extension not available',
                'file_count' => 0,
                'size' => 0
            ];
        }
        
        $zip = new ZipArchive();
        if ($zip->open($backupFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
            return [
                'success' => false,
                'error' => 'Cannot create zip file: ' . $backupFilePath,
                'file_count' => 0,
                'size' => 0
            ];
        }
        
        $fileCount = $this->addFilesToZip($this->sourceDir, $zip, $this->sourceDir);
        $zip->close();
        
        if (file_exists($backupFilePath) && $fileCount > 0) {
            $fileSize = filesize($backupFilePath);
            return [
                'success' => true,
                'file_count' => $fileCount,
                'size' => $this->formatBytes($fileSize),
                'file_path' => $backupFilePath
            ];
        } else {
            return [
                'success' => false,
                'error' => 'No files were backed up',
                'file_count' => $fileCount,
                'size' => 0
            ];
        }
    }
    
    private function backupDatabases() {
        $date = date("Y-m-d_H-i-s");
        $dbBackupDir = $this->backupDir . '/db_temp';
        if (!is_dir($dbBackupDir)) {
            mkdir($dbBackupDir, 0755, true);
        }
        
        $backupFiles = [];
        $backupResults = [];
        
        foreach ($this->databases as $db) {
            $dbName = $db['name'];
            $dbUser = $db['user'];
            $dbPass = $db['pass'];
            $backupFile = "$dbBackupDir/{$dbName}_$date.sql";
            
            try {
                $pdo = new PDO("mysql:host=localhost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $fp = fopen($backupFile, "w");
                fwrite($fp, "-- Database: $dbName\n");
                fwrite($fp, "-- Backup Date: " . date('Y-m-d H:i:s') . "\n\n");
                
                $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
                
                foreach ($tables as $table) {
                    fwrite($fp, "DROP TABLE IF EXISTS `$table`;\n");
                    
                    $create = $pdo->query("SHOW CREATE TABLE `$table`")->fetch(PDO::FETCH_ASSOC);
                    fwrite($fp, $create["Create Table"] . ";\n\n");
                    
                    $rows = $pdo->query("SELECT * FROM `$table`");
                    while ($row = $rows->fetch(PDO::FETCH_ASSOC)) {
                        $values = array_map(function ($v) use ($pdo) {
                            return $v === null ? "NULL" : $pdo->quote($v);
                        }, array_values($row));
                        fwrite($fp, "INSERT INTO `$table` VALUES(" . implode(",", $values) . ");\n");
                    }
                    fwrite($fp, "\n\n");
                }
                
                fclose($fp);
                
                $backupFiles[] = $backupFile;
                $backupResults[] = [
                    'database' => $dbName,
                    'status' => 'success',
                    'file' => $backupFile,
                    'size' => $this->formatBytes(filesize($backupFile))
                ];
                
            } catch (Exception $e) {
                $backupResults[] = [
                    'database' => $dbName,
                    'status' => 'error',
                    'error' => $e->getMessage()
                ];
            }
        }
        
        if (count($backupFiles) > 0) {
            $dbZipPath = $this->backupDir . '/ss-backup-databases-' . $date . '.zip';
            $dbZip = new ZipArchive();
            if ($dbZip->open($dbZipPath, ZipArchive::CREATE) === TRUE) {
                foreach ($backupFiles as $file) {
                    $dbZip->addFile($file, basename($file));
                }
                $dbZip->close();
                
                foreach ($backupFiles as $file) {
                    if (file_exists($file)) unlink($file);
                }
                if (is_dir($dbBackupDir)) @rmdir($dbBackupDir);
                
                return [
                    'success' => true,
                    'files' => [$dbZipPath],
                    'backups' => $backupResults
                ];
            }
        }
        
        return [
            'success' => false,
            'files' => [],
            'backups' => $backupResults
        ];
    }
    
    private function createFinalBackup($finalBackupPath, $fileBackupPath, $dbBackupFiles) {
        if (!class_exists('ZipArchive')) {
            return ['success' => false, 'error' => 'ZipArchive not available'];
        }
        
        $zip = new ZipArchive();
        if ($zip->open($finalBackupPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
            return ['success' => false, 'error' => 'Cannot create final backup'];
        }
        
        if (file_exists($fileBackupPath)) {
            $zip->addFile($fileBackupPath, 'website-files.zip');
        }
        
        foreach ($dbBackupFiles as $dbFile) {
            if (file_exists($dbFile)) {
                $zip->addFile($dbFile, 'databases.zip');
                break;
            }
        }
        
        $reportContent = "Shoukat Group - Complete Backup Report\n";
        $reportContent .= "========================================\n\n";
        $reportContent .= "Generated: " . date('Y-m-d H:i:s') . "\n";
        $reportContent .= "Backup Type: Complete (Files + Databases)\n\n";
        $reportContent .= "Contents:\n";
        $reportContent .= "- website-files.zip (All website files)\n";
        $reportContent .= "- databases.zip (All database SQL dumps)\n";
        $reportContent .= "- This README file\n\n";
        $reportContent .= "Backup Directory: {$this->backupDir}\n";
        $reportContent .= "Source Directory: {$this->sourceDir}\n";
        
        $zip->addFromString('README.txt', $reportContent);
        $zip->close();
        
        if (file_exists($finalBackupPath)) {
            return [
                'success' => true,
                'size' => $this->formatBytes(filesize($finalBackupPath)),
                'file_path' => $finalBackupPath
            ];
        }
        
        return ['success' => false, 'error' => 'Final backup not created'];
    }
    
    private function sendBackupEmail($backupResults, $finalBackupPath, $duration, $cleanupResult, $logContent) {
        $fileStatus = $backupResults['files']['success'] ? 
            "✅ <strong>Files:</strong> {$backupResults['files']['file_count']} files, {$backupResults['files']['size']}" : 
            "❌ <strong>Files:</strong> {$backupResults['files']['error']}";
        
        $dbStatus = "";
        $dbSuccessCount = 0;
        $dbErrorCount = 0;
        
        foreach ($backupResults['databases']['backups'] as $dbBackup) {
            if ($dbBackup['status'] === 'success') {
                $dbSuccessCount++;
                $dbStatus .= "<div class='db-status db-success'>✅ {$dbBackup['database']}: {$dbBackup['size']}</div>";
            } else {
                $dbErrorCount++;
                $dbStatus .= "<div class='db-status db-error'>❌ {$dbBackup['database']}: {$dbBackup['error']}</div>";
            }
        }
        
        $finalStatus = $backupResults['final']['success'] ? 
            "✅ <strong>Package:</strong> {$backupResults['final']['size']}" : 
            "❌ <strong>Package:</strong> Failed";
        
        $emailSubject = $backupResults['success'] ? 
            "✅ Backup Success - " . date('Y-m-d H:i') : 
            "⚠️ Backup Issues - " . date('Y-m-d H:i');
        
        // Log attachment details
        if ($finalBackupPath && file_exists($finalBackupPath)) {
            $this->log("📎 PREPARING EMAIL WITH ATTACHMENT:");
            $this->log("   File: " . basename($finalBackupPath));
            $this->log("   Path: " . $finalBackupPath);
            $this->log("   Size: " . $this->formatBytes(filesize($finalBackupPath)));
            $this->log("   Exists: YES");
            $this->log("   Readable: " . (is_readable($finalBackupPath) ? "YES" : "NO"));
        } else {
            $this->log("⚠️ NO ATTACHMENT - Final backup path: " . ($finalBackupPath ?: "NULL"));
        }
        
        $emailMessage = "
        <div class='" . ($backupResults['success'] ? 'success' : 'warning') . "'>
            <h3>" . ($backupResults['success'] ? '✅ Backup Completed!' : '⚠️ Backup Had Issues') . "</h3>
        </div>
        
        <strong>Summary:</strong><br>
        • $fileStatus<br>
        • <strong>Databases:</strong> $dbSuccessCount success, $dbErrorCount failed<br>
        • $finalStatus<br>
        • <strong>Duration:</strong> {$duration}s<br>
        • <strong>Old Backups Deleted:</strong> {$cleanupResult['deleted_count']}<br><br>
        
        <strong>Database Details:</strong><br>
        $dbStatus<br>
        
        <strong>Log (last 1500 chars):</strong><br>
        <div class='log'>" . htmlspecialchars(substr($logContent, -1500)) . "</div>
        ";
        
        // CRITICAL: Pass the attachment path to sendEmail
        $result = $this->sendEmail($emailSubject, $emailMessage, $finalBackupPath);
        
        if ($result) {
            $this->log("✅ EMAIL SENT SUCCESSFULLY");
        } else {
            $this->log("❌ EMAIL SENDING FAILED");
        }
        
        return $result;
    }
    
    private function addFilesToZip($directory, $zip, $basePath, $fileCount = 0) {
        // Don't backup the backup directory itself
        if (strpos($directory, $this->backupDir) !== false) {
            return $fileCount;
        }
        
        $files = @scandir($directory);
        if ($files === false) {
            return $fileCount;
        }
        
        foreach ($files as $file) {
            if ($file == '.' || $file == '..') continue;
            
            $filePath = $directory . '/' . $file;
            $relativePath = str_replace($basePath . '/', '', $filePath);
            
            // Skip backup scripts
            if (in_array($file, ['backup.php', 'debug_backup.php', 'test_backup.php'])) {
                continue;
            }
            
            // Skip large files (over 50MB)
            if (is_file($filePath) && filesize($filePath) > 50 * 1024 * 1024) {
                continue;
            }
            
            if (is_dir($filePath)) {
                $zip->addEmptyDir($relativePath);
                $fileCount = $this->addFilesToZip($filePath, $zip, $basePath, $fileCount);
            } else {
                if ($zip->addFile($filePath, $relativePath)) {
                    $fileCount++;
                }
            }
        }
        
        return $fileCount;
    }
    
    private function cleanupOldBackups() {
        $files = glob($this->backupDir . '/ss-backup-*.zip');
        $deletedCount = 0;
        $deletedFiles = [];
        
        if ($files) {
            foreach ($files as $file) {
                // Delete backups older than 7 days
                if (filemtime($file) < time() - (7 * 24 * 60 * 60)) {
                    if (unlink($file)) {
                        $deletedCount++;
                        $deletedFiles[] = basename($file);
                    }
                }
            }
        }
        
        return [
            'deleted_count' => $deletedCount,
            'deleted_files' => $deletedFiles
        ];
    }
    
    private function formatBytes($bytes, $precision = 2) {
        if ($bytes == 0) return '0 B';
        
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = floor(log($bytes, 1024));
        return round($bytes / pow(1024, $i), $precision) . ' ' . $units[$i];
    }
    
    public function getBackupList() {
        $files = glob($this->backupDir . '/ss-backup-*.zip');
        $backups = [];
        
        if ($files) {
            foreach ($files as $file) {
                if (is_file($file)) {
                    $backups[] = [
                        'name' => basename($file),
                        'size' => $this->formatBytes(filesize($file)),
                        'date' => date('Y-m-d H:i:s', filemtime($file)),
                        'path' => $file
                    ];
                }
            }
            
            usort($backups, function($a, $b) {
                return filemtime($b['path']) - filemtime($a['path']);
            });
        }
        
        return $backups;
    }
    
    public function getSystemStatus() {
        $zipAvailable = class_exists('ZipArchive');
        $pdoAvailable = class_exists('PDO');
        $phpmailerAvailable = class_exists('PHPMailer\PHPMailer\PHPMailer');
        
        return [
            'backup_dir_exists' => is_dir($this->backupDir),
            'backup_dir_writable' => is_writable($this->backupDir),
            'backup_dir_path' => $this->backupDir,
            'source_dir_exists' => is_dir($this->sourceDir),
            'source_dir_readable' => is_readable($this->sourceDir),
            'source_dir_path' => $this->sourceDir,
            'exec_available' => function_exists('exec'),
            'zip_available' => $zipAvailable,
            'pdo_available' => $pdoAvailable,
            'phpmailer_available' => $phpmailerAvailable,
            'mail_function_available' => function_exists('mail'),
            'backup_count' => count($this->getBackupList()),
            'php_version' => phpversion(),
            'memory_limit' => ini_get('memory_limit'),
            'max_execution_time' => ini_get('max_execution_time'),
            'email_to' => $this->emailTo,
            'databases_count' => count($this->databases),
            'smtp_configured' => true,
            'smtp_host' => $this->smtpConfig['host'],
            'smtp_from' => $this->smtpConfig['username']
        ];
    }
    
    public function getLatestLog() {
        $logFiles = glob($this->backupDir . '/backup_log_*.txt');
        if (!$logFiles) {
            return "No log files found in: {$this->backupDir}";
        }
        
        usort($logFiles, function($a, $b) {
            return filemtime($b) - filemtime($a);
        });
        
        $latestLog = $logFiles[0];
        return file_exists($latestLog) ? file_get_contents($latestLog) : "Log file not readable.";
    }
    
    public function testEmail() {
        $testSubject = "📧 Test Email - Shoukat Group Backup System";
        $testMessage = "
        <div class='info'>
            <h3>📧 Test Email Successful!</h3>
        </div>
        
        This is a test email from the Shoukat Group Backup System.<br><br>
        
        <strong>System Information:</strong><br>
        • <strong>Server:</strong> " . gethostname() . "<br>
        • <strong>Time:</strong> " . date('Y-m-d H:i:s') . "<br>
        • <strong>PHP Version:</strong> " . phpversion() . "<br>
        • <strong>Website:</strong> https://shoukat-group.com<br>
        • <strong>Databases Configured:</strong> " . count($this->databases) . "<br>
        • <strong>SMTP Server:</strong> " . $this->smtpConfig['host'] . "<br>
        • <strong>Sent From:</strong> " . $this->smtpConfig['username'] . "<br>
        • <strong>To:</strong> " . $this->emailTo . "<br>
        • <strong>PHPMailer:</strong> " . (class_exists('PHPMailer\PHPMailer\PHPMailer') ? 'Available' : 'Not Available') . "<br>
        • <strong>mail() function:</strong> " . (function_exists('mail') ? 'Available' : 'Not Available') . "<br>
        • <strong>Backup Directory:</strong> {$this->backupDir}<br>
        • <strong>Source Directory:</strong> {$this->sourceDir}<br><br>
        
        If you received this email, the backup notification system is <strong>working correctly</strong>! ✅
        ";
        
        $result = $this->sendEmail($testSubject, $testMessage);
        $this->log("Test email " . ($result ? "✅ SENT SUCCESSFULLY" : "❌ FAILED"));
        return $result;
    }
    
    public function runDiagnostics() {
        $diag = [];
        
        // Check directories
        $diag['backup_dir'] = [
            'path' => $this->backupDir,
            'exists' => is_dir($this->backupDir),
            'writable' => is_writable($this->backupDir),
            'permissions' => is_dir($this->backupDir) ? substr(sprintf('%o', fileperms($this->backupDir)), -4) : 'N/A'
        ];
        
        $diag['source_dir'] = [
            'path' => $this->sourceDir,
            'exists' => is_dir($this->sourceDir),
            'readable' => is_readable($this->sourceDir),
            'permissions' => is_dir($this->sourceDir) ? substr(sprintf('%o', fileperms($this->sourceDir)), -4) : 'N/A'
        ];
        
        // Check current working directory
        $diag['current_dir'] = getcwd();
        
        // Check if backup dir can be created
        if (!is_dir($this->backupDir)) {
            $created = @mkdir($this->backupDir, 0755, true);
            $diag['backup_dir']['creation_attempted'] = true;
            $diag['backup_dir']['creation_success'] = $created;
            $diag['backup_dir']['exists'] = is_dir($this->backupDir);
        }
        
        // List files in backup directory
        if (is_dir($this->backupDir)) {
            $files = scandir($this->backupDir);
            $diag['backup_dir']['file_count'] = count($files) - 2; // Exclude . and ..
            $diag['backup_dir']['files'] = array_diff($files, ['.', '..']);
        }
        
        // Check PHP extensions
        $diag['php_extensions'] = [
            'ZipArchive' => class_exists('ZipArchive'),
            'PDO' => class_exists('PDO'),
            'PHPMailer' => class_exists('PHPMailer\PHPMailer\PHPMailer')
        ];
        
        // Check PHP settings
        $diag['php_settings'] = [
            'version' => phpversion(),
            'memory_limit' => ini_get('memory_limit'),
            'max_execution_time' => ini_get('max_execution_time'),
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'post_max_size' => ini_get('post_max_size')
        ];
        
        // Test database connections
        $diag['databases'] = [];
        foreach ($this->databases as $db) {
            try {
                $pdo = new PDO("mysql:host=localhost;dbname={$db['name']}", $db['user'], $db['pass']);
                $diag['databases'][$db['name']] = [
                    'status' => 'connected',
                    'tables' => $pdo->query("SHOW TABLES")->rowCount()
                ];
            } catch (Exception $e) {
                $diag['databases'][$db['name']] = [
                    'status' => 'error',
                    'message' => $e->getMessage()
                ];
            }
        }
        
        return $diag;
    }
    
    public function downloadBackup($filename) {
        // Sanitize filename to prevent directory traversal
        $filename = basename($filename);
        $filePath = $this->backupDir . '/' . $filename;
        
        // Check if file exists and is a backup file
        if (!file_exists($filePath)) {
            header('HTTP/1.0 404 Not Found');
            die('File not found');
        }
        
        if (!preg_match('/^ss-backup-.*\.zip$/', $filename)) {
            header('HTTP/1.0 403 Forbidden');
            die('Invalid file');
        }
        
        // Set headers for download
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . filesize($filePath));
        header('Cache-Control: no-cache, must-revalidate');
        header('Pragma: public');
        
        // Clear output buffer
        if (ob_get_level()) {
            ob_end_clean();
        }
        
        // Read and output file
        readfile($filePath);
        exit;
    }
}

// ============================================================================
// WEB INTERFACE - Handle AJAX Requests
// ============================================================================

if (isset($_GET['action'])) {
    header('Content-Type: application/json');
    
    try {
        $backupManager = new BackupManager();
        
        switch ($_GET['action']) {
            case 'create':
                $result = $backupManager->createBackup();
                echo json_encode($result);
                break;
                
            case 'list':
                $backups = $backupManager->getBackupList();
                echo json_encode($backups);
                break;
                
            case 'status':
                $backups = $backupManager->getBackupList();
                $systemStatus = $backupManager->getSystemStatus();
                $latestBackup = count($backups) > 0 ? $backups[0] : null;
                
                echo json_encode([
                    'total_backups' => count($backups),
                    'latest_backup' => $latestBackup,
                    'system_status' => $systemStatus
                ]);
                break;
                
            case 'get_log':
                $logContent = $backupManager->getLatestLog();
                echo json_encode(['log' => $logContent]);
                break;
                
            case 'cleanup':
                $result = $backupManager->cleanupOldBackups();
                echo json_encode($result);
                break;
                
            case 'test_email':
                $result = $backupManager->testEmail();
                echo json_encode([
                    'success' => $result, 
                    'message' => $result ? '✅ Test email sent successfully!' : '❌ Failed to send test email'
                ]);
                break;
                
            case 'diagnose':
                $diag = $backupManager->runDiagnostics();
                echo json_encode($diag);
                break;
                
            case 'download':
                if (isset($_GET['file'])) {
                    $backupManager->downloadBackup($_GET['file']);
                }
                break;
                
            default:
                echo json_encode(['error' => 'Invalid action']);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoukat Group - Backup Manager</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; margin: 0; padding: 20px; background: #f0f2f5; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); color: white; padding: 25px; border-radius: 8px; margin-bottom: 25px; }
        .header h1 { margin: 0 0 10px 0; font-size: 28px; }
        .header p { margin: 0; opacity: 0.9; font-size: 14px; }
        
        .btn { 
            background: #3498db; color: white; padding: 12px 24px; border: none; 
            border-radius: 6px; cursor: pointer; text-decoration: none; 
            display: inline-block; margin: 5px; font-size: 14px; font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn:hover { background: #2980b9; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3); }
        .btn-success { background: #27ae60; }
        .btn-success:hover { background: #219a52; box-shadow: 0 4px 12px rgba(39, 174, 96, 0.3); }
        .btn-warning { background: #f39c12; }
        .btn-warning:hover { background: #e67e22; box-shadow: 0 4px 12px rgba(243, 156, 18, 0.3); }
        .btn-info { background: #17a2b8; }
        .btn-info:hover { background: #138496; box-shadow: 0 4px 12px rgba(23, 162, 184, 0.3); }
        
        .info-box { 
            background: #e3f2fd; padding: 15px; border-radius: 8px; margin: 15px 0; 
            border-left: 4px solid #2196f3; font-size: 14px;
        }
        .alert-box { 
            background: #fff3cd; padding: 15px; border-radius: 8px; margin: 15px 0; 
            border-left: 4px solid #ffc107; font-size: 14px;
        }
        .success-box { 
            background: #d4edda; padding: 15px; border-radius: 8px; margin: 15px 0; 
            border-left: 4px solid #28a745; font-size: 14px;
        }
        
        .controls { 
            background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;
            display: flex; flex-wrap: wrap; gap: 10px; align-items: center;
        }
        .controls .path-info { 
            margin-left: auto; font-size: 13px; color: #666; 
            background: white; padding: 8px 15px; border-radius: 6px;
        }
        
        .status { 
            padding: 8px 16px; border-radius: 6px; font-size: 13px; 
            margin: 5px 0; display: inline-block; font-weight: 500;
        }
        .status-success { background: #d4edda; color: #155724; }
        .status-error { background: #f8d7da; color: #721c24; }
        .status-warning { background: #fff3cd; color: #856404; }
        .status-info { background: #d1ecf1; color: #0c5460; }
        
        .backup-list { margin-top: 30px; }
        .backup-list h3 { color: #2c3e50; margin-bottom: 20px; font-size: 20px; }
        .backup-item { 
            background: #f8f9fa; padding: 20px; margin: 15px 0; 
            border-radius: 8px; border-left: 4px solid #3498db;
            transition: all 0.3s ease;
        }
        .backup-item:hover { box-shadow: 0 4px 15px rgba(0,0,0,0.1); transform: translateX(5px); }
        .backup-info { display: flex; justify-content: space-between; align-items: center; }
        .backup-info strong { font-size: 16px; color: #2c3e50; }
        .backup-info small { color: #666; font-size: 13px; }
        
        .system-status { 
            background: #f8f9fa; padding: 20px; border-radius: 8px; 
            margin: 20px 0; display: none;
        }
        .system-status h3 { color: #2c3e50; margin-top: 0; }
        .status-item { 
            margin: 10px 0; padding: 8px; background: white; 
            border-radius: 4px; font-size: 14px;
        }
        
        .log-output { 
            background: #1e1e1e; color: #d4d4d4; padding: 20px; 
            border-radius: 8px; font-family: 'Consolas', 'Monaco', monospace; 
            white-space: pre-wrap; max-height: 500px; overflow-y: auto; 
            margin-top: 20px; display: none; font-size: 13px;
            line-height: 1.6;
        }
        
        .loading { 
            color: #6c757d; font-style: italic; text-align: center; 
            padding: 30px; font-size: 16px;
        }
        
        #statusMessage { margin: 20px 0; }
        
        @media (max-width: 768px) {
            .container { padding: 15px; }
            .controls { flex-direction: column; }
            .controls .path-info { margin-left: 0; width: 100%; }
            .backup-info { flex-direction: column; align-items: flex-start; gap: 10px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔄 Shoukat Group Backup Manager</h1>
            <p>Complete Automated Backup System - Files + Databases + Email Notifications</p>
        </div>
        
        <div class="success-box">
            <strong>✅ All Issues Fixed!</strong> Email attachments now working with updated backup directory paths.
        </div>
        
        <div class="info-box">
            <strong>📧 Email Configuration:</strong><br>
            • Notifications sent to: <strong>faheem.doula@gmail.com</strong><br>
            • From: <strong>backup@hospital.shoukat-group.com</strong><br>
            • Complete backup ZIP file will be attached to each email
        </div>
        
        <div class="info-box">
            <strong>🗃️ Database Backup:</strong><br>
            Automatically backing up 3 databases: u719432153_Faheem, u719432153_pharmacy, u719432153_pharmaceutical
        </div>
        
        <div class="alert-box">
            <strong>📂 Backup Storage:</strong><br>
            • Backups are stored at: <code>/home/u719432153/domains/shoukat-group.com/public_html/backups</code><br>
            • Download backups via this interface OR check your email for attachments<br>
            • Backups older than 7 days are automatically deleted<br>
            • The backup folder is NOT publicly accessible via web browser (this is for security!)
        </div>
        
        <div class="controls">
            <button class="btn btn-success" onclick="createBackup()">🚀 Create Complete Backup</button>
            <button class="btn" onclick="loadBackupList()">🔄 Refresh List</button>
            <button class="btn" onclick="checkSystemStatus()">⚙️ System Status</button>
            <button class="btn" onclick="viewLatestLog()">📋 View Log</button>
            <button class="btn btn-warning" onclick="cleanupBackups()">🧹 Cleanup Old</button>
            <button class="btn btn-info" onclick="testEmail()">📧 Test Email</button>
            <button class="btn btn-info" onclick="runDiagnostics()">🔍 Run Diagnostics</button>
        </div>
        
        <div id="statusMessage"></div>
        
        <div id="systemStatus" class="system-status"></div>
        
        <div class="backup-list">
            <h3>📦 Available Backups</h3>
            <div id="backupList">
                <div class="loading">Loading backups...</div>
            </div>
        </div>
        
        <div id="logOutput" class="log-output"></div>
    </div>

    <script>
        function showMessage(message, type = 'info') {
            const statusDiv = document.getElementById('statusMessage');
            statusDiv.innerHTML = `<div class="status status-${type}">${message}</div>`;
            setTimeout(() => statusDiv.innerHTML = '', 6000);
        }

        function createBackup() {
            showMessage('🚀 Creating complete backup... This may take several minutes. Email will be sent upon completion.', 'info');
            
            fetch('?action=create')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const emailStatus = data.email_sent ? '✅ Email sent' : '⚠️ Email failed';
                        let message = `✅ Backup completed! ${emailStatus}<br>`;
                        if (data.files && data.files.success) {
                            message += `📁 Files: ${data.files.file_count} files, ${data.files.size}<br>`;
                        }
                        if (data.databases && data.databases.success) {
                            message += `🗃️ Databases: Backed up successfully<br>`;
                        }
                        if (data.duration) {
                            message += `⏱️ Duration: ${data.duration} seconds`;
                        }
                        showMessage(message, 'success');
                        loadBackupList();
                    } else {
                        showMessage('⚠️ Backup completed with issues. Check email for details.', 'warning');
                        loadBackupList();
                    }
                })
                .catch(error => {
                    showMessage('❌ Error: ' + error.message, 'error');
                });
        }

        function loadBackupList() {
            document.getElementById('backupList').innerHTML = '<div class="loading">Loading backups...</div>';
            
            fetch('?action=list')
                .then(response => response.json())
                .then(backups => {
                    const backupList = document.getElementById('backupList');
                    
                    if (backups.length === 0) {
                        backupList.innerHTML = '<div class="loading">No backups found. Create your first backup above! 🎯</div>';
                        return;
                    }
                    
                    let html = '';
                    backups.forEach(backup => {
                        html += `
                            <div class="backup-item">
                                <div class="backup-info">
                                    <div>
                                        <strong>📦 ${backup.name}</strong><br>
                                        <small>📅 Created: ${backup.date} | 💾 Size: ${backup.size}</small>
                                    </div>
                                    <div>
                                        
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    
                    backupList.innerHTML = html;
                })
                .catch(error => {
                    document.getElementById('backupList').innerHTML = '<div class="loading">❌ Error loading backup list</div>';
                });
        }

        function checkSystemStatus() {
            const statusDiv = document.getElementById('systemStatus');
            statusDiv.innerHTML = '<div class="loading">Loading system status...</div>';
            statusDiv.style.display = 'block';
            
            fetch('?action=status')
                .then(response => response.json())
                .then(data => {
                    let html = '<h3>⚙️ System Status</h3>';
                    const s = data.system_status;
                    
                    html += `<div class="status-item"><strong>📊 Total Backups:</strong> ${data.total_backups}</div>`;
                    html += `<div class="status-item"><strong>📦 ZipArchive:</strong> ${s.zip_available ? '✅ Available' : '❌ Not Available'}</div>`;
                                       html += `<div class="status-item"><strong>🐘 PHP Version:</strong> ${s.php_version}</div>`;
                    html += `<div class="status-item"><strong>💾 Memory Limit:</strong> ${s.memory_limit}</div>`;
                    html += `<div class="status-item"><strong>⏱️ Max Execution Time:</strong> ${s.max_execution_time}s</div>`;

                    html += `<div class="status-item"><strong>🗃️ Databases:</strong> ${s.databases_count} configured</div>`;
                    
                    if (data.latest_backup) {
                        html += `<div class="status-item"><strong>📦 Latest Backup:</strong> ${data.latest_backup.name} (${data.latest_backup.size})</div>`;
                    }
                    
                    statusDiv.innerHTML = html;
                });
        }

        function viewLatestLog() {
            const logOutput = document.getElementById('logOutput');
            logOutput.style.display = 'block';
            logOutput.textContent = 'Loading latest log...';
            logOutput.scrollIntoView({ behavior: 'smooth' });
            
            fetch('?action=get_log')
                .then(response => response.json())
                .then(data => {
                    logOutput.textContent = data.log || 'No log content found.';
                })
                .catch(error => {
                    logOutput.textContent = '❌ Error loading log: ' + error.message;
                });
        }

        function cleanupBackups() {
            if (!confirm('⚠️ Are you sure you want to delete backups older than 7 days?')) {
                return;
            }
            
            showMessage('🧹 Cleaning up old backups...', 'info');
            
            fetch('?action=cleanup')
                .then(response => response.json())
                .then(data => {
                    showMessage(`✅ Cleanup completed: ${data.deleted_count} old backup(s) deleted`, 'success');
                    loadBackupList();
                })
                .catch(error => {
                    showMessage('❌ Cleanup failed: ' + error.message, 'error');
                });
        }

        function testEmail() {
            showMessage('📧 Sending test email to faheem.doula@gmail.com...', 'info');
            
            fetch('?action=test_email')
                .then(response => response.json())
                .then(data => {
                    showMessage(data.message, data.success ? 'success' : 'error');
                })
                .catch(error => {
                    showMessage('❌ Test failed: ' + error.message, 'error');
                });
        }
        
        function runDiagnostics() {
            showMessage('🔍 Running comprehensive diagnostics...', 'info');
            
            fetch('?action=diagnose')
                .then(response => response.json())
                .then(data => {
                    const statusDiv = document.getElementById('systemStatus');
                    let html = '<h3>🔍 System Diagnostics</h3>';
                    
                    // Backup Directory
                    html += '<h4>📂 Backup Directory</h4>';
                    html += `<div class="status-item"><strong>Path:</strong> ${data.backup_dir.path}</div>`;
                    html += `<div class="status-item"><strong>Exists:</strong> ${data.backup_dir.exists ? '✅ Yes' : '❌ No'}</div>`;
                    html += `<div class="status-item"><strong>Writable:</strong> ${data.backup_dir.writable ? '✅ Yes' : '❌ No'}</div>`;
                    html += `<div class="status-item"><strong>Permissions:</strong> ${data.backup_dir.permissions}</div>`;
                    if (data.backup_dir.file_count !== undefined) {
                        html += `<div class="status-item"><strong>Files:</strong> ${data.backup_dir.file_count}</div>`;
                        if (data.backup_dir.files && data.backup_dir.files.length > 0) {
                            html += `<div class="status-item"><strong>File List:</strong> ${data.backup_dir.files.join(', ')}</div>`;
                        }
                    }
                    if (data.backup_dir.creation_attempted) {
                        html += `<div class="status-item"><strong>Creation Attempted:</strong> ${data.backup_dir.creation_success ? '✅ Success' : '❌ Failed'}</div>`;
                    }
                    
                    // Source Directory
                    html += '<h4>📁 Source Directory</h4>';
                    html += `<div class="status-item"><strong>Path:</strong> ${data.source_dir.path}</div>`;
                    html += `<div class="status-item"><strong>Exists:</strong> ${data.source_dir.exists ? '✅ Yes' : '❌ No'}</div>`;
                    html += `<div class="status-item"><strong>Readable:</strong> ${data.source_dir.readable ? '✅ Yes' : '❌ No'}</div>`;
                    html += `<div class="status-item"><strong>Permissions:</strong> ${data.source_dir.permissions}</div>`;
                    
                    // Current Directory
                    html += '<h4>📍 Current Working Directory</h4>';
                    html += `<div class="status-item">${data.current_dir}</div>`;
                    
                    // PHP Extensions
                    html += '<h4>🔧 PHP Extensions</h4>';
                    for (const [ext, available] of Object.entries(data.php_extensions)) {
                        html += `<div class="status-item"><strong>${ext}:</strong> ${available ? '✅ Available' : '❌ Not Available'}</div>`;
                    }
                    
                    // PHP Settings
                    html += '<h4>⚙️ PHP Settings</h4>';
                    for (const [setting, value] of Object.entries(data.php_settings)) {
                        html += `<div class="status-item"><strong>${setting}:</strong> ${value}</div>`;
                    }
                    
                    // Databases
                    html += '<h4>🗄️ Database Connections</h4>';
                    for (const [dbName, dbInfo] of Object.entries(data.databases)) {
                        if (dbInfo.status === 'connected') {
                            html += `<div class="status-item">✅ <strong>${dbName}:</strong> Connected (${dbInfo.tables} tables)</div>`;
                        } else {
                            html += `<div class="status-item">❌ <strong>${dbName}:</strong> ${dbInfo.message}</div>`;
                        }
                    }
                    
                    statusDiv.innerHTML = html;
                    statusDiv.style.display = 'block';
                    statusDiv.scrollIntoView({ behavior: 'smooth' });
                    
                    showMessage('✅ Diagnostics complete! Check details above.', 'success');
                })
                .catch(error => {
                    showMessage('❌ Diagnostics failed: ' + error.message, 'error');
                });
        }

        function showDownloadInfo(filename) {
            alert('📥 Download Information:\n\n' +
                  'File: ' + filename + '\n\n' +
                  'Location: /home/u719432153/domains/shoukat-group.com/public_html/backups/\n\n' +
                  'Access via:\n' +
                  '1. Hostinger File Manager\n' +
                  '2. FTP/SFTP Client\n' +
                  '3. Email attachment (if backup was successful)');
        }

        // Auto-load on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadBackupList();
            setTimeout(checkSystemStatus, 1000);
        });
        
        // Auto-refresh backup list every 30 seconds
        setInterval(loadBackupList, 30000);
    </script>
</body>
</html
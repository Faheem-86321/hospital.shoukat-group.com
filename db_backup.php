<?php
/**
 * Hospital DB Backup Script — no token auth
 * ------------------------------------------
 * Same as the secured version, minus the BACKUP_TOKEN check.
 * Still includes: removed leaked hardcoded credentials, .htaccess
 * blocking direct access to the backups folder, retention cleanup,
 * stronger sanity check, and run logging.
 *
 * NOTE: Without a token, anyone who knows or guesses this URL can
 * trigger a full database dump + email at will. If this script is
 * reachable at a public URL, that's a real exposure risk for a
 * hospital system. Consider at least one of these instead:
 *   - Restrict access by IP (only allow your cron server / office IP)
 *     via .htaccess or your hosting firewall.
 *   - Move this file outside the public web root and run it via a
 *     local cron command instead of a public URL.
 */

session_start();
require_once(__DIR__ . "/env/main_config.php");
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// --------------------
// BACKUP FOLDER
// --------------------
$backupDir = __DIR__ . "/backups/";
if (!file_exists($backupDir)) {
    mkdir($backupDir, 0755, true);
}

// Block direct web access to the backups folder itself.
$htaccessPath = $backupDir . ".htaccess";
if (!file_exists($htaccessPath)) {
    file_put_contents($htaccessPath, "Require all denied\n");
}

$filename = "backup_" . date("Y-m-d_H-i-s") . ".sql";
$filepath = $backupDir . $filename;

// --------------------
// LOGGING HELPER
// --------------------
$logFile = $backupDir . "backup.log";
function backup_log($logFile, $msg) {
    file_put_contents($logFile, "[" . date("Y-m-d H:i:s") . "] " . $msg . "\n", FILE_APPEND);
}

// --------------------
// DB CONNECTION
// --------------------
// main_config.php already opens a connection into $con (mysqli_connect).
// Reuse it instead of duplicating credentials in a second place.
if (!isset($con) || !($con instanceof mysqli)) {
    backup_log($logFile, "DB connection ($con) not available from main_config.php");
    die("DB Connection Failed.");
}
$conn = $con;
$conn->set_charset("utf8mb4");

// main_config.php's connect string doesn't pass a dbname positionally in
// a way mysqli always selects by default in every PHP version, so make
// sure the right database is selected explicitly.
$dbname = "u719432153_Faheem"; // matches the DB name used in main_config.php
if (!$conn->select_db($dbname)) {
    backup_log($logFile, "Could not select database: $dbname - " . $conn->error);
    die("DB Connection Failed.");
}

// --------------------
// GET TABLES
// --------------------
$tables = [];
$result = $conn->query("SHOW TABLES");
while ($row = $result->fetch_row()) {
    $tables[] = $row[0];
}

$sql = "-- DATABASE BACKUP: {$dbname}\n-- Generated: " . date("Y-m-d H:i:s") . "\n\n";

// --------------------
// BUILD SQL DUMP
// --------------------
foreach ($tables as $table) {
    $sql .= "\n-- TABLE: $table\n\n";

    // STRUCTURE
    $create = $conn->query("SHOW CREATE TABLE `$table`");
    $row2 = $create->fetch_row();
    $sql .= $row2[1] . ";\n\n";

    // DATA
    $data = $conn->query("SELECT * FROM `$table`");
    while ($row = $data->fetch_assoc()) {
        $columns = array_keys($row);
        $values = array_values($row);
        $values = array_map(function ($v) use ($conn) {
            if ($v === null) return "NULL";
            return "'" . $conn->real_escape_string($v) . "'";
        }, $values);
        $sql .= "INSERT INTO `$table` (`" . implode("`,`", $columns) . "`) VALUES (" . implode(",", $values) . ");\n";
    }
}

$conn->close();

// --------------------
// SAVE FILE
// --------------------
file_put_contents($filepath, $sql);

// --------------------
// SANITY CHECK
// --------------------
$content = file_exists($filepath) ? file_get_contents($filepath) : '';
if ($content === '' || strpos($content, 'CREATE TABLE') === false) {
    backup_log($logFile, "Backup failed or looks empty/invalid: $filename");
    die("❌ Backup Failed or Invalid File");
}

backup_log($logFile, "Backup created successfully: $filename (" . filesize($filepath) . " bytes)");
echo "✅ Backup Created Successfully<br>";

// --------------------
// RETENTION CLEANUP (keep last 14 days)
// --------------------
$retentionDays = 14;
$cutoff = time() - ($retentionDays * 86400);
foreach (glob($backupDir . "backup_*.sql") as $oldFile) {
    if (filemtime($oldFile) < $cutoff) {
        unlink($oldFile);
        backup_log($logFile, "Deleted old backup: " . basename($oldFile));
    }
}

// --------------------
// COMPRESS BEFORE EMAILING
// --------------------
// SQL dumps compress very well (often 80-90%). Compressing first gives
// the attachment the best chance of getting under mail-server size limits.
$gzFilename = $filename . ".gz";
$gzFilepath = $backupDir . $gzFilename;
file_put_contents($gzFilepath, gzencode($sql, 9));
backup_log($logFile, "Compressed backup: $gzFilename (" . filesize($gzFilepath) . " bytes, from " . filesize($filepath) . " bytes)");

// Max attachment size we'll attempt to send (bytes). Most mail servers
// (including PHP mail() and Gmail's receiving limit) reject much above
// 20-25MB total message size, and base64 inflates size by ~33%.
$maxAttachmentBytes = 15 * 1024 * 1024; // 15MB raw -> ~20MB base64

// --------------------
// EMAIL CONFIG
// --------------------
$to = "faheem.doula@gmail.com";
$from = "backup@hospital.shoukat-group.com";
$subject = "Hospital DB Backup - " . $dbname . " - " . date("Y-m-d");
$boundary = "----PHP-MAIL-" . md5(uniqid((string) mt_rand(), true));

$attachThisFile = null;
$attachThisName = null;
if (filesize($gzFilepath) <= $maxAttachmentBytes) {
    $attachThisFile = $gzFilepath;
    $attachThisName = $gzFilename;
} else {
    backup_log($logFile, "Compressed file still too large to email (" . filesize($gzFilepath) . " bytes) - sending notification only");
}

if ($attachThisFile !== null) {
    $message = "Backup generated successfully.\nFile: " . $filename .
        "\nCompressed and attached as: " . $attachThisName .
        "\nUncompressed size: " . round(filesize($filepath) / 1048576, 2) . " MiB" .
        "\nCompressed size: " . round(filesize($attachThisFile) / 1048576, 2) . " MiB" .
        "\n\nUnzip with: gunzip " . $attachThisName;

    $fileContent = file_get_contents($attachThisFile);
    $attachment = chunk_split(base64_encode($fileContent));

    $headers  = "From: {$from}\r\n";
    $headers .= "Reply-To: {$from}\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"{$boundary}\"\r\n";

    $body  = "--{$boundary}\r\n";
    $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $body .= $message . "\r\n\r\n";
    $body .= "--{$boundary}\r\n";
    $body .= "Content-Type: application/gzip; name=\"{$attachThisName}\"\r\n";
    $body .= "Content-Transfer-Encoding: base64\r\n";
    $body .= "Content-Disposition: attachment; filename=\"{$attachThisName}\"\r\n\r\n";
    $body .= $attachment . "\r\n\r\n";
    $body .= "--{$boundary}--";
} else {
    // Notification-only email, no attachment - file stays safely on the server.
    $message = "Backup generated successfully but was too large to email.\n" .
        "File: " . $filename .
        "\nUncompressed size: " . round(filesize($filepath) / 1048576, 2) . " MiB" .
        "\nCompressed size: " . round(filesize($gzFilepath) / 1048576, 2) . " MiB" .
        "\n\nFile is saved on the server at: /backups/" . $filename .
        "\nPlease download it via File Manager or FTP.";

    $headers  = "From: {$from}\r\n";
    $headers .= "Reply-To: {$from}\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $body = $message;
}

// --------------------
// SEND MAIL
// --------------------
$mail = @mail($to, $subject, $body, $headers);

if ($mail) {
    echo "📧 Email Sent Successfully (Server Accepted Request)";
    backup_log($logFile, "Email accepted by server for $filename" . ($attachThisFile !== null ? " (with attachment)" : " (notification only)"));
} else {
    echo "❌ Email Failed (Server blocked mail or SMTP required)";
    backup_log($logFile, "Email FAILED for $filename");
}

// Clean up old compressed copies too, same retention window as .sql files.
foreach (glob($backupDir . "backup_*.sql.gz") as $oldGz) {
    if (filemtime($oldGz) < $cutoff) {
        unlink($oldGz);
        backup_log($logFile, "Deleted old compressed backup: " . basename($oldGz));
    }
}
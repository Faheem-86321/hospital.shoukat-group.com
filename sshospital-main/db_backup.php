<?php
session_start();

require_once(__DIR__ . "/env/main_config.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

// --------------------
// BACKUP FOLDER
// --------------------
$backupDir = __DIR__ . "/backups/";
if (!file_exists($backupDir)) {
    mkdir($backupDir, 0755, true);
}

$filename = "backup_" . date("Y-m-d_H-i-s") . ".sql";
$filepath = $backupDir . $filename;

// --------------------
// DB CONNECTION
// --------------------
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($conn->connect_error) {
    die("DB Connection Failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");

// --------------------
// GET TABLES
// --------------------
$tables = [];
$result = $conn->query("SHOW TABLES");

while ($row = $result->fetch_row()) {
    $tables[] = $row[0];
}

$sql = "-- DATABASE BACKUP: {$dbname}\n\n";

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

// --------------------
// SAVE FILE
// --------------------
file_put_contents($filepath, $sql);

// --------------------
// CHECK BACKUP
// --------------------
if (!file_exists($filepath) || filesize($filepath) < 100) {
    die("❌ Backup Failed or Empty File");
}

echo "✅ Backup Created Successfully<br>";

// --------------------
// EMAIL CONFIG
// --------------------
$to = "faheem.doula@gmail.com";
$from = "backup@hospital.shoukat-group.com";
$subject = "Hospital DB Backup - " . $dbname;
$message = "Backup generated successfully.\nFile: " . $filename;

$fileContent = file_get_contents($filepath);
$attachment = chunk_split(base64_encode($fileContent));

$boundary = "----PHP-MAIL-" . md5(time());

// --------------------
// HEADERS (SAFE FORMAT)
// --------------------
$headers  = "From: {$from}\r\n";
$headers .= "Reply-To: {$from}\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: multipart/mixed; boundary=\"{$boundary}\"\r\n";

// --------------------
// BODY
// --------------------
$body  = "--{$boundary}\r\n";
$body .= "Content-Type: text/plain; charset=UTF-8\r\n";
$body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$body .= $message . "\r\n\r\n";

$body .= "--{$boundary}\r\n";
$body .= "Content-Type: application/octet-stream; name=\"{$filename}\"\r\n";
$body .= "Content-Transfer-Encoding: base64\r\n";
$body .= "Content-Disposition: attachment; filename=\"{$filename}\"\r\n\r\n";
$body .= $attachment . "\r\n\r\n";

$body .= "--{$boundary}--";

// --------------------
// SEND MAIL + REAL CHECK
// --------------------
$mail = @mail($to, $subject, $body, $headers);

// REAL RESULT CHECK
if ($mail) {
    echo "📧 Email Sent Successfully (Server Accepted Request)";
} else {
    echo "❌ Email Failed (Server blocked mail or SMTP required)";
}
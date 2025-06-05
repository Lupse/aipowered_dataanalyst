<?php
header('Content-Type: text/plain; charset=utf-8');

$host = 'localhost';
$user = 'root';
$pass = ''; // sesuaikan password MySQL Anda
$db   = 'hr';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    http_response_code(500);
    die("Koneksi gagal: " . $conn->connect_error);
}

$output = "";

// Ambil struktur tabel
$tables = [];
$res = $conn->query("SHOW TABLES");
while ($row = $res->fetch_array()) {
    $tables[] = $row[0];
}
foreach ($tables as $table) {
    $res = $conn->query("SHOW CREATE TABLE `$table`");
    $row = $res->fetch_assoc();
    $output .= "-- Table structure for table `$table`\n";
    $output .= $row['Create Table'] . ";\n\n";
}

// Ambil data tiap tabel
foreach ($tables as $table) {
    $res = $conn->query("SELECT * FROM `$table`");
    if ($res->num_rows > 0) {
        $output .= "-- Dumping data for table `$table`\n";
        while ($row = $res->fetch_assoc()) {
            $cols = array_map(function ($col) use ($conn) {
                return "`" . $col . "`";
            }, array_keys($row));
            $vals = array_map(function ($val) use ($conn) {
                if (is_null($val)) return "NULL";
                return "'" . $conn->real_escape_string($val) . "'";
            }, array_values($row));
            $output .= "INSERT INTO `$table` (" . implode(", ", $cols) . ") VALUES (" . implode(", ", $vals) . ");\n";
        }
        $output .= "\n";
    }
}

$conn->close();
echo $output;

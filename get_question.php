<?php
include("config.php");
$conn = new mysqli($host, $user, $pass, $db);

$result = $conn->query("SELECT * FROM objects ORDER BY RAND() LIMIT 1");

if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(['error' => 'No questions available']);
}

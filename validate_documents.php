<?php
header("Content-Type: application/json");
include "db.php";

if (!isset($_POST['user_id'], $_POST['scheme_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "user_id and scheme_id required"
    ]);
    exit;
}

$user_id = intval($_POST['user_id']);
$scheme_id = intval($_POST['scheme_id']);

$sql = "
SELECT sd.document_name,
       IF(d.document_id IS NULL, 'missing', 'uploaded') AS status
FROM scheme_documents sd
LEFT JOIN documents d 
  ON d.document_type = sd.document_name 
 AND d.user_id = ?
WHERE sd.scheme_id = ?
";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $user_id, $scheme_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$validation = [];

while ($row = mysqli_fetch_assoc($result)) {
    $validation[] = $row;
}

echo json_encode([
    "status" => "success",
    "validation" => $validation
]);

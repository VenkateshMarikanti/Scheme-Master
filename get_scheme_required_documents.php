<?php
header("Content-Type: application/json");
include "db.php";

if (!isset($_GET['scheme_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "scheme_id required"
    ]);
    exit;
}

$scheme_id = $_GET['scheme_id'];

$stmt = mysqli_prepare(
    $conn,
    "SELECT document_name, mandatory 
     FROM scheme_documents 
     WHERE scheme_id=?"
);

mysqli_stmt_bind_param($stmt, "i", $scheme_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$documents = [];

while ($row = mysqli_fetch_assoc($result)) {
    $documents[] = [
        "name" => $row['document_name'],
        "mandatory" => (bool)$row['mandatory']
    ];
}

echo json_encode([
    "status" => "success",
    "scheme_id" => $scheme_id,
    "documents" => $documents
]);
?>

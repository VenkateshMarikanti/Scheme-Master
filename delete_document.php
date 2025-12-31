<?php
header("Content-Type: application/json");
include "db.php";

if (!isset($_POST['document_id'])) {
    echo json_encode(["status"=>"error","message"=>"Document ID required"]);
    exit;
}

$document_id = $_POST['document_id'];

$getFile = mysqli_prepare(
    $conn,
    "SELECT file_path FROM documents WHERE document_id = ?"
);
mysqli_stmt_bind_param($getFile, "i", $document_id);
mysqli_stmt_execute($getFile);
$result = mysqli_stmt_get_result($getFile);

if ($row = mysqli_fetch_assoc($result)) {
    $filePath = $row['file_path'];

    if (file_exists($filePath)) {
        unlink($filePath);
    }

    $delete = mysqli_prepare(
        $conn,
        "DELETE FROM documents WHERE document_id = ?"
    );
    mysqli_stmt_bind_param($delete, "i", $document_id);

    if (mysqli_stmt_execute($delete)) {
        echo json_encode([
            "status"=>"success",
            "message"=>"Document deleted successfully"
        ]);
    } else {
        echo json_encode([
            "status"=>"error",
            "message"=>"Delete failed"
        ]);
    }
} else {
    echo json_encode([
        "status"=>"error",
        "message"=>"Document not found"
    ]);
}
?>

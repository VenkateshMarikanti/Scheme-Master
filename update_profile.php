<?php
header("Content-Type: application/json");
include "db.php";

if (!isset($_POST['user_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "user_id required"
    ]);
    exit;
}

$user_id = intval($_POST['user_id']);
$name = $_POST['name'] ?? '';
$phone = $_POST['phone'] ?? '';
$caste = $_POST['caste'] ?? '';

$stmt = mysqli_prepare(
    $conn,
    "UPDATE users 
     SET name = ?, phone = ?, caste = ? 
     WHERE user_id = ?"
);

mysqli_stmt_bind_param($stmt, "sssi", $name, $phone, $caste, $user_id);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode([
        "status" => "success",
        "message" => "Profile updated successfully"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Profile update failed"
    ]);
}
?>

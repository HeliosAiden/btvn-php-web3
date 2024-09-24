<?php
// require_once $_SERVER['DOCUMENT_ROOT'] . '/core/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/homework/core/Database.php';
require $_SERVER['DOCUMENT_ROOT'] . '/homework' . '/config.php';

$db = new Database();
$table = 'sinh_vien'; // Exact table name on phpadmin

$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (
    $_SERVER["REQUEST_METHOD"] == "POST" &&
    isset($data['id']) &&
    empty($data['fullname']) &&
    empty($data['student_id']) &&
    empty($data['sex']) &&
    empty($data['date_of_birth'])
) {
    $id = $data["id"];
    $condition = "id = $id";

    $is_susscess = $db->delete($table, $condition);

    if (!$is_susscess) {
        echo 'Failed to insert';
    }
}

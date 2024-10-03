<?php
// require_once $_SERVER['DOCUMENT_ROOT'] . '/core/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/homework/core/Database.php';
require $_SERVER['DOCUMENT_ROOT'] . '/homework' . '/config.php';

$db = new Database();
$table = 'employees'; // Exact table name on phpadmin

$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (
    $_SERVER["REQUEST_METHOD"] == "POST" &&
    isset($data['id']) &&
    empty($data['firstname']) &&
    empty($data['lastname']) &&
    empty($data['role']) &&
    empty($data['department'])
) {
    $id = $data["id"];
    $condition = "employee_id = $id";

    $is_susscess = $db->delete($table, $condition);

    if (!$is_susscess) {
        echo 'Failed to delete';
    }
}

<?php
// require_once $_SERVER['DOCUMENT_ROOT'] . '/core/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/homework/core/Database.php';
require $_SERVER['DOCUMENT_ROOT'] . '/homework' . '/config.php';

$db = new Database();
$table = 'employees'; // Exact table name on phpadmin

$input = file_get_contents("php://input");
$data = json_decode($input, true);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset(
    $data['firstname'],
    $data['lastname'],
    $data['role'],
    $data['department']
)) {
    $lastname = $data["lastname"];
    $firstname = $data["firstname"];
    $role = $data["role"];
    $department = $data["department"];

    $data = [
        'lastname' => $lastname,
        'firstname' => $firstname,
        'role_id' => $role,
        'department_id' => $department
    ];

    $is_susscess = $db->insert($table, $data);

    if (!$is_susscess) {
        echo 'Failed to insert';
    }
}

?>
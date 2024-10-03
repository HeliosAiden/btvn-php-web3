<?php
// require_once $_SERVER['DOCUMENT_ROOT'] . '/core/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/homework/core/Database.php';
require $_SERVER['DOCUMENT_ROOT'] . '/homework/' . 'config.php';

$db = new Database();
$table = 'employees'; // Exact table name on phpadmin

$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (
    $_SERVER["REQUEST_METHOD"] == "PUT" &&
    isset(
        $data['id'],
        $data['firstname'],
        $data['lastname'],
        $data['role'],
        $data['department']
    )
) {

    $id = $data['id'];
    $firstname = $data['firstname'];
    $lastname = $data['lastname'];
    $role = $data['role'];
    $department = $data['department'];

    $data = [
        'firstname' => $firstname,
        'lastname' => $lastname,
        'role_id' => $role,
        'department_id' => $department,
    ];
    $condition = "employee_id = " . $id;

    $stmt = $db->update($table, $data, $condition);
}

?>
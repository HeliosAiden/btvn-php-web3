<?php
// require_once $_SERVER['DOCUMENT_ROOT'] . '/core/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/homework/core/Database.php';
require $_SERVER['DOCUMENT_ROOT'] . '/homework/' . 'config.php';

$db = new Database();
$table = 'sinh_vien'; // Exact table name on phpadmin

$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (
    $_SERVER["REQUEST_METHOD"] == "PUT" &&
    isset(
        $data['id'],
        $data['student_id'],
        $data['fullname'],
        $data['sex'],
        $data['date_of_birth']
    )
) {

    $id = $data['id'];
    $student_id = $data['student_id'];
    $fullname = $data['fullname'];
    $sex = $data['sex'];
    $date_of_birth = $data['date_of_birth'];

    $data = [
        'student_id' => $student_id,
        'fullname' => $fullname,
        'sex' => $sex,
        'date_of_birth' => $date_of_birth,
    ];
    $condition = "id = " . $id;

    $stmt = $db->update($table, $data, $condition);
}

?>
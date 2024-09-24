<?php
// require_once $_SERVER['DOCUMENT_ROOT'] . '/core/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/homework/core/Database.php';
require $_SERVER['DOCUMENT_ROOT'] . '/homework' . '/config.php';

$db = new Database();
$table = 'sinh_vien'; // Exact table name on phpadmin

$input = file_get_contents("php://input");
$data = json_decode($input, true);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset(
    $data['student_id'],
    $data['fullname'],
    $data['sex'],
    $data['date_of_birth']
)) {
    $fullname = $data["fullname"];
    $student_id = $data["student_id"];
    $sex = $data["sex"];
    $date_of_birth = $data["date_of_birth"];

    $data = [
        'fullname' => $fullname,
        'student_id' => $student_id,
        'sex' => $sex,
        'date_of_birth' => $date_of_birth
    ];

    $is_susscess = $db->insert($table, $data);

    if (!$is_susscess) {
        echo 'Failed to insert';
    }
}

?>
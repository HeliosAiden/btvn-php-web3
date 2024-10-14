<?php
require $_SERVER['DOCUMENT_ROOT'] . '/homework/' . 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . __ROOT_CORE__ . '/Database.php';

$db = new Database();
$table = 'users'; // Exact table name on phpadmin
$sql = "SELECT username, role_id, email, id, role_id, password FROM $table";
$result = $db->query($sql) -> fetchAll(PDO::FETCH_ASSOC);
$user = $result[0];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (password_verify($current_password, $user['password'])) {
        header("Content-Type: application/json");
        http_response_code(400);
        echo json_encode('Bad request: current password is incorrect');
        exit;
    }
    if ($new_password !== $confirm_password) {
        header("Content-Type: application/json");
        http_response_code(400);
        echo json_encode('Bad request: new passwords do not match');
        exit;
    }


    try {
        $data = [
            'password' => password_hash($new_password, PASSWORD_BCRYPT)
        ];
        $user_id = $user['id'];
        $condition = "$user_id";
        $status = $db->update($table, $data, $condition);
        if ($status) {
            header("Content-Type: application/json");
            http_response_code(200);
            echo json_encode('You have successfully change your password');
        } else {
            header("Content-Type: application/json");
            http_response_code(400);
            echo json_encode('Bad request');
        }
    } catch (PDOException $e) {
        // Error, redirect back with an error
        echo $e;
        exit();
    }
}

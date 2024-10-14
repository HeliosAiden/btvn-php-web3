<?php
require $_SERVER['DOCUMENT_ROOT'] . '/homework/' . 'config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . __ROOT_CORE__ . '/Database.php';
$db = new Database();
$table = 'users'; // Exact table name on phpadmin

// Get POST data
$username = $_POST['username'];
$email = $_POST['email'];
$role = $_POST['role'];
$password = $_POST['password'];

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

try {
    $data = [
       'username' => $username,
       'email'=> $email,
       'role_id'=> $role,
       'password'=> $hashed_password
    ];
    $status = $db->insert($table, $data);
    if ($status) {
        header("Content-Type: application/json");
        http_response_code(200);
        echo json_encode('You have successfully registered');
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

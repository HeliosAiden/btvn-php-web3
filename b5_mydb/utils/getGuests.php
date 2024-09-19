<?php 

// Kết nối db
require_once $_SERVER['DOCUMENT_ROOT'] . '/homework/b5_mydb/Database.php';

$db = new Database();
$table = 'myguests'; // Exact table name on phpadmin

if ($_SERVER["REQUEST_METHOD"] == "GET" ) {
    $sql = "SELECT id, firstname, lastname, email FROM MyGuests";
    $result = $db->query($sql) -> fetchAll(PDO::FETCH_ASSOC);

    $guests = [];

    if (!empty($result)) {
        foreach($result as $row) {
            $guests[] = $row;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($guests);

}
?>

<?php
    // require $_SERVER['DOCUMENT_ROOT'] . 'config.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/homework/' . 'config.php';
?>
<div class="container mt-5">
    <h2 class="text-center">MyGuests Table</h2>
    <br/>
    <br/>
    <br/>

    <?php
    // Kết nối db
    require_once __DIR__ . '/Database.php';
    $db = new Database();
    $table = 'myguests'; // Exact table name on phpadmin

    // Pagination logic
    $limit = 10; // Number of entries to show per page
    if (isset($_GET["page"])) {
        $page = $_GET["page"];
    } else {
        $page = 1;
    }
    $start_from = ($page - 1) * $limit;

    // Fetch records with pagination
    $sql = "SELECT id, firstname, lastname, email, reg_date FROM $table LIMIT $start_from, $limit";
    $result = $db->query($sql) -> fetchAll(PDO::FETCH_ASSOC);

    ?>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Registration Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($result)) {
                // Output data of each row
                foreach ($result as $row) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['firstname']}</td>
                            <td>{$row['lastname']}</td>
                            <td>{$row['reg_date']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <?php
    // Pagination controls
    $sql = "SELECT COUNT(id) FROM MyGuests";
    $result = $db->query($sql);
    $row = $result-> fetchAll(PDO::FETCH_ASSOC);
    $total_records = $row[0]['COUNT(id)'];
    $total_pages = ceil($total_records / $limit);


    echo '<nav aria-label="Page navigation">';
    echo '<ul class="pagination justify-content-center">';
    $root = __ROOT_DIR__;

    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<li class='page-item'><a class='page-link' href='#' onclick=loadContent(" . "'$root/b5_mydb/list.php?page=" . $i . "') >" . $i . "</a></li>";
    }

    echo '</ul>';
    echo '</nav>';

    ?>
    <script>

    </script>
</div>
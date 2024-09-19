<div class="container mt-5">
    <h2 class="text-center">Insert Data into MyGuests</h2>

    <?php
    // Kết nối db
    require_once __DIR__ . '/Database.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["firstname"]) && !empty($_POST["lastname"]) && !empty($_POST["email"])) {
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];

        $db = new Database();
        $table = 'myguests'; // Exact table name on phpadmin
        $data = [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email
        ];

        $is_susscess = $db->insert($table, $data);

        if (!$is_susscess) {
            echo 'Failed to insert';
        }
        $condition = '';

        foreach ($data as $key => $value) {
            $condition .= $key . " = '" . $value . "' AND ";
        }
        $condition = rtrim($condition, ' AND ');

        $user = $db->select($table, $condition)[0];

    ?>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Registration Date</th>
                </tr>
            </thead>
            <tbody>
            <?php

            echo "<tr>
                <td>{$user['id']}</td>
                <td>{$user['firstname']}</td>
                <td>{$user['lastname']}</td>
                <td>{$user['email']}</td>
                <td>{$user['reg_date']}</td>
            </tr>";
        }

            ?>
            </tbody>
        </table>
        <br />
        <br />
        <br />

        <div class="mb-3">
            <label for="firstname" class="form-label">First Name</label>
            <input type="text" class="form-control" id="firstname" name="firstname" required>
        </div>
        <div class="mb-3">
            <label for="lastname" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="lastname" name="lastname" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="text-center">
            <button id="insert_myGuests" class="btn btn-primary">Submit</button>
        </div>

        <script>
            $(document).ready(function() {
            $('#insert_myGuests').click(function() {
                // Get the input values
                var firstname = $('#firstname').val();
                var lastname = $('#lastname').val();
                var email = $('#email').val();
                
                // Send the POST request via AJAX
                $.ajax({
                    url: '/homework/b5_mydb/insert.php',
                    type: 'POST',
                    data: {
                        firstname: firstname,
                        lastname: lastname,
                        email: email
                    },
                    success: function(response) {
                        // Redirect to list
                        loadContent('/homework/b5_mydb/list.php')
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $('#response').html('<p>Error: ' + textStatus + '</p>');
                    }
                });
            });
        });
        </script>
</div>
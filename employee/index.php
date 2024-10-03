<?php
// require $_SERVER['DOCUMENT_ROOT'] . 'config.php';
require $_SERVER['DOCUMENT_ROOT'] . '/homework/' . 'config.php';
?>
<div class="container mt-5">
    <h2 class="text-center">Bảng nhân viên</h2>
    <br />
    <br />
    <br />

    <?php
    // Kết nối db
    require_once $_SERVER['DOCUMENT_ROOT'] . __ROOT_CORE__ . '/Database.php';
    $db = new Database();
    $table = 'employees'; // Exact table name on phpadmin

    // Pagination logic
    $limit = 10; // Number of entries to show per page
    if (isset($_GET["page"])) {
        $page = $_GET["page"];
    } else {
        $page = 1;
    }
    $start_from = ($page - 1) * $limit;

    // Fetch records with pagination
    $sql = "SELECT employee_id, firstname, lastname, role_id, department_id FROM $table LIMIT $start_from, $limit";
    $result = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <div class="text-end mb-3">
        <button id='add-employee' class='btn btn-primary' onclick="openAddForm()">Thêm sinh viên</button>
    </div>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Role</th>
                <th>Department</th>
                <th>Chọn thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($result)) {
                // Output data of each row
                foreach ($result as $row) {
                    $role_id;
                    switch ($row['role_id']) {
                        case 1:
                            $role_id = 'Manager';
                            break;
                        case 2:
                            $role_id = 'Employee';
                            break;
                        case 3:
                            $role_id = 'Intern';
                            break;
                        default:
                            $role_id = 'Không có role';
                            break;
                    }
                    $department;
                    switch ($row['department_id']) {
                        case 1:
                            $department_id = 'HR';
                            break;
                        case 2:
                            $department_id = 'Marketing';
                            break;
                        case 3:
                            $department_id = 'IT';
                            break;
                        default:
                            $department_id = 'Không có role';
                            break;
                    }
                    echo "<tr>
                            <td>{$row['firstname']}</td>
                            <td>{$row['lastname']}</td>
                            <td>{$role_id}</td>
                            <td>{$department_id}</td>
                            <td class='text-end' >
                                <button id='edit_sinh_vien' class='btn btn-secondary' onclick='openEditForm(" . json_encode($row) . ")' >Sửa</button>
                                <button id='delete_sinhvien' class='btn btn-danger' onclick='openDeleteForm(" . $row["employee_id"] . ")' >Xóa</button>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Add Student Modal -->
    <div class="modal" id="addModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add employee</h5>
                    <button type="button" class="btn-close" onclick="closeAddForm()"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="add-firstname" class="form-label">Firstname<noscript></noscript></label>
                        <input type="text" class="form-control" id="add-firstname">
                    </div>
                    <div class="mb-3">
                        <label for="add-lastname" class="form-label">Lastname<noscript></noscript></label>
                        <input type="text" class="form-control" id="add-lastname">
                    </div>
                    <div class="mb-3">
                        <label for="add-role" class="form-label">Roles</label>
                        <select class="form-select" id="add-role">
                            <option value="">Select your role</option>
                            <option value=1>Manager</option>
                            <option value=2>Employee</option>
                            <option value=3>Intern</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="add-department" class="form-label">Department</label>
                        <select class="form-select" id="add-department">
                            <option value="">Select your department</option>
                            <option value=1>HR</option>
                            <option value=2>Marketing</option>
                            <option value=3>IT</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeAddForm()">Close form</button>
                    <button type="button" id="add-employee-btn" class="btn btn-success" onclick="submitAddForm()" disabled>Add employee</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit employee info</h5>
                    <button type="button" class="btn-close" onclick="closeEditForm()"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit-id">
                    <div class="mb-3">
                        <label for="edit-firstname" class="form-label">Firstname<noscript></noscript></label>
                        <input type="text" class="form-control" id="edit-firstname">
                    </div>
                    <div class="mb-3">
                        <label for="edit-lastname" class="form-label">Lastname<noscript></noscript></label>
                        <input type="text" class="form-control" id="edit-lastname">
                    </div>
                    <div class="mb-3">
                        <label for="edit-role" class="form-label">Roles</label>
                        <select class="form-select" id="edit-role">
                            <option value="">Select your role</option>
                            <option value="1">Manager</option>
                            <option value="2">Employee</option>
                            <option value="3">Intern</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit-department" class="form-label">Department</label>
                        <select class="form-select" id="edit-department">
                            <option value="">Select your department</option>
                            <option value="1">HR</option>
                            <option value="2">Marketing</option>
                            <option value="3">IT</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeEditForm()">Đóng form</button>
                    <button type="button" id='submit-edit' class="btn btn-primary" onclick="submitEditForm()">Thay đổi</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete employee</h5>
                    <button type="button" class="btn-close" onclick="closeDeleteForm()"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this employee row ?</p>
                    <input type="hidden" id="delete-id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeDeleteForm()">Hủy</button>
                    <button type="button" id="delete-student-btn" class="btn btn-danger" onclick="submitDeleteForm()">Xóa</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    // Pagination controls
    $sql = "SELECT COUNT(employee_id) FROM $table";
    $result = $db->query($sql);
    $row = $result->fetchAll(PDO::FETCH_ASSOC);
    $total_records = $row[0]['COUNT(employee_id)'];
    $total_pages = ceil($total_records / $limit);


    echo '<nav aria-label="Page navigation">';
    echo '<ul class="pagination justify-content-center">';
    $root = __ROOT_DIR__;

    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<li class='page-item'><a class='page-link' href='#' onclick=loadContent(" . "'$root/employee/index.php?page=" . $i . "') >" . $i . "</a></li>";
    }

    echo '</ul>';
    echo '</nav>';

    ?>
    <script>
        // Function to open the edit modal with pre-filled student data
        function checkEditForm() {
            const currentData = {
                firstname: document.getElementById('edit-firstname').value,
                lastname: document.getElementById('edit-lastname').value,
                role: document.getElementById('edit-role').value,
                department: document.getElementById('edit-department').value
            };

            // Compare current form data with initial data
            const dataChanged = JSON.stringify(currentData) !== JSON.stringify(initialData);

            // Enable the "Save Changes" button if data has changed
            document.getElementById('submit-edit').disabled = !dataChanged;
        }

        function checkAddForm() {
            const lastName = document.getElementById('add-lastname').value.trim();
            const firstName = document.getElementById('add-firstname').value.trim();
            const role = document.getElementById('add-role').value;
            const department = document.getElementById('add-department').value;

            // Enable the "Add Student" button only if all fields are filled
            const allFieldsFilled = lastName && firstName && role && department;
            console.log(!allFieldsFilled == false)
            document.getElementById('add-employee-btn').disabled = !allFieldsFilled;
        }

        // Function to open the "Add Student" modal
        function openAddForm() {
            document.getElementById('add-lastname').value = '';
            document.getElementById('add-firstname').value = '';
            document.getElementById('add-role').value = '';
            document.getElementById('add-department').value = '';

            // Disable the "Add Student" button initially
            document.getElementById('add-employee-btn').disabled = true;

            // Add event listeners to track changes
            document.getElementById('add-lastname').addEventListener('input', checkAddForm);
            document.getElementById('add-firstname').addEventListener('input', checkAddForm);
            document.getElementById('add-role').addEventListener('change', checkAddForm);
            document.getElementById('add-department').addEventListener('input', checkAddForm);

            var addModal = new bootstrap.Modal(document.getElementById('addModal'));
            addModal.show();
        }

        // Function to close the "Add Student" modal
        function closeAddForm() {
            var addModal = bootstrap.Modal.getInstance(document.getElementById('addModal'));
            addModal.hide();
        }

        function submitAddForm() {
            var lastName = document.getElementById('add-lastname').value;
            var firstName = document.getElementById('add-firstname').value;
            var role = document.getElementById('add-role').value;
            var department = document.getElementById('add-department').value;

            var data = {
                firstname: firstName,
                lastname: lastName,
                role: role,
                department: department
            };

            let url = '<?php echo __ROOT_DIR__ . '/employee/utils' ?>/add.php'

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })

            closeAddForm(); // Close the modal after submission
            loadContent(`<?php echo __ROOT_DIR__ ?>/employee/index.php`)
        }

        function openEditForm(employee) {
            document.getElementById('edit-id').value = employee.employee_id;
            document.getElementById('edit-firstname').value = employee.firstname;
            document.getElementById('edit-lastname').value = employee.lastname;
            document.getElementById('edit-role').value = employee.role_id;
            document.getElementById('edit-department').value = employee.department_id;
            // Store the initial values

            initialData = {
                firstname: employee.firstname,
                lastname: employee.lastname,
                role: employee.role_id,
                department: employee.department_id,
            };

            // Disable "Save Changes" button initially
            document.getElementById('submit-edit').disabled = true;

            // Add event listeners to track changes
            document.getElementById('edit-firstname').addEventListener('input', checkEditForm);
            document.getElementById('edit-lastname').addEventListener('input', checkEditForm);
            document.getElementById('edit-role').addEventListener('change', checkEditForm);
            document.getElementById('edit-department').addEventListener('change', checkEditForm)

            var editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        }

        // Function to close the modal
        function closeEditForm() {
            var editModal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
            editModal.hide();
        }

        function submitEditForm() {
            var id = document.getElementById('edit-id').value;
            var firstName = document.getElementById('edit-firstname').value;
            var lastName = document.getElementById('edit-lastname').value;
            var role = document.getElementById('edit-role').value;
            var department = document.getElementById('edit-department').value;

            var data = {
                id: id,
                firstname: firstName,
                lastname: lastName,
                role: role,
                department: department
            };

            let url = '<?php echo __ROOT_DIR__ . '/employee/utils' ?>/edit.php'

            fetch(url, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })

            closeEditForm(); // Close the modal after submission
            loadContent(`<?php echo __ROOT_DIR__ ?>/employee/index.php`)
        }

        // Function to open the delete confirmation modal
        function openDeleteForm(employee_id) {
            document.getElementById('delete-id').value =employee_id;

            var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }

        // Function to close the delete modal
        function closeDeleteForm() {
            var deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
            deleteModal.hide();
        }

        // Function to submit the delete request via HTTP POST request
        function submitDeleteForm() {
            var employee_id = document.getElementById('delete-id').value;

            let url = '<?php echo __ROOT_DIR__ . '/employee/utils' ?>/delete.php'

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: employee_id
                })
            })

            closeDeleteForm(); // Close the modal after submission
            loadContent(`<?php echo __ROOT_DIR__ ?>/employee/index.php`)
        }
    </script>
</div>
<?php
// require $_SERVER['DOCUMENT_ROOT'] . 'config.php';
require $_SERVER['DOCUMENT_ROOT'] . '/homework/' . 'config.php';
?>
<div class="container mt-5">
    <h2 class="text-center">Bảng sinh viên</h2>
    <br />
    <br />
    <br />

    <?php
    // Kết nối db
    require_once $_SERVER['DOCUMENT_ROOT'] . __ROOT_CORE__ . '/Database.php';
    $db = new Database();
    $table = 'sinh_vien'; // Exact table name on phpadmin

    // Pagination logic
    $limit = 10; // Number of entries to show per page
    if (isset($_GET["page"])) {
        $page = $_GET["page"];
    } else {
        $page = 1;
    }
    $start_from = ($page - 1) * $limit;

    // Fetch records with pagination
    $sql = "SELECT id, student_id, fullname, sex, date_of_birth FROM $table LIMIT $start_from, $limit";
    $result = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <div class="text-end mb-3">
        <button id='add_sinh_vien' class='btn btn-primary' onclick="openAddForm()">Thêm sinh viên</button>
    </div>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Mã sinh viên</th>
                <th>Họ và tên</th>
                <th>Giới tính</th>
                <th>Ngày sinh</th>
                <th>Chọn thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($result)) {
                // Output data of each row
                foreach ($result as $row) {
                    $sex;
                    switch ($row['sex']) {
                        case 'Male':
                            $sex = 'Nam giới';
                            break;
                        case 'Female':
                            $sex = 'Nữ giới';
                            break;
                        case 'Other':
                            $sex = 'Giới tính thứ 3';
                            break;
                        default:
                            $sex = 'Không xác định';
                            break;
                    }
                    $dateTime = new DateTime($row['date_of_birth']);
                    $formattedDate = $dateTime->format('d-m-Y');
                    echo "<tr>
                            <td>{$row['student_id']}</td>
                            <td>{$row['fullname']}</td>
                            <td>{$sex}</td>
                            <td>{$formattedDate}</td>
                            <td class='text-end' >
                                <button id='edit_sinh_vien' class='btn btn-secondary' onclick='openEditForm(" . json_encode($row) . ")' >Sửa</button>
                                <button id='delete_sinhvien' class='btn btn-danger' onclick='openDeleteForm(" . $row["id"] . ")' >Xóa</button>
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
                    <h5 class="modal-title">Thêm sinh viên</h5>
                    <button type="button" class="btn-close" onclick="closeAddForm()"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="add-student-id" class="form-label">Mã sinh viên</label>
                        <input type="text" class="form-control" id="add-student-id">
                    </div>
                    <div class="mb-3">
                        <label for="add-fullname" class="form-label">Họ và tê<noscript></noscript></label>
                        <input type="text" class="form-control" id="add-fullname">
                    </div>
                    <div class="mb-3">
                        <label for="add-sex" class="form-label">Giới tính</label>
                        <select class="form-select" id="add-sex">
                            <option value="">Giới tính</option>
                            <option value="Male">Nam</option>
                            <option value="Female">Nữ</option>
                            <option value="Other">Khác</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="add-dob" class="form-label">Ngày tháng năm sinh</label>
                        <input type="date" class="form-control" id="add-dob">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeAddForm()">Đóng form</button>
                    <button type="button" id="add-student-btn" class="btn btn-success" onclick="submitAddForm()" disabled>Thêm sinh viên</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sửa thông tin sinh viên</h5>
                    <button type="button" class="btn-close" onclick="closeEditForm()"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit-id">
                    <div class="mb-3">
                        <label for="edit-student-id" class="form-label">Mã sinh viên</label>
                        <input type="text" class="form-control" id="edit-student-id">
                    </div>
                    <div class="mb-3">
                        <label for="edit-fullname" class="form-label">Họ và tên</label>
                        <input type="text" class="form-control" id="edit-fullname">
                    </div>
                    <div class="mb-3">
                        <label for="edit-sex" class="form-label">Giới tính</label>
                        <select class="form-select" id="edit-sex">
                            <option value="Male">Nam</option>
                            <option value="Female">Nữ</option>
                            <option value="Other">Khác</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit-dob" class="form-label">Ngày sinh</label>
                        <input type="date" class="form-control" id="edit-dob">
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
                    <h5 class="modal-title">Xóa sinh viên</h5>
                    <button type="button" class="btn-close" onclick="closeDeleteForm()"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc muốn xóa đi sinh viên sau ?</p>
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
    $sql = "SELECT COUNT(id) FROM $table";
    $result = $db->query($sql);
    $row = $result->fetchAll(PDO::FETCH_ASSOC);
    $total_records = $row[0]['COUNT(id)'];
    $total_pages = ceil($total_records / $limit);


    echo '<nav aria-label="Page navigation">';
    echo '<ul class="pagination justify-content-center">';
    $root = __ROOT_DIR__;

    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<li class='page-item'><a class='page-link' href='#' onclick=loadContent(" . "'$root/ql_sinh_vien/index.php?page=" . $i . "') >" . $i . "</a></li>";
    }

    echo '</ul>';
    echo '</nav>';

    ?>
    <script>
        // Function to open the edit modal with pre-filled student data
        function checkEditForm() {
            const currentData = {
                student_id: document.getElementById('edit-student-id').value,
                fullname: document.getElementById('edit-fullname').value,
                sex: document.getElementById('edit-sex').value,
                date_of_birth: document.getElementById('edit-dob').value
            };

            // Compare current form data with initial data
            const dataChanged = JSON.stringify(currentData) !== JSON.stringify(initialData);

            // Enable the "Save Changes" button if data has changed
            document.getElementById('submit-edit').disabled = !dataChanged;
        }

        function checkAddForm() {
            const studentId = document.getElementById('add-student-id').value.trim();
            const fullname = document.getElementById('add-fullname').value.trim();
            const sex = document.getElementById('add-sex').value;
            const dob = document.getElementById('add-dob').value;

            // Enable the "Add Student" button only if all fields are filled
            const allFieldsFilled = studentId && fullname && sex && dob;
            document.getElementById('add-student-btn').disabled = !allFieldsFilled;
        }

        // Function to open the "Add Student" modal
        function openAddForm() {
            document.getElementById('add-student-id').value = '';
            document.getElementById('add-fullname').value = '';
            document.getElementById('add-sex').value = '';
            document.getElementById('add-dob').value = '';

            // Disable the "Add Student" button initially
            document.getElementById('add-student-btn').disabled = true;

            // Add event listeners to track changes
            document.getElementById('add-student-id').addEventListener('input', checkAddForm);
            document.getElementById('add-fullname').addEventListener('input', checkAddForm);
            document.getElementById('add-sex').addEventListener('change', checkAddForm);
            document.getElementById('add-dob').addEventListener('input', checkAddForm);

            var addModal = new bootstrap.Modal(document.getElementById('addModal'));
            addModal.show();
        }

        // Function to close the "Add Student" modal
        function closeAddForm() {
            var addModal = bootstrap.Modal.getInstance(document.getElementById('addModal'));
            addModal.hide();
        }

        function submitAddForm() {
            var studentId = document.getElementById('add-student-id').value;
            var fullname = document.getElementById('add-fullname').value;
            var sex = document.getElementById('add-sex').value;
            var dob = document.getElementById('add-dob').value;

            var data = {
                student_id: studentId,
                fullname: fullname,
                sex: sex,
                date_of_birth: dob
            };

            let url = '<?php echo __ROOT_DIR__ . '/ql_sinh_vien/utils' ?>/add.php'

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })

            closeAddForm(); // Close the modal after submission
            loadContent(`<?php echo __ROOT_DIR__ ?>/ql_sinh_vien/index.php`)
        }

        function openEditForm(student) {
            document.getElementById('edit-id').value = student.id;
            document.getElementById('edit-student-id').value = student.student_id;
            document.getElementById('edit-fullname').value = student.fullname;
            document.getElementById('edit-sex').value = student.sex;
            document.getElementById('edit-dob').value = student.date_of_birth;

            // Store the initial values


            initialData = {
                student_id: student.student_id,
                fullname: student.fullname,
                sex: student.sex,
                date_of_birth: student.date_of_birth
            };

            // Disable "Save Changes" button initially
            document.getElementById('submit-edit').disabled = true;

            // Add event listeners to track changes
            document.getElementById('edit-student-id').addEventListener('input', checkEditForm);
            document.getElementById('edit-fullname').addEventListener('input', checkEditForm);
            document.getElementById('edit-sex').addEventListener('change', checkEditForm);
            document.getElementById('edit-dob').addEventListener('input', checkEditForm)

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
            var studentId = document.getElementById('edit-student-id').value;
            var fullname = document.getElementById('edit-fullname').value;
            var sex = document.getElementById('edit-sex').value;
            var dob = document.getElementById('edit-dob').value;

            var data = {
                id: id,
                student_id: studentId,
                fullname: fullname,
                sex: sex,
                date_of_birth: dob
            };

            let url = '<?php echo __ROOT_DIR__ . '/ql_sinh_vien/utils' ?>/edit.php'

            fetch(url, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })

            closeEditForm(); // Close the modal after submission
            loadContent(`<?php echo __ROOT_DIR__ ?>/ql_sinh_vien/index.php`)
        }

        // Function to open the delete confirmation modal
        function openDeleteForm(studentId) {
            document.getElementById('delete-id').value = studentId;

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
            var studentId = document.getElementById('delete-id').value;

            let url = '<?php echo __ROOT_DIR__ . '/ql_sinh_vien/utils' ?>/delete.php'

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: studentId
                })
            })

            closeDeleteForm(); // Close the modal after submission
            loadContent(`<?php echo __ROOT_DIR__ ?>/ql_sinh_vien/index.php`)
        }
    </script>
</div>
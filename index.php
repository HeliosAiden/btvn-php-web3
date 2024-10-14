<?php require 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BTVN của Nguyễn Lê Nhật Anh - D2022A</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="./style/index.css" rel="stylesheet">
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div id="sidebar" class="bg-dark">
            <a class="nav-link" href="<?php echo __ROOT_DIR__ ?>/" onclick="loadContent('<?php echo __ROOT_DIR__ ?>/index.php')">
                <h3 class="text-center py-3">Menu</h3>
            </a>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="loadContent('<?php echo __ROOT_DIR__ ?>/b4_form/index.php')">Receipt form (bai 4)</a>
                </li>
                <li class="nav-item">
                    <span class="nav-link folder-toggle"><i class="fa-regular fa-folder"></i> b5_mydb</span>
                    <ul class="folder-content">
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="loadContent('<?php echo __ROOT_DIR__ ?>/b5_mydb/info.php')">Info (nên đọc qua)</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="loadContent('<?php echo __ROOT_DIR__ ?>/b5_mydb/list.php')">List.php</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="loadContent('<?php echo __ROOT_DIR__ ?>/b5_mydb/insert.php')">Insert.php</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="loadContent('<?php echo __ROOT_DIR__ ?>/b5_mydb/update.php')">Update.php</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="loadContent('<?php echo __ROOT_DIR__ ?>/b5_mydb/delete.php')">Delete.php</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="loadContent('<?php echo __ROOT_DIR__ ?>/ql_sinh_vien/index.php')">Bảng sinh viên</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="loadContent('<?php echo __ROOT_DIR__ ?>/employee/index.php')">Bảng nhân viên</a>
                </li>
                <li class="nav-item">
                    <span class="nav-link folder-toggle"><i class="fa-regular fa-folder"></i> Bài 9</span>
                    <ul class="folder-content">
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="loadContent('<?php echo __ROOT_DIR__ ?>/b9/login.php')">Login - trang đăng nhập</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="loadContent('<?php echo __ROOT_DIR__ ?>/b9/register.php')">Register - trang đăng ký</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="loadContent('<?php echo __ROOT_DIR__ ?>/b9/admin_dashboard.php')">Admin dashboard - trang của quản trị viên</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="loadContent('<?php echo __ROOT_DIR__ ?>/b9/user_info.php')">User info - thông tin người dùng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="loadContent('<?php echo __ROOT_DIR__ ?>/b9/change_password.php')">Change password - Thay đổi mật khẩu người dùng</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

        <!-- Page Content -->
        <div id="content" class="p-4">
            <div id="mainContent">
                <h2>Bài tập về nhà của Nguyễn Lê Nhật Anh</h2>
                <p>Bấm vào file hoặc thư mục tương ứng để xem :3</p>
                <p>Lưu ý 1: Dùng chung csdl nhưng các bảng trong các bài đứng độc lập với nhau</p>
                <p>Lưu ý 2: Tại bài 9 có mục login nhưng sẽ chỉ login và phân quyền cho riêng trang đó, các trang khác sẽ ko ảnh hưởng và tiếp tục với vai trò Guests</p>
            </div>
        </div>
    </div>

    <button id="sidebarToggle">
        <i class="fas fa-bars"></i> <!-- Icon for open state -->
    </button>

    <!-- jQuery Script -->
    <script src="./js/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- FontAwesome JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

    <!-- JavaScript for Sidebar Toggle, Folder Collapse, and Content Loading -->
    <script src="./js/index.js"></script>

</body>

</html>
<?php
require $_SERVER['DOCUMENT_ROOT'] . '/homework/' . 'config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Store form data in session

    $data = json_decode(file_get_contents('php://input'), true);

    $_SESSION['form_data'] = $data;
    $submitted = true;


    // Handle file upload
    if (isset($data['uploaded_file'])) {
        $_SESSION['file'] = $data['uploaded_file'];
    }
    header("Content-Type: application/json");
    http_response_code(200);
    echo json_encode(["message" => "Form submitted successfully", "data" => $data]);
}

$form_data = $_SESSION['form_data'] ?? null;
$uploaded_file = $_SESSION['file'] ?? null;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .drag-drop-area {
            border: 2px dashed #ccc;
            padding: 40px;
            text-align: center;
            margin: auto;
            margin-bottom: 20px;
            width: 100%;
        }
    </style>
</head>

<body class="container">
    <div class="container">
        <h2>Receipt Form</h2>
        <?php if ($form_data): ?>
            <h3>Submitted Information:</h3>
            <p><strong>First Name:</strong> <?= htmlspecialchars($form_data['firstname']); ?></p>
            <p><strong>Last Name:</strong> <?= htmlspecialchars($form_data['lastname']); ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($form_data['email']); ?></p>
            <p><strong>Invoice ID:</strong> <?= htmlspecialchars($form_data['invoice_id']); ?></p>
            <p><strong>Pay For:</strong> <?= implode(", ", $form_data['pay_for'] ?? []); ?></p>
            <p><strong>Additional Info:</strong> <?= htmlspecialchars($form_data['additional_info']); ?></p>
            <?php
                if (isset($_SESSION['form_data']['uploaded_file'])) {
                    $imageData = $_SESSION['form_data']['uploaded_file'];
                    echo "<img src='$imageData' alt='Uploaded Image' style='max-width: 500px;'>";
                } else {
                    echo "<p>No image uploaded yet. Go back to upload one.</p>";
                }
            ?>
        <?php endif; ?>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="firstname">First Name</label>
                <input type="text" class="form-control" id="firstname" name="firstname" required>
            </div>
            <div class="form-group col-md-6">
                <label for="lastname">Last Name</label>
                <input type="text" class="form-control" id="lastname" name="lastname" required>
            </div>
        </div>

        <div class="form-row">

            <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="form-group col-md-6">
                <label for="invoice_id">Invoice ID</label>
                <input type="text" class="form-control" id="invoice_id" name="invoice_id" required>
            </div>
        </div>

        <label>Pay For</label>
        <div class="form-row">
            <div class="form-group col-md-6">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="15k" name="pay_for[]" value="15K Category">
                    <label class="form-check-label" for="15k">15K Category</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="55K" name="pay_for[]" value="55K Category">
                    <label class="form-check-label" for="55K">55K Category</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="116K" name="pay_for[]" value="116K Category">
                    <label class="form-check-label" for="116K">116K Category</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="35k" name="pay_for[]" value="Shuttle Two Ways">
                    <label class="form-check-label" for="shuttle_two_ways">Shuttle Two Ways</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="35k" name="pay_for[]" value="Compressport T-shirt Merchandise">
                    <label class="form-check-label" for="shuttle_two_ways">Compressport T-shirt Merchandise</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="35k" name="pay_for[]" value="Other">
                    <label class="form-check-label" for="shuttle_two_ways">Other</label>
                </div>
            </div>
            <div class="form-group col-md-6">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="15k" name="pay_for[]" value="35K Category">
                    <label class="form-check-label" for="15k">35K Category</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="35k" name="pay_for[]" value="75K Category">
                    <label class="form-check-label" for="35k">75K Category</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="35k" name="pay_for[]" value="Shuttle One Way">
                    <label class="form-check-label" for="35k">Shuttle One Way</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="35k" name="pay_for[]" value="Training Cap Merchandise">
                    <label class="form-check-label" for="35k">Training Cap Merchandise</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="35k" name="pay_for[]" value="Buf Merchandise">
                    <label class="form-check-label" for="35k">Buf Merchandise</label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="upload">Please upload your payment receipt</label>
            <div class="drag-drop-area">
                <span>Drag and Drop your file here</span><br>
                <input type="file" name="upload" id="upload" class="form-control-file">
            </div>
        </div>

        <div class="form-group">
            <label for="additional_info">Additional Information</label>
            <textarea class="form-control" id="additional_info" name="additional_info" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary" onclick="submitForm()">Submit</button>

        <br/>
        <br/>
        <br/>
        <p>Vì fetch từ server nên sau khi tải form receipt lên thì bấm lại vào Receipt form ở thanh điều hướng để tải lại trang để thấy kết quả</p>
    </div>
    <script>
        async function submitForm() {
            const formData = {
                firstname: document.getElementById('firstname').value,
                lastname: document.getElementById('lastname').value,
                email: document.getElementById('email').value,
                invoice_id: document.getElementById('invoice_id').value,
                pay_for: Array.from(document.querySelectorAll('input[type="checkbox"]:checked')).map(el => el.value),
                additional_info: document.getElementById('additional_info').value
            };

            const fileInput = document.getElementById('upload');
            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                const reader = new FileReader();
                reader.onloadend = async () => {
                    formData.uploaded_file = reader.result;

                    const response = await fetch('<?php echo __ROOT_DIR__ ?>/b4_form/index.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(formData)
                    });

                    const result = await response.json();
                    console.log(result)

                };
                reader.readAsDataURL(file);
            } else {
                // Send without file
                const response = await fetch('<?php echo __ROOT_DIR__ ?>/b4_form/index.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(formData)
                });

                const result = await response.json();
                alert(result.message);
                location.reload();
            }
            loadContent('<?php echo __ROOT_DIR__ ?>/b4_form/index.php')
        }

    </script>
</body>

</html>
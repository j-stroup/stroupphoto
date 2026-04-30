<?php
session_start();

// 1. HARDCODED CONFIG
$password_hash = '$2y$10$BwZ5e09FvMfIAXssmfhFF.Y6CkadFFzNZhTYlsAl5N6mCaC5xgdpu'; 
$allowed_folders = ['film', 'digital'];
$max_file_size = 10 * 1024 * 1024; // 10MB

// 2. AUTHENTICATION LOGIC
if (isset($_POST['login'])) {
    if (password_verify($_POST['pass'], $password_hash)) {
        $_SESSION['authenticated'] = true;
    }
}

if (!isset($_SESSION['authenticated'])) {
    die('<form method="POST">Code: <input type="password" name="pass"><input type="submit" name="login"></form>');
}

// 3. UPLOAD LOGIC
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo'])) {
    $target_folder = in_array($_POST['folder'], $allowed_folders) ? $_POST['folder'] : 'film';
    $upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/images/" . $target_folder . "/";
    
    // File Validation
    $file = $_FILES['photo'];
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime_type = $finfo->file($file['tmp_name']);
    $allowed_mimes = ['image/jpeg', 'image/png', 'image/webp'];

    if (!in_array($mime_type, $allowed_mimes)) {
        $message = "ERROR: Invalid file type.";
    } elseif ($file['size'] > $max_file_size) {
        $message = "ERROR: File too large.";
    } else {
        // Sanitize Filename: timestamp + original name (cleaned)
        $clean_name = preg_replace("/[^a-zA-Z0-9.]/", "_", basename($file['name']));
        $final_path = $upload_dir . time() . "_" . $clean_name;

        if (move_uploaded_file($file['tmp_name'], $final_path)) {
            $message = "SUCCESS: Image uploaded to " . $target_folder;
        } else {
            $message = "ERROR: Upload failed.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Gate</title>
    <style>
        body { background: #0a0a0a; color: #fff; font-family: monospace; padding: 50px; }
        .box { border: 1px solid #333; padding: 20px; max-width: 400px; margin: auto; }
        input, select { display: block; width: 100%; margin-bottom: 10px; background: #111; color: #fff; border: 1px solid #444; padding: 10px; }
        .msg { color: #f39c12; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="box">
        <h3>STREAMP-UPLOAD-v1</h3>
        <?php if($message) echo "<p class='msg'>$message</p>"; ?>
        <form method="POST" enctype="multipart/form-data">
            <label>Category:</label>
            <select name="folder">
                <option value="digital">Digital</option>
                <option value="film">Film</option>
            </select>
            <input type="file" name="photo" required>
            <input type="submit" value="INJECT PHOTO">
        </form>
        <br>
        <a href="?logout=1" style="color:#555">De-authenticate</a>
    </div>
</body>
</html>
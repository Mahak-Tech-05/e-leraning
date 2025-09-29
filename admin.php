<?php
include("config.php");
$conn = new mysqli($host, $user, $pass, $db);
$msg = '';
$uploadDir = __DIR__ . "/uploads/"; // Absolute path to uploads folder

// Make sure the uploads directory exists and is writable
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $filename = basename($_FILES['img']['name']);
        $target = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['img']['tmp_name'], $target)) {
            $imagePathForDb = "uploads/" . $filename;

            $option1 = $conn->real_escape_string($_POST['option1']);
            $option2 = $conn->real_escape_string($_POST['option2']);
            $option3 = $conn->real_escape_string($_POST['option3']);
            $option4 = $conn->real_escape_string($_POST['option4']);
            $correct = $conn->real_escape_string($_POST['correct']);

            $stmt = $conn->prepare("INSERT INTO objects (image_url, option1, option2, option3, option4, correct) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $imagePathForDb, $option1, $option2, $option3, $option4, $correct);
            $stmt->execute();

            $msg = "Object added successfully!";
        } else {
            $msg = "Failed to move uploaded file. Check folder permissions.";
        }
    } else {
        $msg = "File upload error. Error code: " . $_FILES['img']['error'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Add New Object</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('./assests/b.jpeg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background: rgba(255, 255, 255, 0.95);
            max-width: 600px;
            width: 90%;
            margin: 40px auto;
            padding: 40px 30px 30px 30px;
            border-radius: 12px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.2);
            box-sizing: border-box;
        }
        h2 {
            text-align: center;
            color: #0d6efd;
            margin-bottom: 30px;
            font-weight: 800;
            font-size: 2.5em;
        }
        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #444;
            font-size: 1.1em;
        }
        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 12px 14px;
            margin-bottom: 20px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1em;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            box-sizing: border-box;
        }
        input[type="text"]:focus,
        input[type="file"]:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 6px #0d6efd;
            outline: none;
        }
        button {
            width: 100%;
            background-color: #0d6efd;
            color: white;
            padding: 16px;
            border: none;
            border-radius: 10px;
            font-size: 1.1em;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.4);
        }
        button:hover {
            background-color: #0b5ed7;
            box-shadow: 0 6px 15px rgba(11, 94, 215, 0.5);
        }
        .message {
            text-align: center;
            font-weight: 700;
            padding: 14px;
            border-radius: 10px;
            margin-bottom: 30px;
            color: #155724;
            background-color: #d4edda;
            border: 1.5px solid #c3e6cb;
            font-size: 1.1em;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add New Object</h2>

        <?php
            if ($msg) {
                echo '<div class="message">' . htmlspecialchars($msg) . '</div>';
            }
        ?>

        <form method="POST" enctype="multipart/form-data" novalidate>
            <label for="img">Image (upload file):</label>
            <input type="file" name="img" id="img" accept="image/*" required />

            <label for="option1">Option 1:</label>
            <input type="text" name="option1" id="option1" required />

            <label for="option2">Option 2:</label>
            <input type="text" name="option2" id="option2" required />

            <label for="option3">Option 3:</label>
            <input type="text" name="option3" id="option3" required />

            <label for="option4">Option 4:</label>
            <input type="text" name="option4" id="option4" required />

            <label for="correct">Correct Answer (exact option text):</label>
            <input type="text" name="correct" id="correct" required />

            <button type="submit">Add Object</button>
        </form>
    </div>
</body>
</html>

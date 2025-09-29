<?php
// Database connection
include("config.php");
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete selected records
if (isset($_POST['delete']) && !empty($_POST['delete_ids'])) {
    $ids = implode(",", array_map('intval', $_POST['delete_ids'])); // Sanitize input
    $sql = "DELETE FROM users WHERE id IN ($ids)";
    $conn->query($sql);
}

// Fetch only student data
$sql = "SELECT id, username, role FROM users WHERE role='student'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Data</title>
    <style>
        /* Background image for the entire body */
        body {
            background-image: url('./assests/d.jpeg'); /* Replace with your image path */
            background-size: cover; /* Cover the whole page */
            background-repeat: no-repeat;
            background-position: center center;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Container for transparency */
        .container {
            width: 80%;
            margin: 30px auto;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-family: inherit;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        input[type="submit"] {
            margin: 20px auto;
            display: block;
            padding: 10px 20px;
            border: none;
            background: red;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
        input[type="submit"]:hover {
            background: darkred;
        }
    </style>
</head>
<body>

<div class="container">
<form method="post" onsubmit="return confirm('Are you sure you want to delete selected records?');">
    <table>
        <tr>
            <th>Select</th>
            <th>ID</th>
            <th>Username</th>
            <th>Role</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><input type="checkbox" name="delete_ids[]" value="<?php echo $row['id']; ?>"></td>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo htmlspecialchars($row['role']); ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="4">No students found</td></tr>
        <?php endif; ?>
    </table>
    <input type="submit" name="delete" value="Delete Selected">
</form>
</div>

</body>
</html>

<?php
$conn->close();
?>

<?php
include './database/connection.php';

// Initialize variables
$decision_code = $decision_name = $description = "";
$update = false;
$id = 0;

// Create or Update a decision
if (isset($_POST['save'])) {
    $decision_code = $_POST['decision_code'];
    $decision_name = $_POST['decision_name'];
    $description = $_POST['description'];
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($id == 0) {
        // Insert new decision
        $sql = "INSERT INTO decision_table (decision_code, decision_name, description) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $decision_code, $decision_name, $description);
    } else {
        // Update existing decision
        $sql = "UPDATE decision_table SET decision_code=?, decision_name=?, description=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $decision_code, $decision_name, $description, $id);
    }

    if ($stmt->execute()) {
        header('Location: create_decision.php');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Edit a decision
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $update = true;
    $stmt = $conn->prepare("SELECT * FROM decision_table WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $decision_code = htmlspecialchars($row['decision_code']);
        $decision_name = htmlspecialchars($row['decision_name']);
        $description = htmlspecialchars($row['description']);
    }
}

// Delete a decision
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM decision_table WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header('Location: create_decision.php');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Decision Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include CKEditor -->
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>

    <style>
        .cke_notification_warning {
            background: #c83939;
            border: 1px solid #902b2b;
            display: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center mt-4">Decision Management</h2>

        <!-- Form to Create/Update a Decision -->
        <form action="" method="POST" class="mt-4">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <div class="form-group">
                <label for="decision_code">Decision Code:</label>
                <input type="text" name="decision_code" class="form-control" value="<?php echo htmlspecialchars($decision_code); ?>" required>
            </div>
            <div class="form-group">
                <label for="decision_name">Decision Name:</label>
                <input type="text" name="decision_name" class="form-control" value="<?php echo htmlspecialchars($decision_name); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" class="form-control" rows="5" required><?php echo htmlspecialchars($description); ?></textarea>
                <script>
                    CKEDITOR.replace('description');
                </script>
            </div>
            <div class="form-group">
                <?php if ($update == true): ?>
                    <button type="submit" name="save" class="btn btn-info">Update Decision</button>
                <?php else: ?>
                    <button type="submit" name="save" class="btn btn-primary">Add Decision</button>
                <?php endif; ?>
            </div>
        </form>

        <!-- Display Decision Records -->
        <h3 class="mt-4">Decision List</h3>
        <table class="table table-bordered table-striped mt-2">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Decision Code</th>
                    <th>Decision Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $conn->prepare("SELECT * FROM decision_table");
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['decision_code']); ?></td>
                        <td><?php echo htmlspecialchars($row['decision_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                        <td>
                            <a href="?edit=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-info">Edit</a>
                            <a href="?delete=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this decision?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>

<?php
$conn->close();
?>
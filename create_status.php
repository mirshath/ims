<?php
include './database/connection.php';

// Initialize variables
$status_code = $status_name = "";
$update = false;
$id = 0;

// Create or Update a status
if (isset($_POST['save'])) {
  
    $status_name = $_POST['status_name'];
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($id == 0) {
        // Insert new status
        $sql = "INSERT INTO status_table (status_name) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $status_name);
    } else {
        // Update existing status
        $sql = "UPDATE status_table SET  status_name=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si",  $status_name, $id);
    }

    if ($stmt->execute()) {
        header('Location: create_status');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Edit a status
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $update = true;
    $stmt = $conn->prepare("SELECT * FROM status_table WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
      
        $status_name = htmlspecialchars($row['status_name']);
    }
}

// Delete a status
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM status_table WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header('Location: create_status');
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
    <title>Status Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2 class="text-center mt-4">Status Management</h2>

        <!-- Form to Create/Update a Status -->
        <form action="" method="POST" class="mt-4">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
          
            <div class="form-group">
                <label for="status_name">Status Name:</label>
                <input type="text" name="status_name" class="form-control" value="<?php echo htmlspecialchars($status_name); ?>" required>
            </div>
            <div class="form-group">
                <?php if ($update == true): ?>
                    <button type="submit" name="save" class="btn btn-info">Update Status</button>
                <?php else: ?>
                    <button type="submit" name="save" class="btn btn-primary">Add Status</button>
                <?php endif; ?>
            </div>
        </form>

        <!-- Display Status Records -->
        <h3 class="mt-4">Status List</h3>
        <table class="table table-bordered table-striped mt-2">
            <thead>
                <tr>
                    <th>ID</th>
                   
                    <th>Status Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $conn->prepare("SELECT * FROM status_table");
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        
                        <td><?php echo htmlspecialchars($row['status_name']); ?></td>
                        <td>
                            <a href="?edit=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-info">Edit</a>
                            <a href="?delete=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this status?');">Delete</a>
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

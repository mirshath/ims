<?php
include("database/connection.php");
include("includes/header.php");


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

<!-- Page Wrapper -->
<div id="wrapper">

    <?php include("nav.php"); ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <?php include("includes/topnav.php"); ?>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h4 class="h4 mb-0 text-gray-800">Currency managment</h4>
                </div>


                <!-- Add Criteria Form -->
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


                <!-- Criteria Table -->

                <h3 class="mt-4">Status List</h3>
                <table class="table table-bordered table-striped mt-2">
                    <thead>
                        <tr>
                            <!-- <th>ID</th> -->

                            <th>Status Name</th>
                            <!-- <th>Actions</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM status_table");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <!-- <td><?php echo htmlspecialchars($row['id']); ?></td> -->

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
        </div>
    </div>
</div>

</div>

</body>

</html>
<?php $conn->close(); ?>

<?php
include("database/connection.php");
include("includes/header.php");


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



                <!-- Criteria Table -->
                <h3 class="mt-4">Decision List</h3>
                <table class="table table-bordered table-striped mt-2">
                    <thead>
                        <tr>
                            <!-- <th>ID</th> -->
                            <th>Decision Code</th>
                            <th>Decision Name</th>
                            <th>Description</th>
                            <!-- <th>Actions</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM decision_table");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <!-- <td><?php echo htmlspecialchars($row['id']); ?></td> -->
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
        </div>
    </div>
</div>

</div>

</body>

</html>
<?php $conn->close(); ?>

<?php
include("database/connection.php");
include("includes/header.php");


// Initialize variables
$grade_code = $grade_name = "";
$update = false;
$id = 0;

// Create or Update a grade
if (isset($_POST['save'])) {
    $grade_code = $_POST['grade_code'];
    $grade_name = $_POST['grade_name'];
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($id == 0) {
        // Insert new grade
        $sql = "INSERT INTO grade_table (grade_code, grade_name) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $grade_code, $grade_name);
    } else {
        // Update existing grade grade_code=?, $grade_code,
        $sql = "UPDATE grade_table SET  grade_name=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si",  $grade_name, $id);
    }

    if ($stmt->execute()) {
        header('Location: create_grade');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Edit a grade
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $update = true;
    $stmt = $conn->prepare("SELECT * FROM grade_table WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $grade_code = htmlspecialchars($row['grade_code']);
        $grade_name = htmlspecialchars($row['grade_name']);
    }
}

// Delete a grade
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM grade_table WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header('Location: create_grade');
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
                    <h4 class="h4 mb-0 text-gray-800">Grade managment</h4>
                </div>


                <!-- Add Criteria Form -->
                <form action="" method="POST" class="mt-4">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                    <div class="form-group">
                        <label for="grade_code">Grade Code:</label>
                        <!-- <input type="text" name="grade_code" class="form-control" value="<?php echo htmlspecialchars($grade_code); ?>"  required> -->
                        <input type="text" name="grade_code" class="form-control" value="<?php echo htmlspecialchars($grade_code); ?>" <?php echo $update ? 'disabled' : ''; ?> required>

                    </div>
                    <div class="form-group">
                        <label for="grade_name">Grade Name:</label>
                        <input type="text" name="grade_name" class="form-control" value="<?php echo htmlspecialchars($grade_name); ?>" required>
                    </div>
                    <div class="form-group">
                        <?php if ($update == true): ?>
                            <button type="submit" name="save" class="btn btn-info">Update Grade</button>
                        <?php else: ?>
                            <button type="submit" name="save" class="btn btn-primary">Add Grade</button>
                        <?php endif; ?>
                    </div>
                </form>


                <!-- Criteria Table -->
                <h3 class="mt-4">Grade List</h3>
                <table class="table table-bordered table-striped mt-2">
                    <thead>
                        <tr>
                            <!-- <th>ID</th> -->
                            <th>Grade Code</th>
                            <th>Grade Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM grade_table");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <!-- <td><?php echo htmlspecialchars($row['id']); ?></td> -->
                                <td><?php echo htmlspecialchars($row['grade_code']); ?></td>
                                <td><?php echo htmlspecialchars($row['grade_name']); ?></td>
                                <td>
                                    <a href="?edit=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-info">Edit</a>
                                    <a href="?delete=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this grade?');">Delete</a>
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

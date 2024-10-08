<?php
include("database/connection.php");
include("includes/header.php");


// Initialize variables
$title = $lecturer_name = $hourly_rate = $qualification = "";
$programs = []; // Initialize programs as an array
$id = 0;
$update = false;

// Fetch programs for the dropdown
$sql = "SELECT * FROM program_table";
$result = mysqli_query($conn, $sql);
$programsOptions = [];
while ($row = mysqli_fetch_assoc($result)) {
    $programsOptions[] = $row;
}


// Handle form submission
if (isset($_POST['save'])) {
    $title = $_POST['title'];
    $lecturer_name = $_POST['lecturer_name'];
    $hourly_rate = $_POST['hourly_rate'];
    $qualification = $_POST['qualification'];
    $programs = isset($_POST['programs']) ? implode(',', $_POST['programs']) : '';

    $sql = "INSERT INTO lecturer_table (title, lecturer_name, hourly_rate, qualification, programs) VALUES ('$title', '$lecturer_name', '$hourly_rate', '$qualification', '$programs')";
    if ($conn->query($sql) === TRUE) {
        echo '<script> window.location.href = "create_lecturer";</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle record update
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $result = $conn->query("SELECT * FROM lecturer_table WHERE id=$id");
    $row = $result->fetch_assoc();
    $title = $row['title'];
    $lecturer_name = $row['lecturer_name'];
    $hourly_rate = $row['hourly_rate'];
    $qualification = $row['qualification'];
    $programs = explode(',', $row['programs']); // Convert string to array
}

// Handle form update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $lecturer_name = $_POST['lecturer_name'];
    $hourly_rate = $_POST['hourly_rate'];
    $qualification = $_POST['qualification'];
    $programs = isset($_POST['programs']) ? implode(',', $_POST['programs']) : '';

    $sql = "UPDATE lecturer_table SET title='$title', lecturer_name='$lecturer_name', hourly_rate='$hourly_rate', qualification='$qualification', programs='$programs' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo '<script> window.location.href = "create_lecturer";</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle record deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM lecturer_table WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo '<script> window.location.href = "create_lecturer";</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch all records
$result = $conn->query("SELECT * FROM lecturer_table");

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
                    <h4 class="h4 mb-0 text-gray-800">lecture managment</h4>
                </div>


                <!-- Add Criteria Form -->
                <form method="POST" action="">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <select class="form-control" id="title" name="title" required>
                            <option value="Mr" <?php echo $title == 'Mr' ? 'selected' : ''; ?>>Mr</option>
                            <option value="Mrs" <?php echo $title == 'Mrs' ? 'selected' : ''; ?>>Mrs</option>
                            <option value="Ms" <?php echo $title == 'Ms' ? 'selected' : ''; ?>>Ms</option>
                            <option value="Dr" <?php echo $title == 'Dr' ? 'selected' : ''; ?>>Dr</option>
                            <option value="Prof" <?php echo $title == 'Prof' ? 'selected' : ''; ?>>Prof</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="lecturer_name">Lecturer Name:</label>
                        <input type="text" class="form-control" id="lecturer_name" name="lecturer_name" value="<?php echo htmlspecialchars($lecturer_name); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="hourly_rate">Hourly Rate:</label>
                        <input type="number" step="0.01" class="form-control" id="hourly_rate" name="hourly_rate" value="<?php echo htmlspecialchars($hourly_rate); ?>">
                    </div>
                    <div class="form-group">
                        <label for="qualification">Qualification:</label>
                        <textarea class="form-control" id="qualification" name="qualification" rows="3" required><?php echo htmlspecialchars($qualification); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Programs</label>
                        <?php foreach ($programsOptions as $program): ?>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="programs[]" value="<?php echo htmlspecialchars($program['program_name']); ?>"
                                    <?php echo in_array($program['program_name'], $programs) ? 'checked' : ''; ?>>
                                <label class="form-check-label"><?php echo htmlspecialchars($program['program_name']); ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if ($update): ?>
                        <button type="submit" class="btn btn-primary" name="update">Update</button>
                    <?php else: ?>
                        <button type="submit" class="btn btn-primary" name="save">Save</button>
                    <?php endif; ?>
                </form>


                <!-- Criteria Table -->


            </div>
            <h3 class="mt-5">Lecturer List</h3>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <!-- <th>ID</th> -->
                        <th>Title</th>
                        <th>Lecturer Name</th>
                        <th>Qualification</th>
                        <th>Programs</th>
                        <th>Hourly Rate</th>
                        <!-- <th>Actions</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <!-- <td><?php echo $row['id']; ?></td> -->
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo htmlspecialchars($row['lecturer_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['qualification']); ?></td>
                            <td><?php echo htmlspecialchars($row['programs']); ?></td>
                            <td><?php echo htmlspecialchars($row['hourly_rate']); ?></td>
                            <td>
                                <a href="?edit=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

</div>

</body>

</html>
<?php $conn->close(); ?>
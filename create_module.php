<?php
include './database/connection.php';

// Initialize variables
$module_code = $module_name = $university = $programme = $assessment_components = "";
$pass_mark = $type = $lecturers = $institution = "";
$id = 0;
$update = false;


// Fetch universities for the dropdown
$universities_result = mysqli_query($conn, "SELECT * FROM universities");
$universities = [];
while ($row = mysqli_fetch_assoc($universities_result)) {
    $universities[] = $row;
}

// Handle form submission
if (isset($_POST['save'])) {
    $module_code = $_POST['module_code'];
    $module_name = $_POST['module_name'];
    $university = $_POST['university'];
    $programme = $_POST['programme'];
    $assessment_components = $_POST['assessment_components'];
    $pass_mark = $_POST['pass_mark'];
    $type = $_POST['type'];
    $lecturers = $_POST['lecturers'];
    $institution = $_POST['institution'];

    $sql = "INSERT INTO module_table (module_code, module_name, university, programme, assessment_components, pass_mark, type, lecturers, institution) 
            VALUES ('$module_code', '$module_name', '$university', '$programme', '$assessment_components', '$pass_mark', '$type', '$lecturers', '$institution')";
    if ($conn->query($sql) === TRUE) {
        echo '<script> window.location.href = "create_module";</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle record update
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $result = $conn->query("SELECT * FROM module_table WHERE id=$id");
    $row = $result->fetch_assoc();
    $module_code = $row['module_code'];
    $module_name = $row['module_name'];
    $university = $row['university'];
    $programme = $row['programme'];
    $assessment_components = $row['assessment_components'];
    $pass_mark = $row['pass_mark'];
    $type = $row['type'];
    $lecturers = $row['lecturers'];
    $institution = $row['institution'];
}

// Handle form update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $module_code = $_POST['module_code'];
    $module_name = $_POST['module_name'];
    $university = $_POST['university'];
    $programme = $_POST['programme'];
    $assessment_components = $_POST['assessment_components'];
    $pass_mark = $_POST['pass_mark'];
    $type = $_POST['type'];
    $lecturers = $_POST['lecturers'];
    $institution = $_POST['institution'];

    $sql = "UPDATE module_table SET module_code='$module_code', module_name='$module_name', university='$university', programme='$programme', assessment_components='$assessment_components', pass_mark='$pass_mark', type='$type', lecturers='$lecturers', institution='$institution' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo '<script> window.location.href = "create_module";</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle record deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM module_table WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo '<script> window.location.href = "create_module";</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch all records
$result = $conn->query("SELECT * FROM module_table");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Module Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Module Management</h2>

        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="form-group">
                <label for="module_code">Module Code:</label>
                <input type="text" class="form-control" id="module_code" name="module_code" value="<?php echo htmlspecialchars($module_code); ?>" required>
            </div>
            <div class="form-group">
                <label for="module_name">Module Name:</label>
                <input type="text" class="form-control" id="module_name" name="module_name" value="<?php echo htmlspecialchars($module_name); ?>" required>
            </div>


            <!-- <div class="form-group">
                <label for="university">University:</label>
                <input type="text" class="form-control" id="university" name="university" value="<?php echo htmlspecialchars($university); ?>" required>
            </div> -->

            <div class="form-group">
                <label for="university">University:</label>
                <select class="form-control select2" id="university" name="university" required>
                    <?php foreach ($universities as $uni): ?>
                        <option value="<?php echo htmlspecialchars($uni['university_name']); ?>">
                            <?php echo htmlspecialchars($uni['university_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="programme">Programme:</label>
                <input type="text" class="form-control" id="programme" name="programme" value="<?php echo htmlspecialchars($programme); ?>" required>
            </div>
            <div class="form-group">
                <label for="assessment_components">Assessment Components:</label>
                <textarea class="form-control" id="assessment_components" name="assessment_components" rows="3" required><?php echo htmlspecialchars($assessment_components); ?></textarea>
            </div>
            <div class="form-group">
                <label for="pass_mark">Pass Mark:</label>
                <input type="number" class="form-control" id="pass_mark" name="pass_mark" value="<?php echo htmlspecialchars($pass_mark); ?>" required>
            </div>
            <div class="form-group">
                <label>Type:</label><br>
                <input type="radio" id="compulsory" name="type" value="Compulsory" <?php echo $type == 'Compulsory' ? 'checked' : ''; ?> required>
                <label for="compulsory">Compulsory</label><br>
                <input type="radio" id="elective" name="type" value="Elective" <?php echo $type == 'Elective' ? 'checked' : ''; ?>>
                <label for="elective">Elective</label>
            </div>
            <div class="form-group">
                <label for="lecturers">Lecturer/s:</label>
                <textarea class="form-control" id="lecturers" name="lecturers" rows="3"><?php echo htmlspecialchars($lecturers); ?></textarea>
            </div>
            <div class="form-group">
                <label for="institution">Institution:</label>
                <input type="text" class="form-control" id="institution" name="institution" value="<?php echo htmlspecialchars($institution); ?>">
            </div>

            <?php if ($update): ?>
                <button type="submit" class="btn btn-primary" name="update">Update</button>
            <?php else: ?>
                <button type="submit" class="btn btn-primary" name="save">Save</button>
            <?php endif; ?>
        </form>

        <h3 class="mt-5">Module List</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Module Code</th>
                    <th>Module Name</th>
                    <th>University</th>
                    <th>Programme</th>
                    <th>Assessment Components</th>
                    <th>Pass Mark</th>
                    <th>Type</th>
                    <!-- <th>Lecturer/s</th> -->
                    <!-- <th>Institution</th> -->
                    <!-- <th>Actions</th> -->
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['module_code']); ?></td>
                        <td><?php echo htmlspecialchars($row['module_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['university']); ?></td>
                        <td><?php echo htmlspecialchars($row['programme']); ?></td>
                        <td><?php echo htmlspecialchars($row['assessment_components']); ?></td>
                        <td><?php echo htmlspecialchars($row['pass_mark']); ?></td>
                        <td><?php echo htmlspecialchars($row['type']); ?></td>
                        <!-- <td><?php echo htmlspecialchars($row['lecturers']); ?></td> -->
                        <!-- <td><?php echo htmlspecialchars($row['institution']); ?></td> -->
                        <td>
                            <a href="?edit=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<?php $conn->close(); ?>
<?php
include("database/connection.php");
include("includes/header.php");


// Initialize variables
$module_code = $module_name = $university_id = $programme_id = $assessment_components = "";
$pass_mark = $type = $lecturers = $institution = "";
$id = 0;
$update = false;

// Fetch universities for the dropdown
$universities_result = mysqli_query($conn, "SELECT * FROM universities");
$universities = [];
while ($row = mysqli_fetch_assoc($universities_result)) {
    $universities[] = $row;
}

// Fetch programs for dropdown
$sql = "SELECT * FROM program_table";
$result = mysqli_query($conn, $sql);
$programsOptions = [];
while ($row = mysqli_fetch_assoc($result)) {
    $programsOptions[] = $row;
}

// Handle form submission
if (isset($_POST['save'])) {
    $module_code = $_POST['module_code'];
    $module_name = $_POST['module_name'];
    $university_id = $_POST['university'];
    $programme_id = $_POST['programme'];
    $assessment_components = $_POST['assessment_components'];
    $pass_mark = $_POST['pass_mark'];
    $type = $_POST['type'];
    $lecturers = $_POST['lecturers'];
    $institution = $_POST['institution'];

    $sql = "INSERT INTO modules (module_code, module_name, university_id, programme_id, assessment_components, pass_mark, type, lecturers, institution) 
            VALUES ('$module_code', '$module_name', '$university_id', '$programme_id', '$assessment_components', '$pass_mark', '$type', '$lecturers', '$institution')";
    if ($conn->query($sql) === TRUE) {
        echo '<script> window.location.href = "crea_module_table";</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle record update
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $result = $conn->query("SELECT * FROM modules WHERE id=$id");
    $row = $result->fetch_assoc();
    $module_code = $row['module_code'];
    $module_name = $row['module_name'];
    $university_id = $row['university_id'];
    $programme_id = $row['programme_id'];
    $assessment_components = $row['assessment_components'];
    $pass_mark = $row['pass_mark'];
    $type = $row['type'];
    $lecturers = $row['lecturers'];
    $institution = $row['institution'];
}

// Handle form update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $module_name = $_POST['module_name'];
    $university_id = $_POST['university'];
    $programme_id = $_POST['programme'];
    $assessment_components = $_POST['assessment_components'];
    $pass_mark = $_POST['pass_mark'];
    $type = $_POST['type'];
    $lecturers = $_POST['lecturers'];
    $institution = $_POST['institution'];

    $sql = "UPDATE modules SET module_name='$module_name', university_id='$university_id', programme_id='$programme_id', assessment_components='$assessment_components', pass_mark='$pass_mark', type='$type', lecturers='$lecturers', institution='$institution' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo '<script> window.location.href = "crea_module_table";</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle record deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM modules WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo '<script> window.location.href = "crea_module_table";</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch all records
// $result = $conn->query("SELECT * FROM modules");
$result = $conn->query("
    SELECT m.*, p.program_name 
    FROM modules m
    LEFT JOIN program_table p ON m.programme_id = p.program_code
");

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
                    <h4 class="h4 mb-0 text-gray-800">Modules</h4>
                </div>

                <!-- Add Criteria Form -->
                <form method="POST" action="">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="form-group">
                        <label for="module_code">Module Code:</label>
                        <input type="text" class="form-control" placeholder="Module Code" id="module_code" name="module_code" value="<?php echo htmlspecialchars($module_code); ?>" <?php echo $update ? 'disabled' : ''; ?> required>
                    </div>
                    <div class="form-group">
                        <label for="module_name">Module Name:</label>
                        <input type="text" class="form-control" placeholder="Module Name" id="module_name" name="module_name" value="<?php echo htmlspecialchars($module_name); ?>" required>
                    </div>

                    <!-- ------------------------------------------------------------------------  -->
                    <!-- ------------------------------------------------------------------------  -->
                    <div class="form-group">
                        <label for="university">University:</label>
                        <select class="form-control select2" id="university" name="university" required>
                            <option value="">Select University</option>
                            <?php foreach ($universities as $uni): ?>
                                <option value="<?php echo htmlspecialchars($uni['id']); ?>" <?php echo $uni['id'] == $university_id ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($uni['university_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="programme">Programme:</label>
                        <select class="form-control" id="programme" name="programme" required>
                            <option value="">Select Programme</option>
                            <!-- Programs will be dynamically loaded here -->
                        </select>
                    </div>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            var selectedProgramme = '<?php echo $programme_id; ?>';

                            $('#university').on('change', function() {
                                var universityID = $(this).val();
                                if (universityID) {
                                    $.ajax({
                                        type: 'POST',
                                        url: 'get_programs.php', // Ensure this path is correct
                                        data: {
                                            university_id: universityID
                                        },
                                        dataType: 'json',
                                        success: function(data) {
                                            $('#programme').html('<option value="">Select Programme</option>'); // Reset the dropdown
                                            $.each(data, function(key, value) {
                                                var isSelected = value.program_code == selectedProgramme ? 'selected' : '';
                                                $('#programme').append('<option value="' + value.program_code + '" ' + isSelected + '>' + value.program_name + '</option>');
                                            });
                                        },
                                        error: function(xhr, status, error) {
                                            console.error("AJAX Error: " + status + error);
                                        }
                                    });
                                } else {
                                    $('#programme').html('<option value="">Select Programme</option>');
                                }
                            });

                            // Trigger change event to load programs if university is already selected (for edit mode)
                            <?php if ($update && !empty($university_id)): ?>
                                $('#university').trigger('change');
                            <?php endif; ?>
                        });
                    </script>

                    <!-- ------------------------------------------------------------------------  -->

                    <div class="form-group">
                        <label for="assessment_components">Assessment Components:</label>
                        <textarea class="form-control" placeholder="Assessment Components" id="assessment_components" name="assessment_components" rows="3" required><?php echo htmlspecialchars($assessment_components); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="pass_mark">Pass Mark:</label>
                        <input type="number" placeholder="Pass Mark" class="form-control" id="pass_mark" name="pass_mark" value="<?php echo htmlspecialchars($pass_mark); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Type:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="type_compulsory" value="Compulsory" <?php echo $type == 'Compulsory' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="type_compulsory">
                                Compulsory
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" id="type_elective" value="Elective" <?php echo $type == 'Elective' ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="type_elective">
                                Elective
                            </label>
                        </div>
                    </div>
                    <!-- ---------------------------------------------  -->

                    <div class="form-group">
                        <label for="lecturers"><input type="checkbox" id="enable_lecturers" name="enable_lecturers" <?php echo !empty($lecturers) ? 'checked' : ''; ?>> Lecturer/s:</label>
                        <textarea class="form-control" placeholder="lecturers" id="lecturers" name="lecturers" rows="3" <?php echo empty($lecturers) ? 'disabled' : ''; ?>><?php echo htmlspecialchars($lecturers); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="institution"><input type="checkbox" id="enable_institution" name="enable_institution" <?php echo !empty($institution) ? 'checked' : ''; ?>> Institution:</label>
                        <input type="text" placeholder="institution" class="form-control" id="institution" name="institution" value="<?php echo htmlspecialchars($institution); ?>" <?php echo empty($institution) ? 'disabled' : ''; ?>>
                    </div>

                    <!-- ---------------------------------------------  -->

                    <?php if ($update): ?>
                        <button type="submit" class="btn btn-primary" name="update">Update</button>
                    <?php else: ?>
                        <button type="submit" class="btn btn-primary" name="save">Save</button>
                    <?php endif; ?>
                </form>
                <script>
                    $(document).ready(function() {
                        $('#enable_lecturers').change(function() {
                            $('#lecturers').prop('disabled', !this.checked);
                        });

                        $('#enable_institution').change(function() {
                            $('#institution').prop('disabled', !this.checked);
                        });
                    });
                </script>

                <!-- Criteria Table -->
                <h4 class="mt-5">All Modules</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Module Code</th>
                            <th>Module Name</th>
                            <!-- <th>University</th> -->
                            <th>Programme</th>
                            <th>Assessment Components</th>
                            <th>Pass Mark</th>
                            <th>Type</th>
                            <!-- <th>Lecturers</th> -->
                            <!-- <th>Institution</th> -->
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['module_code']); ?></td>
                                <td><?php echo htmlspecialchars($row['module_name']); ?></td>
                                <!-- <td><?php echo htmlspecialchars($row['university_id']); ?></td> -->
                                <!-- <td><?php echo htmlspecialchars($row['programme_id']); ?></td> -->
                                <td><?php echo htmlspecialchars($row['program_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['assessment_components']); ?></td>
                                <td><?php echo htmlspecialchars($row['pass_mark']); ?></td>
                                <td><?php echo htmlspecialchars($row['type']); ?></td>

                                <!-- <td><?php echo htmlspecialchars($row['lecturers']); ?></td> -->
                                <!-- <td><?php echo htmlspecialchars($row['institution']); ?></td> -->
                                <td>
                                    <a href="crea_module_table?edit=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="crea_module_table?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this module?');">Delete</a>
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
<?php
include("database/connection.php");
include("includes/header.php");


// Initialize variables
$batch_name = $university = $programme = $year_batch_code = $intake_date = $end_date = "";
$update = false;
$id = 0;


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





// Create or Update a batch
if (isset($_POST['save'])) {
    $batch_name = $_POST['batch_name'];
    $university = $_POST['university'];
    $programme = $_POST['programme'];
    $year_batch_code = $_POST['year_batch_code'];
    $intake_date = $_POST['intake_date'];
    $end_date = $_POST['end_date'];
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($id == 0) {
        // Insert new batch
        $sql = "INSERT INTO batch_table (batch_name, university, programme, year_batch_code, intake_date, end_date) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $batch_name, $university, $programme, $year_batch_code, $intake_date, $end_date);
    } else {
        // Update existing batch
        $sql = "UPDATE batch_table SET batch_name=?, university=?, programme=?, year_batch_code=?, intake_date=?, end_date=? 
                WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $batch_name, $university, $programme, $year_batch_code, $intake_date, $end_date, $id);
    }

    if ($stmt->execute()) {
        // header('Location: create_batch');
        echo '<script>window.location.href = "create_batch";</script>';
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Edit a batch
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $update = true;
    $stmt = $conn->prepare("SELECT * FROM batch_table WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $batch_name = htmlspecialchars($row['batch_name']);
        $university = htmlspecialchars($row['university']);
        $programme = htmlspecialchars($row['programme']);
        $year_batch_code = htmlspecialchars($row['year_batch_code']);
        $intake_date = htmlspecialchars($row['intake_date']);
        $end_date = htmlspecialchars($row['end_date']);
    }
}

// Delete a batch
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM batch_table WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        // header('Location: create_batch');
        echo '<script>window.location.href = "create_batch";</script>';

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
                    <h4 class="h4 mb-0 text-gray-800">Batch managment</h4>
                </div>


                <!-- Add Criteria Form -->
                <form action="create_batch.php" method="POST" class="mt-4">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                    <div class="form-group">
                        <label for="batch_name">Batch Name:</label>
                        <input type="text" name="batch_name" class="form-control" value="<?php echo htmlspecialchars($batch_name); ?>" required>
                    </div>


                    <!-- <div class="form-group">
                <label for="university">University:</label>
                <input type="text" name="university" class="form-control" value="<?php echo htmlspecialchars($university); ?>" required>
            </div> -->

                    <!-- ------------------------------------------------------------------------  -->

                    <div class="form-group">
                        <label for="university">University:</label>
                        <select class="form-control select2" id="university" name="university" required>
                            <option value="">Select University</option>
                            <?php foreach ($universities as $uni): ?>
                                <option value="<?php echo htmlspecialchars($uni['id']); ?>" <?php echo $uni['id'] == $university ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($uni['university_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>







                    <!-- ------------------------------------------------------------------------  -->
                    <!-- <div class="form-group">
                <label for="programme">Programme:</label>
                <input type="text" name="programme" class="form-control" value="<?php echo htmlspecialchars($programme); ?>" required>
            </div> -->
                    <!-- -----------------------------------------------------------------------------------------------  -->


                    <div class="form-group">
                        <label for="programme">Programme:</label>
                        <select class="form-control" id="programme" name="programme" required>
                            <option value="">Select Programme</option>
                            <!-- Programs will be dynamically loaded here -->
                        </select>
                    </div>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


                    <script>
                        $(document).ready(function() {
                            var selectedProgramme = '<?php echo $programme; ?>';

                            $('#university').on('change', function() {
                                var universityID = $(this).val();
                                if (universityID) {
                                    $.ajax({
                                        type: 'POST',
                                        url: 'get_programs.php',
                                        data: {
                                            university_id: universityID
                                        },
                                        dataType: 'json',
                                        success: function(data) {
                                            $('#programme').html('<option value="">Select Programme</option>');
                                            $.each(data, function(key, value) {
                                                var isSelected = value.program_name == selectedProgramme ? 'selected' : '';
                                                $('#programme').append('<option value="' + value.program_name + '" ' + isSelected + '>' + value.program_name + '</option>');
                                            });
                                        }
                                    });
                                } else {
                                    $('#programme').html('<option value="">Select Programme</option>');
                                }
                            });

                            // Trigger change event to load programs if university is already selected (for edit mode)
                            <?php if ($update && !empty($university)): ?>
                                $('#university').trigger('change');
                            <?php endif; ?>
                        });
                    </script>












                    <!-- -----------------------------------------------------------------------------------------------  -->
                    <div class="form-group">
                        <label for="year_batch_code">Year Batch Code:</label>
                        <input type="text" name="year_batch_code" class="form-control" value="<?php echo htmlspecialchars($year_batch_code); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="intake_date">Intake Date:</label>
                        <input type="date" name="intake_date" class="form-control" value="<?php echo htmlspecialchars($intake_date); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="end_date">End Date:</label>
                        <input type="date" name="end_date" class="form-control" value="<?php echo htmlspecialchars($end_date); ?>" required>
                    </div>
                    <div class="form-group">
                        <?php if ($update == true): ?>
                            <button type="submit" name="save" class="btn btn-info">Update Batch</button>
                        <?php else: ?>
                            <button type="submit" name="save" class="btn btn-primary">Add Batch</button>
                        <?php endif; ?>
                    </div>
                </form>

                <!-- Criteria Table -->

                <h3 class="mt-4">Batch List</h3>
                <table class="table table-bordered table-striped mt-2">
                    <thead>
                        <tr>
                            <!-- <th>ID</th> -->
                            <th>Batch Name</th>
                            <th>University</th>
                            <th>Programme</th>
                            <th>Year Batch Code</th>
                            <th>Intake Date</th>
                            <th>End Date</th>
                            <!-- <th>Actions</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM batch_table");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <!-- <td><?php echo htmlspecialchars($row['id']); ?></td> -->
                                <td><?php echo htmlspecialchars($row['batch_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['university']); ?></td>
                                <td><?php echo htmlspecialchars($row['programme']); ?></td>
                                <td><?php echo htmlspecialchars($row['year_batch_code']); ?></td>
                                <td><?php echo htmlspecialchars($row['intake_date']); ?></td>
                                <td><?php echo htmlspecialchars($row['end_date']); ?></td>
                                <td>
                                    <a href="?edit=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-info">Edit</a>
                                    <a href="?delete=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this batch?');">Delete</a>
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
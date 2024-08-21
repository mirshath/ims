<?php
include("database/connection.php");
include("includes/header.php");

// Initialize variables
$date = $type = $university = $programme = $intake = $first_name = $last_name = $contact = $email = $details = $status = "";
$update = false;
$id = 0;

// Fetch distinct 'type' values from leads_table
$sql_lead = "SELECT DISTINCT lead_type FROM leads_table";
$result_lead = $conn->query($sql_lead);

// Fetch universities and programs for dropdowns
$sql_universities = "SELECT * FROM universities";
$result_universities = $conn->query($sql_universities);

// Fetch programs for dropdown (if needed, otherwise AJAX will load them)
// $programsOptions = [];
// $sql = "SELECT * FROM program_table";
// $result = mysqli_query($conn, $sql);
// while ($row = mysqli_fetch_assoc($result)) {
//     $programsOptions[] = $row;
// }

// Create or Update a lead
if (isset($_POST['save'])) {
    $date = $_POST['date'];
    $type = $_POST['type'];
    $university = $_POST['university'];
    $programme = $_POST['programme'];
    $intake = $_POST['intake'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $details = $_POST['details'];
    $status = $_POST['status'];
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($id == 0) {
        // Insert new lead
        $sql = "INSERT INTO leads (date, type, university, programme, intake, first_name, last_name, contact, email, details, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssss", $date, $type, $university, $programme, $intake, $first_name, $last_name, $contact, $email, $details, $status);
    } else {
        // Update existing lead
        $sql = "UPDATE leads SET date=?, type=?, university=?, programme=?, intake=?, first_name=?, last_name=?, contact=?, email=?, details=?, status=? 
                WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssssi", $date, $type, $university, $programme, $intake, $first_name, $last_name, $contact, $email, $details, $status, $id);
    }

    if ($stmt->execute()) {
        echo '<script>window.location.href = "addLeads.php";</script>';
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Edit a lead
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $update = true;
    $stmt = $conn->prepare("SELECT * FROM leads WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $date = htmlspecialchars($row['date']);
        $type = htmlspecialchars($row['type']);
        $university = htmlspecialchars($row['university']);
        $programme = htmlspecialchars($row['programme']);
        $intake = htmlspecialchars($row['intake']);
        $first_name = htmlspecialchars($row['first_name']);
        $last_name = htmlspecialchars($row['last_name']);
        $contact = htmlspecialchars($row['contact']);
        $email = htmlspecialchars($row['email']);
        $details = htmlspecialchars($row['details']);
        $status = htmlspecialchars($row['status']);
    }
}

// Delete a lead
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM leads WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo '<script>window.location.href = "addLeads.php";</script>';
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
                    <h4 class="h4 mb-0 text-gray-800">Lead Management</h4>
                </div>

                <!-- Add/Edit Lead Form -->
                <form action="addLeads.php" method="POST" class="mt-4">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

                    <!-- Form fields for lead details -->
                    <div class="form-group">
                        <label for="date">Date:</label>
                        <input type="date" name="date" class="form-control" value="<?php echo htmlspecialchars($date); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="type">Type:</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="" disabled>Select Type</option>
                            <?php
                            // Populate the dropdown with lead types
                            if ($result_lead->num_rows > 0) {
                                while ($row = $result_lead->fetch_assoc()) {
                                    $selected = ($row['lead_type'] === $type) ? 'selected' : '';
                                    echo '<option value="' . htmlspecialchars($row['lead_type']) . '" ' . $selected . '>' . htmlspecialchars($row['lead_type']) . '</option>';
                                }
                            } else {
                                echo '<option value="" disabled>No types available</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <!-- University Dropdown -->
                    <div class="form-group">
                        <label for="university">University:</label>
                        <select name="university" id="university" class="form-control" required>
                            <option value="" disabled selected>Select University</option>
                            <?php
                            if ($result_universities->num_rows > 0) {
                                while ($row = $result_universities->fetch_assoc()) {
                                    $selected = ($row['id'] == $university) ? 'selected' : '';
                                    echo '<option value="' . htmlspecialchars($row['id']) . '" ' . $selected . '>' . htmlspecialchars($row['university_name']) . '</option>';
                                }
                            } else {
                                echo '<option value="" disabled>No universities available</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Programme Dropdown -->
                    <div class="form-group">
                        <label for="programme">Programme:</label>
                        <select name="programme" id="programme" class="form-control" required>
                            <option value="" disabled selected>Select Programme</option>
                            <!-- Options will be populated dynamically via AJAX -->
                        </select>
                    </div>

          
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                   

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

                    <div class="form-group">
                        <label for="intake">Intake Date:</label>
                        <input type="date" name="intake" class="form-control" value="<?php echo htmlspecialchars($intake); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="first_name">First Name:</label>
                        <input type="text" name="first_name" class="form-control" value="<?php echo htmlspecialchars($first_name); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name:</label>
                        <input type="text" name="last_name" class="form-control" value="<?php echo htmlspecialchars($last_name); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="contact">Contact:</label>
                        <input type="text" name="contact" class="form-control" value="<?php echo htmlspecialchars($contact); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="details">Details:</label>
                        <textarea name="details" class="form-control"><?php echo htmlspecialchars($details); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select name="status" class="form-control">
                            <option value="Active" <?php echo ($status == 'Active') ? 'selected' : ''; ?>>Active</option>
                            <option value="Inactive" <?php echo ($status == 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" name="save" class="btn btn-primary"><?php echo $update ? 'Update' : 'Save'; ?> Lead</button>
                </form>

                <!-- Leads List -->
                <div class="mt-5">
                    <h5>Leads List</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>University</th>
                                <th>Programme</th>
                                <th>Intake Date</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>Details</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch and display leads from the database
                            $sql_leads = "SELECT * FROM leads";
                            $result_leads = $conn->query($sql_leads);
                            while ($row = $result_leads->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($row['date']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['type']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['university']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['programme']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['intake']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['first_name']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['last_name']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['contact']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['details']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['status']) . '</td>';
                                echo '<td>';
                                echo '<a href="addLeads.php?edit=' . htmlspecialchars($row['id']) . '" class="btn btn-sm btn-warning">Edit</a> ';
                                echo '<a href="addLeads.php?delete=' . htmlspecialchars($row['id']) . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure you want to delete this lead?\')">Delete</a>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <?php include("includes/footer.php"); ?>

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>


<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

</body>

</html>
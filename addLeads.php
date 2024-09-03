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

// Fetch status options from status_table
$query_status = "SELECT id, status_name FROM status_table";
$result_status = $conn->query($query_status);
$status_options = [];

while ($row_status = $result_status->fetch_assoc()) {
    $status_options[] = $row_status;
}

// Create or Update a lead
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
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
        echo '<script>window.location.href = "addLeads";</script>';
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
        // $status = htmlspecialchars($row['status']);
        // Set the status variable to the status from the database
        $status = htmlspecialchars($row['status']);
    }
}

// Delete a lead
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM leads WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo '<script>window.location.href = "addLeads";</script>';
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
            <div class="container-fluid">

                <div class="container">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h4 class="h4 mb-0 text-gray-800">Lead Management</h4>
                    </div>

                    <div class="container">

                        <!-- Add Criteria Form -->
                        <form action="addLeads" method="POST" class="mt-4">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
    
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date">Date:</label>
                                        <input type="date" name="date" class="form-control" value="<?php echo htmlspecialchars($date); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
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
                                </div>
                                <div class="col-md-6">
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
                                </div>
                                <div class="col-md-6">
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
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="intake">Intake Date:</label>
                                        <input type="date" name="intake" class="form-control" value="<?php echo htmlspecialchars($intake); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name">First Name:</label>
                                        <input type="text" name="first_name" class="form-control" value="<?php echo htmlspecialchars($first_name); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">Last Name:</label>
                                        <input type="text" name="last_name" class="form-control" value="<?php echo htmlspecialchars($last_name); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact">Contact:</label>
                                        <input type="text" name="contact" class="form-control" value="<?php echo htmlspecialchars($contact); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="details">Details:</label>
                                        <textarea name="details" class="form-control"><?php echo htmlspecialchars($details); ?></textarea>
                                    </div>
                                </div>
    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <?php
                                            // Generate options for the status dropdown
                                            foreach ($status_options as $status_option) {
                                                // Check if this option is the one currently stored in the database
                                                $selected = ($status_option['status_name'] == $status) ? 'selected' : '';
                                                echo "<option value=\"" . htmlspecialchars($status_option['status_name']) . "\" $selected>" . htmlspecialchars($status_option['status_name']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
    
                            </div>
                            <!-- Submit Button -->
                            <button type="submit" name="save" class="btn btn-primary"><?php echo $update ? 'Update' : 'Save'; ?> Lead</button>
                        </form>
                    </div>
                </div>

                <!-- Criteria Table -->
                <div class="mt-5">
                    <h5>Leads List</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Programme</th>
                                <th>Intake</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>Details</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 12px;">
                            <?php
                            // Fetch and display leads from the database
                            $sql_leads = "SELECT * FROM leads";
                            $result_leads = $conn->query($sql_leads);
                            while ($row = $result_leads->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['date']) ?></td>
                                    <td><?= htmlspecialchars($row['type']) ?></td>
                                    <td><?= htmlspecialchars($row['programme']) ?></td>
                                    <td><?= htmlspecialchars($row['intake']) ?></td>
                                    <td><?= htmlspecialchars($row['first_name']) ?> <?= htmlspecialchars($row['last_name']) ?></td>
                                    <td><?= htmlspecialchars($row['contact']) ?></td>
                                    <td><?= htmlspecialchars($row['email']) ?></td>
                                    <td><?= htmlspecialchars($row['details']) ?></td>
                                    <td>
                                        <form id="updateStatusForm" data-lead-id="<?= htmlspecialchars($row['id']) ?>" style="display:inline;">
                                            <select name="status" class="form-control form-control-sm" id="statusSelect">
                                                <?php
                                                foreach ($status_options as $status) {
                                                    $selected = ($status['status_name'] == $row['status']) ? 'selected' : '';
                                                    echo "<option value=\"" . htmlspecialchars($status['status_name']) . "\" $selected>" . htmlspecialchars($status['status_name']) . "</option>";
                                                }
                                                ?>
                                            </select>
                                            <button type="button" class="btn btn-sm btn-primary w-100 updateStatusButton mt-2">Update</button>
                                        </form>
                                    </td>
                                    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
                                    <script>
                                        $(document).ready(function() {
                                            $('.updateStatusButton').on('click', function() {
                                                // Get the form associated with the clicked button
                                                var form = $(this).closest('form');
                                                var leadId = form.data('lead-id');
                                                var status = form.find('#statusSelect').val();

                                                $.ajax({
                                                    url: 'updateLeadStatus',
                                                    type: 'POST',
                                                    data: {
                                                        lead_id: leadId,
                                                        status: status
                                                    },
                                                    success: function(response) {

                                                        // alert('Status updated successfully!');

                                                    },
                                                    error: function(xhr, status, error) {

                                                        alert('An error occurred: ' + error);
                                                    }
                                                });
                                            });
                                        });
                                    </script>

                                    <td>
                                        <a href="addLeads?edit=<?= htmlspecialchars($row['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="addLeads?delete=<?= htmlspecialchars($row['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this lead?')">Delete</a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
</body>

</html>
<?php $conn->close(); ?>
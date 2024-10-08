<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Programme Allocation</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Edit Programme Allocation</h2>

        <!-- Student Dropdown -->
        <div class="mb-3">
            <label for="student" class="form-label">Select Student:</label>
            <select id="student" name="student" class="form-select">
                <option value="">-- Select Student --</option>
                <?php
                // Fetch students from the database
                $conn = new mysqli('localhost', 'root', '', 'demo_db');
                $result = $conn->query("SELECT student_code, first_name, last_name FROM students");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['student_code']}'>{$row['first_name']} {$row['last_name']}</option>";
                }
                ?>
            </select>
        </div>

        <!-- Form Fields for Allocation Details -->
        <form>
            <div class="mb-3">
                <label for="student_name" class="form-label">Student:</label>
                <input type="text" id="student_name" name="student_name" class="form-control" disabled>
            </div>

            <div class="mb-3">
                <label for="university" class="form-label">University:</label>
                <input type="text" id="university" name="university" class="form-control" disabled>
            </div>

            <div class="mb-3">
                <label for="programme" class="form-label">Programme:</label>
                <input type="text" id="programme" name="programme" class="form-control" disabled>
            </div>

            <div class="mb-3">
                <label for="batch" class="form-label">Batch:</label>
                <input type="text" id="batch" name="batch" class="form-control" disabled>
            </div>

            <div class="mb-3">
                <label for="registration_code" class="form-label">Registration Code:</label>
                <input type="text" id="registration_code" name="registration_code" class="form-control">
            </div>

            <!-- Elective Subjects (with checkboxes) -->
            <div class="mb-3">
                <label for="elective_subjects" class="form-label">Elective Subjects:</label>
                <div id="elective_subjects" class="form-control" style="height: auto;"></div> <!-- Holds the checkboxes -->
            </div>

            <!-- Compulsory Subjects -->
            <!-- <div class="mb-3">
                <label for="compulsory_subjects" class="form-label">Compulsory Subjects:</label>
                <input type="text" id="compulsory_subjects" name="compulsory_subjects" class="form-control" disabled>
            </div> -->
            <!-- Compulsory Subjects (with checkboxes) -->
            <div class="mb-3">
                <label for="compulsory_subjects" class="form-label">Compulsory Subjects:</label>
                <div id="compulsory_subjects" class="form-control" style="height: auto;"></div> <!-- Holds the checkboxes -->
            </div>

        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#student').change(function() {
                var student_code = $(this).val();
                if (student_code !== '') {
                    $.ajax({
                        url: 'fetch_allocation_details.php',
                        type: 'POST',
                        data: {
                            student_code: student_code
                        },
                        success: function(response) {
                            var data = JSON.parse(response);
                            $('#student_name').val(data.student_name);
                            $('#university').val(data.university);
                            $('#programme').val(data.programme);
                            $('#batch').val(data.batch);
                            $('#registration_code').val(data.registration_code);

                            // Clear previous subjects
                            $('#elective_subjects').empty();
                            $('#compulsory_subjects').empty();

                            // Generate checkboxes for elective subjects only if they exist
                            var electiveSubjects = data.elective_subjects.split(',').map(subject => subject.trim()).filter(Boolean); // Trim and filter empty strings
                            if (electiveSubjects.length > 0) {
                                electiveSubjects.forEach(function(subject) {
                                    var checkbox = '<div class="form-check"><input class="form-check-input" type="checkbox" name="elective_subjects[]" value="' + subject + '" checked><label class="form-check-label">' + subject + '</label></div>';
                                    $('#elective_subjects').append(checkbox);
                                });
                            } else {
                                // Optionally display a message when there are no elective subjects
                                $('#elective_subjects').append('<div>No elective subjects available.</div>');
                            }

                            // Generate checkboxes for compulsory subjects
                            var compulsorySubjects = data.compulsory_subjects.split(',').map(subject => subject.trim()).filter(Boolean); // Trim and filter empty strings
                            compulsorySubjects.forEach(function(subject) {
                                var checkbox = '<div class="form-check"><input class="form-check-input" type="checkbox" name="compulsory_subjects[]" value="' + subject + '" checked><label class="form-check-label">' + subject + '</label></div>';
                                $('#compulsory_subjects').append(checkbox);
                            });
                        }


                    });
                }
            });
        });
    </script>
</body>

</html>
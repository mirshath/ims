<?php
include("./database/database.php");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and validate form data
    $id = isset($_POST['student-id']) ? intval($_POST['student-id']) : null;
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    if (empty($name) || empty($email) || empty($phone)) {
        echo "<div class='alert alert-danger'>All fields are required.</div>";
    } else {
        if ($id) {
            // Update existing student
            $stmt = $conn->prepare("UPDATE reg SET name=?, email=?, phone=? WHERE id=?");
            $stmt->bind_param("sssi", $name, $email, $phone, $id);
        } else {
            // Insert new student
            $stmt = $conn->prepare("INSERT INTO reg (name, email, phone) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $phone);
        }

        // Execute and check statement
        if ($stmt->execute()) {
            if ($id) {
                echo '<script>window.location.href = "' . $_SERVER['HTTP_REFERER'] . '";</script>';
                // echo "<div class='alert alert-success'>Student updated successfully.</div>";
            } else {
                echo '<script>window.location.href = "' . $_SERVER['HTTP_REFERER'] . '";</script>';
                // echo "<div class='alert alert-success'>New student registered successfully.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }

        // Close statement
        $stmt->close();
    }
}

// Fetch and display registered students
$result = $conn->query("SELECT * FROM reg");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .dropdown-menu {
            max-height: 200px;
            overflow-y: auto;
            display: none;
            /* Hide by default */
            position: absolute;
            /* Position relative to the input */
            width: 100%;
            z-index: 1000;
        }

        .dropdown-item {
            cursor: pointer;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Student Registration Form</h2>

        <!-- Search Form -->
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6">
                <div class="form-group position-relative">
                    <label style="color: red;" for="search">Search Students for edit:</label>
                    <input type="text" class="form-control" id="search" name="search" placeholder="Type to search..." autocomplete="off">
                    <div id="search-results" class="dropdown-menu"></div>
                </div>
            </div>
        </div>

        <!-- Registration Form -->
        <form action="" method="POST">
            <input type="hidden" id="student-id" name="student-id">
            <div class="form-group">
                <label for="name">Names:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="tel" class="form-control" id="phone" name="phone" required>
            </div>
            <button type="submit" id="submit-button" class="btn btn-primary">Register</button>
        </form>


        <h2 class="mt-5 mb-4">Registered Students</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch and display registered students
                $result = $conn->query("SELECT * FROM reg");
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["phone"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No students registered</td></tr>";
                }
                $result->free();
                ?>
            </tbody>
        </table>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <script>
        $(document).ready(function() {
            let searchResults = $('#search-results');
            let studentIdInput = $('#student-id');
            let submitButton = $('#submit-button');
            let searchInput = $('#search');

            $('#search').on('input', function() {
                let query = $(this).val();
                if (query) {
                    fetchStudents(query);
                } else {
                    searchResults.hide();
                }
            });

            $('#search').on('focus', function() {
                let query = $(this).val();
                if (query) {
                    fetchStudents(query);
                }
            });

            function fetchStudents(query) {
                $.ajax({
                    url: 'search.php',
                    type: 'GET',
                    data: {
                        search: query
                    },
                    success: function(response) {
                        searchResults.html(response).show();
                    }
                });
            }

            $(document).on('click', '.dropdown-item', function() {
                let selectedItemId = $(this).data('id');
                let selectedName = $(this).data('name');
                let selectedEmail = $(this).data('email');
                let selectedPhone = $(this).data('phone');

                studentIdInput.val(selectedItemId);
                $('#name').val(selectedName);
                $('#email').val(selectedEmail);
                $('#phone').val(selectedPhone);


                // Update the search input field with the selected student's name
                searchInput.val(selectedName);

                // Change button text to "Update" if editing an existing student
                submitButton.text('Update');

                searchResults.empty().hide();
            });

            $(document).click(function(event) {
                if (!$(event.target).closest('#search, #search-results').length) {
                    searchResults.empty().hide();
                }
            });
        });
    </script>

</body>

</html>
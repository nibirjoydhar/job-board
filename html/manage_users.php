<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}

include('includes/db.php');

// Fetch all users
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>

<head>
    <?php include('headlink.php');?>
    <title>Manage Users</title>
</head>

<body class="bg-light">
    <?php include('header.php'); ?>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Manage Users</h1>
        <div class="row">
            <div class="col-md-10 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title">User List</h2>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="userTable">
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $action = ($row['status'] == 'active') ? 'deactivate' : 'activate';

                                        echo "<tr id='user-{$row['id']}'>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['email'] . "</td>";
                                        echo "<td>" . $row['role'] . "</td>";
                                        echo "<td class='status-{$row['id']}'>" . $row['status'] . "</td>";
                                        echo "<td>";
                                        echo "<button class='btn btn-warning btn-sm toggle-status' data-id='" . $row['id'] . "' data-action='$action'>$action</button>";
                                        echo "<button class='btn btn-danger btn-sm delete-user ms-2' data-id='" . $row['id'] . "'>Delete</button>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6' class='text-center'>No users found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                        <div class="text-center mt-3">
                            <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('footer.php'); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Delete User
            $(".delete-user").click(function () {
                var userId = $(this).data("id");
                if (confirm("Are you sure you want to delete this user?")) {
                    $.ajax({
                        url: "delete_user.php",
                        type: "POST",
                        data: { user_id: userId },
                        success: function (response) {
                            if (response == "success") {
                                $("#user-" + userId).fadeOut(500, function () { $(this).remove(); });
                            } else {
                                alert("Error deleting user.");
                            }
                        }
                    });
                }
            });

            // Toggle User Status
            $(".toggle-status").click(function () {
                var userId = $(this).data("id");
                var action = $(this).data("action");

                $.ajax({
                    url: "toggle_user_status.php",
                    type: "POST",
                    data: { user_id: userId, action: action },
                    success: function (response) {
                        if (response == "success") {
                            var newStatus = (action === 'deactivate') ? 'inactive' : 'active';
                            $(".status-" + userId).text(newStatus);
                            
                            // Update button text and action
                            if (newStatus === 'active') {
                                $(this).text('deactivate');
                                $(this).data("action", 'deactivate');
                            } else {
                                $(this).text('activate');
                                $(this).data("action", 'activate');
                            }
                        } else {
                            alert("Error updating status.");
                        }
                    }.bind(this) // Ensures 'this' refers to the clicked button inside the success callback
                });
            });
        });
    </script>
</body>

</html>

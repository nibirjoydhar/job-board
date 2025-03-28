<?php
session_start();

// Check if the user confirmed logout
if (isset($_POST['confirm_logout'])) {
    session_destroy();
    session_start(); // Start session again to store the goodbye message
    $_SESSION['message'] = "Goodbye! Hope to see you soon.";
    $_SESSION['message_type'] = "info"; // Info type toast
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <?php include('headlink.php'); ?>
    <title>Logout</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <?php include('header.php'); ?>


    <div class="text-warning d-flex justify-content-center align-items-center vh-100 ">
        <h1 class="text-center">We are sorry to see you go -_-</h1>
    </div>


    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to log out?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="history.back()">Cancel</button>
                    <form method="POST" action="logout.php">
                        <button type="submit" name="confirm_logout" class="btn btn-danger">Yes, Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include('footer.php'); ?>

    <!-- Auto-open logout confirmation modal -->
    <script>
        // document.addEventListener("DOMContentLoaded", function () {
        //     var logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
        //     logoutModal.show();
        // });
        document.addEventListener("DOMContentLoaded", function() {
            var logoutModal=new bootstrap.Modal(document.getElementById('logoutModal'));
            logoutModal.show();

            // Redirect back when modal is closed (either by clicking X or Cancel)
            var modalElement=document.getElementById('logoutModal');
            modalElement.addEventListener('hidden.bs.modal', function() {
                history.back();
            });
        });
    </script>


    <!-- Bootstrap JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
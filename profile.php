<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('includes/db.php');

if (isset($_POST['update_profile'])) {
    $skills = $conn->real_escape_string($_POST['skills']);
    $experience = $conn->real_escape_string($_POST['experience']);
    $user_id = $_SESSION['user_id'];

    // Check if profile already exists
    $check_sql = "SELECT * FROM profiles WHERE user_id = '$user_id'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        // Update existing profile
        $sql = "UPDATE profiles SET skills = '$skills', experience = '$experience' WHERE user_id = '$user_id'";
    } else {
        // Insert new profile
        $sql = "INSERT INTO profiles (user_id, skills, experience) VALUES ('$user_id', '$skills', '$experience')";
    }

    if ($conn->query($sql)) {
        echo "<div class='alert alert-success'>Profile updated successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }

    //extra
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
        $resume_name = basename($_FILES['resume']['name']);
        $resume_tmp = $_FILES['resume']['tmp_name'];
        $resume_path = "uploads/resumes/" . $resume_name;

        if (move_uploaded_file($resume_tmp, $resume_path)) {
            $resume_sql = ", resume = '$resume_path'";
            $sql = "UPDATE profiles SET skills = '$skills', experience = '$experience' $resume_sql WHERE user_id = '$user_id'";
        } else {
            echo "<div class='alert alert-danger'>Error uploading resume.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Update Your Profile</h2>
                        <form method="POST" action="profile.php">
                            <div class="mb-3">
                                <textarea name="skills" class="form-control" placeholder="Skills" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <textarea name="experience" class="form-control" placeholder="Experience"
                                    rows="5"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="resume" class="form-label">Upload Resume (PDF only)</label>
                                <input type="file" name="resume" class="form-control" accept=".pdf">
                            </div>
                            <button type="submit" name="update_profile" class="btn btn-primary w-100">Update
                                Profile</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
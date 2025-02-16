<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('includes/db.php');

$user_id = $_SESSION['user_id'];

// Fetch profile details
$sql = "SELECT * FROM profiles WHERE user_id = '$user_id'";
$result = $conn->query($sql);
$profile = $result->num_rows > 0 ? $result->fetch_assoc() : null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $skills = $conn->real_escape_string($_POST['skills']);
    $experience = $conn->real_escape_string($_POST['experience']);
    $sql = "INSERT INTO profiles (user_id,skills,experience,profile_photo,cv) values('$user_id','$skills','$experience'";

    // Handle profile photo upload
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/profile_photos/';
        $fileName = time() . "_" . basename($_FILES["profile_photo"]["name"]);
        $targetFile = $upload_dir . $fileName;
        $allowedTypes = ["jpg", "jpeg", "png", "gif"];
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if (!in_array($fileType, $allowedTypes)) {
            echo "<div class='alert alert-danger'>Only JPG, JPEG, PNG, and GIF files are allowed!</div>";
        } elseif (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $targetFile)) {
            if (!empty($profile['profile_photo']) && file_exists($profile['profile_photo'])) {
                unlink($profile['profile_photo']);
            }
            $sql = $sql . ",'$targetFile'";
        } else {
            echo "<div class='alert alert-danger'>Image upload failed!</div>";
        }
    }

    // Handle CV upload
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
        $cv_dir = 'uploads/cvs/';
        $cvName = time() . "_" . basename($_FILES["cv"]["name"]);
        $cvPath = $cv_dir . $cvName;
        $cvType = strtolower(pathinfo($cvPath, PATHINFO_EXTENSION));
        if ($cvType != "pdf") {
            echo "<div class='alert alert-danger'>Only PDF files are allowed for CV upload!</div>";
        } elseif (move_uploaded_file($_FILES["cv"]["tmp_name"], $cvPath)) {
            if (!empty($profile['cv']) && file_exists($profile['cv'])) {
                unlink($profile['cv']);
            }
            $sql = $sql . ",'$cvPath')";

        } else {
            echo "<div class='alert alert-danger'>CV upload failed!</div>";
        }
    }
    // echo $sql;
    if ($conn->query($sql)) {
        echo "<div class='alert alert-success'>Profile created successfully.</div>";
        header("Refresh: 2; url=profile.php");
    } else {
        echo "<div class='alert alert-danger'>Error updating profile: " . $conn->error . "</div>";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Update Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .profile-photo {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #ffc107;
    }
    </style>
</head>

<body class="bg-light">
    <?php include('header.php'); ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Update Profile</h2>
                        <!-- Profile Photo -->
                        <div class="text-center mb-4">
                            <?php if (!empty($profile['profile_photo'])): ?>
                            <img src="<?php echo htmlspecialchars($profile['profile_photo']); ?>" alt="Profile Photo"
                                class="profile-photo">
                            <?php else: ?>
                            <img src="images/default-profile.png" alt="Default Profile Photo" class="profile-photo">
                            <?php endif; ?>
                        </div>
                        <form method="POST" action="create_profile.php" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="skills" class="form-label">Skills</label>
                                <textarea name="skills" class="form-control" rows="3"
                                    required><?php echo htmlspecialchars($profile['skills'] ?? ''); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="experience" class="form-label">Experience</label>
                                <textarea name="experience" class="form-control" rows="5"
                                    required><?php echo htmlspecialchars($profile['experience'] ?? ''); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="profile_photo" class="form-label">Profile Photo</label>
                                <input type="file" name="profile_photo" class="form-control" accept="image/*" required>
                            </div>
                            <div class="mb-3">
                                <label for="cv" class="form-label">Upload CV (PDF only)</label>
                                <input type="file" name="cv" class="form-control" accept=".pdf" required>
                            </div>

                            <?php if (!empty($profile['cv'])): ?>
                            <div class="mb-3">
                                <a href="<?php echo htmlspecialchars($profile['cv']); ?>" target="_blank"
                                    class="btn btn-info">View CV</a>
                            </div>
                            <?php endif; ?>

                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-primary">Submit Data</button>
                                <a href="profile.php" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
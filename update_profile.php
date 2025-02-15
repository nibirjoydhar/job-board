<?php
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

if ($result->num_rows > 0) {
    $profile = $result->fetch_assoc();
} else {
    $profile = null;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $skills = $conn->real_escape_string($_POST['skills']);
    $experience = $conn->real_escape_string($_POST['experience']);

    // Handle profile photo upload
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/profile_photos/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Validate file type
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $file_type = $_FILES['profile_photo']['type'];
        if (!in_array($file_type, $allowed_types)) {
            echo "<div class='alert alert-danger'>Only JPEG, PNG, and GIF images are allowed.</div>";
            exit();
        }

        // Validate file size (max 2MB)
        $max_size = 2 * 1024 * 1024; // 2MB
        if ($_FILES['profile_photo']['size'] > $max_size) {
            echo "<div class='alert alert-danger'>File size must be less than 2MB.</div>";
            exit();
        }

        // Generate a unique file name to avoid conflicts
        $file_name = uniqid() . '_' . basename($_FILES['profile_photo']['name']);
        $file_path = $upload_dir . $file_name;

        // Move the uploaded file to the uploads directory
        if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $file_path)) {
            // Delete the old profile photo if it exists
            if (!empty($profile['profile_photo']) && file_exists($profile['profile_photo'])) {
                unlink($profile['profile_photo']);
            }

            // Update the profile photo in the database
            $update_sql = "UPDATE profiles SET skills = '$skills', experience = '$experience', profile_photo = '$file_path' WHERE user_id = '$user_id'";
        } else {
            echo "<div class='alert alert-danger'>Error uploading profile photo. Please try again.</div>";
            exit();
        }
    } else {
        // Update profile without changing the photo
        $update_sql = "UPDATE profiles SET skills = '$skills', experience = '$experience' WHERE user_id = '$user_id'";
    }

    if ($conn->query($update_sql)) {
        echo "<div class='alert alert-success'>Profile updated successfully.</div>";
        // Refresh the page to show updated details
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
                        <form method="POST" action="update_profile.php" enctype="multipart/form-data">
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
                                <input type="file" name="profile_photo" class="form-control" accept="image/*">
                            </div>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-primary">Update Profile</button>
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
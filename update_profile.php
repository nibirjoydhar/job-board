<?php
// error_reporting(E_ALL); // ini_set('display_errors', 1); 
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
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $bio = $conn->real_escape_string($_POST['bio']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $linkedin = $conn->real_escape_string($_POST['linkedin']);
    $github = $conn->real_escape_string($_POST['github']);
    $website = $conn->real_escape_string($_POST['website']);
    $skills = $conn->real_escape_string($_POST['skills']);
    $experience = $conn->real_escape_string($_POST['experience']);
    
    $updateFields = "full_name='$full_name', bio='$bio', phone='$phone', address='$address', linkedin='$linkedin', github='$github', website='$website', skills='$skills', experience='$experience'";

    // Handle profile photo upload
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/profile_photos/';
        $fileName = time() . "_" . basename($_FILES["profile_photo"]["name"]);
        $targetFile = $upload_dir . $fileName;
        $allowedTypes = ["jpg", "jpeg", "png", "gif"];
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if (in_array($fileType, $allowedTypes) && move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $targetFile)) {
            if (!empty($profile['profile_photo']) && file_exists($profile['profile_photo'])) {
                unlink($profile['profile_photo']);
            }
            $updateFields .= ", profile_photo='$targetFile'";
        } else {
            echo "<div class='alert alert-danger'>Invalid image upload!</div>";
        }
    }

    // Handle CV upload
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
        $cv_dir = 'uploads/cvs/';
        $cvName = time() . "_" . basename($_FILES["cv"]["name"]);
        $cvPath = $cv_dir . $cvName;
        $cvType = strtolower(pathinfo($cvPath, PATHINFO_EXTENSION));

        if ($cvType == "pdf" && move_uploaded_file($_FILES["cv"]["tmp_name"], $cvPath)) {
            if (!empty($profile['cv']) && file_exists($profile['cv'])) {
                unlink($profile['cv']);
            }
            $updateFields .= ", cv='$cvPath'";
        } else {
            echo "<div class='alert alert-danger'>Invalid CV upload!</div>";
        }
    }

    // Update profile data
    if ($profile) {
        $sql = "UPDATE profiles SET $updateFields WHERE user_id='$user_id'";
    } else {
        $sql = "INSERT INTO profiles (user_id, full_name, bio, profile_photo, phone, address, linkedin, github, website, skills, experience, cv) 
                VALUES ('$user_id', '$full_name', '$bio', '', '$phone', '$address', '$linkedin', '$github', '$website', '$skills', '$experience', '')";
    }

    if ($conn->query($sql)) {
        echo "<div id='toastMessage' class='toast bg-success text-white'>Profile updated successfully.</div>";
        $_SESSION['name']=$full_name;
        header("Refresh: 3; url=profile.php");
    } else {
        echo "<div id='toastMessage' class='toast bg-danger text-white'>Error updating profile: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <?php include('headlink.php'); ?>
    <style>
        .profile-photo {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #ffc107;
        }

        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 10px;
            border-radius: 5px;
            display: none;
            opacity: 0;
            transition: opacity 0.5s ease, bottom 0.5s ease;
            z-index: 9999;
        }

        .toast.show {
            display: block;
            opacity: 1;
            bottom: 30px;
        }

        .toast.bg-success {
            background-color: #28a745;
        }

        .toast.bg-danger {
            background-color: #dc3545;
        }

        .toast .text-white {
            color: white;
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
                        <div class="text-center mb-4">
                            <?php if (!empty($profile['profile_photo'])): ?>
                                <img src="<?php echo htmlspecialchars($profile['profile_photo']); ?>" alt="Profile Photo" class="profile-photo">
                            <?php else: ?>
                                <img src="images/default-profile.png" alt="Default Profile Photo" class="profile-photo">
                            <?php endif; ?>
                        </div>
                        <form method="POST" action="update_profile.php" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Full Name</label>
                                <input type="text" name="full_name" class="form-control" value="<?php echo htmlspecialchars($_SESSION['name'] ?? ''); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="bio" class="form-label">Bio</label>
                                <textarea name="bio" class="form-control" rows="3" required><?php echo htmlspecialchars($profile['bio'] ?? ''); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($profile['phone'] ?? ''); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" class="form-control" value="<?php echo htmlspecialchars($profile['address'] ?? ''); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="linkedin" class="form-label">LinkedIn</label>
                                <input type="text" name="linkedin" class="form-control" value="<?php echo htmlspecialchars($profile['linkedin'] ?? ''); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="github" class="form-label">GitHub</label>
                                <input type="text" name="github" class="form-control" value="<?php echo htmlspecialchars($profile['github'] ?? ''); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="website" class="form-label">Website</label>
                                <input type="text" name="website" class="form-control" value="<?php echo htmlspecialchars($profile['website'] ?? ''); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="skills" class="form-label">Skills</label>
                                <textarea name="skills" class="form-control" rows="3" required><?php echo htmlspecialchars($profile['skills'] ?? ''); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="experience" class="form-label">Experience</label>
                                <textarea name="experience" class="form-control" rows="5" required><?php echo htmlspecialchars($profile['experience'] ?? ''); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="profile_photo" class="form-label">Profile Picture</label>
                                <input type="file" name="profile_photo" class="form-control" accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label for="cv" class="form-label">Upload CV (PDF only)</label>
                                <input type="file" name="cv" class="form-control" accept=".pdf">
                            </div>
                            <?php if (!empty($profile['cv'])): ?>
                                <div class="mb-3">
                                    <a href="<?php echo htmlspecialchars($profile['cv']); ?>" target="_blank" class="btn btn-info">View CV</a>
                                </div>
                            <?php endif; ?>
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
    <?php include('footer.php'); ?>

    <script>
        // Wait for the page to load before showing the toast
        window.addEventListener('DOMContentLoaded', (event) => {
            var toastMessage = document.getElementById('toastMessage');
            if (toastMessage) {
                toastMessage.classList.add('show');
                setTimeout(function() {
                    toastMessage.classList.remove('show');
                }, 3000); // Hide after 3 seconds
            }
        });
    </script>
</body>

</html>

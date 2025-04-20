<?php
// Get the current page filename
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fs-3" href="index.php">Job Board</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if (!isset($_SESSION['user_id'])): ?>
                <li class="nav-item">
                    <a class="nav-link fw-bold <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" 
                       href="index.php">View Jobs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold <?php echo ($current_page=='login.php') ? 'active' : ''; ?>" 
                       href="login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold <?php echo ($current_page == 'register.php') ? 'active' : ''; ?>" 
                       href="register.php">Register</a>
                </li>
                <?php else: ?>
                <?php if ($_SESSION['role'] == 'job_seeker'): ?>
                <li class="nav-item">
                    <a class="nav-link fw-bold <?php echo ($current_page=='dashboard.php') ? 'active' : ''; ?>" 
                       href="dashboard.php">Dashboard</a>
                </li>
                <?php elseif ($_SESSION['role'] == 'employer'): ?>
                <li class="nav-item">
                    <a class="nav-link fw-bold <?php echo (in_array($current_page, ['employer_dashboard.php', 'post_job.php', 'manage_jobs.php'])) ? 'active' : ''; ?>" 
                       href="employer_dashboard.php">Dashboard</a>
                </li>
                <?php elseif ($_SESSION['role'] == 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link fw-bold <?php echo (in_array($current_page, ['admin_dashboard.php', 'manage_users.php', 'manage_jobs.php'])) ? 'active' : ''; ?>" 
                       href="admin_dashboard.php">Dashboard</a>
                </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link fw-bold <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" 
                       href="index.php">View Jobs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold <?php echo (in_array($current_page, ['profile.php', 'edit_profile.php', 'change_password.php'])) ? 'active' : ''; ?>" 
                       href="profile.php"><?php echo htmlspecialchars($_SESSION['name']); ?></a>
                </li>

                <!-- Show 'Pro Member' badge if user is premium -->
                <?php if (isset($_SESSION['is_premium']) && $_SESSION['is_premium'] == 1): ?>
                <li class="nav-item">
                    <span class="badge bg-success text-dark ms-2">
                        <i class="fas fa-bolt"></i> Pro Member
                    </span>
                </li>
                <?php else: ?>
                <!-- Become a Pro Member Button -->
                <li class="nav-item">
                    <a class="btn btn-warning fw-bold ms-2 <?php echo ($current_page == 'premium.php') ? 'active' : ''; ?>" 
                       href="premium.php"><i class="fas fa-bolt"></i> Become a Pro Member</a>
                </li>
                <?php endif; ?>

                <li class="nav-item">
                    <a class="nav-link text-danger" href="logout.php">Logout</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<style>
    /* Add this to your CSS to make active links more visible */
    .navbar-nav .nav-link.active {
        color: #fff !important;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 4px;
    }
    
    /* Style for the active premium button */
    .navbar-nav .btn-warning.active {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #000 !important;
    }
</style>
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
                    <a class="nav-link fw-bold <?php echo ($current_page == 'login.php') ? 'active' : ''; ?>"
                        href="login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold <?php echo ($current_page == 'register.php') ? 'active' : ''; ?>"
                        href="register.php">Register</a>
                </li>
                <?php else: ?>
                <?php if ($_SESSION['role'] == 'job_seeker'): ?>
                <li class="nav-item">
                    <a class="nav-link fw-bold <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>"
                        href="dashboard.php">Dashboard</a>
                </li>
                <?php elseif ($_SESSION['role'] == 'employer'): ?>
                <li class="nav-item">
                    <a class="nav-link fw-bold <?php echo ($current_page == 'employer_dashboard.php') ? 'active' : ''; ?>"
                        href="employer_dashboard.php">Dashboard</a>
                </li>
                <?php elseif ($_SESSION['role'] == 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link fw-bold <?php echo ($current_page == 'admin_dashboard.php') ? 'active' : ''; ?>"
                        href="admin_dashboard.php">Dashboard</a>
                </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link fw-bold <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>"
                        href="index.php">View Jobs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold <?php echo ($current_page == 'profile.php') ? 'active' : ''; ?>"
                        href="profile.php"><?php echo $_SESSION['name']; ?></a>
                </li>

                <!-- Show 'Pro Member' badge if user is premium -->
                <?php if (isset($_SESSION['is_premium']) && $_SESSION['is_premium'] == 1): ?>
                <li class="nav-item">
                    <span class="badge bg-warning text-dark ms-2">
                        <i class="fas fa-bolt"></i> Pro Member
                    </span>
                </li>
                <?php else: ?>
                <!-- Become a Pro Member Button -->
                <li class="nav-item">
                    <a class="btn btn-warning fw-bold ms-2" href="premium.php">Become a Pro Member</a>
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
<div class="mt-5"></div>

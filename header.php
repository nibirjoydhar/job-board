<!-- db connection, session needed -->

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fs-3" href="index.php">Job Board</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto ">
                <?php
                if (!isset($_SESSION['user_id'])) {
                    ?>
                <li class="nav-item">
                    <a class="nav-link  fw-bold" href="login.php">Login</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link fw-bold" href="register.php">Register</a>
                </li>
                <?php
                } else {
                    ?>
                </u<li class="nav-item ">
                <a class="nav-link fw-bold" href="profile.php"> <?php echo $_SESSION['name'] ?> </a>
                </li>

                <li class="nav-item ">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
                <?php
                }
                ?>

        </div>
    </div>
</nav>
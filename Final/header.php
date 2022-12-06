<?php
session_start();
include_once("./CAS-1.4.0/CAS.php");
phpCAS::client(CAS_VERSION_2_0, 'cas.auth.rpi.edu', 443, '/cas');

// This is not recommended in the real world!
// But we don't have the apparatus to install our own certs...
phpCAS::setNoCasServerValidation();

if (!phpCAS::isAuthenticated()) {
    header("Location: login.php");
}

// Vars for PDO connection
$host = "localhost";
$user = "phpmyadmin";
$pass = "chickenWingsandFries123!";
$dbname = "rensselaer_list";
// PDO Connection
try {
    $dbconn = new PDO("mysql:host=$host; dbname=$dbname", $user, $pass);
    $dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    echo $exception->getMessage();
}
?>
<!-- Site Header -->
<header class="container-xxl">
    <!-- Site Nav Bar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <!-- Site logo -->
        <a href="index.php" class="navbar-brand"><img class="RL-Logo" src="resources/images/Rensselear-List-Logo.png"
                alt="Rensselaer List Logo" /></a>
        <!-- Nav button for mobile  -->
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#RL-Navbar"
            aria-controls="RL-Navbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Off Canvas Nav -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="RL-Navbar">
            <div class="offcanvas-header">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav flex-fill justify-content-between pt-2">
                    <li class="nav-item dropdown ps-3">
                        <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">Browse</a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="browse.php" class="dropdown-item">All</a>
                            </li>
                            <li><a href="#" class="dropdown-item">New Items</a></li>
                            <li><a href="#" class="dropdown-item">By Category</a></li>
                            <li><a href="#" class="dropdown-item">Top Listings</a></li>
                        </ul>
                    </li>
                    <li class="nav-item ms-lg-auto">
                        <form role="search">
                            <div class="input-group">
                                <button class="btn btn-primary input-group-text" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                                <input class="form-control" size="35" type="search" placeholder="Search"
                                    aria-label="Search" />
                            </div>
                        </form>
                    </li>
                    <li class="nav-item ms-lg-auto">
                        <a class="nav-link" href="buyer-page.php">
                            <?php
                if (phpCAS::isAuthenticated()) {
                    $rcsid = phpCAS::getUser();
                    $query = "SELECT * FROM users WHERE rcsid = :rcsid;";
                    $stmt = $dbconn->prepare($query);
                    $stmt->execute(['rcsid' => $rcsid]);
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    if (isset($user) && empty($user)) {
                        $query = "INSERT INTO users(rcsid, admin) VALUES (?,?);";
                        $stmt = $dbconn->prepare($query);
                        $stmt->execute([$rcsid, 0]);
                    }
                    $_SESSION["user"] = $rcsid;
                    echo "<i class='bi bi-person-circle'></i>" . " " . $_SESSION["user"];
                }
                ?>
                        </a>
                    </li>
                    <li class="nav-item pe-2">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                    <li class="nav-item black-line"></li>
                    <li class="nav-item ps-3">
                        <a class="btn btn-primary nav-btn" href="list-item.php" role="button">Sell</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
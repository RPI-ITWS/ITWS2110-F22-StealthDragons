<!DOCTYPE html>
<html lang="en-US">

<head>
  <!--meta tags-->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="A platform for RPI students to buy and sell items." />
  <!-- Latest compiled and minified bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css" />
  <!--Fonts and CSS-->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter&family=Open+Sans&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="resources/stylesheets/style.css" />
  <!-- Bootstrap JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"
    defer></script>
  <!-- custom js -->
  <script src="resources/scripts/index.js" defer></script>
  <title>Rensselaer List</title>
</head>

<body>
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
      <a href="#" class="navbar-brand"><img class="RL-Logo" src="resources/images/Rensselear-List-Logo.png"
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
                  <a href="resources/pages/browse.html" class="dropdown-item">All</a>
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
                  <input class="form-control" size="35" type="search" placeholder="Search" aria-label="Search" />
                </div>
              </form>
            </li>
            <li class="nav-item ms-lg-auto">
              <a class="nav-link" href="#">
                <?php
                if (phpCAS::isAuthenticated()) {
                  $rcsid = phpCAS::getUser();
                  $query = "SELECT * FROM users WHERE rcsid = :rcsid;";
                  $stmt = $dbconn->prepare($query);
                  $stmt->execute(['rcsid'=>$rcsid]);
                  $user = $stmt->fetch(PDO::FETCH_ASSOC);
                  if(isset($user) && empty($user)){
                    $query = "INSERT INTO users(rcsid, admin) VALUES (?,?);";
                    $stmt = $dbconn->prepare($query);
                    $stmt->execute([$rcsid, 0]);
                  }
                  $_SESSION["user"] = $rcsid;
                  echo $_SESSION["user"];
                }
                ?>
              </a>
            </li>
            <li class="nav-item pe-2">
              <a class="nav-link" href="logout.php">Logout</a>
            </li>
            <li class="nav-item black-line"></li>
            <li class="nav-item ps-3">
              <a class="btn btn-primary nav-btn" href="resources/pages/list-item.php" role="button">Sell</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <!-- Top Items of RL with carousel  -->
  <section class="container-xxl py-5">
    <h2 class="sec-head-1 pb-3">Top Items</h2>
    <div id="top-item-carousel" class="carousel carousel-light bg-dark slide">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#top-item-carousel" data-bs-slide-to="0" class="active"
          aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#top-item-carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#top-item-carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="https://ashleyfurniture.scene7.com/is/image/AshleyFurniture/B600001175_1?$AFHS-PDP-Zoomed$"
            class="d-block w-100 carousel-img" alt="..." />
          <div class="carousel-caption d-none d-md-block">
            <h5>Spongebob Chair</h5>
            <a href="resources/pages/product-page.html" class="btn btn-primary">View Item</a>
          </div>
        </div>
        <div class="carousel-item">
          <img
            src="//cdn.shopify.com/s/files/1/0087/3306/5252/products/5106501_1_b8455b48-f65d-4d0b-af08-2a66090d6572_1000x1000_crop_center.jpg?v=1632352094"
            class="d-block w-100 carousel-img" alt="..." />
          <div class="carousel-caption d-none d-md-block">
            <h5>Gamer Chair</h5>
            <a href="#" class="btn btn-primary">View Item</a>
          </div>
        </div>
        <div class="carousel-item">
          <img
            src="https://u-mercari-images.mercdn.net/photos/m16599459385_1.jpg?width=512&height=512&format=pjpg&auto=webp&fit=crop&_=1641254330"
            class="d-block w-100 carousel-img" alt="..." />
          <div class="carousel-caption d-none d-md-block">
            <h5>Nintendo Switch</h5>
            <a href="#" class="btn btn-primary">View Item</a>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#top-item-carousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#top-item-carousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </section>
  <!-- New Items Section -->
  <section class="container-xxl pb-5">
    <h3 class="sec-head-2 pb-3">New Items</h3>
    <div class="row">
      <div class="col-md">
        <a href="#" class="sale-card">
          <div class="card">
            <img src="resources/images/new1.jpg" class="card-img-top" alt="..." />
            <div class="card-body">
              <p class="card-text">Sitting/Standing Desk</p>
              <h6 class="card-subtitle">Price</h6>
              <h6 class="card-title">$79</h6>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md">
        <a href="#" class="sale-card">
          <div class="card">
            <img src="resources/images/new2.jpg" class="card-img-top" alt="..." />
            <div class="card-body">
              <p class="card-text">Spice Rack Organizer</p>
              <h6 class="card-subtitle">Price</h6>
              <h6 class="card-title">$30</h6>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md">
        <a href="#" class="sale-card">
          <div class="card">
            <img src="resources/images/new3.jpg" class="card-img-top" alt="..." />
            <div class="card-body">
              <p class="card-text">Dirt Devil Vacuum</p>
              <h6 class="card-subtitle">Price</h6>
              <h6 class="card-title">$5</h6>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md">
        <a href="#" class="sale-card">
          <div class="card">
            <img src="resources/images/new4.jpg" class="card-img-top" alt="..." />
            <div class="card-body">
              <p class="card-text">Portable Mini-Fridge</p>
              <h6 class="card-subtitle">Price</h6>
              <h6 class="card-title">$25</h6>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md">
        <a href="#" class="sale-card">
          <div class="card">
            <img src="resources/images/new5.jpg" class="card-img-top" alt="..." />
            <div class="card-body">
              <p class="card-text">Quilted Curtains</p>
              <h6 class="card-subtitle">Price</h6>
              <h6 class="card-title">$35</h6>
            </div>
          </div>
        </a>
      </div>
      <a href="#" class="view-all pt-2">View All <i class="bi bi-arrow-right-square"></i></a>
    </div>
  </section>
  <!-- Top Listings Section -->
  <section class="container-xxl pb-5">
    <h3 class="sec-head-2 pb-3">Top Listings</h3>
    <div class="row">
      <div class="col-md">
        <a href="#" class="sale-card">
          <div class="card">
            <img src="resources/images/top1.jpg" class="card-img-top" alt="..." />
            <div class="card-body">
              <p class="card-text">Hutch and Cabinet</p>
              <h6 class="card-subtitle">Price</h6>
              <h6 class="card-title">$225</h6>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md">
        <a href="#" class="sale-card">
          <div class="card">
            <img src="resources/images/top2.jpg" class="card-img-top" alt="..." />
            <div class="card-body">
              <p class="card-text">Oakwood Dresser</p>
              <h6 class="card-subtitle">Price</h6>
              <h6 class="card-title">$80</h6>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md">
        <a href="#" class="sale-card">
          <div class="card">
            <img src="resources/images/top3.jpg" class="card-img-top" alt="..." />
            <div class="card-body">
              <p class="card-text">Love-Seat</p>
              <h6 class="card-subtitle">Price</h6>
              <h6 class="card-title">$230</h6>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md">
        <a href="#" class="sale-card">
          <div class="card">
            <img src="resources/images/top4.jpg" class="card-img-top" alt="..." />
            <div class="card-body">
              <p class="card-text">Bassett Plush Sofa</p>
              <h6 class="card-subtitle">Price</h6>
              <h6 class="card-title">$300</h6>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md">
        <a href="#" class="sale-card">
          <div class="card">
            <img src="resources/images/top5.jpg" class="card-img-top" alt="..." />
            <div class="card-body">
              <p class="card-text">Black Nightstand Table</p>
              <h6 class="card-subtitle">Price</h6>
              <h6 class="card-title">$30</h6>
            </div>
          </div>
        </a>
      </div>
      <a href="#" class="view-all pt-2">View All <i class="bi bi-arrow-right-square"></i></a>
    </div>
  </section>
  <!-- Featured Items Section -->
  <section class="container-xxl pb-5">
    <h3 class="sec-head-2 pb-3">Featured Items</h3>
    <div class="row">
      <div class="col-md">
        <a href="#" class="sale-card">
          <div class="card">
            <img src="resources/images/feat1.jpg" class="card-img-top" alt="..." />
            <div class="card-body">
              <p class="card-text">Bose Speaker Set</p>
              <h6 class="card-subtitle">Price</h6>
              <h5 class="card-title">$20</h5>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md">
        <a href="#" class="sale-card">
          <div class="card">
            <img src="resources/images/feat2.jpg" class="card-img-top" alt="..." />
            <div class="card-body">
              <p class="card-text">Roku Express</p>
              <h6 class="card-subtitle">Price</h6>
              <h5 class="card-title">$55</h5>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md">
        <a href="#" class="sale-card">
          <div class="card">
            <img src="resources/images/feat3.jpg" class="card-img-top" alt="..." />
            <div class="card-body">
              <p class="card-text">Kindle Fire Tablet</p>
              <h6 class="card-subtitle">Price</h6>
              <h5 class="card-title">$45</h5>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md">
        <a href="#" class="sale-card">
          <div class="card">
            <img src="resources/images/feat4.jpg" class="card-img-top" alt="..." />
            <div class="card-body">
              <p class="card-text">Gen. 3 AirPods</p>
              <h6 class="card-subtitle">Price</h6>
              <h5 class="card-title">$150</h5>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md">
        <a href="#" class="sale-card">
          <div class="card">
            <img src="resources/images/feat5.jpg" class="card-img-top" alt="..." />
            <div class="card-body">
              <p class="card-text">Vinyl Record Player</p>
              <h6 class="card-subtitle">Price</h6>
              <h5 class="card-title">$50</h5>
            </div>
          </div>
        </a>
      </div>
      <a href="#" class="view-all pt-2">View All <i class="bi bi-arrow-right-square"></i></a>
    </div>
  </section>
  <!-- Text Books Section -->
  <section class="container-xxl pb-5">
    <h3 class="sec-head-2 pb-3">Textbooks</h3>
    <div class="row">
      <div class="col-md">
        <a href="#" class="sale-card">
          <div class="card">
            <img src="resources/images/textbook1.jpg" class="card-img-top" alt="..." />
            <div class="card-body">
              <p class="card-text">Technician Automotive Repair Textbooks</p>
              <h6 class="card-subtitle">Price</h6>
              <h6 class="card-title">$60</h6>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md">
        <a href="#" class="sale-card">
          <div class="card">
            <img src="resources/images/textbook2.jpg" class="card-img-top" alt="..." />
            <div class="card-body">
              <p class="card-text">Electrical Engineering Textbooks</p>
              <h6 class="card-subtitle">Price</h6>
              <h6 class="card-title">$30</h6>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md">
        <a href="#" class="sale-card">
          <div class="card">
            <img src="resources/images/textbook3.jpg" class="card-img-top" alt="..." />
            <div class="card-body">
              <p class="card-text">Medical Textbooks Mint</p>
              <h6 class="card-subtitle">Price</h6>
              <h6 class="card-title">$45</h6>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md">
        <a href="#" class="sale-card">
          <div class="card">
            <img src="resources/images/textbook4.jpg" class="card-img-top" alt="..." />
            <div class="card-body">
              <p class="card-text">Various Textbooks Good Condition</p>
              <h6 class="card-subtitle">Price</h6>
              <h6 class="card-title">$10</h6>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md">
        <a href="#" class="sale-card">
          <div class="card">
            <img src="resources/images/textbook5.jpg" class="card-img-top" alt="..." />
            <div class="card-body">
              <p class="card-text">Two Reading Textbooks</p>
              <h6 class="card-subtitle">Price</h6>
              <h6 class="card-title">$10</h6>
            </div>
          </div>
        </a>
      </div>
      <a href="#" class="view-all pt-2">View All <i class="bi bi-arrow-right-square"></i></a>
    </div>
  </section>

  <!-- Modal For Signing in -->
  <div class="modal fade" id="log-in-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="log-in-modal-label" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5 sec-head-2" id="log-in-modal-label">
            Welcome Back
          </h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mb-3">
              <label for="email-input" class="form-label">Email address</label>
              <input type="email" class="form-control" id="email-input" />
            </div>
            <label for="password-input" class="form-label">Password</label>
            <div class="mb-3 input-group">
              <input type="password" class="form-control" id="password-input" />
              <button class="input-group-text bg-transparent" onclick="togglePassword()">
                <i class="bi bi-eye-slash" id="toggle-password"></i>
              </button>
            </div>
            <button type="submit" class="btn btn-primary">Log In</button>
          </form>
        </div>
        <div class="modal-footer">
          <a class="modal-footer-link" href="#">Sign Up</a>
          <span>|</span>
          <a class="modal-footer-link" href="#">Forgot Password?</a>
        </div>
      </div>
    </div>
  </div>
  <!-- Site Footer -->
  <footer></footer>
</body>

</html>
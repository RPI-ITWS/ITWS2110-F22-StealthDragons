<!DOCTYPE html>
<html lang="en-US">

<?php include 'head.php' ?>

<body>
  <?php include 'header.php' ?>
  <!-- Section Browse Section -->
  <section class="container-xxl pt-5 pb-3">
    <h2 class="sec-head-1">Browse</h2>
    <div class="row">
      <div class="col-3 pt-4">
        <h3 class="body-text">Filter By</h3>
        <div class="accordion accordion-flush pt-2" id="accordionFlushExample">
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingOne">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                Category
              </button>
            </h2>
            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
              data-bs-parent="#accordionFlushExample">
              <div class="accordion-body">NUll</div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingTwo">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                Condition
              </button>
            </h2>
            <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo"
              data-bs-parent="#accordionFlushExample">
              <div class="accordion-body">NUll</div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingThree">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                Price
              </button>
            </h2>
            <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree"
              data-bs-parent="#accordionFlushExample">
              <div class="accordion-body">NULL</div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingFour">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                Payment Method
              </button>
            </h2>
            <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour"
              data-bs-parent="#accordionFlushExample">
              <div class="accordion-body">NULL</div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingFive">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
                Tags
              </button>
            </h2>
            <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive"
              data-bs-parent="#accordionFlushExample">
              <div class="accordion-body">NULL</div>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="dropdown d-flex justify-content-end py-2">
          <a class="btn btn-primary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            Sort By
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Price Lowest</a></li>
            <li><a class="dropdown-item" href="#">Price Highest</a></li>
            <li><a class="dropdown-item" href="#">Recent</a></li>
          </ul>
        </div>
        <?php 
        $query = "SELECT * FROM items WHERE sold = 0 AND rcsid != :rcsid"; 
        $stmt = $dbconn->prepare($query);
        $stmt->bindValue(':rcsid', $_SESSION['user']);
        $stmt->execute();
        $numCols = 0; 
        $host_URI = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        foreach ($stmt as $row) {
          if($numCols == 0) {
            echo "<div class=\"row py-2\">";
          }
          $new_URI_path = "/iit/Final2/Final/product-page.php?item_ref=".$row['id'];
          $product_URI = $host_URI.$new_URI_path;


        ?>
        <div class="col-md">
          <a href="<?php echo $product_URI?>" class="sale-card">
            <div class="card h-100">
              <img src=.<?php echo $row['image1'] ?> class="card-img-top" alt="...">
              <div class="card-body">
                <p class="card-text">
                  <?php echo $row['title'] ?>
                </p>
                <h6 class="card-subtitle"> Price</h6>
                <h6 class="card-title">
                  $<?php echo $row['price'] ?>
                </h6>
              </div>
            </div>
          </a>
        </div>
        <?php 
          $numCols = $numCols + 1; 
          if($numCols == 5) {
            $numCols = 0; 
          }
        }
        if($numCols != 0 ) {
          for(; $numCols < 5; $numCols++) {
            echo "<div class=\"col-md\"></div>";
          }
        }

        ?>
      </div>
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
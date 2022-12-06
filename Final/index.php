<!DOCTYPE html>
<html lang="en-US">

<?php include 'head.php' ?>

<body>
  <?php include 'header.php' ?>

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
        <?php
        $query = "SELECT * FROM items WHERE sold = 0 AND rcsid != :rcsid ORDER BY id DESC LIMIT 3";
        $stmt = $dbconn->prepare($query);
        $stmt->bindValue(':rcsid', $_SESSION['user']);
        $stmt->execute();
        $count = 0;
        $host_URI = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        foreach ($stmt as $row) {
          $new_URI_path = "/iit/Final2/Final/product-page.php?item_ref=".$row['id'];
          $product_URI = $host_URI.$new_URI_path;
          $count++;
          if ($count == 1) {
            echo '<div class="carousel-item active">';
          } else {
            echo '<div class="carousel-item">';
          } ?>
        <img src=.<?php echo $row['image1'] ?> class="d-block w-100 carousel-img" alt="...">
        <div class="carousel-caption d-block">
          <h5>
            <?php echo $row['title'] ?>
          </h5>
          <a href="<?php echo $product_URI?>" class="btn btn-primary">View Item</a>
        </div>

        <?php
          echo '</div>';
        }
        ?>
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
      <?php
      $query = "SELECT * FROM items WHERE sold = 0 AND rcsid != :rcsid ORDER BY date_posted DESC LIMIT 5";
      $stmt = $dbconn->prepare($query);
      $stmt->bindValue(':rcsid', $_SESSION['user']);
      $stmt->execute();
      foreach ($stmt as $row) {
      ?>
      <div class="col-md">
        <a href="" class="sale-card">
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
      }
      ?>
      <a href="#" class="view-all pt-2">View All <i class="bi bi-arrow-right-square"></i></a>
    </div>
  </section>
  <!-- Top Listings Section -->
  <section class="container-xxl pb-5">
    <h3 class="sec-head-2 pb-3">Top Listings</h3>
    <div class="row">
    <?php
      $query = "SELECT * FROM items WHERE sold = 0 AND rcsid != :rcsid ORDER BY item_views DESC LIMIT 5";
      $stmt = $dbconn->prepare($query);
      $stmt->bindValue(':rcsid', $_SESSION['user']);
      $stmt->execute();
      foreach ($stmt as $row) {
      ?>
      <div class="col-md">
        <a href="" class="sale-card">
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
      }
      ?>
      <a href="#" class="view-all pt-2">View All <i class="bi bi-arrow-right-square"></i></a>
    </div>
  </section>
  <!-- Featured Items Section -->
  <section class="container-xxl pb-5">
    <h3 class="sec-head-2 pb-3">Featured Items</h3>
    <div class="row">
    <?php
      $query = "SELECT * FROM items WHERE sold = 0 AND rcsid != :rcsid LIMIT 5";
      $stmt = $dbconn->prepare($query);
      $stmt->bindValue(':rcsid', $_SESSION['user']);
      $stmt->execute();
      foreach ($stmt as $row) {
      ?>
      <div class="col-md">
        <a href="" class="sale-card">
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
      }
      ?>
      <a href="#" class="view-all pt-2">View All <i class="bi bi-arrow-right-square"></i></a>
    </div>
  </section>
  <!-- Text Books Section -->
  <section class="container-xxl pb-5">
    <h3 class="sec-head-2 pb-3">Textbooks</h3>
    <div class="row">
    <?php
      $query = "SELECT * FROM items WHERE sold = 0 AND category = 2 AND rcsid != :rcsid LIMIT 5";
      $stmt = $dbconn->prepare($query);
      $stmt->bindValue(':rcsid', $_SESSION['user']);
      $stmt->execute();
      foreach ($stmt as $row) {
      ?>
      <div class="col-md">
        <a href="" class="sale-card">
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
      }
      ?>
      <a href="#" class="view-all pt-2">View All <i class="bi bi-arrow-right-square"></i></a>
    </div>
  </section>
  <!-- Site Footer -->
  <footer></footer>
</body>

</html>
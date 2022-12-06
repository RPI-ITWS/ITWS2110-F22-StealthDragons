<!DOCTYPE html>
<html lang="en-US">

<?php include 'head.php' ?>

<body>
  <?php include 'header.php' ?>
  <?php ?>
  <!-- Section Browse Section -->
  <section class="container-xxl pt-5 pb-3">
    <h2 class="sec-head-1">Browse</h2>
    <div class="row">
      <div class="col-3 pt-4">
        <h3 class="body-text"><b>Filter By</b></h3>
        <form action="" method="post">
          <!-- Category -->
          <h3 class="body-text">Category</h3>
          <div id="category-div">
            <div class="input-group py-2 div w-100">
              <span class="input-group-text">
                <i class="bi bi-basket-fill"></i>
              </span>
              <select name="filter-item-category" id="category" class="form-select" required>
                <option selected disabled>Select Category</option>
                <?php
                $query = "SELECT category, id FROM categories";
                $stmt = $dbconn->prepare($query);
                $stmt->execute();
                foreach ($stmt as $data) {
                ?>
                <option value="<?php echo $data['id'] ?>">
                  <?php echo $data['category'] ?>
                </option>

                <?php

                }
                ?>
              </select>
            </div>
            <!-- Subcategory -->
            <div class="input-group py-2 w-100" id="subcat1-div">
              <span class="input-group-text">
                <i class="bi bi-basket-fill"></i>
              </span>
              <select name="filter-item-subcategory" id="subcategory-1" class="form-select" required>
                <option selected disabled>Select Subcategory</option>
              </select>
            </div>
            <!-- Subcategory -->
            <div class="input-group py-2 w-100" id="subcat2-div">
              <span class="input-group-text">
                <i class="bi bi-basket-fill"></i>
              </span>
              <select name="filter-item-subcategory-2" id="subcategory-2" class="form-select" required>
                <option selected disabled>Select Subcategory</option>
              </select>
            </div>
          </div>
          <h3 class="body-text">Condition</h3>
          <div class="input-group py-2">
            <span class="input-group-text">
              <i class="bi bi-search-heart"></i>
            </span>
            <select name="post-item-condition" id="condition" class="form-select" required>
              <option value="select-condition" selected disabled>Select Condition of Item</option>
              <option value="new">New</option>
              <option value="like-new">Like New</option>
              <option value="good">Good</option>
              <option value="fair">Fair</option>
              <option value="poor">Poor</option>
            </select>
          </div>
          <div class="center-button py-4" id="submit-button-div">
            <button type="submit" name="filters-submit" class="btn btn-primary" id="filters-submit">
              Apply Filters
            </button>
          </div>
        </form>
      </div>
      <div class="col">
        <div class="dropdown d-flex justify-content-end py-2">
          <a class="btn btn-primary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            Sort By
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="browse.php?sort=price-low">Price Lowest</a></li>
            <li><a class="dropdown-item" href="browse.php?sort=price-high">Price Highest</a></li>
            <li><a class="dropdown-item" href="browse.php?sort=recent">Recent</a></li>
            <li><a class="dropdown-item" href="browse.php?sort=oldest">Oldest</a></li>
          </ul>
        </div>
        <?php
        $query = "SELECT * FROM items WHERE sold = 0 AND rcsid != ?";
        $params = array($_SESSION['user']);
        if (isset($_POST['filters-submit'])) {
          if (isset($_POST['filter-item-category'])) {
            $category = $_POST['filter-item-category'];
            $query .= " AND category = ?";
            $params[] = $category;
          }

          if (isset($_POST['filter-item-subcategory'])) {
            $subcategory = $_POST['filter-item-subcategory'];
            $query .= " AND subcategory1 = ?";
            $params[] = $subcategory;
          }

          if (isset($_POST['filter-item-subcategory-2'])) {
            $subcategory2 = $_POST['filter-item-subcategory-2'];
            $query .= " AND subcategory2 = ?";
            $params[] = $subcategory2;

          }

          if (isset($_POST['post-item-condition'])) {
            $condition = $_POST['post-item-condition'];
            $query .= " AND item_condition = ?";
            $params[] = $condition;
          }
        }
        if (isset($_POST['search-items'])) {
          $search = htmlspecialchars(trim($_POST['search-items']));
          $query .= " AND title LIKE ? ";
          $params[] = '%' . $search . '%';
          $_SESSION['search-items'] = $search;
        } else {
          if (isset($_SESSION['search-items']) && strlen($_SESSION['search-items']) > 0) {
            $search = $_SESSION['search-items'];
            $query .= " AND title LIKE ? ";
            $params[] = '%' . $search . '%';
          }
        }

        if (isset($_GET['sort'])) {
          if ($_GET['sort'] == 'price-low') {
            $query .= " ORDER BY price ASC";
          } else if ($_GET['sort'] == 'price-high') {
            $query .= " ORDER BY price DESC";
          } else if ($_GET['sort'] == 'recent') {
            $query .= " ORDER BY date_posted DESC";
          } else if ($_GET['sort'] == 'oldest') {
            $query .= " ORDER BY date_posted ASC";
          }
        }

        $stmt = $dbconn->prepare($query);
        $stmt->execute($params);
        $numCols = 0;
        $host_URI = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        foreach ($stmt as $row) {
          if ($numCols == 0) {
            echo "<div class=\"row py-2\">";
          }
          $new_URI_path = "/ITWS2110-F22-StealthDragons/Final/product-page.php?item_ref=" . $row['id'];
          $product_URI = $host_URI . $new_URI_path;


        ?>

        <div class="col-md">
          <a href="<?php echo $product_URI ?>" class="sale-card">
            <div class="card h-100">
              <img src=.<?php echo $row['image1'] ?> class="card-img-top" alt="...">
              <div class="card-body">
                <p class="card-text">
                  <?php echo $row['title'] ?>
                </p>
                <h6 class="card-subtitle"> Price</h6>
                <h6 class="card-title">
                  $
                  <?php echo $row['price'] ?>
                </h6>
              </div>
            </div>
          </a>
        </div>
        <?php
          $numCols = $numCols + 1;
          if ($numCols == 5) {
            $numCols = 0;
          }
        }
        if ($numCols != 0) {
          for (; $numCols < 5; $numCols++) {
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
  <?php include 'footer.php' ?>
</body>

</html>
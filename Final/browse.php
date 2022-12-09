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
      <div class="col-2 pt-4">
        <h3 class="body-text"><b>Filter By</b></h3>
        <form action="" method="get">
          <?php if (isset($_GET['search-items'])) { ?>
          <input type="hidden" name="search-items" value="<?php echo $_GET['search-items'] ?>">
          <?php } ?>
          <?php if (isset($_GET['sort'])) { ?>
          <input type="hidden" name="sort" value="<?php echo $_GET['sort'] ?>">
          <?php } ?>
          <!-- Category -->
          <h3 class="body-text">Category</h3>
          <div id="category-div">
            <div class="input-group py-2 div w-100">
              <span class="input-group-text">
                <i class="bi bi-basket-fill"></i>
              </span>
              <select name="filter-item-category" id="category" class="form-select" required>
                <option selected disabled>Category</option>
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
                <option selected disabled>Subcategory</option>
              </select>
            </div>
            <!-- Subcategory -->
            <div class="input-group py-2 w-100" id="subcat2-div">
              <span class="input-group-text">
                <i class="bi bi-basket-fill"></i>
              </span>
              <select name="filter-item-subcategory-2" id="subcategory-2" class="form-select" required>
                <option selected disabled>Subcategory</option>
              </select>
            </div>
          </div>
          <h3 class="body-text">Condition</h3>
          <div class="input-group py-2">
            <span class="input-group-text">
              <i class="bi bi-search-heart"></i>
            </span>
            <select name="filter-item-condition" id="condition" class="form-select" required>
              <option value="select-condition" selected disabled>Condition</option>
              <option value="new">New</option>
              <option value="like-new">Like New</option>
              <option value="good">Good</option>
              <option value="fair">Fair</option>
              <option value="poor">Poor</option>
            </select>
          </div>
          <div class="center-button py-4" id="submit-button-div">
            <button type="submit" class="btn btn-primary" id="filters-submit">
              Apply Filters
            </button>
          </div>
        </form>
      </div>
      <div class="col">
        <div class="dropdown d-flex justify-content-between align-items-center py-2">
          <div>
            <p class="body-text">
              <?php echo "Showing Results for: ";
              if (isset($_GET['search-items']) && $_GET['search-items'] != "") {
                echo $_GET['search-items'];
              } else {
                echo "All Items";
              }
              echo "&emsp;";
              if (isset($_GET['filter-item-category'])) {
                echo " Category: " . $_GET['filter-item-category'];

              }
              if (isset($_GET['filter-item-subcategory'])) {
                echo "/" . $_GET['filter-item-subcategory'];
              }
              if (isset($_GET['filter-item-subcategory-2'])) {
                echo "/" . $_GET['filter-item-subcategory-2'];
              }
              echo "&emsp;";
              if (isset($_GET['filter-item-condition'])) {
                echo " Condition: " . $_GET['filter-item-condition'];
              }
              ?>
            </p>
          </div>
          <a class="btn btn-primary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            Sort By
          </a>
          <ul class="dropdown-menu">
            <!-- Sort price low -->
            <li><a class="dropdown-item <?php if (isset($_GET['sort']) && $_GET['sort'] == "price-low") {
              echo "active";
            }
            ?>" href="#">
                <form action="" method="get">
                  <?php if (isset($_GET['search-items'])) { ?>
                  <input type="hidden" name="search-items" value="<?php echo $_GET['search-items'] ?>">
                  <?php } ?>
                  <?php if (isset($_GET['filter-item-category'])) { ?>
                  <input type="hidden" name="filter-item-category" value="<?php echo $_GET['filter-item-category'] ?>">
                  <?php } ?>
                  <?php if (isset($_GET['filter-item-subcategory'])) { ?>
                  <input type="hidden" name="filter-item-subcategory"
                    value="<?php echo $_GET['filter-item-subcategory'] ?>">
                  <?php } ?>
                  <?php if (isset($_GET['filter-item-subcategory-2'])) { ?>
                  <input type="hidden" name="filter-item-subcategory-2"
                    value="<?php echo $_GET['filter-item-subcategory-2'] ?>">
                  <?php } ?>
                  <?php if (isset($_GET['filter-item-condition'])) { ?>
                  <input type="hidden" name="filter-item-condition" value="<?php echo $_GET['filter-item-condition'] ?>">
                  <?php } ?>
                  <input type="hidden" name="sort" value="price-low">
                  <button type="submit" class="btn-none">Price Lowest</button>
                </form>
              </a></li>
            <!-- Sort price high -->
            <li><a class="dropdown-item <?php if (isset($_GET['sort']) && $_GET['sort'] == "price-high") {
              echo "active";
            }
            ?>" href="#">
                <form action="" method="get">
                  <?php if (isset($_GET['search-items'])) { ?>
                  <input type="hidden" name="search-items" value="<?php echo $_GET['search-items'] ?>">
                  <?php } ?>
                  <?php if (isset($_GET['filter-item-category'])) { ?>
                  <input type="hidden" name="filter-item-category" value="<?php echo $_GET['filter-item-category'] ?>">
                  <?php } ?>
                  <?php if (isset($_GET['filter-item-subcategory'])) { ?>
                  <input type="hidden" name="filter-item-subcategory"
                    value="<?php echo $_GET['filter-item-subcategory'] ?>">
                  <?php } ?>
                  <?php if (isset($_GET['filter-item-subcategory-2'])) { ?>
                  <input type="hidden" name="filter-item-subcategory-2"
                    value="<?php echo $_GET['filter-item-subcategory-2'] ?>">
                  <?php } ?>
                  <?php if (isset($_GET['filter-item-condition'])) { ?>
                  <input type="hidden" name="filter-item-condition" value="<?php echo $_GET['filter-item-condition'] ?>">
                  <?php } ?>
                  <input type="hidden" name="sort" value="price-high">
                  <button type="submit" class="btn-none">Price Highest</button>
                </form>
              </a>
            </li>
            <!-- Sort date posted low -->
            <li><a class="dropdown-item <?php if (isset($_GET['sort']) && $_GET['sort'] == "date_posted-high") {
              echo "active";
            }
            ?>" href="#">
                <form action="" method="get">
                  <?php if (isset($_GET['search-items'])) { ?>
                  <input type="hidden" name="search-items" value="<?php echo $_GET['search-items'] ?>">
                  <?php } ?>
                  <?php if (isset($_GET['filter-item-category'])) { ?>
                  <input type="hidden" name="filter-item-category" value="<?php echo $_GET['filter-item-category'] ?>">
                  <?php } ?>
                  <?php if (isset($_GET['filter-item-subcategory'])) { ?>
                  <input type="hidden" name="filter-item-subcategory"
                    value="<?php echo $_GET['filter-item-subcategory'] ?>">
                  <?php } ?>
                  <?php if (isset($_GET['filter-item-subcategory-2'])) { ?>
                  <input type="hidden" name="filter-item-subcategory-2"
                    value="<?php echo $_GET['filter-item-subcategory-2'] ?>">
                  <?php } ?>
                  <?php if (isset($_GET['filter-item-condition'])) { ?>
                  <input type="hidden" name="filter-item-condition" value="<?php echo $_GET['filter-item-condition'] ?>">
                  <?php } ?>
                  <input type="hidden" name="sort" value="date_posted-high">
                  <button type="submit" class="btn-none">Most Recent</button>
                </form>
              </a>
            </li>
            <!-- Sort date posted high -->
            <li><a class="dropdown-item <?php if (isset($_GET['sort']) && $_GET['sort'] == "date_posted-low") {
              echo "active";
            }
            ?>" href="#">
                <form action="" method="get">
                  <?php if (isset($_GET['search-items'])) { ?>
                  <input type="hidden" name="search-items" value="<?php echo $_GET['search-items'] ?>">
                  <?php } ?>
                  <?php if (isset($_GET['filter-item-category'])) { ?>
                  <input type="hidden" name="filter-item-category" value="<?php echo $_GET['filter-item-category'] ?>">
                  <?php } ?>
                  <?php if (isset($_GET['filter-item-subcategory'])) { ?>
                  <input type="hidden" name="filter-item-subcategory"
                    value="<?php echo $_GET['filter-item-subcategory'] ?>">
                  <?php } ?>
                  <?php if (isset($_GET['filter-item-subcategory-2'])) { ?>
                  <input type="hidden" name="filter-item-subcategory-2"
                    value="<?php echo $_GET['filter-item-subcategory-2'] ?>">
                  <?php } ?>
                  <?php if (isset($_GET['filter-item-condition'])) { ?>
                  <input type="hidden" name="filter-item-condition" value="<?php echo $_GET['filter-item-condition'] ?>">
                  <?php } ?>
                  <input type="hidden" name="sort" value="date_posted-low">
                  <button type="submit" class="btn-none">Oldest</button>
                </form>
              </a>
            </li>
            <!-- Sort most viewed -->
            <li><a class="dropdown-item <?php if (isset($_GET['sort']) && $_GET['sort'] == "item_views-high") {
              echo "active";
            } ?>" href="#">
                <form action="" method="get">
                  <?php if (isset($_GET['search-items'])) { ?>
                  <input type="hidden" name="search-items" value="<?php echo $_GET['search-items'] ?>">
                  <?php } ?>
                  <?php if (isset($_GET['filter-item-category'])) { ?>
                  <input type="hidden" name="filter-item-category" value="<?php echo $_GET['filter-item-category'] ?>">
                  <?php } ?>
                  <?php if (isset($_GET['filter-item-subcategory'])) { ?>
                  <input type="hidden" name="filter-item-subcategory"
                    value="<?php echo $_GET['filter-item-subcategory'] ?>">
                  <?php } ?>
                  <?php if (isset($_GET['filter-item-subcategory-2'])) { ?>
                  <input type="hidden" name="filter-item-subcategory-2"
                    value="<?php echo $_GET['filter-item-subcategory-2'] ?>">
                  <?php } ?>
                  <?php if (isset($_GET['filter-item-condition'])) { ?>
                  <input type="hidden" name="filter-item-condition" value="<?php echo $_GET['filter-item-condition'] ?>">
                  <?php } ?>
                  <input type="hidden" name="sort" value="item_views-high">
                  <button type="submit" class="btn-none">Most Viewed</button>
                </form>
              </a>
            </li>
          </ul>
        </div>
        <?php
        $query = "SELECT * FROM items WHERE sold = 0 AND rcsid != ?";
        $params = array($_SESSION['user']);

        if (isset($_GET['filter-item-category'])) {
          $category = htmlspecialchars(trim($_GET['filter-item-category']));
          $query .= " AND category = ?";
          $params[] = $category;
        }

        if (isset($_GET['filter-item-subcategory'])) {
          $subcategory = htmlspecialchars(trim($_GET['filter-item-subcategory']));
          $query .= " AND subcategory1 = ?";
          $params[] = $subcategory;
        }

        if (isset($_GET['filter-item-subcategory-2'])) {
          $subcategory2 = htmlspecialchars(trim($_GET['filter-item-subcategory-2']));
          $query .= " AND subcategory2 = ?";
          $params[] = $subcategory2;
        }
        if (isset($_GET['filter-item-condition'])) {
          $condition = htmlspecialchars(trim($_GET['filter-item-condition']));
          $query .= " AND item_condition = ?";
          $params[] = $condition;
        }
        if (isset($_GET['search-items'])) {
          $search = htmlspecialchars(trim($_GET['search-items']));
          $query .= " AND title LIKE ? ";
          $params[] = '%' . $search . '%';
        }
        if (isset($_GET['sort'])) {
          $sort = htmlspecialchars(trim($_GET['sort']));
          if (strpos($sort, '-')) {
            $sort_array = explode('-', $sort);
            if ($sort_array[1] == "high") {
              $query .= " ORDER BY " . $sort_array[0] . " DESC";
            } else {
              $query .= " ORDER BY " . $sort_array[0] . " ASC";
            }
          }
        }

        $stmt = $dbconn->prepare($query);
        $stmt->execute($params);
        $numCols = 0;
        $host_URI = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        foreach ($stmt as $row) {
          if ($numCols == 0 || $numCols % 5 == 0) {
            if ($numCols != 0) {
              echo "</div>";
            }
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
          $numCols++;
        }
        if ($numCols % 5 != 0) {
          while ($numCols % 5 != 0) {
            echo "<div class=\"col-md\"></div>";
            $numCols++;
          }
          echo "</div>";
        }
        ?>
      </div>
    </div>
  </section>
  <!-- Site Footer -->
  <?php include 'footer.php' ?>
</body>

</html>
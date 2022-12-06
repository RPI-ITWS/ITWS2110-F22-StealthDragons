<!DOCTYPE html>
<html lang="en-US">
<?php include 'head.php' ?>

<body>
  <?php include 'header.php' ?>
  <!-- product details section -->
  <section class="container-xxl pt-5">
    <?php
    $item_id = $_GET['item_ref'];
    $query = "SELECT items.*, categories.category AS c, subcategories1.subcategory1 AS sc1, subcategories2.subcategory2 as sc2
    FROM items, categories, subcategories1, subcategories2
    WHERE items.id = :id and categories.id = items.category and subcategories1.id = items.subcategory1 and subcategories2.id = items.subcategory2 LIMIT 1";
    $stmt = $dbconn->prepare($query);
    $stmt->bindValue(':id', $item_id);
    $stmt->execute();
    $row = $stmt->fetch();
    if ( /* $row["rcsid"] != $_SESSION['user'] || */ !isset($_GET['item_ref']) || $stmt->rowCount() == 0) {
      echo '<script>alert("Page Not Found")</script>';
      exit();
    } else {
      $add_item_query = "UPDATE items SET item_views = Coalesce(item_views,0) + 1 WHERE id = :id";
      $add_item_stmt = $dbconn->prepare($add_item_query);
      $add_item_stmt->bindValue(':id', $item_id);
      $add_item_stmt->execute();
    ?>
    <h2 class="sec-head-1 pb-3">
      <?php echo $row['title'] ?>
    </h2>
    <div class="row pb-5">
      <div class="col-md">
        <div class="ratio ratio-1x1 mb-4">
          <img src=".<?php echo $row['image1'] ?>" alt="Current Product" id="current-img"
            class="rounded main-product" />
        </div>
        <div class="row w-100 m-auto">
          <div class="col ratio ratio-1x1">
            <img src=".<?php
      echo $row['image1'];
            ?>" alt="" class="img-thumbnail rounded inactive-thumbnail active-thumbnail" />
          </div>
          <div class="col ratio ratio-1x1">
            <img src=".<?php
      if (!is_null($row['image2'])) {
        echo $row['image2'];
      } else {
        echo $row['image1'];
      }
            ?>" alt="" class="img-thumbnail rounded inactive-thumbnail" />
          </div>
          <div class="col ratio ratio-1x1">
            <img src=".<?php
      if (!is_null($row['image3'])) {
        echo $row['image3'];
      } else {
        echo $row['image1'];
      }
            ?>" alt="" class="img-thumbnail rounded inactive-thumbnail" />
          </div>
        </div>
      </div>
      <div class="col-md ms-5">
        <h3 class="sec-head-1 pb-1">Listed Price</h3>
        <h2 class="sec-head-2"><strong>
            $
            <?php echo $row['price'] ?>
          </strong></h2>
        <div class="row py-4">
          <div class="col">
            <button class="btn btn-success product-btn">Buy Now</button>
          </div>
          <div class="col d-flex justify-content-start">
            <button class="btn btn-secondary product-btn">Make Offer</button>
          </div>
        </div>
        <?php 
          if (phpCAS::isAuthenticated()) {
            $query2 = "SELECT * FROM users WHERE rcsid = :rcsid AND admin = 1;";
            $stmt2 = $dbconn->prepare($query2);
            $stmt2->bindValue(':rcsid', $_SESSION['user']);
            $stmt2->execute();
            $row2 = $stmt2->fetch();
            if ($row2['admin'] == true) {
                echo "
                <div class=\"row py-4\">
                  <div class=\"col\">
                    <form method=\"post\">
                      <input type=\"hidden\" name=\"delete-lisitng\" id=\"delete-listing\" />
                      <button type=\"submit\" class=\"btn btn-danger w-100\">Remove Listing</button>
                    </form>
                  </div>
                  <div class=\"col\">
                  <form method=\"post\">
                    <input type=\"hidden\" name=\"ban-user\" id=\"ban-user\" />
                    <button type=\"submit\" class=\"btn btn-danger w-100\">Ban User</button>
                  </form>
                  </div>
                </div>
                
                ";
                echo "
                <p class=\"body-text py-1\">
                  <strong class=\"pe-3\">Item Poster's RCSID: </strong>
                ";
                echo ucwords($row['rcsid']); 
                echo "</p>";
            }
          }
          if (isset($_POST['delete-lisitng'])) {
            $itemid = $_GET['item_ref'];
            try {
              $query = "DELETE FROM items WHERE id = :itemid";
              $stmt = $dbconn->prepare($query);
              $stmt->bindValue(':itemid', $itemid);
              $stmt->execute();
              $redirect_URI = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/iit/Final2/Final/index.php";
              echo("<script>location.href = '$redirect_URI';</script>");
            } catch (PDOException $e) {
              echo "Error: " . $e->getMessage();
            }
          }
          if (isset($_POST['ban-user'])) {
            try {
              $query = "UPDATE users SET ban = 1 WHERE rcsid = :rcsid";
              $stmt = $dbconn->prepare($query);
              $stmt->bindValue(':rcsid', $row['rcsid']);
              $stmt->execute();
            } catch (PDOException $e) {
              echo "Error: " . $e->getMessage();
            }
          }
        ?>
        <div>
          <p class="body-text py-1">
            <strong class="pe-3">Condition</strong>
            <?php echo ucwords($row['item_condition']) ?>
          </p>
          <p class="body-text py-1">
            <strong class="pe-3">Category</strong>
            <?php echo $row['c'] ?>,
            <?php echo $row['sc1'] ?>,
            <?php echo $row['sc2'] ?>
          </p>
          <p class="body-text py-1">
            <strong class="pe-3">Posted</strong>
            <?php
      $datetime = strtotime($row['date_posted']);
      $date = date('m-d-Y', $datetime);
      echo $date;
            ?>
          </p>
          <p class="body-large strong pt-1">
            <strong class="pe-3">Description</strong>
          </p>
          <p class="body-text">
            <?php echo $row['item_description'] ?>
          </p>
        </div>
      </div>
    </div>
  </section>
  <?php
    }

    ?>
  <!-- Similar Items Section -->
  <section class="container-xxl pb-5">
    <h3 class="sec-head-2 pb-3">Similar Items</h3>
    <div class="row">
      <?php
    $query = "SELECT * FROM items WHERE rcsid = :rcsid ORDER BY id DESC LIMIT 5";
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
                $
                <?php echo $row['price'] ?>
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
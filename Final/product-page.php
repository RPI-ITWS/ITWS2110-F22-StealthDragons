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
    if ($row["rcsid"] != $_SESSION['user'] || !isset($_GET['item_ref']) || $stmt->rowCount() == 0) {
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
        <h2 class="sec-head-2"><b>
            $
            <?php echo $row['price'] ?>
          </b></h2>
        <div class="row py-4">
          <div class="col">
            <button class="btn btn-success product-btn" data-bs-toggle="modal" data-bs-target="#purchase-modal">Buy
              Now</button>
          </div>
          <div class="col d-flex justify-content-start">
            <button class="btn btn-secondary product-btn" data-bs-toggle="modal" data-bs-target="#offer-modal">Make
              Offer</button>
          </div>
        </div>
        <div>
          <p class="body-text py-1">
            <b class="pe-3">Condition</b>
            <?php echo ucwords($row['item_condition']) ?>
          </p>
          <p class="body-text py-1">
            <b class="pe-3">Category</b>
            <?php echo $row['c'] ?>,
            <?php echo $row['sc1'] ?>,
            <?php echo $row['sc2'] ?>
          </p>
          <p class="body-text py-1">
            <b class="pe-3">Posted</b>
            <?php
      $datetime = strtotime($row['date_posted']);
      $date = date('m-d-Y', $datetime);
      echo $date;
            ?>
          </p>
          <p class="body-text pt-1">
            <b class="pe-3">Description</b>
          </p>
          <p class="body-text">
            <?php echo $row['item_description'] ?>
          </p>
        </div>
      </div>
    </div>
  </section>
  <!-- Buy Item Modal -->
  <div class="modal fade" tabindex="-1" id="purchase-modal" aria-labelledby="purchase-modal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirm Purchase</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to purchase this item? <br><b>Note: Not following through with multiple purchases can
              lead
              to your account being reported and later suspended.</b></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <form action="" method="post">
            <input type="hidden" name="purchase-item" id="purchase-item" value="<?php echo $item_id ?>" />
            <button type="submit" class="btn btn-success">Purchase Item</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Offer modal -->
  <div class="modal fade" tabindex="-1" id="offer-modal" aria-labelledby="offer-modal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Make an Offer</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="post">
          <div class="modal-body">
            <div class="input-group py-2">
              <span class="input-group-text">
                <i class="bi bi-tags"></i></span>
              <input id="offer-price" name="offer-price" type="number" min="<?php
      if ($row['price'] < 4) {
        echo 1;
      } else {
        echo floor($row['price'] / 4);
      }
              ?>" max="<?php
      if ($row['price'] == 1) {
        echo 1;
      } else {
        echo $row['price'] - 1;
      }
              ?>" class="form-control" placeholder="Price" required />
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <input type="hidden" name="offer-item" id="offer-item" value="<?php echo $item_id ?>" />
            <button type="submit" class="btn btn-success">Make Offer</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  </div>

  <?php
    }
    if (isset($_POST['purchase-item'])) {
      $item_sold_query = "UPDATE items SET sold = true WHERE id = :item_id";
      $item_sold_stmt = $dbconn->prepare($item_sold_query);
      $item_sold_stmt->bindValue(':item_id', $_POST['purchase-item']);
      $item_sold_stmt->execute();
      $item_sold_add_query = "INSERT INTO sold(item_id, buyer_id, purchase_price) VALUES (:item_id, :buyer_id, :price)";
      $item_sold_add_stmt = $dbconn->prepare($item_sold_add_query);
      $item_sold_add_stmt->bindValue(':item_id', $_POST['purchase-item']);
      $item_sold_add_stmt->bindValue(':buyer_id', $_SESSION['user']);
      $item_sold_add_stmt->bindValue(':price', $row['price']);
      $item_sold_add_stmt->execute();
      $redirect_URI = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/iit/Final/index.php?item_sold_msg=true";
      echo ("<script>location.href = '$redirect_URI';</script>");
    }
    if (isset($_POST['offer-item'])) {
      $offer_query = "INSERT INTO offers(item_id, offerer_id, offer_price) VALUES (:item_id, :buyer_id, :price)";
      $offer_stmt = $dbconn->prepare($offer_query);
      $offer_stmt->bindValue(':item_id', $_POST['offer-item']);
      $offer_stmt->bindValue(':buyer_id', $_SESSION['user']);
      $offer_stmt->bindValue(':price', $_POST['offer-price']);
      $offer_stmt->execute();
      $redirect_URI = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/iit/Final/index.php?offer_msg=true";
      echo ("<script>location.href = '$redirect_URI';</script>");
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
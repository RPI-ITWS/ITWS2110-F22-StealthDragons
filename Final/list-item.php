<!DOCTYPE html>
<html lang="en-US">
<?php include 'head.php' ?>

<body>
  <?php include 'header.php' ?>

  <section class="container-xxl">
    <h2 class="sec-head-1 text-center pt-5">Seller Dashboard
    </h2>
    <div class="text-end">
      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#listing-modal"
        onclick="setToCreate()">Create
        Listing</button>
    </div>
    <div class="seller-dash-pill row p-3 my-3 mx-0">
      <h3 class="sec-head-2">Pending Sales</h3>
      <div class="col">
        <div class="card">
          <div class="card-body" role="button" data-bs-toggle="modal" data-bs-target="#view-sold-items-modal">View Sold
            Items <i class="bi bi-bag p-2"></i></i></div>
        </div>
      </div>
      <div class="col">
        <div class="card">
          <div class="card-body" role="button" data-bs-toggle="modal" data-bs-target="#view-offers-modal">View Offers<i
              class="bi bi-receipt p-2"></i></div>
        </div>
      </div>
    </div>
    <!-- Sold Items modal -->
    <div id="view-sold-items-modal" class="modal fade" tabindex="-1" aria-labelledby="view-sold-items-modal"
      aria-hidden="true" role="dialog">
      <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Sold Items</h5>
          </div>
          <div class="modal-body">
            <?php
            $query = "SELECT items.*, sold.purchase_price, sold.buyer_id FROM items, sold WHERE items.rcsid = :rcsid and items.sold = true and items.id = sold.item_id";
            $stmt = $dbconn->prepare($query);
            $stmt->bindValue(':rcsid', $_SESSION['user']);
            $stmt->execute();

            foreach ($stmt as $row) {
              $datetime = strtotime($row['date_posted']);
              $date = date('m-d-Y', $datetime);
            ?>

            <div class="card my-2">
              <div class="card-body">
                <div class="row">
                  <div class="col-3 sell-img-col-div">
                    <div class="ratio ratio-1x1">
                      <img src=".<?php echo $row['image1'] ?>" class="img-thumbnail sell-img" alt="...">
                    </div>
                  </div>
                  <div class="col">
                    <h4 class="body-large"><strong>
                        <?php echo $row['title'] ?>
                      </strong></h4>
                      <h4 class="body-text">
                        Buyer Contact Information: 
                        <?php echo $row['buyer_id'] . "@rpi.edu" ?>
                      </h4>
                    <p class="body-text">
                      Purchase Price:
                      $
                      <?php echo $row['purchase_price'] ?>
                    </p>
                    <p class="sub-text">
                      Posted:
                      <?php echo $date ?>
                    </p>
                    <button data-id="<?php echo $row['id'] ?>" class="btn btn-danger remove-listing-btn"
                      data-bs-toggle="modal" data-bs-target="#remove-listing-modal">Delete From History</button>
                    <!-- Note: When modifying the database at all use post method as it more secure -->
                    <button data-id="<?php echo $row['id'] ?>" class="btn btn-success relist-item-btn"
                      data-bs-toggle="modal" data-bs-target="#relisting-modal">Relist Item</button>
                  </div>
                </div>
              </div>
            </div>
            <?php
            }
            ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!-- View Offers modal -->
    <div id="view-offers-modal" class="modal fade" tabindex="-1" aria-labelledby="view-offers-modal" aria-hidden="true"
      role="dialog">
      <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Offers</h5>
          </div>
          <div class="modal-body">
            <?php
            $query = "SELECT items.*, offers.item_id, offers.offer_price, offers.offerer_id FROM items, offers WHERE items.rcsid = :rcsid and items.id = offers.item_id";
            $stmt = $dbconn->prepare($query);
            $stmt->bindValue(':rcsid', $_SESSION['user']);
            $stmt->execute();

            foreach ($stmt as $row) {
              $datetime = strtotime($row['date_posted']);
              $date = date('m-d-Y', $datetime);
            ?>

            <div class="card my-2">
              <div class="card-body">
                <div class="row">
                  <div class="col-3 sell-img-col-div">
                    <div class="ratio ratio-1x1">
                      <img src=".<?php echo $row['image1'] ?>" class="img-thumbnail sell-img" alt="...">
                    </div>
                  </div>
                  <div class="col">
                    <h4 class="body-large"><strong>
                        <?php echo $row['title'] ?>
                      </strong></h4>
                    <p class="body-text">
                      Offered Price:
                      $
                      <?php echo $row['offer_price'] ?>
                    </p>
                    <p class="sub-text">
                      Posted:
                      <?php echo $date ?>
                    </p>
                    <button data-id="<?php echo $row['id'] ?>" data-id2="<?php echo $row['offerer_id'] ?>"
                      class="btn btn-danger decline-offer-btn" data-bs-toggle="modal"
                      data-bs-target="#decline-offer-modal">Decline Offer</button>
                    <!-- Note: When modifying the database at all use post method as it more secure -->
                    <button data-id="<?php echo $row['id'] ?>" data-id2="<?php echo $row['offerer_id'] ?>"
                      class="btn btn-success accept-offer-btn" data-bs-toggle="modal"
                      data-bs-target="#accept-offer-modal">Accept Offer</button>
                  </div>
                </div>
              </div>
            </div>
            <?php
            }
            ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <div class="seller-dash-pill p-3">
      <h3 class="sec-head-2">Current Listings</h3>
      <?php

      $query = "SELECT * FROM items WHERE rcsid = :rcsid and sold = false";
      $stmt = $dbconn->prepare($query);
      $stmt->bindValue(':rcsid', $_SESSION['user']);
      $stmt->execute();
      foreach ($stmt as $row) {
        $datetime = strtotime($row['date_posted']);
        $date = date('m-d-Y', $datetime);
      ?>

      <div class="card my-2">
        <div class="card-body">
          <div class="row">
            <div class="col-3 sell-img-col-div">
              <div class="ratio ratio-1x1">
                <img src=".<?php echo $row['image1'] ?>" class="img-thumbnail sell-img" alt="...">
              </div>
            </div>
            <div class="col">
              <h4 class="body-large"><strong>
                  <?php echo $row['title'] ?>
                </strong></h4>
              <p class="body-text">
                $
                <?php echo $row['price'] ?>
              </p>
              <p class="sub-text">
                Posted:
                <?php echo $date ?>
              </p>
              <p class="sub-text">
                Clicks on listing
                <?php echo $row['item_views'] ?>
              </p>
              <button data-id="<?php echo $row['id'] ?>" class="btn btn-danger remove-listing-btn"
                data-bs-toggle="modal" data-bs-target="#remove-listing-modal">Delete Listing</button>
              <!-- Note: When modifying the database at all use post method as it more secure -->
              <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#listing-modal"
                onclick="setToEdit(this)" id="<?php echo $row['id'] ?>" value="<?php echo $row['id'] ?>">Edit
                Listing</button>
              <div class="d-none">
                <input type="text" class="form-control" id="title-<?php echo $row['id'] ?>"
                  value="<?php echo $row['title'] ?>">
                <input type="text" class="form-control" id="price-<?php echo $row['id'] ?>"
                  value="<?php echo $row['price'] ?>">
                <input type="text" class="form-control" id="item_condition-<?php echo $row['id'] ?>"
                  value="<?php echo $row['item_condition'] ?>">
                <input type="text" class="form-control" id="category-<?php echo $row['id'] ?>"
                  value="<?php echo $row['category'] ?>">
                <input type="text" class="form-control" id="subcategory1-<?php echo $row['id'] ?>"
                  value="<?php echo $row['subcategory1'] ?>">
                <input type="text" class="form-control" id="subcategory2-<?php echo $row['id'] ?>"
                  value="<?php echo $row['subcategory2'] ?>">
                <input type="text" class="form-control" id="item_description-<?php echo $row['id'] ?>"
                  value="<?php echo $row['item_description'] ?>">
              </div>
            </div>
          </div>
        </div>
      </div>

      <?php
      }

      if (isset($_POST['delete-lisitng'])) {
        $itemid = $_POST['delete-lisitng'];
        $query = "DELETE FROM items WHERE id = :itemid";
        $stmt = $dbconn->prepare($query);
        $stmt->bindValue(':itemid', $itemid);
        $stmt->execute();
        $stmt2 = $dbconn->prepare($query2);
        $redirect_URI = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/iit/Final/list-item.php";
        echo ("<script>location.href = '$redirect_URI';</script>");
      }
      if (isset($_POST['relist-lisitng'])) {
        $itemid = $_POST['relist-lisitng'];
        $query = "UPDATE items SET sold = false WHERE id = :itemid";
        $query2 = "DELETE FROM sold WHERE item_id = :itemid";
        $stmt = $dbconn->prepare($query);
        $stmt2 = $dbconn->prepare($query2);
        $stmt->bindValue(':itemid', $itemid);
        $stmt2->bindValue(':itemid', $itemid);
        $stmt->execute();
        $stmt2->execute();
        $redirect_URI = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/iit/Final/list-item.php";
        echo ("<script>location.href = '$redirect_URI';</script>");
      }
      if (isset($_POST['accept-offer'])) {
        $itemid = $_POST['accept-offer'];
        $offerer_id = $_POST['accept-offer-user'];
        $query = "UPDATE items SET sold = true WHERE id = :itemid";
        $query2 = "INSERT INTO sold(buyer_id, item_id, purchase_price) SELECT offerer_id, item_id, offer_price FROM offers WHERE item_id = :itemid and offerer_id = :offererid;";
        $query3 = "DELETE FROM offers WHERE item_id = :itemid;";
        $stmt = $dbconn->prepare($query);
        $stmt2 = $dbconn->prepare($query2);
        $stmt3 = $dbconn->prepare($query3);
        $stmt->bindValue(':itemid', $itemid);
        $stmt2->bindValue(':itemid', $itemid);
        $stmt2->bindValue(':offererid', $offerer_id);
        $stmt3->bindValue(':itemid', $itemid);
        $stmt->execute();
        $stmt2->execute();
        $stmt3->execute();
        $redirect_URI = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/iit/Final/list-item.php";
        echo ("<script>location.href = '$redirect_URI';</script>");
      }
      if (isset($_POST['decline-offer'])) {
        $itemid = $_POST['decline-offer'];
        $offerer_id = $_POST['decline-offer-user'];
        $query = "DELETE FROM offers WHERE item_id = :itemid and offerer_id = :offererid";
        $stmt = $dbconn->prepare($query);
        $stmt->bindValue(':itemid', $itemid);
        $stmt->bindValue(':offererid', $offerer_id);
        $stmt->execute();
        $redirect_URI = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/iit/Final/list-item.php";
        echo ("<script>location.href = '$redirect_URI';</script>");
      }
      ?>
    </div>
  </section>
  <!-- Remove listing modal -->
  <div class="modal fade" tabindex="-1" id="remove-listing-modal" aria-labelledby="remove-listing-modal"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirm Removal</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to remove this listing? This action is not reversible.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <form action="list-item.php" method="post">
            <input type="hidden" name="delete-lisitng" id="delete-listing" />
            <button type="submit" class="btn btn-danger">Remove Listing</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Relist Item modal -->
  <div class="modal fade" tabindex="-1" id="relisting-modal" aria-labelledby="relisting-modal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirm Relisting</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to relisting this item?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <form action="list-item.php" method="post">
            <input type="hidden" name="relist-lisitng" id="relist-listing" />
            <button type="submit" class="btn btn-success">Relist Listing</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Accept listing modal -->
  <div class="modal fade" tabindex="-1" id="accept-offer-modal" aria-labelledby="accept-offer-modal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Accept Offer</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to accept this offer?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <form action="list-item.php" method="post">
            <input type="hidden" name="accept-offer" id="accept-offer" />
            <input type="hidden" name="accept-offer-user" id="accept-offer-user" />
            <button type="submit" class="btn btn-success">Accept</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!--  Decline Offer modal -->
  <div class="modal fade" tabindex="-1" id="decline-offer-modal" aria-labelledby="decline-offer-modal"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Decline Offer</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to decline this offer?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <form action="list-item.php" method="post">
            <input type="hidden" name="decline-offer-user" id="decline-offer-user" />
            <input type="hidden" name="decline-offer" id="decline-offer" />
            <button type="submit" class="btn btn-danger">Decline Offer</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Listing item modal -->
  <div class="modal fade" id="listing-modal" tabindex="-1" aria-labelledby="listing-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title list-item-modal" id="listing-modal"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row d-flex justify-content-center align-items-center">
            <div class="col">
              <div class="card custom-card">
                <div class="card-body">
                  <div class="row justify-content-center">
                    <div class="col">
                      <form action="list-item.php" method="post" enctype="multipart/form-data">
                        <!-- Title of item -->
                        <div class="input-group py-2">
                          <span class="input-group-text">
                            <i class="bi bi-card-text"></i>
                          </span>
                          <input id="post-item-title" name="post-item-title" type="text" class="form-control"
                            placeholder="Title" maxlength="15" required />
                        </div>
                        <!-- Price of item -->
                        <div class="input-group py-2">
                          <span class="input-group-text">
                            <i class="bi bi-tags"></i></span>
                          <input id="post-item-price" name="post-item-price" type="number" min="1" max="999999"
                            class="form-control" placeholder="Price" required />
                        </div>
                        <!-- Condition of item -->
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
                        <!-- Category -->
                        <div class="d-flex flex-row" id="category-div">
                          <div class="input-group py-2">
                            <span class="input-group-text">
                              <i class="bi bi-basket-fill"></i>
                            </span>
                            <select name="post-item-category" id="category" class="form-select" required>
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
                          <div class="input-group py-2" id = "subcat1-div">
                            <span class="input-group-text">
                              <i class="bi bi-basket-fill"></i>
                            </span>
                            <select name="post-item-subcategory" id="subcategory-1" class="form-select" required>
                              <option selected disabled>Select Subcategory</option>
                            </select>
                          </div>
                          <!-- Subcategory -->
                          <div class="input-group py-2" id = "subcat2-div">
                            <span class="input-group-text">
                              <i class="bi bi-basket-fill"></i>
                            </span>
                            <select name="post-item-subcategory-2" id="subcategory-2" class="form-select" required>
                              <option selected disabled>Select Subcategory</option>
                            </select>
                          </div>
                        </div>
                        <!-- Description -->
                        <div class="input-group py-2">
                          <span class="input-group-text"><i class="bi bi-pencil-square"></i></span>
                          <textarea class="form-control" name="post-item-description" id="post-item-description"
                            maxlength="100" style="resize: none;" placeholder="Description" autocomplete="off"
                            required></textarea>
                        </div>
                        <!-- Images -->
                        <label for="uploadimg" class="form-label" id="image-up-label">Upload Up to Three Images</label>
                        <div class="input-group py-2" id="image-up-input">
                          <input class="form-control" type="file" name="post-item-uploadimgs[]" accept="image/jpg"
                            multiple required />
                        </div>
                        <!-- Submit Button -->
                        <div class="center-button py-4" id="submit-button-div">
                          <button type="submit" name="post-item" class="btn btn-primary" id="list-or-edit-button">
                          </button>
                        </div>
                        <div class="d-none">
                          <input type="text" class="form-control" name="id-placeholder-row" id="id-placeholder-row"
                            value="<?php echo $row['id'] ?>">
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php

  if (isset($_POST["post-item"])) {

    $rcsid = phpCAS::getUser();
    $title = htmlspecialchars(trim($_POST['post-item-title']));
    $price = htmlspecialchars(trim($_POST['post-item-price']));
    $condition = htmlspecialchars(trim($_POST['post-item-condition']));
    $category = htmlspecialchars(trim($_POST['post-item-category']));
    $subcategory = htmlspecialchars(trim($_POST['post-item-subcategory']));
    $subcategory_2 = htmlspecialchars(trim($_POST['post-item-subcategory-2']));
    $date = date("Y-m-d H:i:s");
    $description = htmlspecialchars(trim($_POST['post-item-description']));
    $file_array = $_FILES['post-item-uploadimgs'];
    $new_file_paths = array();
    if (!empty(array_filter($file_array['name']))) {
      $i = 0;
      define('SITE_ROOT', realpath(dirname(__FILE__)));
      while ($i < 4 && $i < count($file_array['name'])) {
        $file_name = $file_array['name'][$i];
        $file_size = $file_array['size'][$i];
        $file_error = $file_array['error'][$i];
        $file_type = $file_array['type'][$i];
        $check_file = mime_content_type($file_array['tmp_name'][$i]);
        if ($check_file !== "image/jpeg") {
          echo "<script> alert('Error: File type not supported. Please upload a JPEG/JPG file.')</script>";
          exit();
        }
        if ($file_error !== 0) {
          echo "<script> alert('Error: There was an error uploading your file.')</script>";
          exit();
        }
        if ($file_size > 1000000) {
          echo "<script> alert('Error: The file size was too large.')</script>";
          exit();
        }
        $new_file_name = uniqid('', true) . ".jpeg";
        $new_file_location = '/resources/images/' . $new_file_name;
        $file_moved = move_uploaded_file($file_array['tmp_name'][$i], SITE_ROOT . $new_file_location);
        $new_file_paths[$i] = $new_file_location;
        $i++;
        if ($file_moved == false) {
          echo "<script> alert('Error: There was an error uploading your file to the server.')</script>";
          exit();
        }
      }
    } else {
      echo "<script> alert('No Files Uploaded.')</script>";
      exit();
    }

    if (count($new_file_paths) == 3) {
      $new_file_path1 = $new_file_paths[0];
      $new_file_path2 = $new_file_paths[1];
      $new_file_path3 = $new_file_paths[2];
      $query = "INSERT INTO items(rcsid, title, price, item_condition, category, subcategory1, subcategory2, date_posted, item_description, image1, image2, image3) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
      $stmt = $dbconn->prepare($query);
      $stmt->execute([$rcsid, $title, $price, $condition, $category, $subcategory, $subcategory_2, $date, $description, $new_file_path1, $new_file_path2, $new_file_path3]);
      $redirect_URI = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/iit/Final/list-item.php";
      echo ("<script>location.href = '$redirect_URI';</script>");
    } elseif (count($new_file_paths) == 2) {
      $new_file_path1 = $new_file_paths[0];
      $new_file_path2 = $new_file_paths[1];
      $query = "INSERT INTO items(rcsid, title, price,   item_condition, category, subcategory1, subcategory2, date_posted, item_description, image1, image2) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
      $stmt = $dbconn->prepare($query);
      $stmt->execute([$rcsid, $title, $price, $condition, $category, $subcategory, $subcategory_2, $date, $description, $new_file_path1, $new_file_path2]);
      $redirect_URI = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/iit/Final/list-item.php";
      echo ("<script>location.href = '$redirect_URI';</script>");
    } else {
      $new_file_path1 = $new_file_paths[0];
      $query = "INSERT INTO items(rcsid, title, price, item_condition, category, subcategory1, subcategory2, date_posted, item_description, image1) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
      $stmt = $dbconn->prepare($query);
      $stmt->execute([$rcsid, $title, $price, $condition, $category, $subcategory, $subcategory_2, $date, $description, $new_file_path1]);
      $redirect_URI = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/iit/Final/list-item.php";
      echo ("<script>location.href = '$redirect_URI';</script>");
    }
  }
  ?>

  <?php

  if (isset($_POST["edit-item"])) {

    $rcsid = phpCAS::getUser();
    $title = htmlspecialchars(trim($_POST['post-item-title']));
    $price = htmlspecialchars(trim($_POST['post-item-price']));
    $condition = htmlspecialchars(trim($_POST['post-item-condition']));
    $category = htmlspecialchars(trim($_POST['post-item-category']));
    $subcategory = htmlspecialchars(trim($_POST['post-item-subcategory']));
    $subcategory_2 = htmlspecialchars(trim($_POST['post-item-subcategory-2']));
    $rowID = htmlspecialchars(trim($_POST['id-placeholder-row']));
    $date = date("Y-m-d H:i:s");
    $description = htmlspecialchars(trim($_POST['post-item-description']));
    $file_array = $_FILES['post-item-uploadimgs'];
    $new_file_paths = array();
    if (!empty(array_filter($file_array['name']))) {
      $i = 0;
      while ($i < 4 && $i < count($file_array['name'])) {
        $file_name = $file_array['name'][$i];
        $file_tmp_location = $file_array['tmp_name'][$i];
        $file_size = $file_array['size'][$i];
        $file_error = $file_array['error'][$i];
        $file_type = $file_array['type'][$i];
        if ($file_error === 0) {
          if ($file_size < 1000000) {
            $new_file_name = uniqid('', true) . ".jpg";
            $new_file_location = '/resources/images/' . $new_file_name;
            move_uploaded_file($file_tmp_location, $new_file_location);
            $new_file_paths[$i] = $new_file_location;
          } else {
            echo "<script> alert('The file size was too large.')</script>";
            exit();
          }
        } else {
          // echo "<script> alert('There was an error uploading your file.')</script>";
          echo "<script> alert('There was an error uploading your file.')</script>";
          exit();
        }
        $i++;
      }
    } else {
      echo "<script> alert('No Files Uploaded.')</script>";
      exit();
    }

    if (count($new_file_paths) == 3) {
      $new_file_path1 = $new_file_paths[0];
      $new_file_path2 = $new_file_paths[1];
      $new_file_path3 = $new_file_paths[2];
      $query = "UPDATE items SET title = '$title', price = '$price', item_condition = '$condition', category = '$category', subcategory1 = '$subcategory', subcategory2 = '$subcategory_2', item_description = '$description', image1 = '$new_file_path1', image2 = '$new_file_path2', image3 = '$new_file_path3' WHERE id = '$rowID';";
      $stmt = $dbconn->prepare($query);
      $stmt->execute();
      $redirect_URI = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/iit/Final/list-item.php";
      echo ("<script>location.href = '$redirect_URI';</script>");
    } elseif (count($new_file_paths) == 2) {
      $new_file_path1 = $new_file_paths[0];
      $new_file_path2 = $new_file_paths[1];
      $query = "UPDATE items SET title = '$title', price = '$price', item_condition = '$condition', category = '$category', subcategory1 = '$subcategory', subcategory2 = '$subcategory_2', item_description = '$description', image1 = '$new_file_path1', image2 = '$new_file_path2' WHERE id = '$rowID';";
      $stmt = $dbconn->prepare($query);
      $redirect_URI = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/iit/Final/list-item.php";
      echo ("<script>location.href = '$redirect_URI';</script>");
      $stmt->execute();
    } else {
      $new_file_path1 = $new_file_paths[0];
      $query = "UPDATE items SET title = '$title', price = '$price', item_condition = '$condition', category = '$category', subcategory1 = '$subcategory', subcategory2 = '$subcategory_2', item_description = '$description', image1 = '$new_file_path1' WHERE id = '$rowID';";
      $stmt = $dbconn->prepare($query);
      $stmt->execute();
      $redirect_URI = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/iit/Final/list-item.php";
      echo ("<script>location.href = '$redirect_URI';</script>");
    }
  }

  ?>
  <!-- Site Footer -->
  <?php include 'footer.php' ?>
</body>

</html>
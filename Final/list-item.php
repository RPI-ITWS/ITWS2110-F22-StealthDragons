<!DOCTYPE html>
<html lang="en-US">
<?php include 'head.php' ?>

<body>
  <?php include 'header.php' ?>

  <section class="container-xxl">
    <h2 class="sec-head-1 text-center pt-5">Seller Dashboard
    </h2>
    <div class="text-end">
      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#listing-modal">Create
        Listing</button>
    </div>
    <div class="seller-dash-pill row p-3 my-3">
      <h3 class="sec-head-2">Pending Sales</h3>
      <div class="col">
        <div class="card">
          <div class="card-body">View Sold Items <i class="bi bi-bag p-2"></i></i></div>
        </div>
      </div>
      <div class="col">
        <div class="card">
          <div class="card-body">View Offers<i class="bi bi-receipt p-2"></i></div>
        </div>
      </div>
    </div>
    <div class="seller-dash-pill p-3">
      <h3 class="sec-head-2">Current Listings</h3>
      <?php
      try {
        $query = "SELECT * FROM items WHERE rcsid = :rcsid";
        $stmt = $dbconn->prepare($query);
        $stmt->bindValue(':rcsid', $_SESSION['user']);
        $stmt->execute();
        foreach ($stmt as $row) {
          $datetime = strtotime($row['date_posted']);
          $date = date('Y-m-d', $datetime);
      ?>

      <div class="card my-2">
        <div class="card-body">
          <div class="row">
            <div class="col-3">
              <img src="<?php echo $row['image1'] ?>" class="img-thumbnail sell-img" alt="...">
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
                <?php echo 1 #add clicks when added to db ?>
              </p>
              <form action="list-item.php" method="post" class="d-inline-block me-2">
                <button name="delete-btn" class="btn btn-danger" value="<?php echo $row['id'] ?>">Remove Item</button>
              </form>
              <!-- Note: When modifying the database at all use post method as it more secure -->
              <button class="btn btn-secondary">Edit Listing</button>
            </div>
          </div>
        </div>
      </div>

      <?php
        }
      } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      }
      if (isset($_POST['delete-btn'])) {
        $itemid = $_POST['delete-btn'];
        try {
          $query = "DELETE FROM items WHERE id = :itemid";
          $stmt = $dbconn->prepare($query);
          $stmt->bindValue(':itemid', $itemid);
          $stmt->execute();
          header("Location: list-item.php");
        } catch (PDOException $e) {
          echo "Error: " . $e->getMessage();
        }
      }
      ?>
    </div>
  </section>


  <div class="modal fade" id="listing-modal" tabindex="-1" aria-labelledby="listing-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="listing-modal">List an Item</h5>
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
                          <input name="post-item-title" type="text" class="form-control" placeholder="Title" required />
                        </div>
                        <!-- Price of item -->
                        <div class="input-group py-2">
                          <span class="input-group-text">
                            <i class="bi bi-tags"></i></span>
                          <input name="post-item-price" type="number" min="1" max="999999" class="form-control"
                            placeholder="Price" required />
                        </div>
                        <!-- Condition of item -->
                        <div class="input-group py-2">
                          <span class="input-group-text">
                            <i class="bi bi-search-heart"></i>
                          </span>
                          <select name="post-item-condition" id="condition" class="form-select" required>
                            <option selected disabled>Select Condition of Item</option>
                            <option value="new">New</option>
                            <option value="like-new">Like New</option>
                            <option value="good">Good</option>
                            <option value="fair">Fair</option>
                            <option value="poor">Poor</option>
                          </select>
                        </div>
                        <!-- Category -->
                        <div class="d-flex flex-row">
                          <div class="input-group py-2">
                            <span class="input-group-text">
                              <i class="bi bi-basket-fill"></i>
                            </span>
                            <select name="post-item-category" id="category" class="form-select" required>
                              <option selected disabled>Select Category</option>
                              <?php
                              try {
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
                              } catch (PDOException $e) {
                                echo "<script> alert('Error: " . $e->getMessage() . "')</script>";
                              }
                              ?>
                            </select>
                          </div>
                          <!-- Subcategory -->
                          <div class="input-group py-2">
                            <span class="input-group-text">
                              <i class="bi bi-basket-fill"></i>
                            </span>
                            <select name="post-item-subcategory" id="subcategory-1" class="form-select" required>
                              <option selected disabled>Select Subcategory</option>
                            </select>
                          </div>
                          <!-- Subcategory -->
                          <div class="input-group py-2">
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
                            maxlength="100" style="resize: none;" placeholder="Description" required></textarea>
                        </div>
                        <!-- Images -->
                        <label for="uploadimg" class="form-label">Upload Up to Three Images</label>
                        <div class="input-group py-2">
                          <input class="form-control" type="file" name="post-item-uploadimgs[]" accept="image/jpg"
                            multiple required />
                        </div>
                        <!-- Submit Button -->
                        <div class="center-button py-4">
                          <button type="submit" name="post-item" class="btn btn-primary">
                            List your Item!
                          </button>
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
  try {
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
        $query = "INSERT INTO items(rcsid, title, price, item_condition, category, subcategory1, subcategory2, date_posted, item_description, image1, image2, image3) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
        $stmt = $dbconn->prepare($query);
        $stmt->execute([$rcsid, $title, $price, $condition, $category, $subcategory, $subcategory_2, $date, $description, $new_file_path1, $new_file_path2, $new_file_path3]);
        header("Location: list-item.php");
      } elseif (count($new_file_paths) == 2) {
        $new_file_path1 = $new_file_paths[0];
        $new_file_path2 = $new_file_paths[1];
        $query = "INSERT INTO items(rcsid, title, price, item_condition, category, subcategory1, subcategory2, date_posted, item_description, image1, image2) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
        $stmt = $dbconn->prepare($query);
        header("Location: list-item.php");
        $stmt->execute([$rcsid, $title, $price, $condition, $category, $subcategory, $subcategory_2, $date, $description, $new_file_path1, $new_file_path2]);
      } else {
        $new_file_path1 = $new_file_paths[0];
        $query = "INSERT INTO items(rcsid, title, price, item_condition, category, subcategory1, subcategory2, date_posted, item_description, image1, image2, image3) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
        $stmt = $dbconn->prepare($query);
        $stmt->execute([$rcsid, $title, $price, $condition, $category, $subcategory, $subcategory_2, $date, $description, $new_file_path1]);
        header("Location: list-item.php");
      }
    }
  } catch (PDOException $e) {
    echo "Error: " . $e;
  }
  ?>
  <!-- Site Footer -->
  <footer></footer>
</body>

</html>
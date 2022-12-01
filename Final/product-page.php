<!DOCTYPE html>
<html lang="en-US">
<?php include 'head.php' ?>

<body>
  <?php include 'header.php' ?>
  <!-- product details section -->
  <section class="container-xxl pt-5">
    <h2 class="sec-head-1 pb-3">Spongebob Chair</h2>
    <div class="row">
      <div class="col-md">
        <img
          src="https://secure.img1-cg.wfcdn.com/im/16817007/c_crop-h680-w680%5Ecompr-r85/1127/112745653/default_name.jpg"
          alt="Current Product" id="current-img" class="rounded main-product mb-4" />
        <div class="row">
          <div class="col">
            <img
              src="https://secure.img1-cg.wfcdn.com/im/16817007/c_crop-h680-w680%5Ecompr-r85/1127/112745653/default_name.jpg"
              alt="" class="img-thumbnail rounded inactive-thumbnail active-thumbnail" />
          </div>
          <div class="col">
            <img
              src="https://secure.img1-cg.wfcdn.com/im/66981137/c_crop-h680-w680%5Ecompr-r85/2046/204656991/default_name.jpg"
              alt="" class="img-thumbnail rounded inactive-thumbnail" />
          </div>
          <div class="col">
            <img
              src="https://secure.img1-cg.wfcdn.com/im/80960585/c_crop-h680-w680%5Ecompr-r85/1133/113328372/default_name.jpg"
              alt="" class="img-thumbnail rounded inactive-thumbnail" />
          </div>
        </div>
      </div>
      <div class="col-md ms-5">
        <h3 class="sec-head-1 pb-1">Listed Price</h3>
        <h2 class="sec-head-2"><strong>$200</strong></h2>
        <div class="row py-4">
          <div class="col">
            <button class="btn btn-success product-btn">Buy Now</button>
          </div>
          <div class="col d-flex justify-content-start">
            <button class="btn btn-secondary product-btn">Make Offer</button>
          </div>
        </div>
        <div>
          <p class="body-text py-1">
            <strong class="pe-3">Condition</strong> Used Like New
          </p>
          <p class="body-text py-1">
            <strong class="pe-3">Category</strong> Furniture, Seating, Chairs
          </p>
          <p class="body-text py-1">
            <strong class="pe-3">Tags</strong> #chair #spongebob #super
          </p>
          <p class="body-text py-1">
            <strong class="pe-3">Posted</strong> 10/14/2022
          </p>
          <p class="body-large strong pt-1">
            <strong class="pe-3">Description</strong>
          </p>
          <p class="body-text">
            This is a super cool Spongebob chair. It is comfy and is good for
            gaming. Price is solid.
          </p>
        </div>
      </div>
    </div>
  </section>
  <!-- Similar Items Section -->
  <section class="container-xxl pb-5">
    <h3 class="sec-head-2 pb-3">Similar Items</h3>
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
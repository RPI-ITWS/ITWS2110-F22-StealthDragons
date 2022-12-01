<!DOCTYPE html>
<html lang="en-US">
<?php include 'head.php' ?>

<body>
  <?php include 'header.php' ?>

  <section class="container-xxl">
    <h2 class="sec-head-1 text-center pt-5">Seller Dashboard <button class="btn btn-success float-end"
        data-bs-toggle="modal" data-bs-target="#listing-modal">Create Listing</button></h2>
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
    <div class="seller-dash-pill row p-3">
      <h3 class="sec-head-2">Current Listings</h3>
      <div class="col">
        <div class="card my-2">
          <div class="card-body">
            <div class="row">
              <div class="col-3">
                <img class="img-thumbnail sell-img"
                  src="https://ashleyfurniture.scene7.com/is/image/AshleyFurniture/B600001175_1?$AFHS-PDP-Zoomed$"
                  alt="">
              </div>
              <div class="col">
                <h4 class="body-large"><strong>Spongebob Chair</strong></h4>
                <p class="body-text">$200</p>
                <p class="sub-text">Posted 10/14/2022</p>
                <p class="sub-text">Clicks on listing: <strong>10</strong></p>
                <button class="btn btn-danger">Remove Item</button>
                <button class="btn btn-secondary ms-2">Edit Listing</button>
              </div>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card my-2">
            <div class="card-body">
              <div class="row">
                <div class="col-3">
                  <img class="img-thumbnail sell-img" src="resources/images/textbook2.jpg" alt="">
                </div>
                <div class="col">
                  <h4 class="body-large"><strong>Electrical Engineering Textbooks</strong></h4>
                  <p class="body-text">$30</p>
                  <p class="sub-text">Posted 10/14/2022</p>
                  <p class="sub-text">Clicks on listing: <strong>100</strong></p>
                  <button class="btn btn-danger">Remove Item</button>
                  <button class="btn btn-secondary ms-2">Edit Listing</button>
                </div>
              </div>
            </div>
          </div>
        </div>
  </section>


  <div class="modal fade" id="listing-modal" tabindex="-1" aria-labelledby="listing-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="listing-modal">Sell an Item</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row d-flex justify-content-center align-items-center">
            <div class="col">
              <div class="card custom-card">
                <div class="card-body">
                  <div class="row justify-content-center">
                    <div class="col">
                      <form>

                        <label for="uploadFiles" class="form-label">Upload Images</label>

                        <div class="input-group py-2">
                          <input class="form-control" type="file" id="uploadFiles" multiple />
                        </div>

                        <div class="input-group py-2">
                          <span class="input-group-text">
                            <i class="bi bi-card-text"></i>
                          </span>
                          <input type="text" class="form-control" placeholder="Title" />
                        </div>

                        <div class="input-group py-2">
                          <span class="input-group-text">
                            <i class="bi bi-tags"></i></span>
                          <input type="email" class="form-control" placeholder="Price" />
                        </div>

                        <div class="input-group py-2">
                          <span class="input-group-text">
                            <i class="bi bi-basket-fill"></i>
                          </span>
                          <input type="text" class="form-control" placeholder="Category" />
                        </div>

                        <div class="input-group py-2">
                          <span class="input-group-text">
                            <i class="bi bi-hash"></i>
                          </span>
                          <input type="text" class="form-control" placeholder="Tags" />
                        </div>
                        <div class="center-button py-4">
                          <button type="button" class="btn btn-primary">
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
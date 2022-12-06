<!DOCTYPE html>
<html lang="en-US">

<?php include 'head.php' ?>

<body>
    <?php include 'header.php' ?>
    <section class="container-xxl">
        <h2 class="sec-head-1 text-center pt-5">Buyer Dashboard</h2>
        <div class="seller-dash-pill row p-3 my-3">
            <h3 class="sec-head-2 pb-3"><b>History</b></h3>
            <div class="col-md">
                <h3 class="body-large">Purchases</h3>
                <?php
                $query = "SELECT sold.item_id, sold.purchase_price, items.*  FROM sold, items WHERE sold.buyer_id = :user AND sold.item_id = items.id";
                $stmt = $dbconn->prepare($query);
                $stmt->bindValue(':user', $_SESSION['user']);
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
                                    Purchase Amount: 
                                    $<?php echo $row['purchase_price'] ?>
                                </p>
                                <p class="sub-text">
                                    Posted:
                                    <?php echo $date ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
            <div class="col-md">
                <h3 class="body-large">Offers</h3>
                <?php
                $query = "SELECT offers.offerer_id, offers.offer_price, items.*  FROM offers, items WHERE offers.offerer_id = :user AND offers.item_id = items.id";
                $stmt = $dbconn->prepare($query);
                $stmt->bindValue(':user', $_SESSION['user']);
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
                                    Offer: $<?php echo $row['offer_price'] ?>
                                </p>
                                <p class="sub-text">
                                    Posted:
                                    <?php echo $date ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>

        </div>
    </section>



    <?php include 'footer.php' ?>
</body>

</html>
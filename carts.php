<?php
session_start();
$count = 0;
if (isset($_SESSION["shopping_cart"])) {
    $count = count($_SESSION["shopping_cart"]);
}
$cart_items = (isset($_SESSION["shopping_cart"])) ? $_SESSION["shopping_cart"] : array();
$total_price = 0
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <!-- bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <!-- using cdn link for bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

</head>
<body>
<section class="h-100 h-custom" style="background-color: #eee;">

    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col">
                <div class="card">
                    <div class="card-body p-4">

                        <div class="row">

                            <div class="col-lg-7">
                                <h5 class="mb-3"><a href="home.php" class="text-body"><i
                                            class="fas fa-long-arrow-alt-left me-2"></i>Continue shopping</a></h5>
                                <hr>

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div>
                                        <p class="mb-1">Shopping cart</p>
                                        <p class="mb-0">You have <?php echo $count ?> items in your cart</p>
                                    </div>
<!--                                    <div>-->
<!--                                        <p class="mb-0"><span class="text-muted">Sort by:</span> <a href="#!"-->
<!--                                                                                                    class="text-body">price <i class="fas fa-angle-down mt-1"></i></a></p>-->
<!--                                    </div>-->
                                </div>

                                <?php foreach($cart_items as $item)
                                {
                                    ?>

                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex flex-row align-items-center">
                                                    <div>
                                                        <img
                                                                src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-shopping-carts/img1.webp"
                                                                class="img-fluid rounded-3" alt="Shopping item" style="width: 65px;">
                                                    </div>
                                                    <div class="ms-3">
                                                        <h5><?php echo $item['product_name'] ?></h5>
                                                        <p class="small mb-0"><?php echo $item['product_description'] ?></p>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-row align-items-center">
                                                    <div style="width: 50px;">
                                                        <h5 class="fw-normal mb-0"><?php echo $item['product_quantity'] ?></h5>
                                                    </div>
                                                    <div style="width: 80px;">
                                                        <h5 class="mb-0">$<?php echo $item['product_price']; $total_price += $item['product_quantity'] * $item['product_price'] ?></h5>
                                                    </div>
                                                    <a href="#!" style="color: #cecece;"><i class="fas fa-trash-alt"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                <?php } ?>
                                <div class="d-flex flex-row justify-content-end align-items-center">
                                    <div style="width: 80px;">
                                        <h5 class="mb-0"> Total Amount: $<?php echo $total_price; ?></h5>
                                    </div>
                                </div>

                            </div>

<!--                            for checkout feature uncomment this -->

<!--                            <div class="col-lg-5">-->
<!---->
<!--                                <div class="card bg-primary text-white rounded-3">-->
<!--                                    <div class="card-body">-->
<!--                                        <div class="d-flex justify-content-between align-items-center mb-4">-->
<!--                                            <h5 class="mb-0">Card details</h5>-->
<!--                                            <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp"-->
<!--                                                 class="img-fluid rounded-3" style="width: 45px;" alt="Avatar">-->
<!--                                        </div>-->
<!---->
<!--                                        <p class="small mb-2">Card type</p>-->
<!--                                        <a href="#!" type="submit" class="text-white"><i-->
<!--                                                class="fab fa-cc-mastercard fa-2x me-2"></i></a>-->
<!--                                        <a href="#!" type="submit" class="text-white"><i-->
<!--                                                class="fab fa-cc-visa fa-2x me-2"></i></a>-->
<!--                                        <a href="#!" type="submit" class="text-white"><i-->
<!--                                                class="fab fa-cc-amex fa-2x me-2"></i></a>-->
<!--                                        <a href="#!" type="submit" class="text-white"><i class="fab fa-cc-paypal fa-2x"></i></a>-->
<!---->
<!--                                        <form class="mt-4">-->
<!--                                            <div class="form-outline form-white mb-4">-->
<!--                                                <input type="text" id="typeName" class="form-control form-control-lg" siez="17"-->
<!--                                                       placeholder="Cardholder's Name" />-->
<!--                                                <label class="form-label" for="typeName">Cardholder's Name</label>-->
<!--                                            </div>-->
<!---->
<!--                                            <div class="form-outline form-white mb-4">-->
<!--                                                <input type="text" id="typeText" class="form-control form-control-lg" siez="17"-->
<!--                                                       placeholder="1234 5678 9012 3457" minlength="19" maxlength="19" />-->
<!--                                                <label class="form-label" for="typeText">Card Number</label>-->
<!--                                            </div>-->
<!---->
<!--                                            <div class="row mb-4">-->
<!--                                                <div class="col-md-6">-->
<!--                                                    <div class="form-outline form-white">-->
<!--                                                        <input type="text" id="typeExp" class="form-control form-control-lg"-->
<!--                                                               placeholder="MM/YYYY" size="7" id="exp" minlength="7" maxlength="7" />-->
<!--                                                        <label class="form-label" for="typeExp">Expiration</label>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                                <div class="col-md-6">-->
<!--                                                    <div class="form-outline form-white">-->
<!--                                                        <input type="password" id="typeText" class="form-control form-control-lg"-->
<!--                                                               placeholder="&#9679;&#9679;&#9679;" size="1" minlength="3" maxlength="3" />-->
<!--                                                        <label class="form-label" for="typeText">Cvv</label>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!---->
<!--                                        </form>-->
<!---->
<!--                                        <hr class="my-4">-->
<!---->
<!--                                        <div class="d-flex justify-content-between">-->
<!--                                            <p class="mb-2">Subtotal</p>-->
<!--                                            <p class="mb-2">$4798.00</p>-->
<!--                                        </div>-->
<!---->
<!--                                        <div class="d-flex justify-content-between">-->
<!--                                            <p class="mb-2">Shipping</p>-->
<!--                                            <p class="mb-2">$20.00</p>-->
<!--                                        </div>-->
<!---->
<!--                                        <div class="d-flex justify-content-between mb-4">-->
<!--                                            <p class="mb-2">Total(Incl. taxes)</p>-->
<!--                                            <p class="mb-2">$4818.00</p>-->
<!--                                        </div>-->
<!---->
<!--                                        <button type="button" class="btn btn-info btn-block btn-lg">-->
<!--                                            <div class="d-flex justify-content-between">-->
<!--                                                <span>$4818.00</span>-->
<!--                                                <span>Checkout <i class="fas fa-long-arrow-alt-right ms-2"></i></span>-->
<!--                                            </div>-->
<!--                                        </button>-->
<!---->
<!--                                    </div>-->
<!--                                </div>-->
<!---->
<!--                            </div>-->

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</body>
</html>

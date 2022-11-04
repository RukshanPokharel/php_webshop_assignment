
<?php
include_once 'db_functions.php';
$queryFunction = new dbCrudFunctions();
session_start();

$cart_item_count = 0;
if(isset($_SESSION["shopping_cart"])) {
    $cart_item_count = count($_SESSION["shopping_cart"]);
}
// if Add to cart button is pressed
if(isset($_POST["add_to_cart"])){
    // if there is already product present in the shopping cart
    if(isset($_SESSION["shopping_cart"])) {
        $product_array_id = array_column($_SESSION["shopping_cart"], "product_id");
        if(!in_array($_GET["pid"], $product_array_id))  {
            $count = count($_SESSION["shopping_cart"]);
            $product_array = array(
                'product_id'       =>  $_GET["pid"],
                'product_name'     =>  $_POST["hidden_name"],
                'product_price'    =>  $_POST["hidden_price"],
                'product_quantity' =>  $_POST["quantity"],
                'product_description' =>  $_POST["hidden_description"]

            );
            $_SESSION["shopping_cart"][$count] = $product_array;

        }
        else{
            echo '<script>alert("product Already Added")</script>';
            echo '<script>window.location="home.php"</script>';
        }
    }
    else{
        $product_array = array(
            'product_id'       =>  $_GET["pid"],
            'product_name'     =>  $_POST["hidden_name"],
            'product_price'    =>  $_POST["hidden_price"],
            'product_quantity' =>  $_POST["quantity"],
            'product_description' =>  $_POST["hidden_description"]
        );
        $_SESSION["shopping_cart"][0] = $product_array;
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Web Shop</title>
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <!-- bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <!-- using cdn link for bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <link rel="stylesheet" href="custom.css">

</head>
<body>

<!-- navbar starts-->
<nav class="navbar navbar-expand-md navbar-light bg-light">
    <div class="container-xxl">
        <a href="/" class="navbar-brand">
            <img src="images/what.jpg" alt="" width="50" height="40" class="d-inline-block align-text-top">
            <span class="fw-bold text-secondary">
               Classic Store
            </span>
        </a>
        <!-- toggle button for mobile version navigation -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-nav" aria-controls="main-nav" aria-expanded="false" aria-label="toggle navigation">
            <span class="navbar-toggler-icon">
            </span>
        </button>

        <!-- navbar links -->
        <div class="collapse navbar-collapse justify-content-end align-center" id="main-nav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/products.html">products</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="carts.php">
                        <i class="bi bi-cart" style="font-size:24px"></i>
                        <span class='badge badge-warning' id='lblCartCount'> <?php echo $cart_item_count ?>  </span>
                        Cart
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!--- navbar ends --->


    <div class="container-lg">
        <h1 class="display-6 text-muted fw-bold"> Featured Products </h1>
        <div class="text-center">
            <p class="lead text-muted">
                Our best products list.
            </p>
        </div>

        <div class="row my-4 align-items-center justify-content-center">
    <?php
    $queryResult = $queryFunction->getAllProducts();
    foreach($queryResult as $product)
        {
            ?>
                    <div class="col-8 col-lg-4 col-xl-3">

                        <div class="card border-success">
                            <img src="<?php echo $product["image_src"]; ?>" class="card-img-top" alt="">
                            <div class="card-body text-center py-4">
                                <h5 class="card-title"><?php echo $product["product_name"]; ?></h5>
                                <p class="lead card-subtitle"><?php echo $product["price"]; ?></p>
                                <p class="card-text mx-5 text-muted"><?php echo $product["description"]; ?></p>
                                <form method="post" action="home.php?&action=add&pid=<?php echo $product["product_id"]; ?>"">
                                <input type="number" name="quantity" class="form-control" value="1" />
<!--                                <a href="carts.php" class="btn btn-outline-primary btn-lg mt-3">Add to cart</a>-->
                                <input type="submit" name="add_to_cart" class="btn btn-outline-primary btn-lg mt-3" value="Add to cart">
                                    <input type="hidden" name="hidden_name" value="<?php echo $product["product_name"]; ?>" />
                                    <input type="hidden" name="hidden_price" value="<?php echo $product["price"]; ?>" />
                                <input type="hidden" name="hidden_description" value="<?php echo $product["description"]; ?>" />

                                </form>
                            </div>
                        </div>

                    </div>

            <?php
        }
    ?>
        </div>
    </div>
</body>
</html>

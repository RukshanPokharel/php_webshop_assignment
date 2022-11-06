
<?php
include_once 'db_functions.php';
$queryFunction = new dbCrudFunctions();
session_start();

//print_r($_SESSION['login-type']);
//print_r($_SESSION['login']);

// destroying session variable to logout.
if(isset($_GET['logout'])){
    session_destroy();
    header("Location:login.php");
}

$cart_item_count = 0;

// if Add to cart button is pressed
if(isset($_POST["add_to_cart"])){

    // check if the user is logged in before adding items to the cart
    if (!isset($_SESSION['login'])){
        header("Location:login.php");
    }

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

if(isset($_SESSION["shopping_cart"])) {
    $cart_item_count = count($_SESSION["shopping_cart"]);
}


$subcategories = $queryFunction->getAllSubCategories();
$categories = $queryFunction->getAllCategories();

$products = null;
if (isset($_GET['id'])) {
    $products = $queryFunction->getAllProductsBySubCategory($_GET['id']);
}
else{
    header("Location:home.php");
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
    <!--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="custom.css">

</head>
<body>

<!-- navbar starts-->
<nav class="navbar navbar-expand-md navbar-light bg-light">
    <div class="container-xxl">
        <a href="home.php" class="navbar-brand">
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

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-auto-close="outside" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Categories
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php foreach ($categories as $category) { ?>
                            <li class="dropend">
                                <a class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" href="#"><?php echo $category['category_name']; ?></a>
                                <ul class="dropdown-menu">
                                    <?php foreach($subcategories as $subcategory){
                                        if ($subcategory['category_id'] == $category['category_id']){  ?>

                                            <li>
                                                <a class="dropdown-item" href="products.php?id=<?php echo $subcategory['sub_category_id']; ?>"><?php echo $subcategory['sub_category_name']; ?></a>
                                            </li>

                                        <?php } ?>

                                    <?php } ?>
                                </ul>

                            </li>
                        <?php } ?>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="products.php">products</a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="home.php?logout=true">Log-out</a>
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


                <li class="pl-1 nav-item">
                    <a class="nav-link" style="margin-left: 50px;" href="admin.php">Admin Panel</a>
                </li>

                <li class="pl-1 nav-item">
                    <a class="nav-link badge bg-secondary text-wrap font-monospace" style="width: 6rem; font-size: 15px; margin-left: 50px;" href="admin.php">Hi <?php if (isset($_SESSION['login'])) echo $_SESSION['user-name'];?></a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!--- navbar ends --->


<div class="container-lg">
    <h1 class="display-6 text-muted fw-bold"> Category Products </h1>
    <div class="text-center">
        <p class="lead text-muted">
            Our products according to your category choice.
        </p>
    </div>

    <div class="row my-4 align-items-center justify-content-center">
        <?php
        foreach($products as $product)
        {
            ?>
            <div class="col-8 col-lg-4 col-xl-3">

                <div class="card border-success">
                    <img src="<?php echo $product["image_src"]; ?>" class="card-img-top" alt="">
                    <div class="card-body text-center py-4">
                        <h5 class="card-title"><?php echo $product["product_name"]; ?></h5>
                        <p class="lead card-subtitle"><?php echo $product["price"]; ?></p>
                        <p class="card-text mx-5 text-muted"><?php echo $product["description"]; ?></p>
                        <form method="post" action="products.php?&action=add&pid=<?php echo $product["product_id"]; ?>"">
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

<!-- js scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>

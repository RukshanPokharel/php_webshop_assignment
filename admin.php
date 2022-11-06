
<?php
session_start();
require_once 'db_functions.php';
$db_action = new dbCrudFunctions();
if (!isset($_SESSION['login'])){
    header("Location:login.php");
}
else if($_SESSION['login-type'] == "user" ){
    header("Location:not_authorized.php");
}

//print_r($_SESSION['login-type']);
//print_r($_SESSION['login']);

$error_msg = '';
$success_message = '';

$error_msg_update = '';
$success_message_update = '';

// get all form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["productName"]) || empty($_POST["price"]) || empty($_POST["image"]) || empty($_POST["category"])){
        $error_msg = 'Product Name, Price and Image path and Category is mandatory';
    }
    else {
            $add_product = $db_action->addProduct($_POST["productName"], $_POST["price"], $_POST["image"], $_POST["description"] , $_POST["category"]);
            if ($add_product) {
                $success_message = "Successfully added products";
            } else {
                $error_msg = "Product addition failed. Please try again";
            }
    }
}

if (isset($_GET['delete'])){
   $db_action->deleteProduct($_GET['did']);
}

if (isset($_POST['formUpdate'])){
    if (empty($_POST["productNameUpdate"]) || empty($_POST["priceUpdate"]) || empty($_POST["imageUpdate"]) || empty($_POST["descriptionUpdate"]) || empty($_POST["categoryUpdate"])){
        $error_msg_update = 'Product Name, Price and Description is mandatory';
    }
    else {
        $update_product = $db_action->updateProduct( $_POST["pid"],  $_POST["productNameUpdate"], $_POST["priceUpdate"], $_POST["imageUpdate"], $_POST["descriptionUpdate"], $_POST["categoryUpdate"]);
        if ($update_product) {
            $success_message_update = "Successfully updated products";
            header("Location:admin.php");
        } else {
            $error_msg_update = "Product update failed. Please try again";
        }
    }
}

// fetch all subcategories
$subcategories = $db_action->getAllSubCategories();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Panel</title>
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <!-- bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <!-- using cdn link for bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

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
                    <a class="nav-link" href="home.php?logout=true">Log-out</a>
                </li>

                <li class="pl-1 nav-item">
                    <a class="nav-link" href="home.php">Home Page</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!--- navbar ends --->


<div class="container-lg">
    <div class="row justify-content-center align-center">

        <?php
        //validation messages for post
        if(!empty($success_message)){
            echo "<span class='text-xs text-success'>".$success_message."</span>";
        }
        if (!empty($error_msg)){
            echo "<span class='text-xs text-danger'>".$error_msg."</span>";
        }
        ?>

        <?php
        //validation messages for update
        if(!empty($success_message_update)){
            echo "<span class='text-xs text-success'>".$success_message_update."</span>";
        }
        if (!empty($error_msg_update)){
            echo "<span class='text-xs text-danger'>".$error_msg_update."</span>";
        }
        ?>

        <h1 class="display-5 text-center"> Add a new product </h1>
        <!-- form when the update button is clicked       -->
        <?php if (isset($_GET['update']))
        {
            $product = $db_action->getProductById($_GET['uid']);
            foreach($product as $item){
        ?>
        <form class="mt-2" action="" method="post">
            <div class="form-group mb-4">
                <label for="productName" class="form-label">Product Name</label>
                <input type="text" class="form-control" name="productNameUpdate" placeholder="Product Name" id="productName" value="<?php echo $item['product_name']; ?>">
            </div>
            <div class="form-group mb-4">
                <label for="category">Category</label>
                <!--                    <input type="text" class="form-control" id="userType" name="userType" placeholder="Password">-->
                <select class="form-select" name="categoryUpdate" aria-label="Default select example">
                    <option selected>Choose Category</option>
                    <?php foreach ($subcategories as $subcategory) {
                    ?>
                    <option value="<?php echo $subcategory['sub_category_id']; ?>"><?php echo $subcategory['sub_category_name'] ?></option>

                    <?php } ?>

                </select>
            </div>
            <div class="form-group mb-4">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description" name="descriptionUpdate" placeholder="Description" value="<?php echo $item['description']; ?>">
            </div>

            <div class="form-group mb-4">
                <label for="address">Price</label>
                <input type="text" class="form-control" id="price" name="priceUpdate" placeholder="Price" value="<?php echo $item['price']; ?>">
            </div>

            <div class="form-group mb-2">
                <label for="image" class="form-label">Image</label>
                <input type="hidden" class="form-control" name="imageUpdate" placeholder="Img src address" id="image" value="<?php echo $item['image_src']; ?>">
            </div>

            <input type="hidden" class="form-control" name="pid" placeholder="" id="pid" value="<?php echo $item['product_id']; ?>">

            <button type="submit" name="formUpdate" class="btn btn-primary">Submit</button>
        </form>
        <?php } } else { ?>

            <form class="mt-2" action="" method="post">
                <div class="form-group mb-4">
                    <label for="productName" class="form-label">Product Name</label>
                    <input type="text" class="form-control" name="productName" placeholder="Product Name" id="productName">
                </div>
                <div class="form-group mb-4">
                    <label for="category">Category</label>
                    <!--                    <input type="text" class="form-control" id="userType" name="userType" placeholder="Password">-->
                    <select class="form-select" name="category" aria-label="Default select example">
                        <option selected>Choose Category</option>
                        <?php foreach ($subcategories as $subcategory) {
                            ?>
                            <option value="<?php echo $subcategory['sub_category_id']; ?>"><?php echo $subcategory['sub_category_name'] ?></option>

                        <?php } ?>

                    </select>
                </div>
                <div class="form-group mb-4">
                    <label for="description">Description</label>
                    <input type="text" class="form-control" id="description" name="description" placeholder="Description">
                </div>

                <div class="form-group mb-4">
                    <label for="address">Price</label>
                    <input type="text" class="form-control" id="price" name="price" placeholder="Price">
                </div>

                <div class="form-group mb-2">
                    <label for="image" class="form-label">Image</label>
                    <input type="text" class="form-control" name="image" placeholder="Img src address" id="image">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        <?php } ?>

    </div>
</div>
<hr>
<!--- display the products that is in database --->
<div class="container-lg mt-5">
    <div class="row justify-content-center align-center">
        <h1 class="display-5 text-center"> All available products </h1>

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Products</th>
                <th scope="col">Product Name</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $queryResult = $db_action->getAllProducts();

            foreach($queryResult as $product)
            {

                ?>
            <tr>
                <th scope="row"><?php echo $product["product_id"]; ?></th>
                <td><?php echo $product["product_name"]; ?></td>
                <td><?php echo $product["description"]; ?></td>
                <td>$<?php echo $product["price"]; ?></td>
                <td>
                    <a href="admin.php?update=true&uid=<?php echo $product['product_id']; ?>" type="button" id="update" class="btn btn-success"><i class="fas fa-edit"></i></a>
                    <a href="admin.php?delete=true&did=<?php echo $product['product_id']; ?>" type="button" id="delete" class="btn btn-danger"><i class="far fa-trash-alt"></i></a>
                </td>
            </tr>
                <?php
            }
            ?>
            </tbody>
        </table>


    </div>
</div>

</body>
</html>


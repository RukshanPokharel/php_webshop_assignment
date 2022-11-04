<?php
session_start();
require_once 'db_functions.php';
$db_action = new dbCrudFunctions();

// form variables
$fullname = NULL;
$address = NULL;
$contact = null;
$email = null;
$password=null;
$error_msg = null;
$success_message= null;

//form validation
if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $error_msg = '';

    if (empty($_POST['fullname'])){
        $error_msg = 'Name is required';
    }else{
        $fullname = trim($_POST['fullname']);

        if (!preg_match ("/^([a-zA-Z' ]+)$/",$fullname)){
            $error_msg = "only alphabets is valid in name";
        }
    }

    if (empty($_POST['address'])) {

        $error_msg = 'address is required';
    }else{
        $address = trim($_POST['address']);

        if (!preg_match ("/^[\.a-zA-Z0-9,!? ]*$/",$address)){
            $error_msg = "only alphanumeric, comma and whitespaces is valid in address";
        }
    }

    if (empty($_POST['contactno'])) {

        $error_msg = 'contact No is required';
    }else{
        $contact = trim($_POST['contactno']);

        if(strlen($contact) !== 8){
            $error_msg = "Contact number should exactly be 8 digits";
        }
    }

    if (empty($_POST['email'])) {

        $error_msg = 'email is required';
    }else{
        $email = trim($_POST['email']);

        $pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";
        if( !preg_match ($pattern, $email) ){
            $error_msg = "Invalid email pattern";
        }
    }

    if (empty($_POST['password'])) {

        $error_msg = 'password is required';
    }else{
        $password = trim($_POST['password']);

    }

    if (empty($error_msg)) {
        $register_user = $db_action->registerUser($fullname, $address, $email, $contact, $password);
        if ($register_user) {
            $success_message = "Registration has been successfully done";
            header("Location:home.php"); // redirecting to landing page after successful registration.
            $_SESSION['login'] = true; // setting the login session value after successful registration.
        } else {
            $error_msg = "Registration failed. Please try again";
        }
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
    <title>Register User</title>
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <!-- bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <!-- using cdn link for bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

</head>
<body>

<div class="container-lg">
    <div class="row justify-content-center">
        <div class="col-lg-6">

            <?php
            // any validation messages
            if(!empty($success_message)){
                echo "<span class='text-xs text-success'>".$success_message."</span>";
            }
            if (!empty($error_msg)){
                echo "<span class='text-xs text-danger'>".$error_msg."</span>";
            }
            ?>

            <form class="mt-2" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <label for="inputFullName" class="form-label">Full Name</label>
                <div class="input-group mb-4">
                        <span class="input-group-text">
                          <i class="bi bi-person-fill text-secondary"></i>
                        </span>
                    <input type="text" class="form-control" name="fullname" placeholder="Name" id="inputFullName">
                </div>
                <div class="form-group">
                    <label for="contactno">Contact No</label>
                    <input type="text" class="form-control" id="contactno" name="contactno" placeholder="Password">
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Password">
                </div>

                <label for="inputEmail" class="form-label">Email address</label>
                <div class="input-group mb-2">
                      <span class="input-group-text">
                        <i class="bi bi-envelope-fill text-secondary"></i>
                      </span>
                    <input type="email" class="form-control" name="email" placeholder="e.g johndoe@example.com" id="inputEmail" aria-describedby="inputemailHelp">
                </div>
                <div id="inputemailHelp" class="form-text">your email is safe within us</div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>
        </div>
</div>


</body>
</html>

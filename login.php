<?php
session_start();
include_once 'db_functions.php';
$db_action = new dbCrudFunctions();

//form fields
$email = null;
$password = null;
$error_msg_login = null;
$success_message_login = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['email'])){
        $error_msg_login = 'you must enter an email';
    }else{
        $isEmailValid = validateEmailPattern(trim($_POST['email']));
        if (empty($isEmailValid)){
            $email = $_POST['email'];
        }
        else{
            $error_msg_login = $isEmailValid;
        }
    }


    if (empty($_POST['password'])){
        $error_msg_login = 'you must enter a password';
    }else{
        $password = $_POST['password'];
    }

    if (empty($error_msg_login)) {
        $login_user = $db_action->LoginUser($email, $password);
        if ($login_user) {
            foreach ($login_user as $user){
                $_SESSION['login-type'] = $user['user_type'];
                $_SESSION['user-name'] = $user['fullname'];

            }
            $success_message_login = "Login has been successful";
            $_SESSION['login'] = true; // setting the login session value after successful login.
            header("Location:home.php"); // redirecting to home page after successful login.

        } else {
            $error_msg_login = "Login failed. Please try again";
        }
    }

}

function validateEmailPattern($email){
    // reg-ex validation pattern for email
    $email_pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";

    if( !preg_match ($email_pattern, $email) ){
       return "Invalid email";
    }
    else{
        return '';
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
    <title>Login</title>
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
            //login validation messages
            if(!empty($success_message_login)){
                echo "<span class='text-xs text-success'>".$success_message_login."</span>";
            }
            if (!empty($error_msg_login)){
                echo "<span class='text-xs text-danger'>".$error_msg_login."</span>";
            }
            ?>

            <form class="mt-2" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

                <label for="email" class="form-label">Email</label>
                <div class="input-group mb-2">
                      <span class="input-group-text">
                        <i class="bi bi-envelope-fill text-secondary"></i>
                      </span>
                    <input type="email" class="form-control" name="email" placeholder="e.g johndoe@example.com" id="email" aria-describedby="inputemailHelp">
                </div>
                <div id="inputemailHelp" class="form-text">your email is safe within us</div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

            <div class="my-5 text-muted">
                No account yet? Register and enjoy your experience
                <a class="text-muted" href="register.php">
                    Register
                </a>
            </div>

        </div>
    </div>
</div>



</body>
</html>

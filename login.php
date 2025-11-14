<?php include 'header.php'; ?>

<?php

if(isset($_POST['form_login'])){
    try{
        $email = strip_tags($_POST['email']);
        $password = strip_tags($_POST['password']);

        if($email == ''){
             throw new Exception('Please enter your email.');
        }
        // Email validation
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            throw new Exception('Please enter a valid email.');
        }
        if($password === '' ){
            throw new Exception('Please enter your password');
        }

        $q = $pdo->prepare("SELECT * FROM users WHERE email=? AND status=?");
        $q->execute([$email,'Active']);
        $total = $q->rowCount();
        if(!$total) {
            throw new Exception("Email is not found");
        } 

        $result = $q->fetch(PDO::FETCH_ASSOC);
        if(!password_verify($password, $result['password'])) {
            throw new Exception("Password does not match");
        }

        $_SESSION['user'] = $result;

        $_SESSION["success_message"] = 'You have successfully login.'; 
        header("location: ".BASE_URL."user-dashboard.php");
        exit;

    }catch(Exception $e){
        $error_message = $e->getMessage();
    }
}

?>

<!-- breadcrumb start -->
<div class="breadcrumb">
    <div class="container">
        <ul class="list-unstyled d-flex align-items-center m-0">
            <li><a href="<?php echo BASE_URL;?>">Home</a></li>
            <li class="ml_10 mr_10">
                <i class="fas fa-chevron-right"></i>
            </li>
            <li>Login</li>
        </ul>
    </div>
</div>
<!-- breadcrumb end -->

<main id="MainContent" class="content-for-layout">
    <div class="login-page mt-100">
        <div class="container">
            <form action="" class="login-form common-form mx-auto" method="post">
                <div class="section-header mb-3">
                    <h2 class="section-heading text-center">Login</h2>
                </div>
                <div class="row">
                    <div class="col-12">
                        <fieldset>
                            <label class="label">Email address</label>
                            <input type="text" name="email">
                        </fieldset>
                    </div>
                    <div class="col-12">
                        <fieldset>
                            <label class="label">Password</label>
                            <input type="password" name="password">
                        </fieldset>
                    </div>
                    <div class="col-12 mt-3">
                        <a href="<?php echo BASE_URL;?>forget-password.php" class="text_14 d-block">Forgot your password?</a>
                        <button type="submit" class="btn-primary d-block mt-4 btn-signin" name="form_login">SIGN IN</button>
                        <a href="register.php" class="btn-secondary mt-2 btn-signin">CREATE AN ACCOUNT</a>
                    </div>
                </div>
            </form>
        </div>
    </div>            
</main>

<?php include 'footer.php'; ?>
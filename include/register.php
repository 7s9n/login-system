<?php
    session_start();
    require_once './parts/config.php';
    require_once 'utils.php';
    
    $username_err = $password_err = $password2_err = $email_err = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Validate username
        $username = trim($_POST['username']);
        validate_username($username, $username_err);
        if (empty($username_err)){
            user_name_exists($username, $username_err);
        }
        // Validate email
        $email = trim($_POST['email']);
        validate_email($email, $email_err);
        email_exists_in_db($email, $email_err);
        // Validate password
        $password = $_POST['pwd'];
        if (strlen($password) < 8){
            $password_err = 'Use 8 characters or more for your password';
        }
        $password_hashed = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
        $pwd2 = $_POST['pwd2'];

        if (!password_verify($pwd2, $password_hashed)){
            $password2_err = 'Those passwords didn’t match. Try again.';
        }
        if (empty($username_err) and empty($email_err)
        and empty($password_err) and empty($password2_err)){
            echo 'Hello';
            $sql = 'INSERT INTO users(username, email, password) VALUES (?,?,?)';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $username, $email,$password_hashed);
            if ($stmt->execute()){
                $_SESSION['message'] = 'Registerd successfully..';
                $_SESSION['message-type'] = 'success';
                $_SESSION['user'] = $username;
                $stmt->close();
                $conn->close();
                
                header('location: '. SITEURL . 'index.php');
            }else{
                $_SESSION['message'] = 'Try again...';
                $_SESSION['message-type'] = 'error';
                header('location: '. SITEURL . 'index.php');
            }
        }
        $conn->close();
    }else{
        redirect_if_user_is_authenticated();
    }
?>
<?php require_once 'parts/header.php'; ?>
    <div class="container">
        <h4 class="my-3">Registration Form</h4>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
            <div class="row g-3">
                <div class="col-sm-6">
                    <div class="form-group mb-3">
                        <input type="text" name="username" placeholder="Username"
                        class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo $username ?? ''; ?>">
                        <span class="invalid-feedback"><?php echo $username_err;?></span>
                    </div>

                    <div class="form-group mb-3">
                        <input type="email" name="email" placeholder="Email" 
                        class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo $email ?? ''; ?>">
                        <span class="invalid-feedback"><?php echo $email_err;?></span>
                    </div>

                    <div class="form-group mb-3">
                        <input type="password" name="pwd" placeholder="Password" 
                        class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo $password ?? ''; ?>">
                        <span class="invalid-feedback"><?php echo $password_err;?></span>
                    </div>

                    <div class="form-group mb-3">
                        <input type="password" name="pwd2" placeholder="confirm password" 
                        class="form-control <?php echo (!empty($password2_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo $pwd2 ?? ''; ?>">
                        <span class="invalid-feedback"><?php echo $password2_err;?></span>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Register</button>
                        <a href="<?php echo SITEURL . 'index.php'?>" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
        <div class="my-2">
            <small class="text-muted">
                Already have an account ? <a class="ml-2" href="<?php echo SITEURL . 'include/login.php'?>">Sign In</a>
            </small>
        </div>
    </div>
<?php require_once 'parts/footer.php'; ?>
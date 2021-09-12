<?php
    session_start();
    require_once 'parts/header.php';
    require_once 'utils.php';
    // require_once 'parts/config.php';
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username_err = $password_err = '';
        // Validate username
        $username = trim($_POST['username']);
        validate_username($username, $username_err);
        if (empty($username_err) and !user_name_exists($username, $user_error)){
            $username_err = 'username does not exist';
        }
        // validate password
        $password = $_POST['pwd'];
        $sql = 'SELECT password FROM users WHERE username = ?';
        if (empty($username_err)){
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows == 1){
                $row = $result->fetch_array(MYSQLI_ASSOC);
                if (password_verify($password, $row['password'])){
                    $_SESSION['user'] = $username;
                    header('location: '. SITEURL . 'index.php');
                }else{
                    $password_err = 'Wrong password. Try again, or click "Forgot your password" to reset it.';
                }
            }
        }
    }else{
        redirect_if_user_is_authenticated();
    }
?>
<div class="container">
    <h4 class="my-3">Login Form</h4>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
        <div class="row gl-3">
            <div class="col-sm-6">
                <div class="form-group mb-3">
                    <input type="text" name="username" placeholder="Username"
                    class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $username ?? ''; ?>">
                    <span class="invalid-feedback"><?php echo $username_err;?></span>
                </div>

                <div class="form-group mb-3">
                    <input type="password" name="pwd" placeholder="Password"
                    class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $password ?? ''; ?>">
                    <span class="invalid-feedback"><?php echo $password_err;?></span>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </div>
        </div>
    </from>
    <div class="my-2">
        <small class="text-muted">
            Need an account ? <a class="ml-2" href="<?php echo SITEURL . 'include/register.php'?>">Sign Up</a>
        </small>
    </div>
</div>
<?php require_once 'parts/footer.php'; ?>
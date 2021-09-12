<?php
    session_start();
    require_once 'include/parts/header.php';
    if (!isset($_SESSION['user'])){
        header('location: ' . SITEURL . 'include/login.php');
    }
?>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <!-- MESSAGES -->
                <?php if (isset($_SESSION['message'])) { ?>
                    <div class="alert-<?=$_SESSION['message-type']?> my-3" role="alert">
                        <p><?=$_SESSION['message']?></p>
                    </div>
                <?php $_SESSION['message']=''; }?>
            </div>
        </div>
    </div>
<?php
    require_once 'include/parts/footer.php';
?>
<?php require_once 'config.php'; ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" <?php echo "href=" . "\" ". SITEURL . "index.php\""?> >PHP LOGIN SYSTEM</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
        <?php
            if (isset($_SESSION['user'])){
                echo "
                    <li class=\"nav-item\">
                        <a class=\"nav-link\" href=\"" .SITEURL . "index.php". "\">Home</a>";
                    echo "
                    <li class=\"nav-item\">
                        <a class=\"nav-link\" href=\"" .SITEURL . "include/logout.php". "\">Logout</a>";
            }else{
                echo "
                    <li class=\"nav-item\">
                        <a class=\"nav-link\" href=\"" .SITEURL . "include/login.php". "\">Login</a>";
                echo "
                    <li class=\"nav-item\">
                        <a class=\"nav-link\" href=\"" .SITEURL . "include/register.php". "\">Register</a>";
            }
        ?>
    </ul>
  </div>
</nav>
<?php
    require_once 'parts/config.php';
    session_start();
    session_unset();
    session_destroy(); 
    header('location: ' . SITEURL . 'include/login.php');
    exit();
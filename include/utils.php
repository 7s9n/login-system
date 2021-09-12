<?php
    require_once './parts/config.php';
    function validate_username($username, &$str_error){
        if (empty($username)){
            $str_error = 'You must fill this field';
        }elseif(! filter_var($username, FILTER_VALIDATE_REGEXP,
        array("options"=> array("regexp"=> "/^[a-zA-Z\s]+$/"))) ){
            $str_error = 'Please enter a valid username';
        }
    }
    function user_name_exists($username, &$str_error){
        global $conn;
        $stmt = $conn->prepare('SELECT* FROM users WHERE username = ?');
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result()->num_rows;
        $str_error = $result ? 'That username is taken. Try another.' : '';
        return $result;
    }
    function email_exists_in_db($email, &$str_error){
        global $conn;
        $stmt = $conn->prepare('SELECT* FROM users WHERE email = ?');
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result()->num_rows >= 1;
        $str_error = $result ? 'That email is taken. Try another.' : '';
        return $result;
    }

    function validate_email($email, &$str_error){
        if (empty($email)){
            $str_error = 'You must fill this field';
        }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $str_error = 'Invalid email format';
        }
    }
    function redirect_if_user_is_authenticated($redirected_url = NULL){
        if (isset($_SESSION['user'])){
            if ($redirected_url != NULL){
                header('location: ' . redirected_url);
            }else{
                header('location: ' . SITEURL . 'index.php');
            }
        }
    }
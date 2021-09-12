<?php
$conn = new mysqli(
    'localhost',
    'root',
    '',
    'test'
);
if ($conn == false){
    die('Cannot connect to the database.');
}
define('SITEURL', 'http://localhost/Login%20System/');

<?php

session_start();
ob_start();

if(isset($_SESSION['user_id'])){

    session_unset();
    session_destroy();

    header('Location: login.php');
    ob_end_flush();
    die();
}

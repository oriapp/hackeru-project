<?php

session_start();
include_once 'app/helpers.php';
$user_name = $_SESSION['user_name'];
webhook_post("$user_name has been logged out!");
session_destroy();
header('location: signin.php');
<?php

session_start();
session_regenerate_id();
require_once 'app/helpers.php';
include_once 'app/minifier.php';

if (!auth_user()) {

  header('location: signin.php');
  exit;
}

$uid = $_SESSION['user_id'];

if (isset($_GET['pid']) && is_numeric($_GET['pid'])) {

  $pid = $_GET['pid'];
  $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
  $pid = mysqli_real_escape_string($link, $pid);
  $sql = "DELETE FROM posts WHERE id = $pid AND user_id = $uid";
  $result = mysqli_query($link, $sql);
}

header('location: blog.php');
$_SESSION['message'] = "Post has been deleted!";
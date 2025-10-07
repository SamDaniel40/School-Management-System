<?php

$serverName = "RAYENN\RAYENNSERVER";
$database = "DBSchool";
$username = "sa";
$password = "123321";

$connection = [
  "Database" => $database,
  "Uid" => $username,
  "PWD" => $password
];

// Create connection
$db_conn = sqlsrv_connect($serverName, $connection);

if (!$db_conn) {
  echo 'Connection Failed';
  exit;
}

session_start();
date_default_timezone_set('Asia/Kolkata');
include('functions.php');

$site_url = get_setting('site_url', true);

if (empty($site_url)) {

  if (!empty($_POST['site_url'])) {


    $query = sqlsrv_query($db_conn, "INSERT INTO tbl_Settings (SettingKey, SettingValue) VALUES ('site_url' , '{$_POST['site_url']}')") or die('Error while Inserting');

    if ($query) {
      header('Location: /School%20Management%20System/index.php');
      die;
    }
  }

  ?>
  <form action="" method="post">
    <div class="">
      <input type="url" class="" name="site_url" placeholder="Enter your site URL">

      <button>Submit</button>
    </div>
  </form>

  <?php
  die;
}
?>
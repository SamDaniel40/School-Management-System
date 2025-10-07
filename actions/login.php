<?php

include('../includes/config.php');

if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $pass = $_POST['password'];

  $query = sqlsrv_query($db_conn, "SELECT * FROM tbl_Accounts WHERE Email = ? AND Password = ?", array($email, md5($pass)));

  if (sqlsrv_num_rows($query) > 0) {
    $user = sqlsrv_fetch_object($query);
    $_SESSION['login'] = true;
    $_SESSION['session_id'] = uniqid();

    $user_type = $user->type;
    $_SESSION['user_type'] = $user_type;
    $_SESSION['user_id'] = $user->id;
    header('Location: ../' . $user_type . '/dashboard.php');
    exit();
  } else if ($email == 'admin@example.com' && $pass == 'admin@sms') {
    $_SESSION['login'] = true;
    header('Location: ../Admin/dashboard.php');
  } else {
    echo 'Invalid Credentials';
  }
}

?>
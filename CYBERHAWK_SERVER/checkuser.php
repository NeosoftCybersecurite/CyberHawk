<?php include 'config.php'; ?>


<?php

  $_SESSION['adm_passwd'] = null;
  $_SESSION["token"] = null;
  $_SESSION["email"] = null;
  /*session_unset();
  unset($_SESSION);
  session_destroy();
  setcookie('PHPSESSID', null, -1, '/');
  session_start();
  $_SESSION["lang"] = $_ENV['default_language'];*/
  
  if (isset($_POST['email']) and !empty($_POST['email'])) {
    if ($_POST['email'] == "Administrator")
    {
      $response_array['status'] = true;
    }
    else
    {
	     if ($email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	       $response_array['status'] = check_user($email);
  	   }
  	     else {
  	       $response_array['status'] = $_ENV["Register1"][$_SESSION['lang']];
  	   }
    }
  }
  else
  {
    $response_array['status'] = $_ENV["Register0"][$_SESSION['lang']];
  }


  header('Content-type: application/json');
  echo json_encode($response_array);

?>

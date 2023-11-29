<?php include 'config.php'; ?>

<?php
  
  if ($_ENV['accounts_mechanisms'] == "2")
  {
    header('Location: ./index.php');
    exit(0);
  }

  if (!check_csrf_token($_POST["CSRF_TOKEN"]))
  {
     $response_array['status'] = "CSRF Protection";
  }
  else
  {
    if ( (isset($_POST['oldpasswd'])) and (isset($_POST['passwd']) and !empty($_POST['passwd'])) ){

      $response_array['status'] = check_passwd($_SESSION['email'], $_POST['oldpasswd']);

      if ($response_array['status'] === true)
      {
          $salt = sha1(rand());
          $pass = $_POST['passwd'];
          $storedpass = sha1($pass . $salt . $pass);

          $response_array['status'] = change_passwd($_SESSION['email'], $storedpass, $salt);
      }

    }
  }
  
  header('Content-type: application/json');
  echo json_encode($response_array);

?>

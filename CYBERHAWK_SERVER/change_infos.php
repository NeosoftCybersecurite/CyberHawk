<?php include 'config.php'; ?>

<?php
  
  if ($_ENV['accounts_information'] == "0")
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
    if ( isset($_POST['firstname']) and isset($_POST['lastname']) ){
          $lastname   = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
          $firstname  = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
          $response_array['status'] = change_infos($firstname, $lastname, $_SESSION["email"]);
    }
  }
  
  header('Content-type: application/json');
  echo json_encode($response_array);

?>

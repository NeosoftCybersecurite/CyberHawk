<?php include 'config.php'; ?>


<?php
  
  if (isset($_POST['email']) and !empty($_POST['email'])) {

    if (($_POST['email'] == "Administrator") || ($_POST['email'] == "Invited"))
    {
      $username = $_POST['email'];
      $lastname   = $_POST['email'];
      $firstname  = $_POST['email'];
      $token = $_POST['email'];

      if ($_POST['email'] == "Administrator")
        $active = 1;
      else
        $active = $_ENV['invited_account'];
    }
    else
    {
      $username   = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
      $lastname   = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
      $firstname  = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
      $token      = sha1(rand());
      $active     = $_ENV['accounts_validation'];
    }
    
    if ($username) {
    	  $pass = "";
    	  $salt = "";
    	  $storedpass = "";
	
      	if (isset($_POST['pass']) and !empty($_POST['pass'])) {
      	  $salt = sha1(rand());
      	  $pass = $_POST['pass'];
      	  $storedpass = sha1($pass . $salt . $pass);
      	}

	      $response_array['status'] = valid_user($username, $pass);


    	  if ($response_array['status'] === false)
          if ($active != 2)
          {
              if ($username == "Administrator")
              {
                  $response_array['status'] = insert_user($username,$username,$username,$storedpass,$salt,$token,$active);
              }
              else
              {
                  if (($_ENV['accounts_mechanisms'] == 1) && ($pass == ""))
                  {
                      $response_array['status'] = $_ENV["Login23"][$_SESSION['lang']];
                  }
                  else 
                  {
                      if (($_ENV['accounts_mechanisms'] == 2) && ($pass != ""))
                      {
                           $response_array['status'] = $_ENV["Login24"][$_SESSION['lang']];
                      }
                      else
                      {
                          if ($_ENV['accounts_information'] == 0)
                            $response_array['status'] = insert_user($username,$username,$username,$storedpass,$salt,$token,$active);
                          else
                            if ((isset($lastname) and !empty($lastname)) and (isset($firstname) and !empty($firstname)))
                             $response_array['status'] = insert_user($username,$lastname,$firstname,$storedpass,$salt,$token,$active);
                            else
                              $response_array['status'] = $_ENV["Register8"][$_SESSION['lang']];
                      }
                  }
              }
          }
          else
          {
            $response_array['status'] = $_ENV["Register9"][$_SESSION['lang']];
          }
    }
    else {
      $response_array['status'] = $_ENV["Register1"][$_SESSION['lang']];
    }
  }
  else
  {
    $response_array['status'] = $_ENV["Register0"][$_SESSION['lang']];
  }


  header('Content-type: application/json');
  echo json_encode($response_array);

?>

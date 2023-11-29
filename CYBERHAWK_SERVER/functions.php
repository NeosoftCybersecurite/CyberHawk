<?php

  function generate_csrf_token() {
     $token = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
     $_SESSION["CSRF_TOKENS"][$token] = time();
     return $token;
}



function check_csrf_token($token) {
    # Remove tokens older than 20 minuts
    foreach ($_SESSION["CSRF_TOKENS"] as $i => $value) {
	if ((time() - $value) > 1200)
	    unset($_SESSION["CSRF_TOKENS"][$i]);
    }

    if ( ($_SERVER['REQUEST_METHOD'] === 'POST') || ($_SERVER['REQUEST_METHOD'] === 'GET') ){
		if (isset($token)) {
		    if (isset($_SESSION["CSRF_TOKENS"][$token])) {
				//unset($_SESSION["CSRF_TOKENS"][$token]);			// PROBLEM for now, CyberHawk pages never update
				return true;
		    }
		    else {
				return false;
		    }
		}
		else	# POST TOKEN SHOULD HAVE A TOKEN, IF NOT REQUEST CAN'T BE VALIDATED !
		{
		    return false;
		}
    }
}




  function get_user_retention($email) {
  	if ($email == "Administrator")
  		return 0;
  	if ($email == "Invited")
  		return 1;

    if ($link = connect_mysql())
    {
		$query = "SELECT retention FROM `users` WHERE email=? LIMIT 1;";

		if ($stmt = $link->prepare($query))
		{
		  if ($rc = $stmt->bind_param("s",$email))
		  {
		    if ($stmt->execute())
		    {
		      $stmt->bind_result($retention);
		      $stmt->fetch();

		      if ($retention) {
			    $result = $retention;
		      }
		      else {							// User not found in database
				$result = 1;
		      }
		    }
		    $stmt->close();
		  }
		}  
		close_mysql($link);

    	return $result;
    }
  }



  function get_user_storage($email) {
  	if ($email == "Administrator")
  		return 0;
  	if ($email == "Invited")
  		return $_ENV['maximum_space'];

    if ($link = connect_mysql())
    {
		$query = "SELECT storage FROM `users` WHERE email=? LIMIT 1;";

		if ($stmt = $link->prepare($query))
		{
		  if ($rc = $stmt->bind_param("s",$email))
		  {
		    if ($stmt->execute())
		    {
		      $stmt->bind_result($storage);
		      $stmt->fetch();

		      if ($storage) {
			    $result = $storage;
		      }
		      else {							// User not found in database
				$result = 0;
		      }
		    }
		    $stmt->close();
		  }
		}  
		close_mysql($link);

    	return $result;
    }
  }

        
   
  if (!isset($_SESSION['lang']))
    $_SESSION['lang'] = $_ENV["default_language"];
      
  if (!isset($_SESSION['page']))
    $_SESSION['page'] = 'home.php';
    
    
    
  /*
  *
  * CONIX Security : Defining used language on each page load
  * Ludovic COURGNAUD 2015
  *
  */  
  function set_language()
  {
    //$_SESSION['lang'] = 0;
    if (isset($_GET['lang']))
    {
      $lang = filter_var($_GET['lang'], FILTER_SANITIZE_NUMBER_INT);

      if (($lang == 0) or ($lang == 1) or ($lang == 2) or ($lang == 3))
	$_SESSION['lang'] = (int)$lang;
    }
  }
  set_language();

  
  
    
 
  function check_login()
  {
      if (isset($_SESSION['token']))			// User authentified / identified
      {
	if (!is_admin() && (get_user_storage($_SESSION["email"]) != 0))
	    $mess = $_ENV["Welcome2"][$_SESSION['lang']]; 
	else 
	    $mess = $_ENV["Welcome5"][$_SESSION['lang']]; 

	echo "<script>
	    if (document.getElementById('login')) {
	      document.getElementById('login').style.visibility= 'hidden';
	      document.getElementById('login').style.display = 'none';
	    }
	    
	    

	    if (document.getElementById('cyberhawk')) {
	      document.getElementById('cyberhawk').style.visibility= 'visible';
	      document.getElementById('cyberhawk').style.display = 'block';
	    ";
	    if (($_ENV['invited_account']) && ($_SESSION["token"] == "Invited"))
	    {
	    	echo "document.getElementById('welcome').innerHTML  = '<center>" . $_ENV['Welcome6'][$_SESSION['lang']] . "';";
	    }
	    else 
	    {
	    	echo "document.getElementById('welcome').innerHTML  = '<center>" . addslashes($_ENV['Welcome0'][$_SESSION['lang']]) . "<span style=\"font-size: 16px; font-weight: bold;\">" . $_SESSION['firstname']  . "</span> !';";
	    }
	    echo "
	      document.getElementById('welcome').innerHTML += '<center><font color=\'red\'>" . addslashes($_ENV['Welcome1'][$_SESSION['lang']]) . "</font></center><br/>';
	      document.getElementById('welcome').innerHTML += '<br /><center>" . addslashes($mess) . "</center><br/>';
	    }
	    
	    document.getElementById('menu-cyberhawk').innerHTML = '" . $_ENV["Menu0"][0] . "';

	    $('#storage-txt').text('" . get_user_storage($_SESSION["email"]) / 1000000 . "');
	</script>";
	return true;
      }
      else {
	echo "<script>
	  if (document.getElementById('login')) {
	    document.getElementById('login').style.visibility= 'visible';
	    document.getElementById('login').style.display = 'block';
	  }
	  
	  if (document.getElementById('cyberhawk')) {
	    document.getElementById('cyberhawk').style.visibility= 'hidden';
	    document.getElementById('cyberhawk').style.display = 'none';
	    
	    document.getElementById('welcome').innerHTML  = '';
	  }
	  
	  document.getElementById('menu-cyberhawk').innerHTML = '" . $_ENV["Menu3"][$_SESSION['lang']] . "';
	</script>";
	return false;
      }
  }
  
  
  
 
  function connect_mysql() {
      if (!$link = mysqli_connect($_ENV["dbhost"], $_ENV["dbuser"], $_ENV["dbpass"], $_ENV["dbname"]))
	return null;

      return $link;
  }

  
  
  

  function close_mysql($link) {
     mysqli_close($link);
  }
  
  
  
  
 
  function check_avstate($cmd) {
      exec("which " . $cmd, $result);

      if ($result == NULL)
	  return false;
	  
      return true;
  }
  
  
  
  

  function check_lastupdate($av_folder)
  {
	exec("ls " . $av_folder . " -Art | tail -n 1", $result);		// Checking last updated pattern file
	
	if ($result == NULL)
	    return '01-01-1970';
	else
	{
	    exec("stat --format=%y " . $result[0], $result2);
	    return $result2[0];
	}
  }
  


  function action_users($action, $users, $time=0, $parameter=0) {
      $ids = explode(",", $users);							// Converting string id,id,id into array
      $result = $_ENV["Accounts8"][$_SESSION['lang']];
      
      if ( ($action == "1") || ($action == "0") ){			// Activate (1) & Deactivate (0)    
	      if ($link = connect_mysql())
	      {
			$query = "UPDATE `users` SET active = ? WHERE id = ? and email != 'Administrator';";
			
			if ($stmt = $link->prepare($query))
			{
			    $tmpres = true;
			    foreach ($ids as $id) {
					$actint = intval($action);
					$stmt->bind_param("ii", $actint, $id);
					
					$infos = get_user_info($id);
					if (!$stmt->execute())
					{
					    $tmpres = $_ENV["Accounts8"][$_SESSION['lang']];
					    
					    if ($action == 1)
						insert_log("Failure" ,"User Activation", "User Info: " . $infos);
					    else
						insert_log("Failure" ,"User Deactivation", "User Info: " . $infos);
					}
					else
					{
					    if ($action == 1)
						insert_log("Success" ,"User Activation", "User Info: " . $infos);
					    else
						insert_log("Success" ,"User Deactivation", "User Info: " . $infos);
					}
			    }
			    $result = $tmpres;
			    $stmt->close();
			}
		  close_mysql($link);
	      }
      }

	if ($action == "60") {				// Export users
        if ($link = connect_mysql())
    	{
    		if (!is_dir ($_ENV['files_path']."Administrator/"))
				exec('mkdir "' . $_ENV['files_path'] . 'Administrator/"');
	
			$filename = "Administrator/USERS_EXPORT.csv";
    		$resfile = fopen($_ENV['files_path'].$filename, "w");
    		fputcsv($resfile, Array("Nom;Prénom;Email"));


			$query = "SELECT email,first_name,last_name FROM `users`;";
			$stmt = $link->prepare($query);
	
			if ($stmt)
			{
	    		$ex = $stmt->execute();
	    
	    		if ($ex)
	    		{
	      			$stmt->bind_result($email, $firstname, $lastname);
	      
	      			while ($stmt->fetch())
	      				fputcsv($resfile, Array($lastname . ";" . $firstname . ";" . $email ));

	      			$result = true;
	    		}
	    		$stmt->close();
			}
			close_mysql($link);
			fclose($resfile);
      	}
    }
  


      
      if ($action == "2") {						// Deletion (2)
	    if ($link = connect_mysql())
	    {
		$tmpres = true;
		$query = "SELECT token FROM `users` WHERE id = ? and email != 'Administrator';";
		
		if ($stmt = $link->prepare($query))
		{
		    foreach ($ids as $id) {
			$stmt->bind_param("i", $id);
			
			if (!$stmt->execute())
			{
			    $tmpres = $_ENV["Accounts8"][$_SESSION['lang']];
			}
			else						// Removing user's files
			{
			    $stmt->bind_result($token);
			    $stmt->fetch();
			    if ($token != "")
				exec("rm -Rf " . $_ENV['files_path'] . $token);
			}
		    }
		    $stmt->close();
		}
		
		$query = "DELETE FROM `users` WHERE id = ? and email != 'Administrator';";
		
		if ($stmt = $link->prepare($query))			// Removing user's account
		{    
		    foreach ($ids as $id) {
			$stmt->bind_param("i",$id);
			
			$infos = get_user_info($id);
			if (!$stmt->execute()) 
			{
			    $tmpres = $_ENV["Accounts8"][$_SESSION['lang']];
			    insert_log("Failure" ,"User Deletion", "User Info: " . $infos);
			}
			else
			{
			    insert_log("Success" ,"User Deletion", "User Info: " . $infos);
			}
		    }
		    $result = $tmpres;
		    $stmt->close();
		}
		close_mysql($link);
	    }
      }

 	  if ($action == "3"){							// Reset Password (3)
	      if ($link = connect_mysql())
	      {
	      	if (!is_dir ($_ENV['files_path']."Administrator/"))
				exec('mkdir "' . $_ENV['files_path'] . 'Administrator/"');
	
			$filename = "Administrator/PASSWORD_RESET_".$time.".csv";
    		$resfile = fopen($_ENV['files_path'].$filename, "w");
    		fputcsv($resfile, Array("Nom;Prénom;Email;Password"));

			$query = "UPDATE `users` SET passwd = ?, salt = ? WHERE id = ? and email != 'Administrator';";
			
			if ($stmt = $link->prepare($query))
			{
			    $tmpres = true;
			    foreach ($ids as $id) {
			    	$salt = sha1(rand());
      	  			$pass = generateRandomPassword();
      	  			$storedpass = sha1($pass . $salt . $pass);

					$stmt->bind_param("ssi", $storedpass, $salt, $id);
					
					$infos = get_user_lastname($id) . ';' . get_user_firstname($id) . ';' . get_user_email($id);
					if (!$stmt->execute())
					{
					    $tmpres = $_ENV["Accounts8"][$_SESSION['lang']];
						insert_log("Failure" ,"User Password Reset", "User Info: " . $infos);
					}
					else
					{
						insert_log("Success" ,"User Password Reset", "User Info: " . $infos);
						fputcsv($resfile, Array($infos . ";" . $pass));
					}
			    }
			    $result = $tmpres;
			    $stmt->close();
			}
		  close_mysql($link);
		  fclose($resfile);
	      }
      }


      if ($action == "4"){							// Users import from IMPORT_UTILISATEURS.csv
      	  $result = $_ENV["Accounts33"][$_SESSION['lang']];
	      if ($link = connect_mysql())
	      {
	      	if (!file_exists($_ENV['files_path']."Administrator/IMPORT_UTILISATEURS.csv"))
				return $_ENV["Accounts29"][$_SESSION['lang']];

			$filename = "Administrator/IMPORT_UTILISATEURS_".time().".csv";
    		$resfile = fopen($_ENV['files_path'].$filename, "w");
    		fputcsv($resfile, Array("Nom,Prénom,Email,Password"));

			$row = 1;
			if (($handle = fopen($_ENV['files_path']."Administrator/IMPORT_UTILISATEURS.csv", "r")) !== FALSE) {
			  	while (($data = fgetcsv($handle, 2500, ';')) !== FALSE) {
			  		if ($row > 1)
			  		{
			    		if (count($data) == 3)
			    		{
			   				$lastname 	= filter_var($data[0], FILTER_SANITIZE_STRING);
			   				$firstname 	= filter_var($data[1], FILTER_SANITIZE_STRING);
			   				$email 		= filter_var($data[2], FILTER_VALIDATE_EMAIL);

			   				$salt 		= sha1(rand());
      	  					$pass 		= generateRandomPassword();
      	  					$storedpass = sha1($pass . $salt . $pass);
      	  					$active 	= 1;
      	  					$token      = sha1(rand());

			   				$query = "INSERT INTO `users` (id, email, first_name, last_name, passwd, salt, token, active) VALUES(null,?,?,?,?,?,?,?)";

			   				if ($stmt = $link->prepare($query))
							{
							  	if ($rc = $stmt->bind_param("ssssssi",$email,$firstname,$lastname,$storedpass,$salt,$token,$active))
							  	{
							    	if ($stmt->execute())
							    	{     
									    insert_log("Success", "User Creation (No validation required)", 'Authentication');
									    fputcsv($resfile, Array($lastname . "," . $firstname . ',' . $email . ',' . $pass));
									    $result = true;
								  	}
							    }
							    $stmt->close();
							}
			    		}
			    	}
			    	$row++;
			  	}
			  	fclose($handle);
			  	unlink($_ENV['files_path']."Administrator/IMPORT_UTILISATEURS.csv");
			}
		  close_mysql($link);
		  fclose($resfile);
	      }
      }


      if ($action == "49"){							// Remove Passwords
	      if ($link = connect_mysql())
	      {
	      	if (!is_dir ($_ENV['files_path']."Administrator/"))
				exec('mkdir "' . $_ENV['files_path'] . 'Administrator/"');
	
			$filename = "Administrator/PASSWORD_REMOVE_".$time.".csv";
    		$resfile = fopen($_ENV['files_path'].$filename, "w");
    		fputcsv($resfile, Array("Nom;Prénom;Email;Password"));

			$query = "UPDATE `users` set passwd = '', salt='' WHERE id = ? and email != 'Administrator';";
			
			if ($stmt = $link->prepare($query))
			{
			    $tmpres = true;
			    foreach ($ids as $id) {
					$stmt->bind_param("i", $id);
					
					$infos = get_user_lastname($id) . ';' . get_user_firstname($id) . ';' . get_user_email($id);
					if (!$stmt->execute())
					{
					    $tmpres = $_ENV["Accounts8"][$_SESSION['lang']];
						insert_log("Failure" ,"User Password Reset", "User Info: " . $infos);
					}
					else
					{
						insert_log("Success" ,"User Password Reset", "User Info: " . $infos);
						fputcsv($resfile, Array($infos . ";Empty"));
					}
			    }
			    $result = $tmpres;
			    $stmt->close();
			}
		  close_mysql($link);
		  fclose($resfile);
	      }
      }

      if ($action == "50"){							// Retention modification
	      if ($link = connect_mysql())
	      {
			$query = "UPDATE `users` set retention = ? WHERE id = ? and email != 'Administrator';";
			
			if ($stmt = $link->prepare($query))
			{
			    $tmpres = true;
			    foreach ($ids as $id) {
					$stmt->bind_param("ii", $parameter, $id);
					
					if (!$stmt->execute())
					{
					    $tmpres = $_ENV["Accounts8"][$_SESSION['lang']];
						insert_log("Failure" ,"User Information Change", "User Info: " . $infos);
					}
					else
					{
						insert_log("Success" ,"User Information Change", "User Info: " . $infos);
					}
			    }
			    $result = $tmpres;
			    $stmt->close();
			}
		  close_mysql($link);
		  fclose($resfile);
	      }
      }

 		if ($action == "51"){							// Storage Limit modification
	      if ($link = connect_mysql())
	      {
			$query = "UPDATE `users` set storage = ? WHERE id = ? and email != 'Administrator';";
			
			if ($stmt = $link->prepare($query))
			{
			    $tmpres = true;
			    foreach ($ids as $id) {
					$stmt->bind_param("ii", $parameter, $id);
					
					if (!$stmt->execute())
					{
					    $tmpres = $_ENV["Accounts8"][$_SESSION['lang']];
						insert_log("Failure" ,"User Information Change", "User Info: " . $infos);
					}
					else
					{
						insert_log("Success" ,"User Information Change", "User Info: " . $infos);
					}
			    }
			    $result = $tmpres;
			    $stmt->close();
			}
		  close_mysql($link);
		  fclose($resfile);
	      }
      }

      return $result;
  }
  
  
  

  function list_users() {
    $result = $_ENV["Accounts6"][$_SESSION['lang']];
    
    if ($link = connect_mysql())
    {
	$query = "SELECT id,email,first_name,last_name,active FROM `users` where email != 'Administrator' ORDER BY last_name ASC;";
	$stmt = $link->prepare($query);
	
	if ($stmt)
	{
	    $ex = $stmt->execute();
	    
	    if ($ex)
	    {
	      $stmt->bind_result($id, $email, $firstname, $lastname, $active);
	      $res = array();
	      
	      while ($stmt->fetch())
		  array_push($res, array("ID" => $id, "MAIL" => $email,  "FIRSTNAME" => $firstname, "LASTNAME" => $lastname, "ACT" => $active));
    
	      $result = $res;
	    }
	    $stmt->close();
	}
	close_mysql($link);
      }
  
      return $result;
  }
  
  
  

  function check_user($email) {
    $result = $_ENV["Register3"][$_SESSION['lang']];

    if ($link = connect_mysql())
    {
	$query = "SELECT email FROM `users` WHERE email=? LIMIT 1;";

	if ($stmt = $link->prepare($query))
	{
	  if ($stmt->bind_param("s",$email))
	  {
	    if ($stmt->execute())
	    {
	      $stmt->bind_result($e);
	      $stmt->fetch();

	      if ($e)
		$result = true;				// User found
	      else
		$result = false;			// User not found
	    }
	    $stmt->close();
	  }
	}  
	close_mysql($link);
      }
      else {
	$result = $_ENV["Register2"][$_SESSION['lang']];
      }
      return $result;
  }
  
  

  function check_passwd($email, $pass) {
    $result = $_ENV["Register3"][$_SESSION['lang']];

    if ($link = connect_mysql())
    {
		$query = "SELECT passwd,salt FROM `users` WHERE email=? LIMIT 1;";

		if ($stmt = $link->prepare($query))
		{
	  		if ($rc = $stmt->bind_param("s",$email))
	  		{
	    		if ($stmt->execute())
	    		{
	      			$stmt->bind_result($passwd,$salt);
	      			$stmt->fetch();

	      			if ($passwd == "") 
	      			{
	      				if ($pass == "")
	      					return true;
	      				else
	      					$result = $_ENV["Accounts23"][$_SESSION['lang']];
	      			}
	      			else
	      			{
	      				if ($passwd == sha1($pass . $salt . $pass))
	      					return true;
	      				else
	      					$result = $_ENV["Accounts23"][$_SESSION['lang']];
	      			}

	      		}
	      		$stmt->close();
	      	}
	    }
	    close_mysql($link);
	}
	return $result;
  }

  


  function change_passwd($email, $pass, $salt) {
  	if ($email != "Invited")
  	{
	    $result = $_ENV["Register3"][$_SESSION['lang']];

	    if ($link = connect_mysql())
	    {
			$query = "UPDATE `users` SET passwd = ?, salt = ? WHERE email = ? ;";
				
			if ($stmt = $link->prepare($query))
			{
				$stmt->bind_param("sss", $pass, $salt, $email);
						
				if (!$stmt->execute())
				{
					insert_log("Failure" ,"User Password Change", "User Info: " . $email);
				}
				else
				{
					insert_log("Success" ,"User Password Change", "User Info: " . $email);
					$result = true;
				}
				$stmt->close();
			}
		    close_mysql($link);
		}
		return $result;
	}
	else
	{
		return $_ENV["Register15"][$_SESSION['lang']];
	}
  }



  function change_infos($firstname, $lastname, $email) {
  	if ($email != "Invited")
  	{
	    $result = $_ENV["Register3"][$_SESSION['lang']];

	    if ($link = connect_mysql())
	    {
			$query = "UPDATE `users` SET first_name = ?, last_name = ? WHERE email = ? ;";
				
			if ($stmt = $link->prepare($query))
			{
				$stmt->bind_param("sss", $firstname, $lastname, $email);
						
				if (!$stmt->execute())
				{
					insert_log("Failure" ,"User Information Change", "User Info: " . $email);
				}
				else
				{
					$_SESSION['lastname'] = $lastname;
				  	$_SESSION['firstname'] = $firstname;
					insert_log("Success" ,"User Information Change", "User Info: " . $email);
					$result = true;
				}
				$stmt->close();
			}
		    close_mysql($link);
		}
		return $result;
	}
	else
	{
		return $_ENV["Register15"][$_SESSION['lang']];
	}
  }



  function is_admin()
  {
  		if (isset($_SESSION['email']))
      		return ($_SESSION['email'] == "Administrator");
      	else
      		return false;
  }
  
  
  
  

  function get_user_info($id) {
    if ($link = connect_mysql())
    {
		$query = "SELECT email,first_name,last_name FROM `users` WHERE id=? LIMIT 1;";

		if ($stmt = $link->prepare($query))
		{
		  if ($rc = $stmt->bind_param("i",$id))
		  {
		    if ($stmt->execute())
		    {
		      $stmt->bind_result($email,$first_name,$last_name);
		      $stmt->fetch();

		      if ($email) {
			    $result = $first_name . " " . $last_name . " " . " (" . $email . ")[" . $id . "]";
		      }
		      else {							// User not found in database
				$result = "User not Found";
		      }
		    }
		    $stmt->close();
		  }
		}  
		close_mysql($link);

    	return $result;
    }
  }

   

 
  function get_user_firstname($id) {
    if ($link = connect_mysql())
    {
		$query = "SELECT first_name FROM `users` WHERE id=? LIMIT 1;";

		if ($stmt = $link->prepare($query))
		{
		  if ($rc = $stmt->bind_param("i",$id))
		  {
		    if ($stmt->execute())
		    {
		      $stmt->bind_result($first_name);
		      $stmt->fetch();

		      if ($first_name) {
			    $result = $first_name;
		      }
		      else {							// User not found in database
				$result = "User not Found";
		      }
		    }
		    $stmt->close();
		  }
		}  
		close_mysql($link);

    	return $result;
    }
  }



  function get_user_lastname($id) {
    if ($link = connect_mysql())
    {
		$query = "SELECT last_name FROM `users` WHERE id=? LIMIT 1;";

		if ($stmt = $link->prepare($query))
		{
		  if ($rc = $stmt->bind_param("i",$id))
		  {
		    if ($stmt->execute())
		    {
		      $stmt->bind_result($last_name);
		      $stmt->fetch();

		      if ($last_name) {
			    $result = $last_name;
		      }
		      else {							// User not found in database
				$result = "User not Found";
		      }
		    }
		    $stmt->close();
		  }
		}  
		close_mysql($link);

    	return $result;
    }
  }


  function get_user_email($id) {
    if ($link = connect_mysql())
    {
		$query = "SELECT email FROM `users` WHERE id=? LIMIT 1;";

		if ($stmt = $link->prepare($query))
		{
		  if ($rc = $stmt->bind_param("i",$id))
		  {
		    if ($stmt->execute())
		    {
		      $stmt->bind_result($email);
		      $stmt->fetch();

		      if ($email) {
			    $result = $email;
		      }
		      else {							// User not found in database
				$result = "User not Found";
		      }
		    }
		    $stmt->close();
		  }
		}  
		close_mysql($link);

    	return $result;
    }
  }




  function pie_chart_detections() {
    $obj = new stdClass();

    $obj->datasets = array();
    $obj->labels = array();

    $data = new stdClass();

    $data->data = array();
    $data->backgroundColor = array();

    array_push($obj->datasets, $data);

    $data->label = "Dataset";

    if ($link = connect_mysql())
    {
		$query = "SELECT count(*) as res FROM logs WHERE details LIKE CONCAT('%',?,'%');";
		
		$cpt = 0;
		while (isset($_ENV[$cpt . "_AV_NAM"]))
		{
			if ($stmt = $link->prepare($query))
			{
			  if ($rc = $stmt->bind_param("s", $_ENV[$cpt . "_AV_NAM"]))
			  {
			    if ($stmt->execute())
			    {
			      $stmt->bind_result($res);
			      $stmt->fetch();

			      if ($res > 0) {
				        array_push($data->data, $res);
					    array_push($data->backgroundColor, 'rgba('. rand(0,255) . ', '. rand(0,255) . ', '. rand(0,255) . ', 0.8)');
					    array_push($obj->labels, $_ENV[$cpt . "_AV_NAM"]);
			      }
			    }
			    $stmt->close();
			  }
			}
			$cpt++;
		}
		close_mysql($link);
    }
    return json_encode($obj);
  }



  function bar_chart_detections() {
    $obj = new stdClass();

    $obj->datasets = array();
    $obj->labels = array();

    for ($i = 0; $i <= 12; $i++)
    	array_push($obj->labels, $_ENV["Month" . date('m', strtotime('-'.$i.' month')) ][$_SESSION['lang']] . " " . date('Y', strtotime('-'.$i.' month')));

    if ($link = connect_mysql())
    {
		$query = "SELECT count(*) as res FROM logs WHERE MONTH(time) = ? AND YEAR(time) = ? AND details LIKE CONCAT('%',?,'%');";
		

			$cpt = 0;
			while (isset($_ENV[$cpt . "_AV_NAM"]))
			{
				$dataset = new stdClass();
				$dataset->label = $_ENV[$cpt . "_AV_NAM"];
				$dataset->backgroundColor = 'rgba('. rand(0,255) . ', '. rand(0,255) . ', '. rand(0,255) . ', 0.8)';
				$dataset->borderWidth = 1;
				$dataset->data = array();
							   
				for ($i = 0; $i <= 12; $i++)
				{
					if ($stmt = $link->prepare($query))
					{
					  $month = date('m', strtotime('-'.$i.' month'));
					  $year = date('Y', strtotime('-'.$i.' month'));

					  if ($rc = $stmt->bind_param("iis", $month, $year, $_ENV[$cpt . "_AV_NAM"]))
					  {
					    if ($stmt->execute())
					    {
					      $stmt->bind_result($res);
					      $stmt->fetch();

					      if ($res >= 0) {
							    array_push($dataset->data, $res);
					      }
					    }
					    $stmt->close();
					  }
					}
				}
				 array_push($obj->datasets, $dataset);
				$cpt++;
			}
		close_mysql($link);
    }
    return json_encode($obj);
  }



  function valid_user($email, $pass) {

  	if (($email == "Invited") && ($_ENV['invited_account']))
  	{
  		$_SESSION['token'] = $email;
		$_SESSION['email'] = $email;
		$_SESSION['lastname'] = $email;
		$_SESSION['firstname'] = $email;
		insert_log("Success", "User Login", 'Identification');

		return true;
  	}


    $result = $_ENV["Register3"][$_SESSION['lang']];

    $email_save = $email;

    if ($link = connect_mysql())
    {
	$query = "SELECT email,passwd,first_name,last_name,salt,token,active FROM `users` WHERE email=? LIMIT 1;";

	if ($stmt = $link->prepare($query))
	{
	  if ($rc = $stmt->bind_param("s",$email))
	  {
	    if ($stmt->execute())
	    {
	      $stmt->bind_result($email,$passwd,$firstname,$lastname,$salt,$token,$active);
	      $stmt->fetch();

	      if ($token) {						// User found in database
		    if (($pass == "") and ($passwd == ""))		// Identification
		    {
			  if ($active)
			  {
			      $_SESSION['token'] = $token;
			      $_SESSION['email'] = $email;
			      $_SESSION['lastname'] = $lastname;
			      $_SESSION['firstname'] = $firstname;
			      $result = true;
			      insert_log("Success", "User Login", 'Identification');
			  }
			  else
			  {
			      $result = $_ENV["Register7"][$_SESSION['lang']];
			      insert_log("Failure", "User Login", "Used Email: " . $email . " / Account is not active");
			  }
		    }
		    else						// Authentication
		    {
			  $storedpass = sha1($pass . $salt . $pass);
			  if ($passwd === $storedpass) 
			  {
			      if ($active)
			      {
				  $_SESSION['token'] = $token;
				  $_SESSION['email'] = $email;
				  $_SESSION['lastname'] = $lastname;
			  	  $_SESSION['firstname'] = $firstname;

			  	  if ($email == "Administrator")
			  	  	$_SESSION['firstname'] = "Administrator";

				  $result = true;
				  insert_log("Success", "User Login", 'Authentication');
			      }
			      else
			      {
				  sleep(3);
				  $result = $_ENV["Register7"][$_SESSION['lang']];
				  insert_log("Failure", "User Login", "Used Email: " . $email . " / Account is not active");
			      }
			  }
			  else
			  {
			    sleep(3);
			    $result = $_ENV["Register4"][$_SESSION['lang']];
			    insert_log("Failure", "User Login", "Used Email: " . $email . " / Wrong Password");
			  }  
		    }
	      }
	      else {							// User not found in database
	        sleep(3);
		$result = false;
		insert_log("Failure", "User Login", "Used Email: '" . $email_save ."'");
	      }
	    }
	    $stmt->close();
	  }
	}  
	close_mysql($link);
      }
      else {
	$result = $_ENV["Register2"][$_SESSION['lang']];
      }
  
      return $result;
  }
  
  
  
 
 
  function insert_user($email,$lastname,$firstname,$pass,$salt,$token,$active) {
      $result =  $_ENV["Register3"][$_SESSION['lang']];
      
      if ($link = connect_mysql())
      {
			$query = "INSERT INTO `users` (id, email, first_name, last_name, passwd, salt, token, active, storage, retention) VALUES(null,?,?,?,?,?,?,?,".$_ENV['maximum_space'].",".$_ENV['clear_accounts_days'].")";
			
			if ($stmt = $link->prepare($query))
			{
			  if ($rc = $stmt->bind_param("ssssssi",$email,$firstname,$lastname,$pass,$salt,$token,$active))
			  {
			    if ($stmt->execute())
			    {     
				  if ($email != "Administrator")
				  {
				      if ($active) {
						  $_SESSION['token'] = $token;
						  $_SESSION['email'] = $email;
						  $_SESSION['lastname'] = $lastname;
						  $_SESSION['firstname'] = $firstname;
						  $result = true;
						  
						  if ($pass != "")
						    insert_log("Success", "User Creation (No validation required)", 'Authentication');
						  else
						    insert_log("Success", "User Creation (No validation required)", 'Identification');
				      }
				      else
				      {
						  $result = $_ENV["Register6"][$_SESSION['lang']];

						  if ($pass != "")
						    insert_log("Success", "User Creation (Validation required)", 'Authentication');
						  else
						    insert_log("Success", "User Creation (Validation required)", 'Identification');
				      }
				  }
			    }
			    $stmt->close();
			  }
			}
			close_mysql($link);
      }
      else {
			$result = $_ENV["Register2"][$_SESSION['lang']];
      }
      
      return $result;
  }
  
  
  

  function insert_log($logs ,$logt, $details  = null, $filename = null, $md5 = null, $sha1 = null) {
      openlog("LOG_CYBERHAWK", LOG_PID | LOG_PERROR, LOG_LOCAL0);
      
      $time = date('Y-m-d H:i:s');

      if (isset($_SESSION['email']))
	  	$log = "[" . $time . "] [INFO] User '" . $_SESSION['email'] . "' (" . $_SERVER['REMOTE_ADDR'] . ") caused '" . $logs . "' with '" . $logt . "'";
      else
	  	$log = "[" . $time . "] [INFO] Unauthentified user (" . $_SERVER['REMOTE_ADDR'] . ") caused '" . $logs . "' with '" . $logt . "'";
	  
      if ($filename != null)
	  	$log .= " (FILENAME: '" . $filename . "' / MD5: '" . $md5 . "' / SHA1: '" . $sha1 . "')";
      
      if ($details != null)
	  	$log .= " - [ " . $details . " ]";
      else 
	  	$details = "";

      
      	if ($link = connect_mysql())
      	{
			if (isset($_SESSION['email']))
			    $query = "INSERT INTO `logs` VALUES(null,(SELECT id FROM `users` WHERE email = ?),(SELECT id FROM `log_types` WHERE type = ?),(SELECT id FROM `log_states` WHERE state = ?),?,?,?,?,?,?);";
			else
			    $query = "INSERT INTO `logs` VALUES(null,null,(SELECT id FROM `log_types` WHERE type = ?),(SELECT id FROM `log_states` WHERE state = ?),?,?,?,?,?,?);";

			if ($stmt = $link->prepare($query))
			{
				if (isset($_SESSION['email']))
			    	$email = $_SESSION['email'];
			    $ip = $_SERVER['REMOTE_ADDR'];
			    
			    if (isset($_SESSION['email']))
					$rc = $stmt->bind_param("sssssssss", $email, $logt, $logs, $time, $ip, $details, $filename, $md5, $sha1);
			    else
					$rc = $stmt->bind_param("ssssssss", $logt, $logs, $time, $ip, $details, $filename, $md5, $sha1);
				
			    if ($rc)
			    {
			      	if ($stmt->execute())
						syslog(LOG_INFO, $log);
			      	else
						syslog(LOG_ERR, "ERROR WRITTING SQL 1: " . $log . $stmt->error);
				
			      	$stmt->close();
			    }	
			}
			else 
				close_mysql($link);
      	}
    	else 
    	{
			syslog(LOG_ERR, "ERROR WRITTING SQL 2: " . $log);
      	}
      
      closelog();
  }
  
  

  function generateRandomPassword($length = 10) {
		return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ*-+_()[]{}#', ceil($length/strlen($x)) )),1,$length);
  }


  function generateRandomString($length = 10) {
		return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
  }

  function download_log($from, $to) {
    $result = true;
    if (!is_dir ($_ENV['files_path']."Administrator/"))
	exec('mkdir "' . $_ENV['files_path'] . 'Administrator/"');
	
	$xmlDoc = new DOMDocument();
	$root = $xmlDoc->appendChild($xmlDoc->createElement("CYBERHAWK_LOGS"));

    $logfile = fopen($_ENV['files_path']."Administrator/LOGS_".$from."_".$to.".xml", "w");

    for ($i = 1; $i <= 2; $i++) {
		if ($i == 1)
			$firsttag = $root->appendChild($xmlDoc->createElement("SUCCESS_LOGS"));
		else
			$firsttag = $root->appendChild($xmlDoc->createElement("FAILURE_LOGS"));
		    
	for ($j = 1; $j <= 13; $j++) {
	    if ($link = connect_mysql())
	    {
		$query = "SELECT (SELECT email FROM `users` WHERE id = user_id), (SELECT type FROM `log_types` WHERE id = ?), time, ip, details, filename, md5, sha1 FROM `logs` WHERE log_state_id = ? and log_type_id = ? and DATE(time) >= DATE(?) and DATE(time) <= DATE(?) ORDER BY time DESC;";

		if ($stmt = $link->prepare($query))
		{
		  if ($stmt->bind_param("iiiss",$j,$i,$j,$from,$to))
		  {
		    if ($stmt->execute())
		    {
				$stt = 1;
				
				$stmt->bind_result($email, $type, $time, $ip, $details, $filename, $md5, $sha1);
				
				while ($stmt->fetch())
				{
				    if ($stt) {
				    	$typetag = $firsttag->appendChild($xmlDoc->createElement( str_replace("(",'',str_replace(")",'',str_replace(" ",'_', $type))) ));
						$stt = false;
				    }
				    if (isset($email) and $email != "NULL" and $email != "") 
				    	$email = $email;
				    else
				    	$email = 'Unauthentified user';

				    	$actiontag = $typetag->appendChild($xmlDoc->createElement( str_replace("(",'',str_replace(")",'',str_replace(" ",'_', $type))) ));
				    	$actiontag->appendChild($xmlDoc->createAttribute("user"))->appendChild($xmlDoc->createTextNode($email)); 


					$actiontag->appendChild($xmlDoc->createElement("Time", $time));
					$actiontag->appendChild($xmlDoc->createElement("IP", $ip));
					$actiontag->appendChild($xmlDoc->createElement("User", $email));

				    if (isset($filename) and $filename != "NULL" and $filename != "")
				    {
				    	$actiontag->appendChild($xmlDoc->createElement("Filename", $filename));
				    	$actiontag->appendChild($xmlDoc->createElement("MD5", $md5));
				    	$actiontag->appendChild($xmlDoc->createElement("SHA1", $sha1));
				    }
					
				    if (isset($details) and $details != "NULL" and $details != "")
				    	$actiontag->appendChild($xmlDoc->createElement("Details", $details));
				}
			}
		    else
		    {
			$result = false;
		    }
		    $stmt->close();
		  }
		  else 
		  {
		      $result = false;
		  }
		}
		else
		{
		    $result = false;
		}
		close_mysql($link);
	    }
	    else
	    {
		$result = false;
	    }
	}
    }
  
  	$xmlDoc->formatOutput = true;

	fputs($logfile, $xmlDoc->saveXML());
    fclose($logfile);
    
    if (!$result)
		exec('rm -f "' . $_ENV['files_path'] . 'Administrator/LOGS_'.$from.'_'.$to.'.xml"');
	
    return $result;
  }
  
  
  
  

  function clear_database_and_files()
  {
	$result = false;
	
	exec("find " . $_ENV['files_path'] . "Invited/ -type f -mtime +" . get_user_retention("Invited") . " -exec rm {} \;");

	if ($link = connect_mysql())
	{	
		$query = "SHOW COLUMNS FROM `users` LIKE 'retention'";

		$res = mysqli_query($link,$query);

		if(mysqli_num_rows($res) == 0) 
		{ 
		   	$alter = "ALTER TABLE `users` ADD retention INT(5) NULL;"; 
		   	mysqli_query($link,$alter); 

		   	$fill = "UPDATE `users` SET retention = " . intval($_ENV['clear_accounts_days']) . " WHERE email != 'Administrator';";
		   	mysqli_query($link,$fill);

		   	$fill = "UPDATE `users` SET storage = " . intval($_ENV['maximum_space']) . " WHERE email != 'Administrator';";
		   	mysqli_query($link,$fill);  
		}

		$query = "SELECT token,retention FROM `users` where email != 'Administrator';";
		$stmt = $link->prepare($query);
			
		if ($stmt)
		{
			$ex = $stmt->execute();
			    
			if ($ex)
			{
			    $stmt->bind_result($token,$retention);
			      
			    while ($stmt->fetch())
				  	exec("find " . $_ENV['files_path'] . $token . "/ -type f -mtime +" . $retention . " -exec rm {} \;");
			}
			$stmt->close();
		}

		$log_retention = $_ENV['logs_retention'];
	
		if ($log_retention != 0)
		{
		    $query = "DELETE FROM `logs` WHERE time < (NOW() - INTERVAL ? MONTH) ;";
		    
		    if ($stmt = $link->prepare($query))
		    {    
			$stmt->bind_param("i",$log_retention);
			    
			if ($stmt->execute()) 
			    $result = true;
			    
			$stmt->close();
		    }
		    else
			$result = $result & false;
		}
		
		close_mysql($link);
	}
	
	if ($link = connect_mysql())
	{	
		$share_validity = $_ENV['share_validity'];
	
		if ($share_validity != 0)
		{
		    $query = "DELETE FROM `shared_files` WHERE valid_time < (NOW() - INTERVAL ? HOUR) ;";
		    
		    if ($stmt = $link->prepare($query))
		    {    
			$stmt->bind_param("i", $share_validity);

			if ($stmt->execute()) 
			    $result = $result & true;
			    
			$stmt->close();
		    }
		    else
			$result = $result & false;
		}
		
		close_mysql($link);
	}

	return $result;
  }
  
  

  function share_file($filename, $token)
  {
	if (empty($filename) || ($filename == ""))
		return false;
	 
	if ($_ENV['share_validity'] == 0)
		return false;

	$result = false;
	$email = $_SESSION['email'];
	
	if ($link = connect_mysql())
	{	
		$share_validity = $_ENV['share_validity'];
	
		$query = "INSERT INTO `shared_files` VALUES (null, (SELECT id FROM `users` WHERE email = ?), ?, ?, now()) ;";
		    
		if ($stmt = $link->prepare($query))
		{    
			$stmt->bind_param("sss", $email, $filename, $token);

			if ($stmt->execute()) 
			    $result = true;
			    
			$stmt->close();
		}
		
		close_mysql($link);
	}
	
	return $result;
  }
  
  
  
  

  function download_file($token)
  {
	$result = false;
	$filename = "";
	
	if ($link = connect_mysql())
	{	
		$share_validity = $_ENV['share_validity'];
	
		$query = "SELECT (SELECT token FROM `users` WHERE id = user_id) as token_user, filename FROM `shared_files` WHERE token = ? AND valid_time > (NOW() - INTERVAL ? HOUR) LIMIT 1;";
		    
		if ($stmt = $link->prepare($query))
		{    
			$stmt->bind_param("si", $token, $share_validity);

			if ($stmt->execute())
			{
			    $stmt->bind_result($token_user, $filename);
			    $stmt->fetch();
			    
			    if (isset($filename) and ($filename != ""))
			    $result = $token_user."/".$filename;
			}
			$stmt->close();
		}
		
		close_mysql($link);
	}
	
	if ($result)
	{
	      if (file_exists($_ENV['files_path'] . $result)) {
		  header('Content-Type: application/octet-stream');
		  header("Content-Transfer-Encoding: binary");
		  header('Content-Disposition: attachment; filename="'.basename($_ENV['files_path'] . $result).'"');
		  header('Content-Length: ' . filesize($_ENV['files_path'] . $result));
		  readfile($_ENV['files_path'] . $result);
		  exit;
	      }
	}
  }
  
?>

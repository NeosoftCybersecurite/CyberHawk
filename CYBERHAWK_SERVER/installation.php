<?php session_start(); 

  if (isset($_GET['cancel']))
  {
	session_destroy();
	session_start();
  }
?>

<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		
		<!-- Include Twitter Bootstrap and jQuery: -->
		<link rel="stylesheet" href="./FileUpload/css/bootstrap.min.css" type="text/css"/>
		<script type="text/javascript" src="./FileUpload/js/jquery.min.js"></script>
		<script type="text/javascript" src="./FileUpload/js/bootstrap.min.js"></script>
		
		<!-- Include the plugin's CSS and JS: -->
		<script type="text/javascript" src="./js/bootstrap-multiselect.js"></script>
		<link rel="stylesheet" href="./css/bootstrap-multiselect.css" type="text/css"/>

		<title>CyberHawk Installation</title>
	</head>
	
	<body style="font-size:12px;">

<?php
  echo "
    <center>
    <h1>CyberHawk Installation</h1>
  ";

  if (!empty($_POST['dbip']))
  {
	if ($link = mysqli_connect($_POST['dbip'], $_POST['dbuser'], $_POST['dbpass']))
	{
	    $configFile = fopen("./config2.php", "w");

	    fputs($configFile, "<?php \n\n session_start();\n\n // Informations related to database\n");
	    fputs($configFile, '$_ENV[\'dbhost\'] = "' . $_POST['dbip'] . '";' . "\n");
	    fputs($configFile, '$_ENV[\'dbuser\'] = "' . $_POST['dbuser'] . '";' . "\n");
	    fputs($configFile, '$_ENV[\'dbpass\'] = "' . $_POST['dbpass'] . '";' . "\n");
	    fputs($configFile, '$_ENV[\'dbname\'] = "' . $_POST['dbname'] . '";' . "\n");
	    fputs($configFile, '$_ENV[\'logs_retention\'] = "' . $_POST['logs_retention'] . '";' . "\n");
	    fclose($configFile);
	    
	    exec("sed s/cyberhawk/" . $_POST['dbname'] . "/ ./install.sql > ./install2.sql; mv ./install2.sql ./install.sql");
	    exec("mysql -h " . $_POST['dbip'] . " -u" . $_POST['dbuser'] ." -p" . $_POST['dbpass'] . "  < ./install.sql");
	    exec("rm -f ./*.sql*");
	    
	    $_SESSION['dblink'] = true;
	}
	else
	{
	    echo "
		    <script type='text/javascript'>
			alert('Connection to the Database refused!');
		    </script>
	    ";
	}
  }
  
  if (!empty($_POST['client_name']))
  {
      $ret = true;
      
      if (!empty($_FILES['client_logo']['name']))
	   if (!move_uploaded_file($_FILES["client_logo"]["tmp_name"], "./images/client.png"))
		$ret = false;
   
      if ($ret)
      {
	    $_SESSION['client'] = true;
	    $configFile = fopen("./config2.php", "a");
	    fputs($configFile, "\n\n // Informations related to client\n");
	    fputs($configFile, '$_ENV[\'company_name\'] = "' . $_POST['client_name'] . '";' . "\n");
	    fputs($configFile, '$_ENV[\'company_logo\'] = "./images/client.png";' . "\n\n\ninclude 'contact-config.php';\ninclude 'cyberhawk-config.php';\ninclude 'modules-config.php';\ninclude 'languages.php';\ninclude 'functions.php';\n\n?>");
	    fclose($configFile);
      }
      else
      {
      	    echo "
		    <script type='text/javascript'>
			alert('Error while uploading your file!');
		    </script>
	    ";
      }
  }
  
  if (!empty($_POST['conix_name']))
  {
      $ret = true;
      
      if (!empty($_FILES['conix_qr']['name']))
	   if (!move_uploaded_file($_FILES["conix_qr"]["tmp_name"], "./images/qr.png"))
		$ret = false;
   
      if ($ret)
      {
	    $_SESSION['conix'] = true;
	    $configFile = fopen("./contact-config.php", "w");
	    fputs($configFile, "<?php \n\n // Informations related to CONIX\n");
	    fputs($configFile, '$_ENV[\'conix\'] = "' . $_POST['conix_name'] . '";' . "\n");
	    fputs($configFile, '$_ENV[\'conix_street\'] = "' . $_POST['conix_street'] . '";' . "\n");
	    fputs($configFile, '$_ENV[\'conix_postcode\'] = "' . $_POST['conix_postcode'] . '";' . "\n");
	    fputs($configFile, '$_ENV[\'conix_city\'] = "' . $_POST['conix_city'] . '";' . "\n");
	    fputs($configFile, '$_ENV[\'conix_country\'] = "' . $_POST['conix_country'] . '";' . "\n");
	    fputs($configFile, '$_ENV[\'conix_phone\'] = "' . $_POST['conix_phone'] . '";' . "\n");
	    fputs($configFile, '$_ENV[\'conix_contact\'] = "' . $_POST['conix_contact'] . '";' . "\n");
	    fputs($configFile, '$_ENV[\'conix_qrcode\'] = "/images/qr.png";' . "\n?>");
	    fclose($configFile);
      }
      else
      {
      	    echo "
		    <script type='text/javascript'>
			alert('Error while uploading your file!');
		    </script>
	    ";
      }
  }
  
  
  if (!empty($_POST['adm_passwd']))
  {
      $configFile = fopen("./cyberhawk-config.php", "w");
      fputs($configFile, "<?php\n\n // Informations related to CyberHawk\n");
      fputs($configFile, '$_ENV[\'default_language\'] = ' . $_POST['cyberhawk_language'] . ';' . "\n");
      fputs($configFile, '$_ENV[\'install_path\'] = "' . $_POST['install_path'] . '";' . "\n");
      fputs($configFile, '$_ENV[\'files_path\'] = "' . $_POST['files_path'] . '";' . "\n");
      fputs($configFile, '$_ENV[\'accounts_information\'] = ' . $_POST['accounts_information'] . ';' . "\n");
      fputs($configFile, '$_ENV[\'accounts_validation\'] = ' . $_POST['accounts_validation'] . ';' . "\n");
      fputs($configFile, '$_ENV[\'accounts_mechanisms\'] = ' . $_POST['accounts_mechanisms'] . ';' . "\n");
      fputs($configFile, '$_ENV[\'accounts_password_length\'] = ' . $_POST['accounts_password_length'] . ';' . "\n");
      fputs($configFile, '$_ENV[\'accounts_password_complexity\'] = ' . $_POST['accounts_password_complexity'] . ';' . "\n");
      fputs($configFile, '$_ENV[\'maximum_space\'] = ' . $_POST['max_space'] . ';' . "\n");
      fputs($configFile, '$_ENV[\'clear_accounts_days\'] = ' . $_POST['cyberhawk_retention'] . ';' . "\n");
      fputs($configFile, '$_ENV[\'share_validity\'] = ' . $_POST['share_validity'] . ';' . "\n");
      fputs($configFile, '$_ENV[\'MOD_DETAILS\'] = "' . $_POST['MOD_DETAILS'] . '";'. "\n");
      fputs($configFile, '$_ENV[\'CHX_VERSION\'] = "' . $_POST['CHX_VERSION'] . '";'. "\n");
      $modules = (isset($_POST['ADM_MODULES'])) ? 1 : 0;
	  fputs($configFile, '$_ENV[\'ADM_MODULES\'] = ' . $modules . ';'. "\n");
      fputs($configFile, '$_ENV[\'syslog\'] = "' . $_POST['syslog'] . '";' . "\n");

      $invited = (isset($_POST['INVITED_ACCOUNT'])) ? 1 : 0;
      fputs($configFile, '$_ENV[\'invited_account\'] = ' . $invited . ';' . "\n?>");

      fclose($configFile);
     
      $_SESSION['adm_passwd'] = $_POST['adm_passwd'];
      $_SESSION['cyberhawk'] = true;
  }
  
  
  if (!empty($_POST['0_AV_NAM']))
  {
      $configFile = fopen("./modules-config.php", "w");
      fputs($configFile, "<?php \n\n // Informations related to Modules\n");

      $mimesok = "";
      if (isset($_POST['3_AV_OK']))
	      foreach($_POST['3_AV_OK'] as $mime)
		    if ($mimesok == "")
		      $mimesok = $mime;
		    else
		      $mimesok = $mimesok . "|" . $mime;
	      
      $mimesnok = "";
      if (isset($_POST['4_AV_NOK']))
	      foreach($_POST['4_AV_NOK'] as $mime)
		    if ($mimesnok == "")
		      $mimesnok = $mime;
		    else
		      $mimesnok = $mimesnok . "|" . $mime;     

      $i = 0;
	  $j = 0;
	  while (isset($_POST[strval($j).'_AV_TYP'])) {
		if (!empty($_POST[strval($j).'_AV_NAM'])) {
	      
			  fputs($configFile, '$_ENV[\''.strval($i).'_AV_TYP\'] = "' . $_POST[strval($j).'_AV_TYP'] . '";'. "\n");
			  $act = (isset($_POST[strval($j).'_AV_ACT'])) ? 1 : 0;
			  fputs($configFile, '$_ENV[\''.strval($i).'_AV_ACT\'] = ' . $act  . ';'. "\n");
			  fputs($configFile, '$_ENV[\''.strval($i).'_AV_NAM\'] = "' . $_POST[strval($j).'_AV_NAM'] . '";' . "\n");
			  fputs($configFile, '$_ENV[\''.strval($i).'_AV_DES\'][0] = "' . $_POST[strval($j).'_AV_FRD'] . '";' . "\n");
			  fputs($configFile, '$_ENV[\''.strval($i).'_AV_DES\'][1] = "' . $_POST[strval($j).'_AV_END'] . '";' . "\n");
			  fputs($configFile, '$_ENV[\''.strval($i).'_AV_CMD\'] = "' . $_POST[strval($j).'_AV_CMD'] . '";' . "\n");
			  fputs($configFile, '$_ENV[\''.strval($i).'_AV_PTN\'] = "' . $_POST[strval($j).'_AV_PTN'] . '";' . "\n");

			  if ($i == 3)
			  {
			  	fputs($configFile, '$_ENV[\''.strval($i).'_AV_OK\']  = "/' . str_replace("/","\/",$mimesok)  . '/";' . "\n");
			  	fputs($configFile, '$_ENV[\''.strval($i).'_AV_NOK\']  = "";' . "\n");
			  }
			  else
			  {
			  	if ($i == 4)
			  	{
			  		fputs($configFile, '$_ENV[\''.strval($i).'_AV_OK\']  = "";' . "\n");
			  		fputs($configFile, '$_ENV[\''.strval($i).'_AV_NOK\']  = "/' . str_replace("/","\/",$mimesnok)  . '/";' . "\n");
			  	}
			  	else
			  	{
			  		fputs($configFile, '$_ENV[\''.strval($i).'_AV_OK\']  = "' . $_POST[strval($j).'_AV_OK']  . '";' . "\n");
			  		fputs($configFile, '$_ENV[\''.strval($i).'_AV_NOK\'] = "' . $_POST[strval($j).'_AV_NOK'] . '";' . "\n");
			  	}
			  }

			  if ($_POST[strval($j).'_AV_TYP'] == 0)
			  	fputs($configFile, '$_ENV[\''.strval($i).'_AV_DGN\'] = "' . $_POST[strval($j).'_AV_DGN'] . '";' . "\n\n");
			  else
			  	fputs($configFile, '$_ENV[\''.strval($i).'_AV_DGN\'] = "' . 1 . '";' . "\n\n");

			$i++;
		}
		$j++;
      }
      
      fputs($configFile, "\n\n?>\n");
      fclose($configFile);
    
      exec("rm -f ./installation.php");
      exec("mv -f ./config2.php config.php");
		      
      echo "
	  <h2>Step 6: Finishing Installation</h2><br/>
	  <span style='font-size: 16px; font-weight: bold;'>Installation finished, you will be redirected in 5 seconds!</span>
	  <script type=\"text/javascript\">
		  $.post('./register.php', { email: 'Administrator', pass: '" . $_SESSION['adm_passwd'] . "' } );
		  setTimeout(\"window.location='./index.php'\",5000);
	  </script>";
      
      session_destroy();
      unset($_SESSION);
      session_start();
      $_SESSION["lang"] = 0;
      
      exit(0);
  }


  

  
  
  
  if (isset($_SESSION['dblink']))
  {
      if (isset($_SESSION['client']))
      {
	  if (isset($_SESSION['conix']))
	  {
	      if (isset($_SESSION['cyberhawk']))
	      {
		      echo "
			  <h2>Step 5: Modules Information</h2><br/>
			  
			  <form action='./installation.php' method='post' enctype='multipart/form-data'>
			  <table id='myTable' name='myTable' border=1 >
			    <tr>
			      <th style='padding: 10px; width: 150px;'><center>Module Type</center></th>
			      <th style='padding: 10px; max-width: 95px;'><center>Activated?</center></th>
			      <th style='padding: 10px; max-width: 150px;'><center>Module Name</center></th>
			      <th style='padding: 10px; max-width: 100px;'><center>Module Description (FR / EN)</center></th>
			      <th style='padding: 10px; max-width: 200px;'><center>Module Launch Command</center></th>
			      <th style='padding: 10px; max-width: 150px;'><center>Updates location (Antivirus Only)</center></th>
			      <th style='padding: 10px; max-width: 150px;'><center>Regular Expression (Safe File)</center></th>
			      <th style='padding: 10px; max-width: 150px;'><center>Regular Expression (Unsafe File)</center></th>
			      <th style='padding: 10px; max-width: 150px;'><center>Days before update alert is triggered (Antivirus Only)</center></th>
			    </tr>
			    
			    
			    <tr>
			      <td><center>
				  <select name='0_AV_TYP' readonly>
				      <option value='0' selected>Antivirus</option>
				      <option value='1'>Command / Script</option>
				      <option value='2'>Whitelist</option>
				      <option value='3'>Blacklist</option>
				  </select></center>
				  </td>
				  <td style='padding: 10px;'><center><input type='checkbox' name='0_AV_ACT' checked></center></td>
			      <td style='padding: 10px;'><center><input size=20 type='text' name='0_AV_NAM' value='ClamAV' readonly></center></td>
			      <td style='padding: 10px;'><center><textarea name='0_AV_FRD' readonly>Analyse antivirale ClamAV.</textarea><br/><textarea name='0_AV_END' readonly>ClamAV antiviral analysis.</textarea></center></td>
			      <td style='padding: 10px;'><center><input type='text' name='0_AV_CMD' value='/usr/bin/clamdscan --fdpass [FILE]' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='text' name='0_AV_PTN' value='/var/lib/clamav/*.c*d' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='text' name='0_AV_OK' value='/\:\ OK/' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='text' name='0_AV_NOK' value='/\:\s*(.*)\ FOUND/' readonly/></center></td>
			      <td><center>
				  <select name='0_AV_DGN'>
				      <option value='1'>1 day</option>
				      <option value='7'>1 week</option>
				      <option value='10' selected >10 days</option>
				      <option value='15'>15 days</option>
				      <option value='31'>1 month</option>
				  </select></center>
				</td>
			    </tr>
			    
			    
			    <tr>
			      <td><center>
				  <select name='1_AV_TYP' readonly>
				      <option value='0' selected>Antivirus</option>
				      <option value='1'>Command / Script</option>
				      <option value='2'>Whitelist</option>
				      <option value='3'>Blacklist</option>
				  </select></center>
				  </td>
			      <td style='padding: 10px;'><center><input type='checkbox' name='1_AV_ACT' checked></center></td>
			      <td style='padding: 10px;'><center><input size=20 type='text' name='1_AV_NAM' value='Sophos' readonly></center></td>
			      <td style='padding: 10px;'><center><textarea name='1_AV_FRD' readonly>Analyse antivirale Sophos.</textarea><br/><textarea name='1_AV_END' readonly>Sophos antiviral analysis.</textarea></center></td>
			      <td style='padding: 10px;'><center><input type='text' name='1_AV_CMD' value='/opt/cyberhawk/scan-sophos-sssp.sh [FILE]' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='text' name='1_AV_PTN' value='/opt/sophos-av/lib/sav/*.ide' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='text' name='1_AV_OK' value='/The\ function\ call\ succeeded/' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='text' name='1_AV_NOK' value='/VIRUS\ ([^\ ]*)/' readonly/></center></td>
				<td><center>
				  <select name='1_AV_DGN'>
				      <option value='1'>1 day</option>
				      <option value='7'>1 week</option>
				      <option value='10' selected >10 days</option>
				      <option value='15'>15 days</option>
				      <option value='31'>1 month</option>
				  </select></center>
				</td>
			    </tr>
			    
			    
			    <tr>
			      <td><center>
				  <select name='2_AV_TYP' readonly>
				      <option value='0' selected>Antivirus</option>
				      <option value='1'>Command / Script</option>
				      <option value='2'>Whitelist</option>
				      <option value='3'>Blacklist</option>
				  </select></center>
				  </td>
			      <td style='padding: 10px;'><center><input type='checkbox' name='2_AV_ACT' checked></center></td>
			      <td style='padding: 10px;'><center><input size=20 type='text' name='2_AV_NAM' value='Comodo' readonly></center></td>
			      <td style='padding: 10px;'><center><textarea name='2_AV_FRD' readonly>Analyse antivirale Comodo.</textarea><br/><textarea name='2_AV_END' readonly>Comodo antiviral analysis.</textarea></center></td>
			      <td style='padding: 10px;'><center><input type='text' name='2_AV_CMD' value='/opt/COMODO/cmdscan -v -s [FILE]' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='text' name='2_AV_PTN' value='/opt/COMODO/scanners/*.cav' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='text' name='2_AV_OK' value='/Not\ Virus/' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='text' name='2_AV_NOK' value='/Malware\ Name\ is\ (.*)/' readonly/></center></td>
			      <td><center>
				  <select name='2_AV_DGN'>
				      <option value='1'>1 day</option>
				      <option value='7'>1 week</option>
				      <option value='10' selected >10 days</option>
				      <option value='15'>15 days</option>
				      <option value='31'>1 month</option>
				  </select></center>
				</td>
			    </tr>



			    <tr>
			      <td><center>
				  <select name='3_AV_TYP' readonly>
				      <option value='0'>Antivirus</option>
				      <option value='1'>Command / Script</option>
				      <option value='2' selected>Whitelist</option>
				      <option value='3'>Blacklist</option>
				  </select></center>
				  </td>
			      <td style='padding: 10px;'><center><input type='checkbox' name='3_AV_ACT' id='3_AV_ACT' onclick=\"document.getElementById('4_AV_ACT').checked = false;\"></center></td>
			      <td style='padding: 10px;'><center><input size=20 type='text' name='3_AV_NAM' value='Whitelist' readonly></center></td>
			      <td style='padding: 10px;'><center><textarea name='3_AV_FRD' readonly>Autorise une liste de fichiers (extensions) ne présentant aucun risque de malveillance.</textarea><br/><textarea name='3_AV_END' readonly>Allows a files' list (extensions) presenting no risk of maliciousness.</textarea></center></td>
			      <td style='padding: 10px;'><center><input type='text' name='3_AV_CMD' value='file --mime-type -b [FILE]' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='hidden' name='3_AV_PTN' value='' readonly/></center></td>
			      <td style='padding: 10px;'><center>

 					<select name='3_AV_OK[]' id='3_AV_OK' multiple='multiple' class=\"json-multiple-select0\"></select>
				    <script type='text/javascript'>
						$.getJSON('./multipleselect.json', function (data) {
							$.each(data.sectors, function (i, sector) {
								var group = $('<optgroup />').attr('label', sector.title).appendTo('.json-multiple-select0');

								$.each(sector.extensions, function (i, extention) {
									$('<option value=\"' + extention.value + '\" />').html(extention.name).appendTo(group);
								});
							});
						});

						setTimeout(
							function() 
							{
								$('#3_AV_OK').multiselect({
							    	enableClickableOptGroups: true,
							    	enableCollapsibleOptGroups: false,
							    	enableFiltering: true,
							    	maxHeight: 200,
							    	buttonWidth: '200px'
								});
							 }
							,1000);
						
				    </script>
				    </script>


			      </center></td>


			      <td style='padding: 10px;'><center><input type='hidden' name='3_AV_NOK' value='' readonly/></center></td>
			      <td></td>
			    </tr>


			      <tr>
			      <td><center>
				  <select name='4_AV_TYP' readonly>
				      <option value='0'>Antivirus</option>
				      <option value='1'>Command / Script</option>
				      <option value='2'>Whitelist</option>
				      <option value='3' selected>Blacklist</option>
				  </select></center>
				  </td>
			      <td style='padding: 10px;'><center><input type='checkbox' onclick=\"document.getElementById('3_AV_ACT').checked = false;\" name='4_AV_ACT' id='4_AV_ACT'></center></td>
			      <td style='padding: 10px;'><center><input  size=20 type='text' name='4_AV_NAM' value='Blacklist' readonly></center></td>
			      <td style='padding: 10px;'><center><textarea name='4_AV_FRD' readonly>Bloque une liste de fichiers (extensions) présentant un risque de malveillance.</textarea><br/><textarea name='4_AV_END' readonly>Blocks a files' list (extensions) presenting a risk of maliciousness.</textarea></center></td>
			      <td style='padding: 10px;'><center><input type='text' name='4_AV_CMD' value='file --mime-type -b [FILE]' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='hidden' name='4_AV_PTN' value='' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='hidden' name='4_AV_OK' value='' readonly/></center></td>
			      <td style='padding: 10px;'><center>

 					<select name='4_AV_NOK[]' id='4_AV_NOK' multiple='multiple' class=\"json-multiple-select1\"></select>


				    <script type='text/javascript'>
						$.getJSON('./multipleselect.json', function (data) {
							$.each(data.sectors, function (i, sector) {
								var group = $('<optgroup />').attr('label', sector.title).appendTo('.json-multiple-select1');

								$.each(sector.extensions, function (i, extention) {
									$('<option value=\"' + extention.value + '\" />').html(extention.name).appendTo(group);
								});
							});
						});

						setTimeout(
							function() 
							{
								$('#4_AV_NOK').multiselect({
							    	enableClickableOptGroups: true,
							    	enableCollapsibleOptGroups: false,
							    	enableFiltering: true,
							    	maxHeight: 200,
							    	buttonWidth: '200px'
								});
							 }
							,1000);
						
				    </script>


			      </center></td>

			      <td></td>
			    </tr>

			    <tr>
			      <td><center>
				  <select name='5_AV_TYP' readonly>
				      <option value='0'>Antivirus</option>
				      <option value='1' selected>Command / Script</option>
				      <option value='2'>Whitelist</option>
				      <option value='3'>Blacklist</option>
				  </select></center>
				  </td>
				  <td style='padding: 10px;'><center><input type='checkbox' name='5_AV_ACT'></center></td>
			      <td style='padding: 10px;'><center><input size=20 type='text' name='5_AV_NAM' value='OCR (Images)' readonly></center></td>
			      <td style='padding: 10px;'><center><textarea name='5_AV_FRD' readonly>Blocage des images par reconnaissance optique de caractères (ROC).</textarea><br/><textarea name='5_AV_END' readonly>Blocking of images by optical character recognition (OCR).</textarea></center></td>
			      <td style='padding: 10px;'><center><input type='text' name='5_AV_CMD' value='tesseract [FILE] stdout | grep \a' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='hidden' name='5_AV_PTN' value='' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='text' name='5_AV_OK' value=''/></center></td>
			      <td style='padding: 10px;'><center><input type='text' name='5_AV_NOK' value='/Confidentiel|Confidential/'/></center></td>
			      <td></td>
			    </tr>

			    <tr>
			      <td><center>
				  <select name='6_AV_TYP' readonly>
				      <option value='0'>Antivirus</option>
				      <option value='1' selected>Command / Script</option>
				      <option value='2'>Whitelist</option>
				      <option value='3'>Blacklist</option>
				  </select></center>
				  </td>
				  <td style='padding: 10px;'><center><input type='checkbox' name='6_AV_ACT'></center></td>
			      <td style='padding: 10px;'><center><input size=20 type='text' name='6_AV_NAM' value='OCR (PDF)' readonly></center></td>
			      <td style='padding: 10px;'><center><textarea name='6_AV_FRD' readonly>Blocage des PDF par reconnaissance optique de caractères (ROC).</textarea><br/><textarea name='6_AV_END' readonly>Blocking of PDF by optical character recognition (OCR).</textarea></center></td>
			      <td style='padding: 10px;'><center><input type='text' name='6_AV_CMD' value='pdftotext [FILE] -' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='hidden' name='6_AV_PTN' value='' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='text' name='6_AV_OK' value=''/></center></td>
			      <td style='padding: 10px;'><center><input type='text' name='6_AV_NOK' value='/Confidentiel|Confidential/'/></center></td>
			      <td></td>
			    </tr>

			    <tr>
			      <td><center>
				  <select name='7_AV_TYP' readonly>
				      <option value='0'>Antivirus</option>
				      <option value='1' selected>Command / Script</option>
				      <option value='2'>Whitelist</option>
				      <option value='3'>Blacklist</option>
				  </select></center>
				  </td>
				  <td style='padding: 10px;'><center><input type='checkbox' name='7_AV_ACT'></center></td>
			      <td style='padding: 10px;'><center><input size=20 type='text' name='7_AV_NAM' value='VBA Blocker' readonly></center></td>
			      <td style='padding: 10px;'><center><textarea name='7_AV_FRD' readonly>Blocage des fichiers Office contenant des Macros.</textarea><br/><textarea name='7_AV_END' readonly>Blocking Office files containing Macros.</textarea></center></td>
			      <td style='padding: 10px;'><center><input type='text' name='7_AV_CMD' value='/opt/cyberhawk/oletools/oletools/olevba.py -a [FILE]' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='hidden' name='7_AV_PTN' value='' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='text' name='7_AV_OK' value=''/></center></td>
			      <td style='padding: 10px;'><center><input type='text' name='7_AV_NOK' value='/VBA\ MACRO\ /'/></center></td>
			      <td></td>
			    </tr>

			    <tr>
			      <td><center>
				  <select name='8_AV_TYP' readonly>
				      <option value='0'>Antivirus</option>
				      <option value='1' selected>Command / Script</option>
				      <option value='2'>Whitelist</option>
				      <option value='3'>Blacklist</option>
				  </select></center>
				  </td>
				  <td style='padding: 10px;'><center><input type='checkbox' name='8_AV_ACT'></center></td>
			      <td style='padding: 10px;'><center><input size=20 type='text' name='8_AV_NAM' value='Malicious VBA Blocker' readonly></center></td>
			      <td style='padding: 10px;'><center><textarea name='8_AV_FRD' readonly>Blocage des fichiers Office contenant des Macros potentiellement malveillantes.</textarea><br/><textarea name='8_AV_END' readonly>Blocking Office files containing potentially malicious macros.</textarea></center></td>
			      <td style='padding: 10px;'><center><input type='text' name='8_AV_CMD' value='/opt/cyberhawk/oletools/oletools/mraptor.py [FILE]' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='hidden' name='8_AV_PTN' value='' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='text' name='8_AV_OK' value=''/></center></td>
			      <td style='padding: 10px;'><center><input type='text' name='8_AV_NOK' value='/20\ -\ SUSPICIOUS/'/></center></td>
			      <td></td>
			    </tr>
			  </table>
			  
			   <br />

			   <script>
			  	cpt = 8;
			  	function add_row()
			  	{
			  		cpt++;
			  		$('#myTable > tbody').append(`
						    <tr>
						      <td><center>
							  <select name='`+cpt+`_AV_TYP'>
							      <option value='0'>Antivirus</option>
							      <option value='1' selected>Command / Script</option>
							  </select></center>
							  </td>
							  <td style='padding: 10px;'><center><input type='checkbox' name='`+cpt+`_AV_ACT'></center></td>
						      <td style='padding: 10px;'><center><input size=20 type='text' name='`+cpt+`_AV_NAM'></center></td>
						      <td style='padding: 10px;'><center><textarea name='`+cpt+`_AV_FRD'></textarea><br/><textarea name='`+cpt+`_AV_END'></textarea></center></td>
						      <td style='padding: 10px;'><center><input type='text' name='`+cpt+`_AV_CMD' /></center></td>
						      <td style='padding: 10px;'><center><input type='text' name='`+cpt+`_AV_PTN' /></center></td>
						      <td style='padding: 10px;'><center><input type='text' name='`+cpt+`_AV_OK' /></center></td>
						      <td style='padding: 10px;'><center><input type='text' name='`+cpt+`_AV_NOK' /></center></td>
						      <td><center>
								  <select name='`+cpt+`_AV_DGN'>
								      <option value='1'>1 day</option>
								      <option value='7'>1 week</option>
								      <option value='10' selected >10 days</option>
								      <option value='15'>15 days</option>
								      <option value='31'>1 month</option>
								  </select></center>
							</td>
						    </tr>
			  			`);
			  	}
			  </script>
			
			  <input type=button value='Add Module' onclick='add_row();' />
			  <br /><br />


			   <input type='submit' value='Next Step!' />
			  </form>


		      ";
	      }
	      else
	      {
		    echo "
			  <h2>Step 4: CyberHawk Information</h2><br/>
			  
			  <form action='./installation.php' method='post'>
			    <table style='border-collapse: separate; border-spacing: 0px 5px;'>
			      <tr>
				<td><h4>General</h4></td>
			      </tr>
			      <tr>
				<td>Default Language:</td>
				<td>
				    <select name='cyberhawk_language'>
				      	<option value='0' selected>French</option>
				      	<option value='1'         >English</option>
					<option value='2'         >Spanish</option>
					<option value='3'         >Italian</option>
				    </select>
				</td>
			      </tr>
			      <tr>
				<td>Web server Path:</td>
				<td>
				    <input type='text' name='install_path' value='/var/www/' />
				</td>
			      </tr>
			      <tr>
				<td>File Storage Path:</td>
				<td>
				    <input type='text' name='files_path' value='/var/files/' /><font size='2' color='red'> /!\ For security, set a path outside of /var/www/ (/var/files for example, with www-data write privileges)!</font>
				</td>
			      </tr>
			      
			      <tr> <td>&nbsp;</td> <td>&nbsp;</td> </tr>
			      <tr> <td>&nbsp;</td> <td>&nbsp;</td> </tr>
			      
			      
			      <tr>
				<td><h4>Administration</h4></td>
			      </tr>
			      <tr>
				<td>User 'Administrator' login:</td>
				<td>
				    <input type='text' name='tmp' value='Administrator' readonly />
				</td>
			      </tr>
			      <tr>
				<td>User 'Administrator' password:</td>
				<td>
				    <input type='text' name='adm_passwd' /><font size='2' color='red'> /!\ Please use a strong password!</font>
				</td>
			      </tr>

			    <tr>
			    <td>Activate modules for Administrator ?:</td>
				<td>
				   <input type='checkbox' name='ADM_MODULES' checked>
				</td>
				</tr>
			      
			      <tr> <td>&nbsp;</td> <td>&nbsp;</td> </tr>
			      <tr> <td>&nbsp;</td> <td>&nbsp;</td> </tr>
			      
			      <tr>
				<td><h4>Users</h4></td>
			      </tr>
			      
			      
			      <tr>
			    <td>Invited Acccount:</td>
				<td>
				    <input type='checkbox' name='INVITED_ACCOUNT'></center><font size='2' color='red'> /!\ For security reason, files within this shared space will be erased each 24 hours.</font>
				</td>
				</tr>
			      
			      
			      <tr>
			    <td>Personal Information:</td>
				<td>
				    <select name='accounts_information'>
				      <option value='1' selected>Required (First / Last Name)</option>
				      <option value='0'         >Deactivated</option>
				    </select>
				</td>
			      </tr>
			      
			      <tr>
				<td>Accounts validation:</td>
				<td>
				    <select name='accounts_validation'>
				      <option value='2' 		>No registration allowed (Database import only)</option>
				      <option value='1' selected>No validation required</option>
				      <option value='0'         >Administrator validation required</option>
				    </select>
				</td>
			      </tr>
			      
			      <tr>
			    <td>Login Allowed Mechanisms:</td>
				<td>
				    <select name='accounts_mechanisms'>
				      <option value='0' selected>Authentication & Indentification</option>
				      <option value='1'         >Authentication Only</option>
				      <option value='2'         >Identification Only</option>
				    </select>
				</td>
			      </tr>
			      
			      <tr>
			    <td>Password Minimum Length:</td>
				<td>
				    <select name='accounts_password_length'>
				      <option value='4'         >4 Characters</option>
				      <option value='6' selected>6 Characters</option>
				      <option value='8'         >8 Characters</option>
				    </select>
				</td>
			      </tr>
			      
			      <tr>
			    <td>Password Complexity:</td>
				<td>
				    <select name='accounts_password_complexity'>
				      <option value='0.0'         >Simple (e.g. 123456)</option>
				      <option value='0.3'         >Medium (e.g. 12E456)</option>
				      <option value='0.7' selected>Complex (e.g. 12E4*6d6)</option>
				    </select>
				</td>
			      </tr>
			      
			      <tr>
			    <td>Maximum Default Personal Storage Space:</td>
				<td>
				    <select name='max_space'>
				      <option value='10000000' selected>10 Mo</option>
				      <option value='50000000'         >50 Mo</option>
				      <option value='100000000'        >100 Mo</option>
				      <option value='250000000'        >250 Mo</option>
				      <option value='500000000'        >500 Mo</option>
				      <option value='1000000000'       >1 Go</option>
				      <option value='0'                >Unlimited</option>
				    </select>
				</td>
			      </tr>

			    <tr>
			    <td>Show modules details (name, description) to users:</td>
				<td>
				   <input type='checkbox' name='MOD_DETAILS' checked>
				</td>
				</tr>

			    <tr>
			    <td>Show CyberHawk version and Changelog to users:</td>
				<td>
				   <input type='checkbox' name='CHX_VERSION' checked>
				</td>
				</tr>

			      <tr> <td>&nbsp;</td> <td>&nbsp;</td> </tr>
			      <tr> <td>&nbsp;</td> <td>&nbsp;</td> </tr>
			      
			      
			      <tr>
				<td><h4>Files</h4></td>
			      </tr>
			      <tr>
				<td>Files Default Retention Time (days):</td>
				<td>
				    <select name='cyberhawk_retention'>
				      <option value='1'         >1 Day</option>
				      <option value='7'         >7 Days</option>
				      <option value='31'        >31 Days</option>
				      <option value='365'       >1 Year</option>
				      <option value='0' selected>Unlimited</option>
				    </select>
				</td>
			      </tr>

			      		      <tr>
			<td>Share Link Validity (hours):</td>
			<td>
				<select name='share_validity'>
					  <option value='0' selected>Deactivated</option>
				      <option value='1'         >1 Hour</option>
				      <option value='2'         >2 Hours</option>
				      <option value='3'         >3 Hours</option>
				      <option value='6'         >6 Hours</option>
				      <option value='12'        >12 Hours</option>
				      <option value='24'        >24 Hours</option>
				</select>
			</td>
		      </tr>
			      
			      <tr> <td>&nbsp;</td> <td>&nbsp;</td> </tr>
			      <tr> <td>&nbsp;</td> <td>&nbsp;</td> </tr>
			      
			      
			      <tr>
				<td><h4>Logs</h4></td>
			      </tr>
			      <tr>
				<td>Syslog:</td>
				<td>
				    <input type='text' name='syslog' value='/var/log/syslog' readonly />
				</td>
			      </tr>

			    </table>
			    <br />
			    <input type='submit' value='Next Step!' />
			  </form>
		    ";
	      }
	  }
	  else
	  {
		echo "
			  <h2>Step 3: Contact Information</h2><br/>
			  
			  <form action='./installation.php' method='post' enctype='multipart/form-data'>
			    <table style='border-collapse: separate; border-spacing: 0px 5px;'>
			      <tr>
				<td>Name:</td>
				<td><input type='text' name='conix_name' value='CONIX Technologies et Services' /></td>
			      </tr>
			      <tr>
				<td>Street:</td>
				<td><input type='text' name='conix_street' value='2, rue Maurice Hartmann' /></td>
			      </tr>
			      <tr>
				<td>Postcode:</td>
				<td><input type='text' name='conix_postcode' value='92130' /></td>
			      </tr>
			      <tr>
				<td>City:</td>
				<td><input type='text' name='conix_city' value='Issy-les-Moulineaux' /></td>
			      </tr>
			      <tr>
				<td>Country:</td>
				<td><input type='text' name='conix_country' value='France' /></td>
			      </tr>
			      <tr>
				<td>Phone:</td>
				<td><input type='text' name='conix_phone' value='+33 1 46 41 08 00' /></td>
			      </tr>
			      <tr>
				<td>Contact Email:</td>
				<td><input type='text' name='conix_contact' value='cyberhawk@conix.fr'/></td>
			      </tr>
			      <tr>
				  <td>QR Code (PNG):</td>
				  <td><center><img height='100px' src='./images/qr.png' /></center></td>
				  <td><input type='file' name='conix_qr' /></td>
				</tr>
			    </table>
			    <br />
			    <input type='submit' value='Next Step!' />
			  </form>
		";
	  }
	
      }
      else
      {
	echo "
		    <h2>Step 2: Client Information</h2><br/>
		    
		    <form action='./installation.php' method='post' enctype='multipart/form-data'>
		      <table style='border-collapse: separate; border-spacing: 0px 5px;'>
			<tr>
			  <td>Name:</td>
			  <td><input type='text' name='client_name' value='Customer' /></td>
			</tr>
			<tr>
			  <td>Logo (PNG):</td>
			  <td><center><img height='100px' src='./images/client.png' /></center></td>
			  <td><input type='file' name='client_logo' /></td>
			</tr>
		      </table>
		      <br />
		      <input type='submit' value='Next Step!' />
		    </form>
	  ";
      }
  }
  else
  {
	echo "
		  <h2>Step 1: Database Configuration</h2><br/>
		  
		  <form action='./installation.php' method='post'>
		    <table style='border-collapse: separate; border-spacing: 0px 5px;'>
		      <tr>
			<td>Database IP:</td>
			<td><input type='text' name='dbip' value='127.0.0.1' /></td>
		      </tr>
		      <tr>
			<td>Database Name:</td>
			<td><input type='text' name='dbname' value='cyberhawk' /></td>
		      </tr>
		      <tr>
			<td>User Name:</td>
			<td><input type='text' name='dbuser' /></td>
		      </tr>
		      <tr>
			<td>User Password:</td>
			<td><input type='password' name='dbpass' /></td>
		      </tr>
		      
		      <tr> <td>&nbsp;</td> <td>&nbsp;</td> </tr>
		      <tr> <td>&nbsp;</td> <td>&nbsp;</td> </tr>
		      
		      <tr>
			<td>Application's Logs Retention Time (months):</td>
			<td>
				<select name='logs_retention'>
				      <option value='1'         >1 Month</option>
				      <option value='2'         >2 Months</option>
				      <option value='3'         >3 Months</option>
				      <option value='6'         >6 Months</option>
				      <option value='12'        >12 Months</option>
				      <option value='24'        >24 Months</option>
				      <option value='0' selected>Unlimited</option>
				</select>
			</td>
		      </tr>
		    </table>
		    <br />
		    <input type='submit' value='Next Step!' />
		  </form>
    ";
  }
  
  echo "<br /><br /><br /><a href='./installation.php?cancel=1'>Cancel All</a></center>";
?>



	</body>
</html>

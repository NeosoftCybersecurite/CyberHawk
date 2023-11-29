<?php 
    include 'config.php'; 
    
    if (!is_admin())
	exit(1);
	
    if (isset($_POST['conix_name']))
    {
    	$response_array['status'] = true;

    	if (!check_csrf_token($_POST["CSRF_TOKEN"]))
    	{
    		$response_array['status'] = "CSRF Protection";
    	}
    	else
    	{
		      if (!empty($_FILES['conix_qr']['name']))
			   if (!move_uploaded_file($_FILES["conix_qr"]["tmp_name"], $_ENV['install_path'] . "images/qr.png"))
				$response_array['status'] = false;
		   
		      if ($response_array['status'])
		      {
			    $configFile = fopen("./contact-config.php", "w");
			    fputs($configFile, "<?php \n\n // Informations related to CONIX\n");
			    fputs($configFile, '$_ENV[\'conix\'] = "' . htmlentities($_POST['conix_name'], ENT_QUOTES) . '";' . "\n");
			    fputs($configFile, '$_ENV[\'conix_street\'] = "' .  htmlentities($_POST['conix_street'], ENT_QUOTES) . '";' . "\n");
			    fputs($configFile, '$_ENV[\'conix_postcode\'] = "' .  htmlentities($_POST['conix_postcode'], ENT_QUOTES) . '";' . "\n");
			    fputs($configFile, '$_ENV[\'conix_city\'] = "' .  htmlentities($_POST['conix_city'], ENT_QUOTES) . '";' . "\n");
			    fputs($configFile, '$_ENV[\'conix_country\'] = "' .  htmlentities($_POST['conix_country'], ENT_QUOTES) . '";' . "\n");
			    fputs($configFile, '$_ENV[\'conix_phone\'] = "' .  htmlentities($_POST['conix_phone'], ENT_QUOTES) . '";' . "\n");
			    fputs($configFile, '$_ENV[\'conix_contact\'] = "' .  htmlentities($_POST['conix_contact'], ENT_QUOTES) . '";' . "\n");
			    fputs($configFile, '$_ENV[\'conix_qrcode\'] = "/images/qr.png";' . "\n?>");
			    fclose($configFile);
		      }
		}
		 
		header('Content-type: application/json');
		echo json_encode($response_array);
		exit(0);
    }
?>


	    <center>
	    <div>
			    <table id="contactmgt" style='display:none;border-collapse: separate; border-spacing: 0px 5px;'>
			    	<tr>
				    <td colspan=4 style='padding: 5px;'>	    
				    	<center><b><h4 style="cursor:pointer" onclick="$('#contactmgt').toggle();"><?php echo $_ENV["Accounts44"][$_SESSION['lang']] ; ?></h4></b></center>
				    </td>
				    </tr>
			      <tr>
			      <tr>
				<td><?php echo $_ENV["Contact5"][$_SESSION['lang']]; ?></td>
				<td><input type='text' id='conix_name' value='<?php echo $_ENV['conix']; ?>' /></td>
			      </tr>
			      <tr>
				<td><?php echo $_ENV["Contact6"][$_SESSION['lang']]; ?></td>
				<td><input type='text' id='conix_street' value='<?php echo $_ENV['conix_street']; ?>' /></td>
			      </tr>
			      <tr>
				<td><?php echo $_ENV["Contact7"][$_SESSION['lang']]; ?></td>
				<td><input type='text' id='conix_postcode' value='<?php echo $_ENV['conix_postcode']; ?>' /></td>
			      </tr>
			      <tr>
				<td><?php echo $_ENV["Contact8"][$_SESSION['lang']]; ?></td>
				<td><input type='text' id='conix_city' value='<?php echo $_ENV['conix_city']; ?>' /></td>
			      </tr>
			      <tr>
				<td><?php echo $_ENV["Contact9"][$_SESSION['lang']]; ?></td>
				<td><input type='text' id='conix_country' value='<?php echo $_ENV['conix_country']; ?>' /></td>
			      </tr>
			      <tr>
				<td><?php echo $_ENV["Contact3"][$_SESSION['lang']]; ?></td>
				<td><input type='text' id='conix_phone' value='<?php echo $_ENV['conix_phone']; ?>' /></td>
			      </tr>
			      <tr>
				<td><?php echo $_ENV["Contact10"][$_SESSION['lang']]; ?></td>
				<td><input type='text' id='conix_contact' value='<?php echo $_ENV['conix_contact']; ?>'/></td>
			      </tr>
			      <tr>
				  <td>QR Code (PNG):</td>
				  <td><center><img height='100px' src='.<?php echo $_ENV['conix_qrcode']; ?>' /></center></td>
				  <td><input type='file' id='conix_qr' /></td>
				</tr>
				<tr><td colspan=3>&nbsp;</td></tr>
				<tr>
					<td colspan=3><center>
						<button id="param_contact_mgt" type="submit" class="btn btn-primary">
						<i class="glyphicon glyphicon-ok"></i>
						<span>OK</span>
						</button></center>
					</td>
				</tr>
			    </table>
		</div>
			  </center>
	  
	<script type='text/javascript'>
		$("#param_contact_mgt").click(function(){ 
			var data = new FormData();
			data.append("CSRF_TOKEN", "<?php echo generate_csrf_token(); ?>");
			data.append("conix_name", $("#conix_name").val());
			data.append("conix_street", $("#conix_street").val());
			data.append("conix_postcode", $("#conix_postcode").val());
			data.append("conix_city", $("#conix_city").val());
			data.append("conix_country", $("#conix_country").val());
			data.append("conix_phone", $("#conix_phone").val());
			data.append("conix_contact", $("#conix_contact").val());
			data.append("conix_qr",  $("#conix_qr")[0].files[0]);

			$.ajax({
				type: "POST",
				enctype: "multipart/form-data",
				processData : false,
				contentType: false,
				cache : false,
				url: "./param_contact.php",
				data: data,
				success: function(data, textStatus, jqXHR)
				{
				    if (data.status == true) {
						swal({ title: "<?php echo $_ENV["Accounts9"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Accounts45"][$_SESSION['lang']]; ?>", type: "success" },
						    function(isConfirm){ $('#contactmgt').toggle(); scroll(0,0); }
						);
				    }
				    else
						swal({ title: "<?php echo $_ENV["Logs4"][$_SESSION['lang']]; ?>", text: data.status, type: "error" });
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					swal({ title: "<?php echo $_ENV["Logs4"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Logs4"][$_SESSION['lang']]; ?>", type: "error" });
				}
			});
		});
	</script>

<?php 
    include 'config.php'; 
    
    if (!is_admin())
		exit(1);

    if (isset($_POST['cyberhawk_language']))
    {
    	$response_array['status'] = true;

    	if (!check_csrf_token($_POST["CSRF_TOKEN"]))
    	{
    		$response_array['status'] = "CSRF Protection";
    	}
    	else
    	{
		      $configFile = fopen("./cyberhawk-config.php", "w");
		      fputs($configFile, "<?php\n\n // Informations related to CyberHawk\n");
		      fputs($configFile, '$_ENV[\'default_language\'] = ' . htmlentities($_POST['cyberhawk_language'], ENT_QUOTES) . ';' . "\n");
		      fputs($configFile, '$_ENV[\'install_path\'] = "' . $_ENV['install_path'] . '";' . "\n");
		      fputs($configFile, '$_ENV[\'files_path\'] = "' . $_ENV['files_path'] . '";' . "\n");
		      fputs($configFile, '$_ENV[\'accounts_information\'] = ' . htmlentities($_POST['accounts_information'], ENT_QUOTES) . ';' . "\n");
		      fputs($configFile, '$_ENV[\'accounts_validation\'] = ' . htmlentities($_POST['accounts_validation'], ENT_QUOTES) . ';' . "\n");
		      fputs($configFile, '$_ENV[\'accounts_mechanisms\'] = ' . htmlentities($_POST['accounts_mechanisms'], ENT_QUOTES) . ';' . "\n");
		      fputs($configFile, '$_ENV[\'accounts_password_length\'] = ' . $_ENV['accounts_password_length'] . ';' . "\n");
		      fputs($configFile, '$_ENV[\'accounts_password_complexity\'] = ' . $_ENV['accounts_password_complexity'] . ';' . "\n");
		      fputs($configFile, '$_ENV[\'maximum_space\'] = ' . htmlentities($_POST['max_space'], ENT_QUOTES) . ';' . "\n");
		      fputs($configFile, '$_ENV[\'clear_accounts_days\'] = ' . htmlentities($_POST['cyberhawk_retention'], ENT_QUOTES) . ';' . "\n");
		      fputs($configFile, '$_ENV[\'share_validity\'] = ' . htmlentities($_POST['share_validity'], ENT_QUOTES) . ';' . "\n");
		      fputs($configFile, '$_ENV[\'MOD_DETAILS\'] = "' . htmlentities($_POST['MOD_DETAILS'], ENT_QUOTES) . '";'. "\n");
		      fputs($configFile, '$_ENV[\'CHX_VERSION\'] = "' . htmlentities($_POST['CHX_VERSION'], ENT_QUOTES) . '";'. "\n");
		      $modules = (isset($_POST['ADM_MODULES'])) ? 1 : 0;
			  fputs($configFile, '$_ENV[\'ADM_MODULES\'] = ' . $modules . ';'. "\n");
		      fputs($configFile, '$_ENV[\'syslog\'] = "' . $_ENV['syslog'] . '";' . "\n");

		      $invited = (isset($_POST['INVITED_ACCOUNT'])) ? 1 : 0;
		      fputs($configFile, '$_ENV[\'invited_account\'] = ' . $invited . ';' . "\n?>");

		      fclose($configFile);
		}
		 
		header('Content-type: application/json');
		echo json_encode($response_array);
		exit(0);
    }
?>


	    <center>
	    <div>
			    <table id="cyberhawkmgt" style='display:none;border-collapse: separate; border-spacing: 0px 5px;'>
			    	<tr>
				    <td colspan=2 style='padding: 5px;'>
				    	<center><b><h4 style="cursor:pointer" onclick="$('#cyberhawkmgt').toggle();"><?php echo $_ENV["Accounts42"][$_SESSION['lang']] ; ?></h4></b></center>
				    </td>
				    </tr>
			      <tr>
				<td><h4><?php echo $_ENV['Param0'][$_SESSION['lang']]; ?></h4></td>
			      </tr>
			      <tr>
				<td><?php echo $_ENV['Param1'][$_SESSION['lang']]; ?></td>
				<td>
				    <select id='cyberhawk_language'>
				    	<option value='0' <?php if ($_ENV['default_language'] == 0) echo "selected=true"; ?>><?php echo $_ENV['Param2'][$_SESSION['lang']]; ?></option>
				      	<option value='1' <?php if ($_ENV['default_language'] == 1) echo "selected=true"; ?>><?php echo $_ENV['Param3'][$_SESSION['lang']]; ?></option>
				      	<option value='2' <?php if ($_ENV['default_language'] == 2) echo "selected=true"; ?>><?php echo $_ENV['Param28'][$_SESSION['lang']]; ?></option>
				      	<option value='3' <?php if ($_ENV['default_language'] == 3) echo "selected=true"; ?>><?php echo $_ENV['Param29'][$_SESSION['lang']]; ?></option>
				    </select>
				</td>
			      </tr>
			      
			      <tr> <td>&nbsp;</td> <td>&nbsp;</td> </tr>
			      
			      <tr>
				<td><h4><?php echo $_ENV['Param4'][$_SESSION['lang']]; ?></h4></td>
			      </tr>

			    <tr>
			    <td><?php echo $_ENV['Param5'][$_SESSION['lang']]; ?></td>
				<td>
				   <input type='checkbox' id='ADM_MODULES' <?php if ($_ENV['ADM_MODULES'] == 1) echo "checked"; ?>>
				</td>
				</tr>
			      
			      <tr> <td>&nbsp;</td> <td>&nbsp;</td> </tr>

			      <tr>
				<td><h4><?php echo $_ENV['Param6'][$_SESSION['lang']]; ?></h4></td>
			      </tr>
			      
			      
			      <tr>
			    <td><?php echo $_ENV['Param7'][$_SESSION['lang']]; ?></td>
				<td>
				    <input type='checkbox' id='INVITED_ACCOUNT' <?php if ($_ENV['invited_account'] == 1) echo "checked"; ?>></center><font size='2' color='red'> <?php echo $_ENV['Param8'][$_SESSION['lang']]; ?></font>
				</td>
				</tr>
			      
			      
			      <tr>
			    <td><?php echo $_ENV['Param9'][$_SESSION['lang']]; ?></td>
				<td>
				    <select id='accounts_information'>
				      <option value='1' <?php if ($_ENV['accounts_information'] == 1) echo "selected=true"; ?>><?php echo $_ENV['Param10'][$_SESSION['lang']]; ?></option>
				      <option value='0' <?php if ($_ENV['accounts_information'] == 0) echo "selected=true"; ?>><?php echo $_ENV['Param11'][$_SESSION['lang']]; ?></option>
				    </select>
				</td>
			      </tr>
			      
			      <tr>
				<td><?php echo $_ENV['Param12'][$_SESSION['lang']]; ?></td>
				<td>
				    <select id='accounts_validation'>
				      <option value='2' <?php if ($_ENV['accounts_validation'] == 2) echo "selected=true"; ?>><?php echo $_ENV['Param13'][$_SESSION['lang']]; ?></option>
				      <option value='1' <?php if ($_ENV['accounts_validation'] == 1) echo "selected=true"; ?>><?php echo $_ENV['Param14'][$_SESSION['lang']]; ?></option>
				      <option value='0' <?php if ($_ENV['accounts_validation'] == 0) echo "selected=true"; ?>><?php echo $_ENV['Param15'][$_SESSION['lang']]; ?></option>
				    </select>
				</td>
			      </tr>
			      
			      <tr>
			    <td><?php echo $_ENV['Param16'][$_SESSION['lang']]; ?></td>
				<td>
				    <select id='accounts_mechanisms'>
				      <option value='0' <?php if ($_ENV['accounts_mechanisms'] == 0) echo "selected=true"; ?>><?php echo $_ENV['Param17'][$_SESSION['lang']]; ?></option>
				      <option value='1' <?php if ($_ENV['accounts_mechanisms'] == 1) echo "selected=true"; ?>><?php echo $_ENV['Param18'][$_SESSION['lang']]; ?></option>
				      <option value='2' <?php if ($_ENV['accounts_mechanisms'] == 2) echo "selected=true"; ?>><?php echo $_ENV['Param19'][$_SESSION['lang']]; ?></option>
				    </select>
				</td>
			      </tr>
			      
			      <tr>
			    <td><?php echo $_ENV['Param20'][$_SESSION['lang']]; ?></td>
				<td>
				    <select id='max_space'>
				      <option value='10000000' <?php if ($_ENV['maximum_space'] == 10000000) echo "selected=true"; ?>>10 Mo</option>
				      <option value='50000000' <?php if ($_ENV['maximum_space'] == 50000000) echo "selected=true"; ?>>50 Mo</option>
				      <option value='100000000' <?php if ($_ENV['maximum_space'] == 100000000) echo "selected=true"; ?>>100 Mo</option>
				      <option value='250000000' <?php if ($_ENV['maximum_space'] == 250000000) echo "selected=true"; ?>>250 Mo</option>
				      <option value='500000000'   <?php if ($_ENV['maximum_space'] == 500000000) echo "selected=true"; ?>>500 Mo</option>
				      <option value='1000000000'  <?php if ($_ENV['maximum_space'] == 1000000000) echo "selected=true"; ?>>1 Go</option>
				      <option value='0'           <?php if ($_ENV['maximum_space'] == 0) echo "selected=true"; ?>>Unlimited</option>
				    </select>
				</td>
			      </tr>

			    <tr>
			    <td><?php echo $_ENV['Param21'][$_SESSION['lang']]; ?></td>
				<td>
				   <input type='checkbox' id='MOD_DETAILS' <?php if ($_ENV['MOD_DETAILS'] == "on") echo "checked"; ?>>
				</td>
				</tr>

			    <tr>
			    <td><?php echo $_ENV['Param22'][$_SESSION['lang']]; ?></td>
				<td>
				   <input type='checkbox' id='CHX_VERSION' <?php if ($_ENV['CHX_VERSION'] == "on") echo "checked"; ?>>
				</td>
				</tr>

			      <tr> <td>&nbsp;</td> <td>&nbsp;</td> </tr>

			      <tr>
				<td><h4><?php echo $_ENV['Param23'][$_SESSION['lang']]; ?></h4></td>
			      </tr>
			      <tr>
				<td><?php echo $_ENV['Param24'][$_SESSION['lang']]; ?></td>
				<td>
				    <select id='cyberhawk_retention'>
				      <option value='1'   <?php if ($_ENV['clear_accounts_days'] == 1) echo "selected=true"; ?>>1 <?php echo $_ENV['Accounts39'][$_SESSION['lang']]; ?></option>
				      <option value='7'   <?php if ($_ENV['clear_accounts_days'] == 7) echo "selected=true"; ?>>7 <?php echo $_ENV['Accounts40'][$_SESSION['lang']]; ?></option>
				      <option value='31'  <?php if ($_ENV['clear_accounts_days'] == 31) echo "selected=true"; ?>>31 <?php echo $_ENV['Accounts40'][$_SESSION['lang']]; ?></option>
				      <option value='365' <?php if ($_ENV['clear_accounts_days'] == 365) echo "selected=true"; ?>>1 <?php echo $_ENV['Accounts40'][$_SESSION['lang']]; ?></option>
				      <option value='0'   <?php if ($_ENV['clear_accounts_days'] == 0) echo "selected=true"; ?>><?php echo $_ENV['Accounts41'][$_SESSION['lang']]; ?></option>
				    </select>
				</td>
			      </tr>

			<tr>
			<td><?php echo $_ENV['Param25'][$_SESSION['lang']]; ?></td>
			<td>
				<select id='share_validity'>
					  <option value='0' <?php if ($_ENV['share_validity'] == 0) echo "selected=true"; ?>><?php echo $_ENV['Param11'][$_SESSION['lang']]; ?></option>
				      <option value='1' <?php if ($_ENV['share_validity'] == 1) echo "selected=true"; ?>>1 <?php echo $_ENV['Param26'][$_SESSION['lang']]; ?></option>
				      <option value='2' <?php if ($_ENV['share_validity'] == 2) echo "selected=true"; ?>>2 <?php echo $_ENV['Param27'][$_SESSION['lang']]; ?></option>
				      <option value='3' <?php if ($_ENV['share_validity'] == 3) echo "selected=true"; ?>>3 <?php echo $_ENV['Param27'][$_SESSION['lang']]; ?></option>
				      <option value='6'  <?php if ($_ENV['share_validity'] == 6) echo "selected=true"; ?>>6 <?php echo $_ENV['Param27'][$_SESSION['lang']]; ?></option>
				      <option value='12' <?php if ($_ENV['share_validity'] == 12) echo "selected=true"; ?>>12 <?php echo $_ENV['Param27'][$_SESSION['lang']]; ?></option>
				      <option value='24' <?php if ($_ENV['share_validity'] == 24) echo "selected=true"; ?>>24 <?php echo $_ENV['Param27'][$_SESSION['lang']]; ?></option>
				</select>
			</td>
		      </tr>
			      
			      <tr> <td>&nbsp;</td> <td>&nbsp;</td> </tr>
			      
			      <tr><td colspan=3>&nbsp;</td></tr>
				<tr>
					<td colspan=3><center>
						<button id="param_cyberhawk_mgt" type="submit" class="btn btn-primary">
						<i class="glyphicon glyphicon-ok"></i>
						<span>OK</span>
						</button></center>
					</td>
				</tr>
			    </table>
			  </div>
			  </center>
	  
	<script type='text/javascript'>
		$("#param_cyberhawk_mgt").click(function(){ 
			var data = new FormData();
			data.append("CSRF_TOKEN", "<?php echo generate_csrf_token(); ?>");
			data.append("cyberhawk_language", $("#cyberhawk_language").val());

			if ($("#ADM_MODULES").is(':checked'))
				data.append("ADM_MODULES", "on");

			if ($("#INVITED_ACCOUNT").is(':checked'))
				data.append("INVITED_ACCOUNT", "on");

			data.append("accounts_information", $("#accounts_information").val());
			data.append("accounts_validation", $("#accounts_validation").val());
			data.append("accounts_mechanisms", $("#accounts_mechanisms").val());
			data.append("max_space", $("#max_space").val());

			if ($("#MOD_DETAILS").is(':checked'))
				data.append("MOD_DETAILS", "on");

			if ($("#CHX_VERSION").is(':checked'))
				data.append("CHX_VERSION", "on");

			data.append("cyberhawk_retention", $("#cyberhawk_retention").val());
			data.append("share_validity", $("#share_validity").val());


			$.ajax({
				type: "POST",
				enctype: "multipart/form-data",
				processData : false,
				contentType: false,
				cache : false,
				url: "./param_cyberhawk.php",
				data: data,
				success: function(data, textStatus, jqXHR)
				{
				    if (data.status == true) {
						swal({ title: "<?php echo $_ENV["Accounts9"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Accounts45"][$_SESSION['lang']]; ?>", type: "success" },
						    function(isConfirm){ $('#cyberhawkmgt').toggle(); scroll(0,0); }
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

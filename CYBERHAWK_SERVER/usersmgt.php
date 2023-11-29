<?php 
    include 'config.php'; 
    
    if (!is_admin())
	exit(1);
	


    if (!empty($_POST['users']))
    {
    	if (!check_csrf_token($_POST["CSRF_TOKEN"]))
    	{
    		$response_array['status'] = "CSRF Protection";
    	}
    	else
    	{
    		if (isset($_POST["time"]))
				$response_array['status'] = action_users($_POST['action'], $_POST['users'], intval($_POST['time']));
			else
				if(isset($_POST["parameter"]))
					$response_array['status'] = action_users($_POST['action'], $_POST['users'], 0, $_POST["parameter"]);
				else
					$response_array['status'] = action_users($_POST['action'], $_POST['users']);
	}	    
	header('Content-type: application/json');
	echo json_encode($response_array);
	exit(0);
    }
?>

		

	<script src="./FileUpload/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="./FileUpload/js/bootstrap.min.js"></script>


	<!-- Include the plugin's CSS and JS: -->
	<script type="text/javascript" src="./js/bootstrap-multiselect.js"></script>
	<link rel="stylesheet" href="./css/bootstrap-multiselect.css" type="text/css"/>

	    <center>
	    <table id='usermgt' style='display:none;border-collapse: separate; border-spacing: 0px 5px;' border=0>
	    	<tr>
		    <td colspan=4 style='padding: 5px;'>
		    	<center><b><h4 style="cursor:pointer" onclick="$('#usermgt').toggle();"><?php echo $_ENV["Accounts0"][$_SESSION['lang']] ; ?></h4></b></center>
		    </td>
		    </tr>
		<tr>
		    <td colspan=4 style='padding: 5px;'>
			<center><select name='users[]' id='users' multiple='multiple'>
				<?php
				    $list_users = list_users();

				    if (is_array($list_users))
				    {
					    echo "<optgroup label='" . $_ENV["Accounts1"][$_SESSION['lang']] . "'>";
					    foreach ($list_users as $user)
					    {
							if($user["ACT"])
							{
								echo "<option value='" . $user["ID"] . "'>" . strtoupper($user["LASTNAME"]) . " " . $user["FIRSTNAME"] . " (" . $user["MAIL"] . ")" . "</option>";
							}
					    }
					    
					    echo "</optgroup><optgroup label='" . $_ENV["Accounts2"][$_SESSION['lang']] . "'>";
					    foreach ($list_users as $user)
					    {
							if(!$user["ACT"])
							{
								echo "<option value='" . $user["ID"] . "'>" . strtoupper($user["LASTNAME"]) . " " . $user["FIRSTNAME"] . " (" . $user["MAIL"] . ")" . "</option>";
							}
					    }
					    
					    echo "</optgroup>";
				    }
				    else
				    {
					  echo '<script>swal({ title: "' . $_ENV["Accounts7"][$_SESSION['lang']] . '", text: "' . $_ENV["Accounts6"][$_SESSION['lang']] . '", type: "error" });</script>';
				    }
				?>
			</select></center>
		    </td>
		</tr>
		<tr>
		    <td style='padding: 5px;' >
			<center><button style="width:110px" type="submit" class="btn btn-success" id="1">
			  <i class="glyphicon glyphicon-ok-circle"></i>
			  <span><?php echo $_ENV["Accounts3"][$_SESSION['lang']]; ?></span>
			</button></center>
		    </td>
		    <td style='padding: 5px;' colspan="2">
			<center><button style="width:110px" type="submit" class="btn btn-warning" id="0">
			  <i class="glyphicon glyphicon-ban-circle"></i>
			  <span><?php echo $_ENV["Accounts4"][$_SESSION['lang']]; ?></span>
			</button></center>
		    </td>
		    <td style='padding: 5px;'>
			<center><button style="width:110px" type="submit" class="btn btn-danger" id="2">
			  <i class="glyphicon glyphicon-trash"></i>
			  <span><?php echo $_ENV["Accounts5"][$_SESSION['lang']]; ?></span>
			</button></center>
		    </td>
		</tr>
		<tr>
		    <td style='padding: 5px;' colspan="2">
			<center><button style="width:275px" type="submit" class="btn btn-warning" id="3">
			  <i class="glyphicon glyphicon-lock"></i>
			  <span><?php echo $_ENV["Accounts15"][$_SESSION['lang']]; ?></span>
			</button></center>
		    </td>
		     <td style='padding: 5px;' colspan="2">
			<center><button style="width:275px" type="submit" class="btn btn-warning" id="49">
			  <i class="glyphicon glyphicon-remove"></i>
			  <span><?php echo $_ENV["Accounts34"][$_SESSION['lang']]; ?></span>
			</button></center>
		    </td>
		</tr>
		<tr>
		    <td style='padding: 5px;' colspan="2">
			<center><button style="width:275px" type="submit" class="btn btn-info" id="50">
			  <i class="glyphicon glyphicon-trash"></i>
			  <span><?php echo $_ENV["Accounts37"][$_SESSION['lang']]; ?></span>
			</button></center>
		    </td>
		     <td style='padding: 5px;' colspan="2">
			<center><button style="width:275px" type="submit" class="btn btn-info" id="51">
			  <i class="glyphicon glyphicon-folder-open"></i>
			  <span><?php echo $_ENV["Accounts16"][$_SESSION['lang']]; ?></span>
			</button></center>
		    </td>
		</tr>
		<tr>
		    <td style='padding: 5px;' colspan="2">
			<center><button style="width:275px" type="submit" class="btn btn-default" onclick="document.location.href='./IMPORT_UTILISATEURS.csv'">
			  <i class="glyphicon glyphicon-save-file"></i>
			  <span><?php echo $_ENV["Accounts25"][$_SESSION['lang']]; ?></span>
			</button></center>
		    </td>
		    <td style='padding: 5px;' colspan="2">
			<center><button style="width:275px" type="submit" class="btn btn-success" id="4">
			  <i class="glyphicon glyphicon-user"></i>
			  <span><?php echo $_ENV["Accounts26"][$_SESSION['lang']]; ?></span>
			</button></center>
		    </td>
		</tr>
		<tr>
		    <td style='padding: 5px;' colspan="4">
			<center><button style="width:400px" type="submit" class="btn btn-success" id='60'>
			  <i class="glyphicon glyphicon-user"></i>
			  <span><?php echo $_ENV["Accounts48"][$_SESSION['lang']]; ?></span>
			</button></center>
		    </td>
		</tr>
	    </table></center>
	  
	<script type='text/javascript'>
		$('#users').multiselect({
			enableClickableOptGroups: true,
			enableCollapsibleOptGroups: false,
			enableFiltering: true,
			maxHeight: 200,
			disableIfEmpty: false,
			buttonWidth: '200px'
		});
		
		
		$.ajaxPrefilter(function( options, originalOptions, jqXHR ) {
			options.async = true;
		});
		
		$("#1").click(function(){ 
			$.ajax({
				type: "POST",
				url: "./usersmgt.php",
				data: "action=1&users=" + encodeURI($("#users").val()) + "&CSRF_TOKEN=<?php echo generate_csrf_token(); ?>",
				success: function(data, textStatus, jqXHR)
				{
				    if (data.status == true) {
					swal({ title: "<?php echo $_ENV["Accounts9"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Accounts10"][$_SESSION['lang']]; ?>", type: "success" });
					change_content("./cyberhawk.php");
				    }
				    else
					swal({ title: "<?php echo $_ENV["Accounts7"][$_SESSION['lang']]; ?>", text: data.status, type: "error" });
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					swal({ title: "<?php echo $_ENV["Accounts7"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Accounts8"][$_SESSION['lang']]; ?>", type: "error" });
				}
			});
		});

		$("#60").click(function(){ 
			$.ajax({
				type: "POST",
				url: "./usersmgt.php",
				data: "action=60&users=" + encodeURI($("#users").val()) + "&CSRF_TOKEN=<?php echo generate_csrf_token(); ?>",
				success: function(data, textStatus, jqXHR)
				{
				    if (data.status == true) {
						swal({ title: "<?php echo $_ENV["Accounts47"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Accounts46"][$_SESSION['lang']]; ?>", type: "success" },
					    function(isConfirm){ location.reload(); }
						);
				    }
				    else
					swal({ title: "<?php echo $_ENV["Accounts7"][$_SESSION['lang']]; ?>", text: data.status, type: "error" });
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					swal({ title: "<?php echo $_ENV["Accounts7"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Accounts8"][$_SESSION['lang']]; ?>", type: "error" });
				}
			});
		});

		$("#0").click(function(){ 
			$.ajax({
				type: "POST",
				url: "./usersmgt.php",
				data: "action=0&users=" + encodeURI($("#users").val()) + "&CSRF_TOKEN=<?php echo generate_csrf_token(); ?>",
				success: function(data, textStatus, jqXHR)
				{
				    if (data.status == true) {
					swal({ title: "<?php echo $_ENV["Accounts9"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Accounts10"][$_SESSION['lang']]; ?>", type: "success" });
					change_content("./cyberhawk.php");
				    }
				    else
					swal({ title: "<?php echo $_ENV["Accounts7"][$_SESSION['lang']]; ?>", text: data.status, type: "error" });
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					swal({ title: "<?php echo $_ENV["Accounts7"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Accounts8"][$_SESSION['lang']]; ?>", type: "error" });
				}
			});
		});
		
		$("#2").click(function(){
			swal({   
				title: "<?php echo $_ENV["Accounts13"][$_SESSION['lang']]; ?>",   
				text: "<?php echo $_ENV["Accounts14"][$_SESSION['lang']]; ?>",   
				type: "warning",   
				confirmButtonClass: "btn-danger",
				showCancelButton: true,   
				confirmButtonColor: "#ec971f",     
				closeOnConfirm: false
			}, 
			function(isConfirm){   
				if (isConfirm) {
					$.ajax({
						type: "POST",
						url: "./usersmgt.php",
						data: "action=2&users=" + encodeURI($("#users").val()) + "&CSRF_TOKEN=<?php echo generate_csrf_token(); ?>",
						success: function(data, textStatus, jqXHR)
						{
						    if (data.status == true) {
							swal({ title: "<?php echo $_ENV["Accounts9"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Accounts10"][$_SESSION['lang']]; ?>", type: "success" });
							change_content("./cyberhawk.php");
						    }
						    else
							swal({ title: "<?php echo $_ENV["Accounts7"][$_SESSION['lang']]; ?>", text: data.status, type: "error" });
						},
						error: function (jqXHR, textStatus, errorThrown)
						{
							swal({ title: "<?php echo $_ENV["Accounts7"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Accounts8"][$_SESSION['lang']]; ?>", type: "error" });
						}
					});
				} else {    
					swal("<?php echo $_ENV["Accounts11"][$_SESSION['lang']]; ?>", "<?php echo $_ENV["Accounts12"][$_SESSION['lang']]; ?>", "error");   
				}
			});
		});


		$("#49").click(function(){
			swal({
				title: "<?php echo $_ENV["Accounts34"][$_SESSION['lang']]; ?>",   
				text: "<?php echo $_ENV["Accounts35"][$_SESSION['lang']]; ?>",   
				type: "warning",   
				confirmButtonClass: "btn-danger",
				showCancelButton: true,   
				confirmButtonColor: "#ec971f",     
				closeOnConfirm: false
			}, 
			function(isConfirm){   
				if (isConfirm) {
					$time = Math.floor(Date.now() / 1000);
					$.ajax({
						type: "POST",
						url: "./usersmgt.php",
						data: "action=49&users=" + encodeURI($("#users").val()) + "&CSRF_TOKEN=<?php echo generate_csrf_token(); ?>&time=" + $time,
						success: function(data, textStatus, jqXHR)
						{
						    if (data.status == true) {
								swal({ title: "<?php echo $_ENV["Accounts9"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Accounts36"][$_SESSION['lang']]; ?>" + $time + ".csv'.", type: "success" },
					    		function(isConfirm){ location.reload(); }
								);
						    }
						    else
								swal({ title: "<?php echo $_ENV["Accounts7"][$_SESSION['lang']]; ?>", text: data.status, type: "error" });
						},
						error: function (jqXHR, textStatus, errorThrown)
						{
							swal({ title: "<?php echo $_ENV["Accounts7"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Accounts8"][$_SESSION['lang']]; ?>", type: "error" });
						}
					});
				} else {    
					swal("<?php echo $_ENV["Accounts11"][$_SESSION['lang']]; ?>", "<?php echo $_ENV["Accounts12"][$_SESSION['lang']]; ?>", "error");   
				}
			});
		});


		$("#50").click(function(){
			swal({
				title: "<?php echo $_ENV["Accounts37"][$_SESSION['lang']]; ?>",   
				text: "<?php echo $_ENV["Accounts49"][$_SESSION['lang']]; ?><br/><br/><select id='parameter'><option value='1'         >1 <?php echo $_ENV["Accounts39"][$_SESSION['lang']]; ?></option><option value='7'         >7 <?php echo $_ENV["Accounts40"][$_SESSION['lang']]; ?></option> <option value='15'         >15 <?php echo $_ENV["Accounts40"][$_SESSION['lang']]; ?></option><option value='31'        >31 <?php echo $_ENV["Accounts40"][$_SESSION['lang']]; ?></option>  <option value='365'       >365 <?php echo $_ENV["Accounts40"][$_SESSION['lang']]; ?></option> <option value='0' selected><?php echo $_ENV["Accounts41"][$_SESSION['lang']]; ?></option> </select>",   
				type: "warning",
				html: true,
				confirmButtonClass: "btn-danger",
				showCancelButton: true,   
				confirmButtonColor: "#ec971f",     
				closeOnConfirm: false
			}, 
			function(isConfirm){   
				if (isConfirm) {
					$.ajax({
						type: "POST",
						url: "./usersmgt.php",
						data: "action=50&users=" + encodeURI($("#users").val()) + "&CSRF_TOKEN=<?php echo generate_csrf_token(); ?>&parameter=" + encodeURI($("#parameter").val()),
						success: function(data, textStatus, jqXHR)
						{
						    if (data.status == true) {
								swal({ title: "<?php echo $_ENV["Accounts9"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Accounts10"][$_SESSION['lang']]; ?>", type: "success" });
								change_content("./cyberhawk.php");
						    }
						    else
								swal({ title: "<?php echo $_ENV["Accounts7"][$_SESSION['lang']]; ?>", text: data.status, type: "error" });
						},
						error: function (jqXHR, textStatus, errorThrown)
						{
							swal({ title: "<?php echo $_ENV["Accounts7"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Accounts8"][$_SESSION['lang']]; ?>", type: "error" });
						}
					});
				} else {    
					swal("<?php echo $_ENV["Accounts11"][$_SESSION['lang']]; ?>", "<?php echo $_ENV["Accounts12"][$_SESSION['lang']]; ?>", "error");   
				}
			});
		});


		$("#51").click(function(){
			swal({
				title: "<?php echo $_ENV["Accounts16"][$_SESSION['lang']]; ?>",   
				text: "<?php echo $_ENV["Accounts38"][$_SESSION['lang']]; ?><br/><br/><select id='parameter'><option value='10000000' selected>10 Mo</option> <option value='50000000'         >50 Mo</option><option value='100000000'        >100 Mo</option><option value='250000000'        >250 Mo</option> <option value='500000000'        >500 Mo</option><option value='1000000000'       >1 Go</option>  <option value='0'                ><?php echo $_ENV["Accounts41"][$_SESSION['lang']]; ?></option>  </select>",   
				type: "warning",
				html: true,
				confirmButtonClass: "btn-danger",
				showCancelButton: true,   
				confirmButtonColor: "#ec971f",     
				closeOnConfirm: false
			}, 
			function(isConfirm){   
				if (isConfirm) {
					$.ajax({
						type: "POST",
						url: "./usersmgt.php",
						data: "action=51&users=" + encodeURI($("#users").val()) + "&CSRF_TOKEN=<?php echo generate_csrf_token(); ?>&parameter=" + encodeURI($("#parameter").val()),
						success: function(data, textStatus, jqXHR)
						{
						    if (data.status == true) {
								swal({ title: "<?php echo $_ENV["Accounts9"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Accounts10"][$_SESSION['lang']]; ?>", type: "success" });
								change_content("./cyberhawk.php");
						    }
						    else
								swal({ title: "<?php echo $_ENV["Accounts7"][$_SESSION['lang']]; ?>", text: data.status, type: "error" });
						},
						error: function (jqXHR, textStatus, errorThrown)
						{
							swal({ title: "<?php echo $_ENV["Accounts7"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Accounts8"][$_SESSION['lang']]; ?>", type: "error" });
						}
					});
				} else {    
					swal("<?php echo $_ENV["Accounts11"][$_SESSION['lang']]; ?>", "<?php echo $_ENV["Accounts12"][$_SESSION['lang']]; ?>", "error");   
				}
			});
		});


		$("#3").click(function(){
			swal({
				title: "<?php echo $_ENV["Accounts15"][$_SESSION['lang']]; ?>",   
				text: "<?php echo $_ENV["Accounts17"][$_SESSION['lang']]; ?>",   
				type: "warning",   
				confirmButtonClass: "btn-danger",
				showCancelButton: true,   
				confirmButtonColor: "#ec971f",     
				closeOnConfirm: false
			}, 
			function(isConfirm){   
				if (isConfirm) {
					$time = Math.floor(Date.now() / 1000);
					$.ajax({
						type: "POST",
						url: "./usersmgt.php",
						data: "action=3&users=" + encodeURI($("#users").val()) + "&CSRF_TOKEN=<?php echo generate_csrf_token(); ?>&time=" + $time,
						success: function(data, textStatus, jqXHR)
						{
						    if (data.status == true) {
								swal({ title: "<?php echo $_ENV["Accounts9"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Accounts30"][$_SESSION['lang']]; ?>" + $time + ".csv'.", type: "success" },
					    		function(isConfirm){ location.reload(); }
								);
						    }
						    else
								swal({ title: "<?php echo $_ENV["Accounts7"][$_SESSION['lang']]; ?>", text: data.status, type: "error" });
						},
						error: function (jqXHR, textStatus, errorThrown)
						{
							swal({ title: "<?php echo $_ENV["Accounts7"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Accounts8"][$_SESSION['lang']]; ?>", type: "error" });
						}
					});
				} else {    
					swal("<?php echo $_ENV["Accounts11"][$_SESSION['lang']]; ?>", "<?php echo $_ENV["Accounts12"][$_SESSION['lang']]; ?>", "error");   
				}
			});
		});

		$("#4").click(function(){
			swal({   
				title: "<?php echo $_ENV["Accounts27"][$_SESSION['lang']]; ?>",   
				text: "<?php echo $_ENV["Accounts28"][$_SESSION['lang']]; ?>",   
				type: "warning",   
				confirmButtonClass: "btn-danger",
				showCancelButton: true,   
				confirmButtonColor: "#ec971f",     
				closeOnConfirm: false
			}, 
			function(isConfirm){   
				if (isConfirm) {
					$time = Math.floor(Date.now() / 1000);
					$.ajax({
						type: "POST",
						url: "./usersmgt.php",
						data: "action=4&users=x&CSRF_TOKEN=<?php echo generate_csrf_token(); ?>&time=" + $time,
						success: function(data, textStatus, jqXHR)
						{
						    if (data.status == true) {
							swal({ title: "<?php echo $_ENV["Accounts32"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Accounts31"][$_SESSION['lang']]; ?>" + $time + ".csv'.", type: "success" },
					    		function(isConfirm){ location.reload(); }
								);
						    }
						    else
							swal({ title: "<?php echo $_ENV["Accounts7"][$_SESSION['lang']]; ?>", text: data.status, type: "error" });
						},
						error: function (jqXHR, textStatus, errorThrown)
						{
							swal({ title: "<?php echo $_ENV["Accounts7"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Accounts8"][$_SESSION['lang']]; ?>", type: "error" });
						}
					});
				} else {    
					swal("<?php echo $_ENV["Accounts11"][$_SESSION['lang']]; ?>", "<?php echo $_ENV["Accounts12"][$_SESSION['lang']]; ?>", "error");   
				}
			});
		});
	</script>

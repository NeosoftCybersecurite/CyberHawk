<?php 
    include 'config.php'; 
    
    if (!is_admin())
	exit(1);
	
    if (!empty($_POST['from']))
    {
    	if (!check_csrf_token($_POST["CSRF_TOKEN"]))
    	{
    		$response_array['status'] = "CSRF Protection";
    	}
    	else
    	{
			$from = $_POST['from'];

			
			if (empty($_POST['to']))
				$to = date("Y-m-d");
			else
				$to = $_POST['to'];
					    
			if (download_log($from, $to))
				$response_array['status'] = true;
			else
				$response_array['status'] = $_ENV["Logs5"][$_SESSION['lang']];
		}
		 
		header('Content-type: application/json');
		echo json_encode($response_array);
		exit(0);
    }
?>

	    
	    <center>
	    <table id="logmgt" style='display:none;border-collapse: separate; border-spacing: 0px 5px;' border=0>
		<tr>
		    <td colspan=2 style='padding: 5px;'>
		    	<center><b><h4 style="cursor:pointer" onclick="$('#logmgt').toggle();"><?php echo $_ENV["Logs0"][$_SESSION['lang']] ; ?></h4></b></center>
		    </td>
		</tr>

		<tr>
		    <td style='padding: 5px;'>
			<p><?php echo $_ENV["Logs2"][$_SESSION['lang']] ; ?></p>
		    </td>
		    <td style='padding: 5px;'>
			<p><input type="text" id="from" size="9px" ></p>
		    </td>
		</tr>
		<tr>
		    <td style='padding: 5px;'>
			<p><?php echo $_ENV["Logs3"][$_SESSION['lang']] ; ?> </p>
		    </td>
		    <td style='padding: 5px;'>
			<p> <input type="text" id="to" size="9px" ></p>
		    </td>
		</tr>
		<tr>
		    <td colspan=2 style='padding: 5px;'>
			<center><button type="submit" class="btn btn-success" id="download">
			  <i class="glyphicon glyphicon-ok-circle"></i>
			  <span><?php echo $_ENV["Logs1"][$_SESSION['lang']]; ?></span>
			</button></center>
		    </td>
		</tr>
	    </table></center>
	  
	<script type='text/javascript'>	
		$(function() {
		    <?php 
			if ($_SESSION['lang'] == 0)
			    echo "$.datepicker.setDefaults( $.datepicker.regional[ 'fr' ] );";
			else
			    echo "$.datepicker.setDefaults( $.datepicker.regional[ '' ] );"; 
		    ?>
		    
		    $( "#from" ).datepicker({
		    regional: "fr",
		      defaultDate: "-2m",
		      numberOfMonths: 3,
		      showButtonPanel: true,
		      maxDate: "+0D",
		      dateFormat: "yy-mm-dd",
		      onClose: function( selectedDate ) {
			$( "#to" ).datepicker( "option", "minDate", selectedDate );
		      }
		    });
		    $( "#to" ).datepicker({
		      defaultDate: "-2m",
		      numberOfMonths: 3,
		      showButtonPanel: true,
		      maxDate: "+0D",
		      dateFormat: "yy-mm-dd",
		      onClose: function( selectedDate ) {
			$( "#from" ).datepicker( "option", "maxDate", selectedDate );
		      }
		    });
		});
		
		  
		$.ajaxPrefilter(function( options, originalOptions, jqXHR ) {
			options.async = true;
		});
		
		$("#download").click(function(){ 
			$.ajax({
				type: "POST",
				url: "./logsmgt.php",
				data: "from=" +  encodeURI($("#from").val()) + "&to=" + encodeURI($("#to").val()) + "&CSRF_TOKEN=<?php echo generate_csrf_token(); ?>",
				success: function(data, textStatus, jqXHR)
				{
				    if (data.status == true) {
						swal({ title: "<?php echo $_ENV["Logs6"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Logs7"][$_SESSION['lang']]; ?>", type: "success" },
						    function(isConfirm){ location.reload(); }
						);
				    }
				    else
						swal({ title: "<?php echo $_ENV["Logs4"][$_SESSION['lang']]; ?>", text: data.status, type: "error" });
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					swal({ title: "<?php echo $_ENV["Logs4"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Logs5"][$_SESSION['lang']]; ?>", type: "error" });
				}
			});
		});
	</script>
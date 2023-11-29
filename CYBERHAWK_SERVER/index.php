<?php include 'config.php';?>
<?php
	if (isset($_GET["token"]) && !empty($_GET["token"]))
		download_file($_GET["token"]);
?>


<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<title>CyberHawk By CONIX</title>
	
	
		<link rel="stylesheet" href="./css/font-awesome.min.css"/>

		<script type="text/javascript" src="./FileUpload/js/jquery.min.js"></script>
		<!--[if lt IE 9]>
		  <script src="./js/html5.js"></script>
		<![endif]-->
		
		<script type="text/javascript" src="./js/jquery.complexify.js"></script>
				
		<!-- Include the plugin's CSS and JS: -->
		<script type="text/javascript" src="./js/bootstrap-multiselect.js"></script>
		<link rel="stylesheet" href="./css/bootstrap-multiselect.css" type="text/css"/>
		
		
		<!-- Bootstrap styles -->
		<link rel="stylesheet" href="./FileUpload/css/bootstrap.min.css">
		

		<link rel="icon" type="image/png" href="./images/logo_cyberhawk.png" />
		<link rel="stylesheet" type="text/css" href="./css/default.css" />
		<link rel="stylesheet" type="text/css" href="./css/component.css" />
		<script src="./js/modernizr.custom.js"></script>
		
		<link rel="stylesheet" href="./css/login.css" />
		

		<script src="./js/sweetalert.min.js"></script> 
		<link rel="stylesheet" type="text/css" href="./css/sweetalert.css">
		

		<link rel="stylesheet" href="./css/jquery-ui.css">
		<script type="text/javascript" src="./js/jquery-ui.js"></script>
		<script src="./js/datepicker-es.js"></script>
		<script src="./js/datepicker-fr.js"></script>

	</head>

	<body>



		<center>
		  <div style="top:10px;" >
		      <table id="logo-table" border="0" style="top:10px;"> 
			  <tr>
			    <td colspan="4">&nbsp;</td>
			  </tr>
			  <tr>
			    <td rowspan=2><center><a href="#" id="FR" onclick="change_language(0);" ><img width=30px src="./images/fr.png" alt="FR" title="FR" style="cursor:pointer;" /></a><a href="#" id="ES" onclick="change_language(2);" ><img width=30px src="./images/es.png" alt="ES" title="ES" style="cursor:pointer;" /></a></center></td>

			    <td colspan="2" rowspan=2><center><img width=70px onclick="document.location.href='./'" style="cursor: pointer;" src="./images/logo_cyberhawk.png"/></center></td>

			    <td rowspan=2><center><a href="#" id="UK" onclick="change_language(1);" ><img width=30px src="./images/uk.png" alt="UK" title="UK" style="cursor:pointer;" /></a><a href="#" id="IT" onclick="change_language(3);" ><img width=30px src="./images/it.png" alt="IT" title="IT" style="cursor:pointer;" /></a></center></td>
			  </tr>
			  <tr></tr>
			  <tr>
			    <td colspan="4"><center><img width=175px src="./images/logo_conix.png"/></center></td>
			  </tr>

		      </table>
		    </div>
		</center>
		
		<div class="containerMenu">	
			<div class="menuMain clearfix">
				<nav id="menu" class="nav">					
					<ul>
						<li>
							<a href="#" onclick="change_content('home.php')">
								<span class="icon">
									<i aria-hidden="true" class="icon-home"></i>
								</span>
								<span><?php echo $_ENV["Menu1"][$_SESSION['lang']]; ?></span>
							</a>
						</li>
						<li>
							<a href="#" onclick="change_content('tutorial.php')">
								<span class="icon">
									<i aria-hidden="true" class="icon-book"></i>
								</span>
								<span><?php echo $_ENV["Menu2"][$_SESSION['lang']]; ?></span>
							</a>
						</li>
						<li>
							<a href="#" onclick="change_content('./cyberhawk.php')">
								<span class="icon">
									<i aria-hidden="true" class="icon-hawk"></i>
								</span>
								<span><div id="menu-cyberhawk">
								
								<?php

								  if (isset($_SESSION['token']))
								    echo $_ENV["Menu0"][0];
								  else
								    echo $_ENV["Menu3"][$_SESSION['lang']];
		
								?>

								</div></span>
							</a>
						</li>
						<li>
							<a href="#" onclick="change_content('logout.php')">
								<span class="icon" >
									<i aria-hidden="true" class="icon-exit"></i>
								</span>
								<span><?php echo $_ENV["Menu4"][$_SESSION['lang']]; ?></span>
							</a>
						</li>
						<li>
							<a href="#" onclick="change_content('contact.php')">
								<span class="icon">
									<i aria-hidden="true" class="icon-envelop"></i>
								</span>
								<span><?php echo $_ENV["Menu5"][$_SESSION['lang']]; ?></span>
							</a>
						</li>
					</ul>
				</nav>
				
			</div>
		
		</div><!-- /containerMenu -->

		<script>
			//  The function to change the class
			var changeClass = function (r,className1,className2) {
				var regex = new RegExp("(?:^|\\s+)" + className1 + "(?:\\s+|$)");
				if( regex.test(r.className) ) {
					r.className = r.className.replace(regex,' '+className2+' ');
			    }
			    else{
					r.className = r.className.replace(new RegExp("(?:^|\\s+)" + className2 + "(?:\\s+|$)"),' '+className1+' ');
			    }
			    return r.className;
			};	

			//  Creating our button in JS for smaller screens
			var menuElements = document.getElementById('menu');
			menuElements.insertAdjacentHTML('afterBegin','<button type="button" id="menutoggle" class="navtoogle" aria-hidden="true"><i aria-hidden="true" class="icon-menu"> </i> Menu</button>');

			//  Toggle the class on click to show / hide the menu
			document.getElementById('menutoggle').onclick = function() {
				changeClass(this, 'navtoogle active', 'navtoogle');
			}

			// http://tympanus.net/codrops/2013/05/08/responsive-retina-ready-menu/comment-page-2/#comment-438918
			document.onclick = function(e) {
				var mobileButton = document.getElementById('menutoggle'),
					buttonStyle =  mobileButton.currentStyle ? mobileButton.currentStyle.display : getComputedStyle(mobileButton, null).display;

				if(buttonStyle === 'block' && e.target !== mobileButton && new RegExp(' ' + 'active' + ' ').test(' ' + mobileButton.className + ' ')) {
					changeClass(mobileButton, 'navtoogle active', 'navtoogle');
				}
				

			}
		</script>
		
		<div id="content">

		</div>
		
		<div class="container" id="login" style="visibility:hidden; display:none">
		    <form method="post" action="">
			    
			    <div class="row email">
				    <input type="text" id="email" name="email" placeholder="Email" autocomplete="off"/>
			    </div>
			    
			    <div class="row pass">
				    <input type="password" id="password1" name="password1" placeholder="<?php echo $_ENV["Login0"][$_SESSION['lang']]; ?>" autocomplete="off"/>
			    </div>
			    
			    <!-- The rotating arrow -->
			    <div class="arrowCap"></div>
			    <div class="arrow"></div>
			    
			    <p class="meterText"><?php echo $_ENV["Login3"][$_SESSION['lang']]; ?></p>
			    

			    <button type=submit style="width:300px; height:30px; margin: 200px auto 0;" class="btn btn-success popconfirm_full" data-toggle='confirmation' id="important_action">
				  <b><font size="4"><?php echo $_ENV["Login2"][$_SESSION['lang']]; ?></font></b>
			    </button>
			    <?php if ($_ENV['invited_account']) { echo "<br/><br/><center><a style='cursor:pointer' id='10'>" . $_ENV["Login25"][$_SESSION['lang']] . "</a></center>";} ?>

		    </form>
		    
		</div>

		
		<div id="cyberhawk" style="visibility:hidden; display:none">
		

		      

			      <!-- Generic page styles -->
			      <link rel="stylesheet" href="./FileUpload/css/style.css">
			      <!-- blueimp Gallery styles -->
			      <link rel="stylesheet" href="./FileUpload/css/blueimp-gallery.min.css">
			      
			      <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
			      <link rel="stylesheet" href="./FileUpload/css/jquery.fileupload.css">
			      <link rel="stylesheet" href="./FileUpload/css/jquery.fileupload-ui.css">
			      <!-- CSS adjustments for browsers with JavaScript disabled -->
			      <noscript><link rel="stylesheet" href="./FileUpload/css/jquery.fileupload-noscript.css"></noscript>
			      <noscript><link rel="stylesheet" href="./FileUpload/css/jquery.fileupload-ui-noscript.css"></noscript>
			      

				      
			      <div id="welcome">

			      </div>
			      
			      
			      <script>
				      	function ShareFile(filename) 
				      	{
					      $.ajax({
							  type: "POST",
							  url: "./FileUpload/server/php/index.php",
							  data: "action_conix=SHARE&file=" +  encodeURI(filename) + "&CSRF_TOKEN=<?php echo generate_csrf_token(); ?>",
							  success: function(data, textStatus, jqXHR)
							  {
							      var table = (((data.replace(/{/g, "")).replace(/}/g, "")).replace(/"/g, "")).split(":");
							      var http = location.protocol;
							      var slashes = http.concat("//");
							      var host = slashes.concat(window.location.hostname);

							      if (table[1] != "false")
								  swal({ title: "<?php echo $_ENV["FileSharing1"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["FileSharing3"][$_SESSION['lang']]; ?><a href='" + host + window.location.pathname.split("/").slice(0, -1).join("/") + "/index.php?token=" + table[1] + "'><?php echo $_ENV["FileSharing5"][$_SESSION['lang']]; ?></a>", html:true, type: "success" });
							      else
								  swal({ title: "<?php echo $_ENV["FileSharing2"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["FileSharing4"][$_SESSION['lang']]; ?>", type: "error" });
							  },
							  error: function (jqXHR, textStatus, errorThrown)
							  {
							      swal({ title: "<?php echo $_ENV["FileSharing2"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["FileSharing4"][$_SESSION['lang']]; ?>", type: "error" });
							  }
					      });
				      	}
			      </script>
			      
			      
				<div> 
			    <?php 
			    	if (isset($_SESSION["token"]))
			    	{
				    	if ($_SESSION["token"] != "Invited")
				    	{
					    	if ($_ENV['accounts_mechanisms'] != "2")
					    	{
					    		echo "<center><button style='width:315px;padding-left:10px' type='submit' class='btn btn-info' id='5'><i class='glyphicon glyphicon-pencil'></i><span>" . $_ENV['Accounts18'][$_SESSION['lang']] . "</span></button><br/><br/>";
					    		
					    		if ($_ENV['accounts_information'] != "0")
					    		{
					    			echo "<button style='width:315px' type='submit' class='btn btn-info' id='6'><i class='glyphicon glyphicon-pencil'></i><span>" . $_ENV['Accounts24'][$_SESSION['lang']] . "</span></button>";
					    		}

					    		echo "<input type=hidden id='txtPassword' size=1/><br/><br/><br/></center>";
					    	}
					    	else
					    	{
					    		if ($_ENV['accounts_information'] != "0")
					    		{
					    			echo "<center><button style='width:315px' type='submit' class='btn btn-info' id='6'><i class='glyphicon glyphicon-pencil'></i><span>" . $_ENV['Accounts18'][$_SESSION['lang']] . "</span></button><br/><br/><br/></center>";
					    		}
					    	}
					    }
					}
			    ?>
			    </div>


				<script type="text/javascript">

					$("#10").click(function(){ 
						swal({
							  	title: "<?php echo $_ENV["Login25"][$_SESSION['lang']]; ?>",
								text: "<?php echo $_ENV["Login26"][$_SESSION['lang']]; ?>",
								type: "warning",
								showCancelButton: true,
								closeOnCancel: true,
								closeOnConfirm: false,
								},

								function(){   

									$.ajax({
										url: "./register.php",
										type: "POST",
										data: "email=Invited",
											success: function(data, textStatus, jqXHR)
											{
												if(data.status == true) 
												{
													window.location.href = "./index.php";
												}
												else
												{
													swal({ title: "<?php echo $_ENV["Login16"][$_SESSION['lang']]; ?>", text: data.status, type: "warning" }, function(){   change_content("./home.php"); });
												}
											},
											error: function (jqXHR, textStatus, errorThrown)
											{
												swal({ title: "<?php echo $_ENV["Login7"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Login8"][$_SESSION['lang']]; ?>", type: "error" });
											}
									});
								}
							);	
						});		

					$("#5").click(function(){ 
						swal({
							title: "<?php echo $_ENV["Accounts18"][$_SESSION['lang']]; ?>",
							text: "<?php echo $_ENV["Accounts21"][$_SESSION['lang']]; ?>",
							type: "input",
							inputType: "password",
							showCancelButton: true,
							closeOnCancel: true,
							closeOnConfirm: false,
							inputPlaceholder: "<?php echo $_ENV["Login0"][$_SESSION['lang']]; ?>"
							},

							function(OldPassword){   
								if (OldPassword === false) return false;

								swal({
									title: "<?php echo $_ENV["Accounts18"][$_SESSION['lang']]; ?>",
									text: "<?php echo $_ENV["Accounts19"][$_SESSION['lang']]; ?>",
									type: "input",
									inputType: "password",
									showCancelButton: true,
									closeOnCancel: true,
									closeOnConfirm: false,
									inputPlaceholder: "<?php echo $_ENV["Login0"][$_SESSION['lang']]; ?>"
									},

									function(NewPassword1){   
										if (NewPassword1 === false) return false;
			  
			  							if (NewPassword1 === "") {
											swal.showInputError("<?php echo $_ENV["Login22"][$_SESSION['lang']]; ?>");
											return false
										}

										$("#txtPassword").val(NewPassword1);
										$("#txtPassword").attr('type', 'text');
										$("#txtPassword").focus();
										$("#txtPassword").attr('type', 'hidden');
										
										if ($("#txtPassword").val() == "true")
										{
											swal({
												title: "<?php echo $_ENV["Accounts18"][$_SESSION['lang']]; ?>",
												text: "<?php echo $_ENV["Accounts20"][$_SESSION['lang']]; ?>",
												type: "input",
												inputType: "password",
												showCancelButton: true,
												closeOnCancel: true,
												closeOnConfirm: false,
												inputPlaceholder: "<?php echo $_ENV["Login0"][$_SESSION['lang']]; ?>"
												},

												function(NewPassword2){   
													if (NewPassword2 === false) return false;
						  
						  							if (NewPassword2 === "") {
														swal.showInputError("<?php echo $_ENV["Login22"][$_SESSION['lang']]; ?>");
														return false
													}

													if (NewPassword2 != NewPassword1) {
														swal.showInputError("<?php echo $_ENV["Register13"][$_SESSION['lang']]; ?>");
														return false
													}
													
													$.ajax({
													    url: "./change_pwd.php",
													    type: "POST",
													    data: "oldpasswd=" + encodeURI(OldPassword) + "&passwd=" + encodeURI(NewPassword1) + "&CSRF_TOKEN=<?php echo generate_csrf_token(); ?>",
													    success: function(data, textStatus, jqXHR)
													    {
															if(data.status == true)
															{
																swal({ title: "<?php echo $_ENV["Accounts18"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Accounts22"][$_SESSION['lang']]; ?>", type: "success" });
															}
															else
														  		swal({ title: "<?php echo $_ENV["Login16"][$_SESSION['lang']]; ?>", text: data.status, type: "error" }, function(){   change_content("./cyberhawk.php"); }); 
													    },
													    error: function (jqXHR, textStatus, errorThrown)
													    {
													      swal({ title: "<?php echo $_ENV["Login7"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Login8"][$_SESSION['lang']]; ?>", type: "error" });
													    }
													});
												}
											);
										}
										else
										{
											swal.showInputError("<?php echo $_ENV["Login6"][$_SESSION['lang']]; ?>");
											return false
										}
									}
								);
							}
						);
					});

					$(function () {
			            $("#txtPassword").complexify({minimumChars:<?php echo $_ENV['accounts_password_length']; ?>, strengthScaleFactor:<?php echo $_ENV['accounts_password_complexity']; ?>}, function (valid, complexity) {
			                $("#txtPassword").val(valid);
			            });
			        });

			        $("#6").click(function(){ 
						swal({
						  	title: "<?php echo $_ENV["Login17"][$_SESSION['lang']]; ?>",
							text: "<?php echo $_ENV["Login18"][$_SESSION['lang']]; ?>",
							type: "input",
							showCancelButton: true,
							closeOnCancel: true,
							closeOnConfirm: false,
							inputPlaceholder: "<?php if (isset($_SESSION['lastname'])) {echo $_SESSION['lastname'];} else {echo "";}  ?>"
							},

							function(LastName){   
								if (LastName === false) return false;
			  
								if (LastName === "") {
									swal.showInputError("<?php echo $_ENV["Login22"][$_SESSION['lang']]; ?>");
									return false
								}

								swal({
									title: "<?php echo $_ENV["Login17"][$_SESSION['lang']]; ?>",
									text: "<?php echo $_ENV["Login19"][$_SESSION['lang']]; ?>",
									type: "input",
									showCancelButton: true,
									closeOnCancel: true,
									closeOnConfirm: false,
									inputPlaceholder: "<?php if (isset($_SESSION['firstname'])) {echo $_SESSION['firstname'];} else {echo "";}  ?>"
									},

									function(FirstName){   
									   	if (FirstName === false) return false;
				  
										if (FirstName === "") {
											swal.showInputError("<?php echo $_ENV["Login22"][$_SESSION['lang']]; ?>");
											return false
										}

										$.ajax({
											url: "./change_infos.php",
											type: "POST",
											data: "&lastname=" + encodeURI(LastName) + "&firstname=" + encodeURI(FirstName) + "&CSRF_TOKEN=<?php echo generate_csrf_token(); ?>",
											success: function(data, textStatus, jqXHR)
											{
												if(data.status == true) 
												{
													swal({ title: "<?php echo $_ENV["Accounts9"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Accounts10"][$_SESSION['lang']]; ?>", type: "success" }, function(){   window.location.href = "./index.php"; });
												}
												else
												{
													swal({ title: "<?php echo $_ENV["Login16"][$_SESSION['lang']]; ?>", text: data.status, type: "warning" }, function(){   change_content("./home.php"); });
												}
											},
											error: function (jqXHR, textStatus, errorThrown)
											{
												swal({ title: "<?php echo $_ENV["Login7"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Login8"][$_SESSION['lang']]; ?>", type: "error" });
											}
										});
									}
								);
							}
						);	
					});			
				</script>


			      <div class="container"> 
				    <!-- The file upload form used as target for the file upload widget -->
					<form id="fileupload" action="#" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="CSRF_TOKEN" value="<?php echo generate_csrf_token(); ?>" />
					    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
					    <div class="row fileupload-buttonbar">
						<div class="col-lg-7">
					    <!-- The fileinput-button span is used to style the file input field as button -->
					    <span class="btn btn-success fileinput-button">
						<i class="glyphicon glyphicon-plus"></i>
						<span><?php echo $_ENV["FileUploadButton1"][$_SESSION['lang']]; ?></span>
						<input type="file" name="files[]" multiple title="">
					    </span>
					    <button type="submit" class="btn btn-primary start">
						<i class="glyphicon glyphicon-upload"></i>
						<span><?php echo $_ENV["FileUploadButton2"][$_SESSION['lang']]; ?></span>
					    </button>
					    <button type="reset" class="btn btn-warning cancel">
						<i class="glyphicon glyphicon-ban-circle"></i>
						<span><?php echo $_ENV["FileUploadButton3"][$_SESSION['lang']]; ?></span>
					    </button>
					    <!--<button type="button" class="btn btn-info share" id="share" name="share">
						<i class="glyphicon glyphicon-link"></i>
						<span><?php echo $_ENV["FileUploadButton8"][$_SESSION['lang']]; ?></span>
					    </button>-->
					    <button type="button" class="btn btn-danger delete">
						<i class="glyphicon glyphicon-trash"></i>
						<span><?php echo $_ENV["FileUploadButton4"][$_SESSION['lang']]; ?></span>
					    </button>
					    <input title="<?php echo $_ENV["FileUploadButton6"][$_SESSION['lang']]; ?>" type="checkbox" class="toggle">
					    <!-- The global file processing state -->
					    <span class="fileupload-process"></span>
						</div>
						<!-- The global progress state -->
						<div class="col-lg-5 fileupload-progress fade">
					    <!-- The global progress bar -->
					    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
						<div class="progress-bar progress-bar-success" style="width:0%;"></div>
					    </div>
					    <!-- The extended global progress state -->
					    <div class="progress-extended">&nbsp;</div>
						</div>
					    </div>
					    <!-- The table listing the files available for upload/download -->
					    <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
					</form>
					<br>
			      </div>

			      
			      <!-- The blueimp Gallery widget -->
			      <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
				      <div class="slides"></div>
				      <h3 class="title"></h3>
				      <a class="prev">‹</a>
				      <a class="next">›</a>
				      <a class="close">×</a>
				      <a class="play-pause"></a>
				      <ol class="indicator"></ol>
			      </div>


			      
			      
			      <!-- The template to display files available for upload -->
			      <script id="template-upload" type="text/x-tmpl">
			      {% for (var i=0, file; file=o.files[i]; i++) { %}
				  <tr class="template-upload fade">
			      <td>
				  <!--<span class="preview"></span>-->
			      </td>
			      <td>
				  <p class="name">{%=file.name%}</p>
				  <strong class="error text-danger"></strong>
			      </td>
			      <td>
				  <p class="size"><?php echo $_ENV["FileUploadButton5"][$_SESSION['lang']]; ?></p>
				  <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
			      </td>
			      <td>
				  {% if (!i && !o.options.autoUpload) { %}
			      <button class="btn btn-primary start" disabled>
				  <i class="glyphicon glyphicon-upload"></i>
				  <span><?php echo $_ENV["FileUploadButton2"][$_SESSION['lang']]; ?></span>
			      </button>
				  {% } %}
				  {% if (!i) { %}
			      <button class="btn btn-warning cancel">
				  <i class="glyphicon glyphicon-ban-circle"></i>
				  <span><?php echo $_ENV["FileUploadButton3"][$_SESSION['lang']]; ?></span>
			      </button>
				  {% } %}
			      </td>
				  </tr>
			      {% } %}
			      </script>
			      <!-- The template to display files available for download -->
			      <script id="template-download" type="text/x-tmpl">
			      {% for (var i=0, file; file=o.files[i]; i++) { %}
				  <tr class="template-download fade">
			      <td>
				  <!--<span class="preview">
			      {% if (file.thumbnailUrl) { %}
				  <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
			      {% } %}
				  </span>-->
			      </td>
			      <td>
				      {% if ((!file.error) && (<?php echo $_ENV['share_validity'] ?>)) { %}
				      <button type="button" class="btn btn-info share" id="share" name="{%=file.name%}" onclick="ShareFile(this.name)">
						<i class="glyphicon glyphicon-link"></i>
						<span><?php echo $_ENV["FileUploadButton8"][$_SESSION['lang']]; ?></span>
				      </button>
				      {% } %}
			      </td>
			      <td>
				  <p class="name">
			      {% if (file.url) { %}
				  <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
			      {% } else { %}
				  <span>{%=file.name%}</span>
			      {% } %}
				  </p>
				  {% if (file.error) { %}
			      <div><span class="label label-warning"><?php echo $_ENV["FileUploadError"][$_SESSION['lang']]; ?></span> {%=file.error%}</div>
				  {% } %}
			      </td>
			      <td>
				  <span class="size">{%=o.formatFileSize(file.size)%}</span>
			      </td>
			      <td>
				  {% if (file.deleteUrl) { %}
			      <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}&CSRF_TOKEN=<?php echo generate_csrf_token(); ?>"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
				  <i class="glyphicon glyphicon-trash"></i>
				  <span><?php echo $_ENV["FileUploadButton4"][$_SESSION['lang']]; ?></span>
			      </button>
			      <input title="<?php echo $_ENV["FileUploadButton7"][$_SESSION['lang']]; ?>" type="checkbox" name="delete" value="1" class="toggle">
				  {% } else { %}
			      <button class="btn btn-warning cancel">
				  <i class="glyphicon glyphicon-ban-circle"></i>
				  <span><?php echo $_ENV["FileUploadButton3"][$_SESSION['lang']]; ?></span>
			      </button>
				  {% } %}
			      </td>
				  </tr>
			      {% } %}
			      </script>
			      

				<?php 
					if (is_admin())
					{
						echo "
					      <style>
						        #container{
						            max-width: 480px;
						            width: 100%;
						            margin: 20px auto;
						        }
						        #demo_box2{
						            width: 480px;
						        }
						        .fa{
						            font-size: 50px;
						            line-height: 70px;
						        }
						        .fa-bars{
						            color: #3498db;
						        }
						        pre{
						            font-family: Consolas,Liberation Mono,Courier,monospace;
						            font-size: 13px;
						        }
						        @media screen and (orientation: portrait){
						            pre{
						                overflow-x: scroll;
						            }
						        }
						  </style>
						";

						echo "<center>";
						echo '<div style="width:50px;" id="demo_box2">';
						echo '<span class="pop_ctrl"><i style="color:#1b3647" class="fa fa-equalizer"></i></span>';
						echo '<ul id="demo_ul">';
						echo '<li id="LI1" class="demo_li" style="color:white" onclick="myToggle(1);"><div><i class="fa fa-users"></i></div><div>' . $_ENV["Accounts0"][$_SESSION["lang"]] . '</div></li>';
						echo '<li id="LI2" class="demo_li" style="color:white" onclick="myToggle(2);"><div><i class="fa fa-history"></i></div><div>' .  $_ENV["Logs0"][$_SESSION["lang"]] . '</div></li>';
						echo '<li id="LI3" class="demo_li" style="color:white" onclick="myToggle(3);"><div><i class="fa fa-pie-chart"></i></div><div>' .  $_ENV["Stats0"][$_SESSION["lang"]] . '</div></li>';
						echo '<li id="LI4" class="demo_li" style="color:white" onclick="myToggle(4);"><div><i class="fa fa-wrench"></i></div><div>' .  $_ENV["Accounts43"][$_SESSION["lang"]] . '</div></li>';
						echo '<li id="LI5" class="demo_li" style="color:white" onclick="myToggle(5);"><div><i class="fa fa-cog"></i></div><div>' .  $_ENV["Accounts42"][$_SESSION["lang"]] . '</div></li>';
						echo '<li id="LI6" class="demo_li" style="color:white" onclick="myToggle(6);"><div><i class="fa fa-cog"></i></div><div>' .  $_ENV["Accounts44"][$_SESSION["lang"]] . '</div></li>';
						echo '</ul></div></center><br/><br/>';


						echo "
								<script>
								    (function ($) {

								    $.fn.popmenu = function (options) {

								        var settings = $.extend({
								            'controller': true,
								            'width': '750px',
								            'background': '#1b3647',
								            'focusColor': '#d06503',
								            'borderRadius': '10px',
								            'top': '100',
								            'left': '350',
								            'iconSize': '125px',
								            //'color': '#f0f',
								            'border': '0px'
								        }, options);
								        if (settings.controller === true) {
								            var temp_display = 'none';
								        } else {
								            var temp_display = 'block';
								        }
								        var tar = $(this);
								        var tar_body = tar.children('ul');
								        var tar_list = tar_body.children('li');
								        var tar_a = tar_list.children('a');
								        var tar_ctrl = tar.children('.pop_ctrl');


								        function setIt() {
								            tar_body.css({
								                'display': temp_display,
								                'position': 'absolute',
								                'margin-top': -settings.top,
								                'margin-left': -settings.left,
								                'background': settings.background,
								                'width': settings.width,
								                'float': 'left',
								                'padding': '0',
								                'border-radius': settings.borderRadius,
								                'border': settings.border
								            });
								            
								            tar_list.css({
								                'display': 'block',
								                //'color': '#f00',
								                'float': 'left',
								                'width': settings.iconSize,
								                'height': settings.iconSize,
								                'text-align': 'center',
								                'border-radius': settings.borderRadius
								            });
								            tar_a.css({
								                'text-decoration': 'none',
								                //'color': settings.color
								            });
								            tar_ctrl.hover(function () {
								                tar_ctrl.css('cursor', 'pointer');
								            }, function () {
								                tar_ctrl.css('cursor', 'default')
								            });
								            tar_ctrl.click(function (e) {
								                e.preventDefault();
								                tar_body.show('slow');
								                $(document).mouseup(function (e) {
								                    var _con = tar_body;
								                    if (!_con.is(e.target) && _con.has(e.target).length === 0) {
								                        _con.hide();
								                    }
								                    //_con.hide(); some functions you want
								                });
								            });
								            tar_list.hover(function () {
								                $(this).css({
								                    'background': settings.focusColor,
								                    'cursor': 'pointer'
								                });
								            }, function () {
								                $(this).css({
								                    'background': settings.background,
								                    'cursor': 'default'
								                });
								            });
								        }
								        return setIt();

								    };

								}(jQuery));
						        $(function(){
						            $('#demo_box2').popmenu();
						        })

								function myToggle(id)
								{
									$('#contactmgt').toggle(false);
									$('#modulesmgtdiv').toggle(false);
									$('#usermgt').toggle(false);
									$('#logmgt').toggle(false);
									$('#cyberhawkmgt').toggle(false);
									$('#statmgt').toggle(false);

									if (id == 1)
										$('#usermgt').toggle(true);
									if (id == 2)
										$('#logmgt').toggle(true);
									if (id == 3)
										$('#statmgt').toggle(true);
									if (id == 4)
										$('#modulesmgtdiv').toggle(true);
									if (id == 5)
										$('#cyberhawkmgt').toggle(true);
									if (id == 6)
										$('#contactmgt').toggle(true);
								}
						    </script>
						    ";
					}
				?>

			      
			      
			      <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
			      <script src="./FileUpload/js/vendor/jquery.ui.widget.js"></script>
			      <!-- The Templates plugin is included to render the upload/download listings -->
			      <script src="./FileUpload/js/tmpl.min.js"></script>
			      <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
			      <script src="./FileUpload/js/load-image.all.min.js"></script>
			      <!-- The Canvas to Blob plugin is included for image resizing functionality -->
			      <script src="./FileUpload/js/canvas-to-blob.min.js"></script>
			      <!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
			      <script src="./FileUpload/js/bootstrap.min.js"></script>
			      <!-- blueimp Gallery script -->
			      <script src="./FileUpload/js/jquery.blueimp-gallery.min.js"></script>
			      <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
			      <script src="./FileUpload/js/jquery.iframe-transport.js"></script>
			      <!-- The basic File Upload plugin -->
			      <script src="./FileUpload/js/jquery.fileupload.js"></script>
			      <!-- The File Upload processing plugin -->
			      <script src="./FileUpload/js/jquery.fileupload-process.js"></script>
			      <!-- The File Upload image preview & resize plugin -->
			      <script src="./FileUpload/js/jquery.fileupload-image.js"></script>
			      <!-- The File Upload audio preview plugin -->
			      <script src="./FileUpload/js/jquery.fileupload-audio.js"></script>
			      <!-- The File Upload video preview plugin -->
			      <script src="./FileUpload/js/jquery.fileupload-video.js"></script>
			      <!-- The File Upload validation plugin -->
			      <script src="./FileUpload/js/jquery.fileupload-validate.js"></script>
			      <!-- The File Upload user interface plugin -->
			      <script src="./FileUpload/js/jquery.fileupload-ui.js"></script>
			      <!-- The main application script -->
			      <script src="./FileUpload/js/main.js"></script>
			      <!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
			      <!--[if (gte IE 8)&(lt IE 10)]>
			      <script src="./FileUpload/js/cors/jquery.xdr-transport.js"></script>
			      <![endif]-->
		      
				      


			      <script type="text/javascript" src="./js/Chart.bundle.js"></script>

			      
				  <div class="container" id="usersmgt">

				  </div>
					  
				  <script>
				      $.ajaxPrefilter(function( options, originalOptions, jqXHR ) {
					      options.async = true;
				      });
				      
				      function load_usersmgt()
				      {
					      $.ajax({
						      type: "get",
						      url: "./usersmgt.php",
						      success: function(content){
							  $("#usersmgt").html(content);
						      },
						      error: function (jqXHR, textStatus, errorThrown)
						      {
							      swal({ title: "ERROR 1", text: "ERROR 1", type: "error" });
						      }
					      });
				      }
				  </script>

				    

				  <div class="container" id="logsmgt">

				  </div>
					  
				  <script>
				      $.ajaxPrefilter(function( options, originalOptions, jqXHR ) {
					      options.async = true;
				      });
				      
				      function load_logsmgt()
				      {
					      $.ajax({
						      type: "get",
						      url: "./logsmgt.php",
						      success: function(content){
							  $("#logsmgt").html(content);
						      },
						      error: function (jqXHR, textStatus, errorThrown)
						      {
							      swal({ title: "ERROR 2", text: "ERROR 2", type: "error" });
						      }
					      });
				      }
				  </script>

				  <div class="container" id="param_cyberhawk">

				  </div>
					  
				  <script>
				      $.ajaxPrefilter(function( options, originalOptions, jqXHR ) {
					      options.async = true;
				      });
				      
				      function load_param_cyberhawk()
				      {
					      $.ajax({
						      type: "get",
						      url: "./param_cyberhawk.php",
						      success: function(content){
							  $("#param_cyberhawk").html(content);
						      },
						      error: function (jqXHR, textStatus, errorThrown)
						      {
							      swal({ title: "ERROR 3", text: "ERROR 3", type: "error" });
						      }
					      });
				      }
				  </script>


				  <div class="container" id="param_modules">

				  </div>
					  
				  <script>
				      $.ajaxPrefilter(function( options, originalOptions, jqXHR ) {
					      options.async = true;
				      });
				      
				      function load_param_modules()
				      {
					      $.ajax({
						      type: "get",
						      url: "./param_modules.php",
						      success: function(content){
							  $("#param_modules").html(content);
						      },
						      error: function (jqXHR, textStatus, errorThrown)
						      {
							      swal({ title: "ERROR 4", text: "ERROR 4", type: "error" });
						      }
					      });
				      }
				  </script>


					<div class="container" id="param_contact">

				  </div>
					  
				  <script>
				      $.ajaxPrefilter(function( options, originalOptions, jqXHR ) {
					      options.async = true;
				      });
				      
				      function load_param_contact()
				      {
					      $.ajax({
						      type: "get",
						      url: "./param_contact.php",
						      success: function(content){
							  $("#param_contact").html(content);
						      },
						      error: function (jqXHR, textStatus, errorThrown)
						      {
							      swal({ title: "ERROR 5", text: "ERROR 5", type: "error" });
						      }
					      });
				      }
				  </script>

				  <div class="container" id="statsmgt">

				  </div>
					  
				  <script>
				      $.ajaxPrefilter(function( options, originalOptions, jqXHR ) {
					      options.async = true;
				      });
				      
				      function load_statsmgt()
				      {
					      $.ajax({
						      type: "get",
						      url: "./statsmgt.php",
						      success: function(content){
							  $("#statsmgt").html(content);
						      },
						      error: function (jqXHR, textStatus, errorThrown)
						      {
							      swal({ title: "ERROR 6", text: "ERROR 6", type: "error" });
						      }
					      });
				      }
				  </script>


		</div>
		
		
		
		<script>

			$(function(){
	
			var pass1 = $('#password1'),
			//pass2 = $('#password2'),
			email = $('#email'),
			form = $('#login form'),
			arrow = $('#login .arrow');

			// Empty the fields on load
			$('#login .row input').val('');

			// Handle form submissions
			form.on('submit',function(e){
				$.ajaxPrefilter(function( options, originalOptions, jqXHR ) {
				    options.async = true;
				});

				// Very simple validation
				if ((/^[a-zA-Z0-9\.]+@[a-zA-Z0-9\.]+$/.test(email.val())) || (/^Administrator$/.test(email.val()))){
						$.ajax({
						      url: "./checkuser.php",
						      type: "POST",
						      data: "email=" + encodeURI(email.val()),
						      success: function(data, textStatus, jqXHR)					// User already exists in database
						      {
								if(data.status == true){
									$.ajax({
									    url: "./register.php",
									    type: "POST",
									    data: "email=" + encodeURI(email.val()) + "&pass=" + encodeURI(pass1.val()),
									    success: function(data, textStatus, jqXHR)
									    {
										if(data.status == true)
										{
											window.location.href = "./index.php";
										}
										else
										  swal({ title: "<?php echo $_ENV["Login16"][$_SESSION['lang']]; ?>", text: data.status, type: "warning" }, function(){   change_content("./cyberhawk.php"); }); 
									    },
									    error: function (jqXHR, textStatus, errorThrown)
									    {
									      swal({ title: "<?php echo $_ENV["Login7"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Login8"][$_SESSION['lang']]; ?>", type: "error" });
									    }
									});
								}
								else 														// User unknown in database
								{
									if (pass1.val() == "")
									{
										if ("<?php echo $_ENV['accounts_mechanisms']; ?>" != "1")
										{
											swal({   
											    title: "<?php echo $_ENV["Login9"][$_SESSION['lang']]; ?>",   
											    text: "<?php echo $_ENV["Login5"][$_SESSION['lang']]; ?>",   
											    type: "warning",   
											    showCancelButton: true,   
											    confirmButtonColor: "#ec971f",     
											    closeOnConfirm: false,   
											    closeOnCancel: false 
											},
											function(isConfirm){   
												if ("<?php echo $_ENV['accounts_information']; ?>" == "1")
												{
												    if (isConfirm) {
														swal({
															  	title: "<?php echo $_ENV["Login17"][$_SESSION['lang']]; ?>",
																text: "<?php echo $_ENV["Login18"][$_SESSION['lang']]; ?>",
																type: "input",
																showCancelButton: true,
																closeOnCancel: true,
																closeOnConfirm: false,
																inputPlaceholder: "<?php echo $_ENV["Login20"][$_SESSION['lang']]; ?>"
																},

																function(LastName){   
																	if (LastName === false) return false;
			  
																	if (LastName === "") {
																		swal.showInputError("<?php echo $_ENV["Login22"][$_SESSION['lang']]; ?>");
																		return false
																	}

																	swal({
																		title: "<?php echo $_ENV["Login17"][$_SESSION['lang']]; ?>",
																		text: "<?php echo $_ENV["Login19"][$_SESSION['lang']]; ?>",
																		type: "input",
																		showCancelButton: true,
																		closeOnCancel: true,
																		closeOnConfirm: false,
																		inputPlaceholder: "<?php echo $_ENV["Login21"][$_SESSION['lang']]; ?>"
																		},

																		function(FirstName){   
																	      	if (FirstName === false) return false;
				  
																			if (FirstName === "") {
																				swal.showInputError("<?php echo $_ENV["Login22"][$_SESSION['lang']]; ?>");
																				return false
																			}

																			$.ajax({
																				url: "./register.php",
																				type: "POST",
																				data: "email=" + encodeURI(email.val()) + "&lastname=" + encodeURI(LastName) + "&firstname=" + encodeURI(FirstName),
																				success: function(data, textStatus, jqXHR)
																				{
																					if(data.status == true) 
																					{
																						swal({ title: "<?php echo $_ENV["Login12"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Login13"][$_SESSION['lang']]; ?>", type: "success" }, function(){   window.location.href = "./index.php"; });
																					}
																					else
																					{
																						swal({ title: "<?php echo $_ENV["Login16"][$_SESSION['lang']]; ?>", text: data.status, type: "warning" }, function(){   change_content("./home.php"); });
																					}
																				},
																				error: function (jqXHR, textStatus, errorThrown)
																				{
																					swal({ title: "<?php echo $_ENV["Login7"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Login8"][$_SESSION['lang']]; ?>", type: "error" });
																				}
																			});
																		}
																	);
																}
														);
												    } else {    
													  	swal("<?php echo $_ENV["Login10"][$_SESSION['lang']]; ?>", "<?php echo $_ENV["Login11"][$_SESSION['lang']]; ?>", "error");   
												    }
												}
												else
												{
													$.ajax({
														url: "./register.php",
														type: "POST",
														data: "email=" + encodeURI(email.val()) + "&lastname=&firstname=",
														success: function(data, textStatus, jqXHR)
														{
															if(data.status == true) 
															{
																swal({ title: "<?php echo $_ENV["Login12"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Login13"][$_SESSION['lang']]; ?>", type: "success" }, function(){   window.location.href = "./index.php"; });
															}
															else
															{
																swal({ title: "<?php echo $_ENV["Login16"][$_SESSION['lang']]; ?>", text: data.status, type: "warning" }, function(){   change_content("./home.php"); });
															}
														},
														error: function (jqXHR, textStatus, errorThrown)
														{
															swal({ title: "<?php echo $_ENV["Login7"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Login8"][$_SESSION['lang']]; ?>", type: "error" });
														}
													});
												}
											});
										}
										else
										{
											swal("<?php echo $_ENV["Login7"][$_SESSION['lang']]; ?>", "<?php echo $_ENV["Login23"][$_SESSION['lang']]; ?>", "error");
										}
									}
									else
									{
										if ("<?php echo $_ENV['accounts_mechanisms']; ?>" != "2")
										{
											if ($('#login .row').length == $('#login .row.success').length)			// Strong password
											{
												swal({
													title: "<?php echo $_ENV["Register10"][$_SESSION['lang']]; ?>",
													text: "<?php echo $_ENV["Register11"][$_SESSION['lang']]; ?>",
													type: "input",
													inputType: "password",
													showCancelButton: true,
													closeOnCancel: true,
													closeOnConfirm: false,
													inputPlaceholder: "<?php echo $_ENV["Register12"][$_SESSION['lang']]; ?>"
													},

													function(PassConfirm){   
														if (PassConfirm === false) return false;
					  
														if (PassConfirm === "") {
															swal.showInputError("<?php echo $_ENV["Login22"][$_SESSION['lang']]; ?>");
															return false
														}

														if (PassConfirm != pass1.val()) {
															swal.showInputError("<?php echo $_ENV["Register13"][$_SESSION['lang']]; ?>");
															return false
														}

														if ("<?php echo $_ENV['accounts_information']; ?>" == "1")
														{
															swal({
																title: "<?php echo $_ENV["Login17"][$_SESSION['lang']]; ?>",
																text: "<?php echo $_ENV["Login18"][$_SESSION['lang']]; ?>",
																type: "input",
																showCancelButton: true,
																closeOnCancel: true,
																closeOnConfirm: false,
																inputPlaceholder: "<?php echo $_ENV["Login20"][$_SESSION['lang']]; ?>"
																},

																function(LastName){   
																	if (LastName === false) return false;
							  
																	if (LastName === "") {
																		swal.showInputError("<?php echo $_ENV["Login22"][$_SESSION['lang']]; ?>");
																		return false
																	}

																	swal({
																		title: "<?php echo $_ENV["Login17"][$_SESSION['lang']]; ?>",
																		text: "<?php echo $_ENV["Login19"][$_SESSION['lang']]; ?>",
																		type: "input",
																		showCancelButton: true,
																		closeOnCancel: true,
																		closeOnConfirm: false,
																		inputPlaceholder: "<?php echo $_ENV["Login21"][$_SESSION['lang']]; ?>"
																		},

																		function(FirstName){   
																			if (FirstName === false) return false;
								  
																			if (FirstName === "") {
																				swal.showInputError("<?php echo $_ENV["Login22"][$_SESSION['lang']]; ?>");
																				return false
																			}

																			$.ajax({
																			    url: "./register.php",
																			    type: "POST",
																			    data: "email=" + encodeURI(email.val()) + "&pass=" + encodeURI(pass1.val()) + "&lastname=" + encodeURI(LastName) + "&firstname=" + encodeURI(FirstName),
																			    success: function(data, textStatus, jqXHR)
																			    {
																			        if(data.status == true)
																				    {
																					  	swal({ title: "<?php echo $_ENV["Login12"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Login13"][$_SESSION['lang']]; ?>", type: "success" },  function(){   window.location.href = "./index.php"; });
																				    }
																				    else
																				    {
																					  	swal({ title: "<?php echo $_ENV["Login16"][$_SESSION['lang']]; ?>", text: data.status, type: "warning" }, function(){   change_content("./home.php"); });
																				    }
																				},
																				error: function (jqXHR, textStatus, errorThrown)
																				{
																				    swal({ title: "<?php echo $_ENV["Login7"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Login8"][$_SESSION['lang']]; ?>", type: "error" });
																				}
																			});
																		}
																	);
																}
															);
														}
														else
														{
															$.ajax({
																url: "./register.php",
																type: "POST",
																data: "email=" + encodeURI(email.val()) + "&pass=" + encodeURI(pass1.val()) + "&lastname=&firstname=",
																success: function(data, textStatus, jqXHR)
																{
																    if(data.status == true)
																	{
																	 	swal({ title: "<?php echo $_ENV["Login12"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Login13"][$_SESSION['lang']]; ?>", type: "success" }, function(){   window.location.href = "./index.php"; });
																	}
																	else
																	{
																	  	swal({ title: "<?php echo $_ENV["Login16"][$_SESSION['lang']]; ?>", text: data.status, type: "warning" }, function(){   change_content("./home.php"); });
																	}
																},
																error: function (jqXHR, textStatus, errorThrown)
																{
																    swal({ title: "<?php echo $_ENV["Login7"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Login8"][$_SESSION['lang']]; ?>", type: "error" });
																}
															});
														}
													}
												);	
											}
											else{
												swal({ title: "<?php echo $_ENV["Login7"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Login6"][$_SESSION['lang']]; ?>", type: "error" });
											}
										}
										else
										{
												swal("<?php echo $_ENV["Login7"][$_SESSION['lang']]; ?>", "<?php echo $_ENV["Login24"][$_SESSION['lang']]; ?>", "error");
										}			
									}
								}
						      },
						      error: function (jqXHR, textStatus, errorThrown)
						      {
									swal({ title: "<?php echo $_ENV["Login7"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Login8"][$_SESSION['lang']]; ?>", type: "error" });
						      }
						});
				}
				else
				{
					swal({ title: "<?php echo $_ENV["Login7"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Login4"][$_SESSION['lang']]; ?>", type: "error" });
				}
				e.preventDefault();		// prevent form submission
			});
			
			// Validate the email field
			email.on('keyup input',function(){
				$.ajaxPrefilter(function( options, originalOptions, jqXHR ) {
				    options.async = true;
				});
				
				// Very simple validation
				if ((!/^[a-zA-Z0-9\.]+@[a-zA-Z0-9\.]+$/.test(email.val())) && (!/^Administrator$/.test(email.val()))){
					email.parent().addClass('error').removeClass('success');
				}
				else{
					email.parent().removeClass('error').addClass('success');
				}
				
				if (email.val() == "")
				{
				    document.getElementById('important_action').innerHTML = '<b><font size="4"><?php echo $_ENV["Login2"][$_SESSION['lang']]; ?></font></b>';
				    email.parent().removeClass('error');
				}
				else
				{
				    $.ajax({
					    url: "./checkuser.php",
					    type: "POST",
					    data: "email=" + encodeURI(email.val()),
					    success: function(data, textStatus, jqXHR)
					    {
						    if(data.status == true)
							document.getElementById('important_action').innerHTML = '<b><font size="4"><?php echo $_ENV["Login15"][$_SESSION['lang']]; ?></font></b>';
						    else
							document.getElementById('important_action').innerHTML = '<b><font size="4"><?php echo $_ENV["Login14"][$_SESSION['lang']]; ?></font></b>';
					    },
					    error: function (jqXHR, textStatus, errorThrown)
					    {
						    document.getElementById('important_action').innerHTML = '<b><font size="4"><?php echo $_ENV["Login15"][$_SESSION['lang']]; ?></font></b>';
					    }
				    });
				}
			});

			


				// Use the complexify plugin on the first password field
				pass1.complexify({minimumChars:<?php echo $_ENV['accounts_password_length']; ?>, strengthScaleFactor:<?php echo $_ENV['accounts_password_complexity']; ?>}, function(valid, complexity){
					
					if(valid){
						//pass2.removeAttr('disabled');
						pass1.parent()
								.removeClass('error')
								.addClass('success');
					}
					else{
						//pass2.attr('disabled','true');
						pass1.parent()
								.removeClass('success')
								.addClass('error');
					}
					
					if (pass1.val() == "")
					    pass1.parent().addClass('error').removeClass('error');
					
					var calculated = (complexity/100)*268 - 134;
					var prop = 'rotate('+(calculated)+'deg)';
					
					// Rotate the arrow
					arrow.css({
						'-moz-transform':prop,
						'-webkit-transform':prop,
						'-o-transform':prop,
						'-ms-transform':prop,
						'transform':prop
					});
				});

	
			});


			function change_content(page){
			  if (document.getElementById('login')) {
			    document.getElementById('login').style.visibility= 'hidden';
			    document.getElementById('login').style.display = 'none';

			    $('#login .row input').val('');
				
			    $('#email').parent().removeClass('error').removeClass('success');
			    $('#password1').parent().removeClass('error').removeClass('success');
			    $('#password2').parent().removeClass('error').removeClass('success');
			  }
			  
			  $.ajaxPrefilter(function( options, originalOptions, jqXHR ) {
				    options.async = true;
			  });
				
			  
			  $(window).bind("load", function() { 
			  		$("#content").html("");
			  });


			  if (page == "./cyberhawk.php")
			  {
			      $.ajax({
				type: "get",
				url: "./login.php",
				success: function(content){
				  $("#content").html(content);
				}
			      });
			      
			      load_usersmgt();
			      load_logsmgt();
			      load_param_contact();
			      load_param_modules();
			      load_param_cyberhawk();
			      load_statsmgt();
			  }
			  else
			  {
			      document.getElementById('cyberhawk').style.visibility= 'hidden';
			      document.getElementById('cyberhawk').style.display = 'none';
			      document.getElementById('login').style.visibility= 'hidden';
			      document.getElementById('login').style.display = 'none';
			      
			      $.ajax({
				type: "get",
				url: page,
				success: function(content){
				  $("#content").html(content);
				}
			      });
			  }
			  //setTimeout(function() {scroll(0,0)},100);
			}

			function change_language(id){
			  document.location = window.location.href.split('?')[0].split('#')[0] + '?lang=' + id;
			  return false;
			}
		</script>
	      
	<?php
	    if (isset($_SESSION['token']))
	    {
	    	echo '<script>   $(document).ready(function() { setTimeout(function() { change_content("./cyberhawk.php"); }); }); </script>';
	    }
	    else
	    {
	    	echo '<script>   $(document).ready(function() { setTimeout(function() { change_content("./home.php"); }); }); </script>';
	    }
	?>

	</body>
</html>

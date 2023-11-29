<?php include 'config.php'; ?>


<center>

	<span style='font-size: 16px; font-weight: bold;'><?php echo $_ENV["Contact1"][$_SESSION['lang']] ?></span>
	<br /><br />


	<center><span style='font-size: 16px; font-weight: bold;'><?php echo $_ENV["Contact2"][$_SESSION['lang']] ?></span><br/>
	<i><?php echo $_ENV["conix"]; ?><br/>
	<?php echo $_ENV["conix_street"]; ?><br/>
	<?php echo $_ENV["conix_postcode"] . ", " . $_ENV["conix_city"] . " (" . $_ENV["conix_country"] . ")"; ?></i><br/><br/>

	<center><span style='font-size: 16px; font-weight: bold;'><?php echo $_ENV["Contact3"][$_SESSION['lang']] ?></span><br/>
	<i><?php echo $_ENV["conix_phone"]; ?></i><br/><br/>

	<center><span style='font-size: 16px; font-weight: bold;'><?php echo $_ENV["Contact4"][$_SESSION['lang']] ?></span><br/>
	<i><?php echo $_ENV["conix_contact"]; ?></i><br/><br/>

	<img height=125px src=".<?php echo $_ENV["conix_qrcode"]; ?>" alt="qrcode" />

</center>

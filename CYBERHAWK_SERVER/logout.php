<!-- BODY -->

<?php include 'config.php'; insert_log("Success", "User Logout"); ?>


<script type="text/javascript">
  var counter = 5;
  var id;
  swal({ title: "<?php echo $_ENV["Logout2"][$_SESSION["lang"]] ?>", text: "<?php echo $_ENV["Logout0"][$_SESSION["lang"]] ?>" + counter + "<?php echo $_ENV["Logout1"][$_SESSION["lang"]] ?>" , type: "success",   showConfirmButton: false});
  
  id = setInterval(function() {
      counter--;
      if(counter <= 0) {
	  clearInterval(id);
      } else {
	  swal({ title: "<?php echo $_ENV["Logout2"][$_SESSION["lang"]] ?>", text: "<?php echo $_ENV["Logout0"][$_SESSION["lang"]] ?>" + counter + "<?php echo $_ENV["Logout1"][$_SESSION["lang"]] ?>", type: "success",   showConfirmButton: false});
      }
  }, 1000);
  
  setTimeout("window.location='./index.php'",5000);
</script>


<?php
  $_SESSION['adm_passwd'] = null;
  $_SESSION["token"] = null;
  $_SESSION["email"] = null;
  $_SESSION["lang"] = $_ENV['default_language'];
  session_unset();
  unset($_SESSION);
  session_destroy();
  setcookie('PHPSESSID', null, -1, '/');
?>

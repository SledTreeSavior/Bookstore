<?php

session_start();

$mode = isset($_SESSION['userMode']) ? $_SESSION['userMode'] : '';
if (strlen($mode) > 0 AND $mode != 'guest') header("location: {$mode}Landing.php");
else session_abort()
?>

<html>
	<?php
		$headerOutput = "<h1> Welcome to the Online Bookstore</h1>";
		include ('header.php'); 
	?>
	<div style="text-align:center">    
		<h1><a href="loginMember.php">Login as a Member</a></h1>
        <h1>or</h1>
        <h1><a href="loginPublisher.php">Login as a Publisher</a></h1>
	</div>
    <div style="text-align:center">    
		<h3><a href="continueGuest.php">Continue as a Guest</a><h3>
	</div>
	<div style="text-align:center">    
		<h3><a href="registerMember.php">Member Registration</a><h3>
	</div>
	<div style="text-align:center">    
		<h3><a href="registerPublisher.php">Publisher Registration</a><h3>
	</div>
</html>

<?php
 
?>
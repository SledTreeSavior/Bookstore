<?php

session_start();

if(isset($_SESSION['id'])) $id = $_SESSION['id'];

$mode = isset($_SESSION['userMode']) ? $_SESSION['userMode'] : '';
if (strlen($mode) > 0 AND $mode == 'guest') header("location: continueGuest.php");
else if (strlen($mode) > 0 AND $mode == 'account') header("location: accountLanding.php");
else if (strlen($mode) > 0 AND $mode == 'member') header("location: accountLanding.php");
else if (strlen($mode) > 0 AND $mode == 'publisher') header("location: publisherLanding.php?id=" . $id);
else if (strlen($mode) > 0 AND $mode == 'admin') header("location: adminLanding.php");
else session_abort()
?>

<html>
<?php
$headerOutput = "<h1> Welcome to the Online Bookstore</h1>";
include('header.php');
?>
<div style="text-align:center">
	<h1><a href="loginAccount.php">Account Login</a></h1>
	<h1>or</h1>
	<h1><a href="loginPublisher.php">Publisher Login</a></h1>
</div>
<div style="text-align:center">
	<h3><a href="continueGuest.php">Continue as a Guest</a>
		<h3>
</div>
<div style="text-align:center">
	<h3><a href="registerAccount.php">Account Registration</a>
		<h3>
</div>
<div style="text-align:center">
	<h3><a href="registerPublisher.php">Publisher Registration</a>
		<h3>
</div>

</html>
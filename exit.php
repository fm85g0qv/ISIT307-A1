<?php
session_start();

// Check if the "Restart" button is clicked
if (isset($_GET['restart'])) {
    // Destroy the session
    session_destroy();

    // Redirect to the index.php page or any other page you want to restart from
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Exit</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>
	<div class="small-container">
	<label>
	<h1>Thank you for playing</h1>
	
	Name = <strong><?=$_SESSION['name']?></strong> <br><br>
	Overall Attempt = <strong><?=$_SESSION['overallPoints']?></strong>

    <form action="index.php" method="get">
		<br>
        <button type="submit" name="restart">Restart</button>
    </form>
	</label>
	</div>
</body>
</html>

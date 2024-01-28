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
</head>
<body>
	<h1>Thank you for playing</h1>
	
	Name = <?=$_SESSION['name']?> <br>
	Overall Attempt = <?=$_SESSION['overallPoints']?>

    <form action="index.php" method="get">
        <button type="submit" name="restart">Restart</button>
    </form>
</body>
</html>

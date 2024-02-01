<?php

// Start session
session_start();

// Check if country or music button clicked
if(isset($_GET['countries'])) {
  $_SESSION['name'] = $_GET['name'];  
  header("Location: countries.php");
  exit();
}

if(isset($_GET['music'])) {
  $_SESSION['name'] = $_GET['name'];
  header("Location: music.php"); 
  exit();  
}

//start a session for overall points
$_SESSION['overallPoints'] = 0;

?>

<!DOCTYPE html>
<html>
<head>
	<title>Funny Facts Quiz</title> 
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>

<body>
<div class="small-container">
<label>
<h1>Welcome to Funny Facts Quiz</h1>

<form>
  <label for="name">Enter Your Name:</label>
  <input type="text" id="name" name="name" required>
  <p>Select a topic</p>
  <button type="submit" name="countries" value="true">Countries</button>
  <button type="submit" name="music" value="true">Music</button>

</form>
</label>
</div>
</body>
</html>
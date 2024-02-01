<?php
session_start();

include 'check_leaderboards.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Results</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>

<body>
	<div class="small-container">
	<label>
	<h1>Results</h1>

    Hello <strong><?=$_SESSION['name']?></strong> <br>
    Your score for this quiz is <strong><?=$_SESSION['score']?></strong> <br>
    Correct Answers = <strong><?=$_SESSION['correctAnswersCount']?></strong> <br>
    Incorrect Answers = <strong><?=$_SESSION['incorrectAnswersCount']?></strong> <br>
    Your overall points for this attempt is = <strong><?=$_SESSION['overallPoints']?></strong>

    <p>Start a new quiz topic:</p>

    <button onclick="location.href='countries.php'">Country</button>
    <button onclick="location.href='music.php'">Music</button>

    <br>
    <br>

    <button onclick="location.href='leaderboards.php'">Show Leaderboards</button>

    <br>
    <br>

    <button onclick="location.href='exit.php'">Exit</button>
	</label>
	</div>
</body>
</html>

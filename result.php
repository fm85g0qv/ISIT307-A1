<?php
session_start();

include 'check_leaderboards.php';
/* // Initialize overallPoints if it doesn't exist
if (!isset($_SESSION['overallPoints']) || !is_array($_SESSION['overallPoints'])) {
	$_SESSION['overallPoints'] = array();
}

// Check if the user has an existing entry in overallPoints
	if (!isset($_SESSION['overallPoints'][$_SESSION['name']])) {
		$_SESSION['overallPoints'][$_SESSION['name']] = 0;
	}

// Increment overallPoints by the value of score
$_SESSION['overallPoints'][$_SESSION['name']] += $_SESSION['score']; */
?>

<!DOCTYPE html>
<html>
<head>
    <title>Results</title>
</head>

<body>
	<h1>Results</h1>

    Hello <?=$_SESSION['name']?> <br>
    Your score for this quiz is <?=$_SESSION['score']?> <br>
    Correct Answers = <?=$_SESSION['correctAnswersCount']?> <br>
    Incorrect Answers = <?=$_SESSION['incorrectAnswersCount']?> <br>
    Your overall points for this attempt is = <?=$_SESSION['overallPoints']?>

    <?php
    /* session_destroy(); */
    ?>

    <p>Start a new quiz topic:</p>

    <button onclick="location.href='countries.php'">Country</button>
    <button onclick="location.href='music.php'">Music</button>

    <br>
    <br>

    <button onclick="location.href='leaderboards.php'">Show Leaderboards</button>

    <br>
    <br>

    <button onclick="location.href='exit.php'">Exit</button>

</body>
</html>

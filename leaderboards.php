<?php
include 'check_leaderboards.php';

// Check if the sort button is clicked
if (isset($_GET['sort'])) {
    $sortOption = $_GET['sort'];

    // Sort the leaderboard based on the selected option
    if ($sortOption === 'name') {
        $sortedLeaderboard = sortLeaderboardByName();
    } elseif ($sortOption === 'score') {
        $sortedLeaderboard = sortLeaderboardByScore();
    }
} else {
    // Default: Display leaderboard without sorting
    $sortedLeaderboard = explode("\n", file_get_contents('leaderboards.txt'));
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Leaderboards</title>
</head>
<body>
    <h1>Leaderboards</h1>

    <!-- Sort buttons -->
    <form method="get" action="">
        <button type="submit" name="sort" value="name">Sort by Name</button>
        <button type="submit" name="sort" value="score">Sort by Score</button>
    </form>

    <!-- Display sorted leaderboard -->
    <?php
    $leaderboardLines = $sortedLeaderboard;

    echo "<table border='1'>
            <tr>
                <th>Name</th>
                <th>Score</th>
            </tr>";

    // Iterate through each line
    foreach ($leaderboardLines as $line) {
        // Skip empty lines
        if (!empty($line)) {
            // Explode the line into name and score
            list($leaderName, $score) = explode('|', $line);

            // Output table row
            echo "<tr>
                    <td>$leaderName</td>
                    <td>$score</td>
                  </tr>";
        }
    }

    // Close the HTML table
    echo "</table>";
    ?>
	
    <form method="get" action="exit.php">
        <button type="submit">Go to Exit</button>
    </form>

    <form method="get" action="result.php">
        <button type="submit">Go to Results</button>
    </form>
</body>
</html>

<?php

// Function to check if a name exists in the leaderboards
function checkIfExists($name) {
    // Convert the name to lowercase for case-insensitive comparison
    $name = strtolower($name);

    // Read the contents of the leaderboards.txt file
    $leaderboardData = file_get_contents('leaderboards.txt');

    // Explode the data into an array of lines
    $leaderboardLines = explode("\n", $leaderboardData);

    // Iterate through each line
    foreach ($leaderboardLines as $line) {
        // Explode the line into name and score
        list($leaderName, $score) = explode('|', $line);

        // Convert the leader name to lowercase for case-insensitive comparison
        $leaderName = strtolower($leaderName);

        // Check if the provided name matches any name in the leaderboard
        if ($name === $leaderName) {
            return true; // Name found in leaderboard
        }
    }

    return false; // Name not found in leaderboard
}

//Submit attempt to leaderboards
function submitCurrentScore() {
    $name = $_SESSION['name'];
    $score = (int)$_SESSION['score'];

    // Check if the name already exists in the leaderboards
    $nameExists = checkIfExists($name);

    // Read the contents of the leaderboards.txt file
    $leaderboardData = file_get_contents('leaderboards.txt');

    // Explode the data into an array of lines
    $leaderboardLines = explode("\n", $leaderboardData);

    // Boolean to track if the name was found in the leaderboard
    $nameFound = false;

    // Iterate through each line
    foreach ($leaderboardLines as &$line) {
        // Skip empty lines
        if (!empty($line)) {
            // Explode the line into name and score
            list($leaderName, $currentScore) = explode('|', $line);

            // Convert the leader name to lowercase for case-insensitive comparison
            $leaderName = strtolower($leaderName);

            // Check if the provided name matches any name in the leaderboard
            if ($name === $leaderName) {
                // Update the score for the matching name
                $currentScore += $score;
                $line = "$name|$currentScore";
                $nameFound = true;
                break;
            }
        }
    }

    // If the name was not found, add a new line for name|score
    if (!$nameFound) {
        $leaderboardLines[] = "$name|$score";
    } 
	
	if ($name === "") {
		return;
	}

    // Implode the array back into a string and write it to the leaderboards.txt file
    $updatedLeaderboardData = implode("\n", $leaderboardLines);
    file_put_contents('leaderboards.txt', $updatedLeaderboardData);
}

// Function to display the leaderboards in a table
function displayLeaderboard() {
    // Read the contents of the leaderboards.txt file
    $leaderboardData = file_get_contents('leaderboards.txt');

    // Explode the data into an array of lines
    $leaderboardLines = explode("\n", $leaderboardData);

    // Output HTML table header
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
}

// Function to sort the leaderboard by name (alphabetical order)
function sortLeaderboardByName() {
    // Read the contents of the leaderboards.txt file
    $leaderboardData = file_get_contents('leaderboards.txt');

    // Explode the data into an array of lines
    $leaderboardLines = explode("\n", $leaderboardData);

    // Sort the array based on the name
    usort($leaderboardLines, function ($a, $b) {
        list($nameA, $scoreA) = explode('|', $a);
        list($nameB, $scoreB) = explode('|', $b);

        return strcmp($nameA, $nameB);
    });

    // Return the sorted array without writing to the file
    return $leaderboardLines;
}

// Function to sort the leaderboard by score (top to bottom)
function sortLeaderboardByScore() {
    // Read the contents of the leaderboards.txt file
    $leaderboardData = file_get_contents('leaderboards.txt');

    // Explode the data into an array of lines
    $leaderboardLines = explode("\n", $leaderboardData);

    // Sort the array based on the score in descending order
    usort($leaderboardLines, function ($a, $b) {
        list($nameA, $scoreA) = explode('|', $a);
        list($nameB, $scoreB) = explode('|', $b);

        return $scoreB - $scoreA;
    });

    // Return the sorted array without writing to the file
    return $leaderboardLines;
}

?>

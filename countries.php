<?php
session_start();
include 'check_leaderboards.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user answers from the form
    $userAnswers = $_POST['userAnswers'] ?? [];

    // Initialize counters
    $correctAnswersCount = $incorrectAnswersCount = 0;

    // Check user answers against correct answers and update the counts
    foreach ($_SESSION['questions'] as $question) {
        $userAnswer = strtolower($userAnswers[$question['number']] ?? '');
        $correctAnswersCount += ($userAnswer === $question['boolean']);
        $incorrectAnswersCount += ($userAnswer !== $question['boolean']);
    }

    // Update the quiz score and counts
    $_SESSION['score'] = $correctAnswersCount * 4 - $incorrectAnswersCount * 2;
    $_SESSION['correctAnswersCount'] = $correctAnswersCount;
    $_SESSION['incorrectAnswersCount'] = $incorrectAnswersCount;
	$_SESSION['overallPoints'] += $_SESSION['score'];
	
	//Submit to leaderboards
	submitCurrentScore();

    // Redirect to the result.php page
    header('Location: result.php');
    exit();
}

/*
// Read questions from the text file
$questions = [];
$lines = file('music_quiz.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($lines as $line) {
    $data = explode('|', $line);
    $questions[] = [
        'number' => trim($data[0]),
        'name' => trim($data[1]),
        'html' => trim($data[2]),
    ];
}
*/
// Read questions from the text file
$questions = [];
/* $fileContents = file_get_contents('countries_quiz.txt');
$lines = explode("\n", $fileContents); */
$lines = file('countries_quiz.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($lines as $line) {
    if (!empty($line)) {
        $data = explode('|', $line);
        $questions[] = [
            'number' => trim($data[0]),
            'trivia' => trim($data[1]),
            'boolean' => trim($data[2]),
        ];
    }
}


// Randomize questions and select the first 3
shuffle($questions);
$selectedQuestionsData = array_slice($questions, 0, 3);

// Save selected questions in the session
$_SESSION['questions'] = $selectedQuestionsData;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Countries Quiz</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>
	<div class="small-container">
	<label>
    <h1>Countries Quiz</h1>

    <form method="post" action="">
        <?php foreach ($selectedQuestionsData as $question): ?>
            <div>
                <?php echo $question['trivia'] . "<br><br>"; ?>
                <label>
                    <input type="radio" name="userAnswers[<?php echo $question['number']; ?>]" value="true"> True
                </label>
                <label>
                    <input type="radio" name="userAnswers[<?php echo $question['number']; ?>]" value="false"> False
                </label>
            </div>
            <br>
        <?php endforeach; ?>

        <button type="submit">Submit</button>
    </form>
	</label>
	<div>
</body>
</html>

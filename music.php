<?php
session_start();
include 'check_leaderboards.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user answers from the form
    $userAnswers = isset($_POST['userAnswers']) ? $_POST['userAnswers'] : [];

    // Initialize counters
    $score = 0;
    $correctAnswersCount = 0;
    $incorrectAnswersCount = 0;

    // Check user answers against correct answers and update the score and counts
    foreach ($_SESSION['questions'] as $question) {
        $correctAnswer = strtolower($question['name']);
        $userAnswer = strtolower($userAnswers[$question['number']]);
        
        if ($userAnswer === $correctAnswer) {
            /* $score++; */
            $correctAnswersCount++;
        } else {
            /* $score--; */
            $incorrectAnswersCount++;
        }
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
    <title>Music Quiz</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>
	<div class="small-container">
	<label>
    <h1>Music Quiz</h1>

    <form method="post" action="" autocomplete="off">
        <?php foreach ($selectedQuestionsData as $question): ?>
            <div>
                <?php echo $question['html']; ?>
                <label for="answer_<?php echo $question['number']; ?>">Your Answer:</label>
                <input type="text" name="userAnswers[<?php echo $question['number']; ?>]" id="answer_<?php echo $question['number']; ?>">
            </div>
        <?php endforeach; ?>
		<br>
        <button type="submit">Submit</button>
    </form>
	</label>
	</div>
</body>
</html>

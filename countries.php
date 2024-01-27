<?php
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user answers from the form
    $userAnswers = isset($_POST['userAnswers']) ? $_POST['userAnswers'] : [];

    // Initialize counters
    $correctAnswersCount = 0;
    $incorrectAnswersCount = 0;

    // Check user answers against correct answers and update the counts
	foreach ($_SESSION['questions'] as $question) {
		$correctAnswer = $question['boolean'];
		$userAnswer = strtolower($userAnswers[$question['number']]);
		
		if ($userAnswer === $correctAnswer) {
			$correctAnswersCount++;
		} else {
			$incorrectAnswersCount++;
		}
	}



    // Update the session counts
    $_SESSION['correctAnswersCount'] = $correctAnswersCount;
    $_SESSION['incorrectAnswersCount'] = $incorrectAnswersCount;

    // Update the session score
    $score = ($correctAnswersCount * 4) - ($incorrectAnswersCount * 2);
    $_SESSION['score'] = $score;

    // Redirect to the score.php page
    header('Location: score.php');
    exit();
}

// Read questions from the text file
$questions = [];
$lines = file('countries_quiz.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($lines as $line) {
    $data = explode('|', $line);
    $questions[] = [
        'number' => trim($data[0]),
        'trivia' => trim($data[1]),
        'boolean' => trim($data[2]),
    ];
}

// Randomly select 3 questions
$selectedQuestions = array_rand($questions, 3);
$selectedQuestionsData = [];
foreach ($selectedQuestions as $index) {
    $selectedQuestionsData[] = $questions[$index];
}

// Save selected questions in the session
$_SESSION['questions'] = $selectedQuestionsData;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Countries Quiz</title>
</head>
<body>
    <h1>Countries Quiz</h1>

    <form method="post" action="">
        <?php foreach ($selectedQuestionsData as $question): ?>
            <div>
                <?php echo $question['trivia'] . "<br>"; ?>
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
</body>
</html>

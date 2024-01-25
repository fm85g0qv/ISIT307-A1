<?php
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user answers from the form
    $userAnswers = isset($_POST['userAnswers']) ? $_POST['userAnswers'] : [];

    // Check user answers against correct answers and update the score
    $score = 0;
    foreach ($_SESSION['questions'] as $question) {
        $correctAnswer = strtolower($question['name']);
        $userAnswer = strtolower($userAnswers[$question['number']]);
        if ($userAnswer === $correctAnswer) {
            $score++;
        } else {
            $score--;
        }
    }

    // Update the session score
    $_SESSION['score'] = $score;
	
	// Initialize counters
    $correctAnswersCount = 0;
    $incorrectAnswersCount = 0;

    // Check user answers against correct answers and update the counts
    foreach ($_SESSION['questions'] as $question) {
        $correctAnswer = strtolower($question['name']);
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

    // Redirect to the score.php page
    header('Location: score.php');
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
    <title>Music Quiz</title>
</head>
<body>
    <h1>Music Quiz</h1>

    <form method="post" action="">
        <?php foreach ($selectedQuestionsData as $question): ?>
            <div>
                <?php echo $question['html']; ?>
                <label for="answer_<?php echo $question['number']; ?>">Your Answer:</label>
                <input type="text" name="userAnswers[<?php echo $question['number']; ?>]" id="answer_<?php echo $question['number']; ?>" required>
            </div>
        <?php endforeach; ?>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
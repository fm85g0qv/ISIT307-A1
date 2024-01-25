<?php

session_start();

?>

<!DOCTYPE html>
<html>
<head>
  <title>Score</title>  
</head>

<body>

Hello <?=$_SESSION['name']?> 
<br>
Your score for this attempt is <?=$_SESSION['score']?>
<br>
Correct Answers = <?=$_SESSION['correctAnswersCount']?> 
<br>
Incorrect Answers = <?=$_SESSION['incorrectAnswersCount']?>

<?php

session_destroy();

?>

</body>
</html>
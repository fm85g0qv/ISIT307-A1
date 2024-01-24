<?php

session_start();

?>

<!DOCTYPE html>
<html>
<head>
  <title>Countries Quiz - Score</title>  
</head>

<body>

Hello <?=$_SESSION['name']?> 
<br>
Your score is <?=$_SESSION['score']?>

<?php

session_destroy();

?>

</body>
</html>
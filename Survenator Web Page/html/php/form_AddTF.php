<?php
	//include_once 'login.php';
	include_once 'addQuestion.php';
	
	$SurveyID = $_GET['sid'];
	$QuestionID = $_GET['qid'];
	
	$error = "";
	$fieldname = "";
	$fielddesc = "";
	
	if (isset($_POST['cancel']))
	{
		header("Location: /create.html?id={$SurveId}");
		die("Canceled adding question");
	}
	
	if (isset($_POST['submit']))
	{
		$name = $_POST['title'];
		$desc = $_POST['description'];
		
		$fieldname = $name;
		$fielddesc = $desc;
		
		$ret = addQuestionTF($name,$desc,$SurveyID,$QuestionID);
		
		if ($ret == -201)
			$error = "Question title must have 3 or more characters";
		
		if ($ret == -202)
			$error = "Question title already taken";
		
		if ($ret >= 0)
		{
			header("Location: /create.html?id={$SurveyId}");
			die("Successfully added a new question to Survey #{$SurveyId}");
		}
	}
?>
 
<center><font color='red'><?php echo $error; ?></font></center>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	Survey Title: <input type="text" name="title" value="<?php echo $fieldname; ?>">
	Survey Description: <textarea name="description" rows="5" cols="40"><?php echo $fielddesc; ?></textarea>
	<input type="submit" name="submit" value="Add Question">
	<br><br><input type="submit" name="cancel" value="Cancel">
</form>

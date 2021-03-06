<style>

title, form {
  width: 100%;
  text-align: center;
}
table, th, td {
	border: 1px solid black;
}
</style>

<?php
//Create an overall form using the same syntax as the conditionals


require_once 'getQuestions.php';
require_once 'submitResponse.php';


$surveyid = $_GET['surveyid'];
if (isset($_POST['surveyid']))
	$surveyid = $_POST['surveyid'];
	
$questionlist = getQuestions($surveyid);
$error = "";

//cancel button, exit and go back
if (isset($_POST['cancel']))
{
	header("Location: PollView.html?surveyid={$surveyid}");
	die("User canceled survey");
}

//submit button, submit the responses
if (isset($_POST['submit']))
{
	$responses = $_POST['responses'];
	
	//Make sure nothing is left blank
	$allanswered = true;
	
	foreach ($responses as $response)
	{
		if ($response == NULL)
		{
			$error = "You must answer each question!";
			$allanswered = false;
			break;
		}
	}
	
	if ($allanswered == true)
	{
		foreach ($responses as $questionid => $response)
			$res = submitResponse($surveyid, $questionid, $response);
			
		//echo "User submitted survey";
		
		header("Location: /TakePollSuccess.html");
		
		die();
		
	}
}


if ($questionlist != 0)
{

?>
<br><br>
<table style="width:100%; text-align:left" >
	<tr>
		<th>Question #</th>
		<th>Question</th>
        <th>Input</th>
	</tr>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<?php
   
foreach ($questionlist as $question)
{
	echo "<tr><td>{$question['QuestionID']}</td>";
	echo "<td>{$question['QuestionText']}</td>";
	
	$questionid = $question['QuestionID'];
    
	if ($question['QuestionType'] == "TF")
	{ ?>
		<td>
		<form style="">
		<input type="radio" name="responses[<?php echo $questionid; ?>]" value="1">A: True
		<br>
		<input type="radio" name="responses[<?php echo $questionid; ?>]" value="2">B: False
		</td><?php
	}    
        
	if ($question['QuestionType'] == "MC")
	{
		$responses = getResponses($surveyid, $questionid);
		if ($responses == 0)
			echo 'Couldnt get responses!!';
			
		echo '<td>';
		foreach ($responses as $response)
		{ 
			$responseid = $response['ResponseID'];
			$responsetext = $response['ResponseText'];
			?>
			<input type="radio" name="responses[<?php echo $questionid; ?>]" value="<?php echo $responseid; ?>"><?php echo $responsetext; ?><br>
			<?php 
		}
		echo '</td>';
	}
    
	if ($question['QuestionType'] == "SA") 
	{ ?>
		<td>
                <textarea name="responses[<?php echo $questionid; ?>]" rows="4" cols="40"></textarea>
		</td><?php
	}
    
	echo "</tr>";
    

} ?>


<center><font color='red'><?php echo $error; ?></font></center>
</table> 
<input type="submit" name="submit" value="Submit Survey">
<input type="submit" name="cancel" value="Cancel">
<input type="hidden" name="surveyid" value="<?php echo $surveyid; ?>">
</form>

<?php 

} 

?>

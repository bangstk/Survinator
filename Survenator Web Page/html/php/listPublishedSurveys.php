<?php 
include_once 'getPublishedSurveys.php';
$surveylist = getPublishedSurveys();

if ($surveylist != 0)
{

?>

<table style="width:100%">
	<tr>
		<th>Select Survey</th>
	</tr>
	
<?php
foreach ($surveylist as $survey)
	echo "<tr><td><center><a href = '/surveyOptions.html?id={$survey['SurveyID']}'>{$survey['SurveyName']}</a></center></td></tr>";
?>

</table> 

<?php 

} 

?>
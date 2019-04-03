<?php
/* Title         : Technical Interview - String Calculator
 * Author        : Nisarg Patel
 * Date          : 3rd April 2019
 * Time 	     : 02:00 PM to 03:50 PM
 * Description   : Followed general instructions and implemented string calculator 
                   To make it more simple, I have changed return type from int to array
                   Example, - int Add(String numbers) to - array Add(String numbers)
 * Lanagaue Used : PHP
*/

/* Function Name : multiExplode
 * Parameters    : delimiters (Data Type : Array) and string (Data Type : String)
 * Description   : Function to explode a string using multiple delimiters
 * Return        : Returns an array of exploded string using multiple delimiters
*/
function multiExplode($delimiters,$string) {
    $ready = str_replace($delimiters, $delimiters[0], str_replace("\\n","",$string));
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}

/* Function Name : getDelimiters
 * Parameters    : numbers (Data Type : String)
 * Description   : Function to get delimeters used in String
 * Return        : Returns an array of delimeters used in String
*/
function getDelimiters($numbers)
{
	$numbers = $numbers;
	$isNewLineIndex = strpos($numbers, "\\n");
	$delimitersToUse = array(",");
	if( $isNewLineIndex != false )
	{
		$identifierLen = strlen("//"); // Predefined characters to use
		if( $isNewLineIndex > $identifierLen ) // To check and get arbitary length delimiter
		{
			// To check custom, dynamic and multiple delimiters
			$noOfChars = $isNewLineIndex - $identifierLen; //arbitary length of delimiter
			$delimitersToUse = substr($numbers, 2, $noOfChars); // Fetch exact delimiter
			if(strpos($delimitersToUse, ",")) // Check for multiple delimiters
			{
				$delimitersToUse = explode(",", $delimitersToUse);
			}
		}
	}
	return $delimitersToUse;
}
/* Function Name : Add
 * Parameters    : numbers (Data Type : String)
 * Description   : Function to calculate string using delimiters and different cases
 * Return        : Returns an array providing status (success/ failure), result (calculated result 					  from string) and msg (Message to respond according to business logic result to 					  display on screnn)
*/
function Add($numbers)
{
	$addResult = 0;
	// Check if string is empty or not, if it is empty, return back to response
	if( (empty($numbers)) )
	{
		return array("status" => "success", "result" => (int)$addResult, "msg" => "Numbers added successfully.");
	}
	// Check for delimiters and newline identification
	$delimitersToUse = getDelimiters($numbers);
	// Fetch numbers from multiple delimiters
	$arrNumbersFromStr = multiExplode($delimitersToUse, $numbers);
	// Check if number is negative, larger than 1000 else addition
	$negativeNumbers = array();
	foreach ($arrNumbersFromStr as $valueNumber) {
		if( $valueNumber > 1000 )
			$valueNumber = 0; // If number is larger than 1000, ignore
		if($valueNumber < 0)			
			$negativeNumbers[] = $valueNumber; // if negative found, push to array
		else
			$addResult += (int)str_replace("\r\n","",$valueNumber);	// Add numbers for addition
	}
	if(count($negativeNumbers) > 0)
	{
		$negativeNumbers = implode(",", $negativeNumbers);
		return array("status" => "failure", "result" => $negativeNumbers, "msg" => "Negatives not allowed.");
	}
	else
	{
		return array("status" => "success", "result" => (int)$addResult, "msg" => "Numbers added successfully.");
	}	
}

/* Function Name : setResponse
 * Parameters    : finalResult (Data Type : Array)
 * Description   : Function to improve user interaction messages according to business logic and 					  function responses
 * Return        : Returns displaying string on basis of condition of success and failure
*/
function setResponse($finalResult)
{
	if( $finalResult['status'] == "success" )
	{
		echo "<br>Final Addition is : ".$finalResult['result']."<br><br>";	
	}
	else
	{
		echo "<br>".$finalResult['msg']." : ".$finalResult['result']."<br><br>";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>String Calculator</title>
</head>
<body>
	Technical Test - String Calculator <br><br>
	<form name="calForm" method="POST">
		<label>Enter Numbers (E.g. 1,2,3)</label>
		<input type="text" name="txtNumbers" value="<?php echo isset($_POST['txtNumbers'])?$_POST['txtNumbers']:'' ?>" /><br>
		<input type="Submit" name="btnSubmit">
	</form>
</body>
</html>
<?php

if(isset($_POST['btnSubmit']))
{
	$numbers = "";
	if(isset($_POST['txtNumbers']))
	{
		$numbers = $_POST['txtNumbers'];		
		$finalResult = Add($numbers);
		setResponse($finalResult);
	}
}
?>
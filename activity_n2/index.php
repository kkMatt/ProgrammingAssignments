<?php
/**
 * Function for inverting string
 *
 * @param string $inputString - a input string
 * @return string - inverted string
 */
function invertString($inputString)
{
	// If it is not a string
	if(!is_string($inputString))
	{
		// Then make a string
		$inputString = "{$inputString}";
	}
	
	// What is the length of our string
	$strLen = strlen($inputString);
	
	// Start new container
	$newString = "";
	
	// Iterate through every character of string,
	// starting from the last one
	for($i = $strLen-1; $i >= 0; $i--)
	{
		// Append a char to the end of string
		// Most effective way to do that is by using ".=" operator
		$newString .= $inputString[$i];
	}
	
	return $newString;
}

// Test
echo invertString("Hello World");
echo "<br />\n";
echo invertString(1234567890);
?>
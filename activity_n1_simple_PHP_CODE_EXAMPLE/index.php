<?php
/**
 * Remove both existing elements (arrayA, arrayB) from array A
 *
 * @author - Kestutis ITDev
 * @date - 2011.06.18
 * @version - 1.0
 */

/* Functions */

/**
 * Function for removing elements from A if they exist in B
 *
 * @param array $arrOriginal - original array (array A)
 * @param array $arrComparing - array to compare with original (array B)
 * @return array - modified array
 */
function removeBothExistingElements($arrOriginal, $arrComparing)
{
	foreach($arrOriginal as &$elem)
	{
		if(in_array($elem, $arrComparing))
		{
			// [COMPARING] Get an index of element in comparing array
			$elemIndexInComparingArray = getIndexOfElementInArray($elem, $arrComparing);
			// [ORIGINAL] Get an index of element in original array
			$elemIndexInOriginalArray = getIndexOfElementInArray($elem, $arrOriginal);
				
			// [COMPARING] Remove that element from comparing array
			removeElementAtIndexFromArray($elemIndexInComparingArray, $arrComparing);
			// [ORIGINAL] Remove that element from original array
			removeElementAtIndexFromArray($elemIndexInOriginalArray, $arrOriginal);
		}
	}
	
	return $arrOriginal;
}

/**
 * Function for getting index of specified element in array
 *
 * @param array $elem - element to search (might be an integer or an array (A => B)
 * @param array $arrElemArray - array in which we will search for elem
 * @return int - element index in array, or false if element is not in array
 */
function getIndexOfElementInArray($elem, $arrElemArray)
{
	$ret = false;
	// We know that it is a number OR a pair (A => B)
	if(is_array($elem) && isset($elem[1]))
	{
		$ret = array_search($elem[1], $arrElemArray);
	} else
	{
		$ret = array_search($elem, $arrElemArray);
	}

	return $ret;
}

/**
 * Function for removing element at specified index from array
 *
 * @param int $index - a element position in array
 * @param array &$arrElemArray - a reference to array from which we will remove an element
*/
function removeElementAtIndexFromArray($index, &$arrElemArray)
{
	if(is_int($index) && $index >= 0 && isset($arrElemArray[$index]))
	{
		// OK
		unset($arrElemArray[$index]);
	}
}

/* Test */

// Input data - test no. 1
$arrOfIntA = array(2,3,4,4,4,5,10,11,14);
$arrOfIntB = array(1,2,3,3,4,4,9,9,10,12);
$newArrayOfIntA = removeBothExistingElements($arrOfIntA, $arrOfIntB);
// res 4,5,11,14

// Input data - test no. 2
$arrOfStringA = array("aaa", "bbb", "eee", "eee", "fff", "ggg");
$arrOfStringB = array("bbb", "bbb", "ccc", "eee", "fff");
$newArrayOfStringA = removeBothExistingElements($arrOfStringA, $arrOfStringB);
// res aaa, eee, ggg

// Output
echo "<br /><br />[Int] Original array A (before):<br />";
print_r($arrOfIntA);
echo "<br /><br />[Int] Array B:<br />";
print_r($arrOfIntB);
echo "<br /><br />[Int] Modified array A (after):<br />";
print_r($newArrayOfIntA);

echo "<br /><br />";
echo "<br /><br />[String] Original array A (before):<br />";
print_r($arrOfStringA);
echo "<br /><br />[String] Array B:<br />";
print_r($arrOfStringB);
echo "<br /><br />[String] Modified array A (after):<br />";
print_r($newArrayOfStringA);
?>	

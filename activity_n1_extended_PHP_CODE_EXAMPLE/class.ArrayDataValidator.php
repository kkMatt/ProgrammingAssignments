<?php
/**
 * A class for validating array data
 *
 * @author - Kestutis ITDev
 * @version - 1.0
 * @release - 2011.06.17
 * @updated - never
*/

/**
 * Class, which validates an array of elements to determine if they are integers, strings, or pairs (integer => string)
 * This class throws ModernException type exceptions
*/
class ArrayDataValidator
{
	/**
	 * Status of data validator
	 *
	 * @see function validateArrayList
	 * @see function isValidData
	 */
	private $validData = false;


	
	/**
	 * Checker/setter - checks the array passed by param and sets a status of that validation
	 *
	 * @param $arrListOfArrayToValidate - list of arrays with elements which we will validate
	 * @return bool - true, if validation was successful
	 */
	protected function validateArrayList($arrListOfArrayToValidate)
	{
		$validData = true;
	
		// Validate every array in the list
		foreach($arrListOfArrayToValidate AS &$arrArrayToValidate)
		{
			if(!$this->isValidArray($arrArrayToValidate))
			{
				$validData = false;
				break;
			}
		}
				
		// Set data validator status of class global data
		$this->validData = $validData;
		
		return $validData;
	}

	/**
	 * Checker - is validData is set to true
	 *
	 * @return bool - status of data after validation
	 * @throws ModernException - if data validData is false
	 */
	protected function isValidData()
	{
		$ret = true;
		if(!$this->validData)
		{
			$ret = false;
			throw new ModernException("Invalid data use in function (look in traceback)");
		}
		
		return $ret;
	}
	
	/**
	 * Checker - is valid array passed by reference
	 *
	 * @param array &$arrayToValidate - an array, which will be validated
	 * @return bool - status of data after validation
	 * @throws ModernException - if array is invalid
	*/
	protected function isValidArray(&$arrayToValidate)
	{
		$ret = true;
		if(!is_array($arrayToValidate))
		{
			// This is not an array
			$ret = false;
			throw new ModernException("Not an array passed");
		} else if(sizeof($arrayToValidate) < 1)
		{
			// If validating array size is eq to 0
			$ret = false;
			throw new ModernException("An empty array passed");
		} else {
			// This is an array with elements, so we must iterate through every element and check if it is a valid element
			foreach($arrayToValidate as &$elem)
			{
				if(!$this->isValidArrayElement($elem))
				{
					$ret = false;
					break;
				}
			}
		}
		
		return $ret;
	}
	
	/**
	 * Checker - is valid array element passed by reference
	 *
	 * @param array &$elem - an element, which will be validated
	 * @return bool - true if this is a valid array element
	 * @throws ModernException - if array is invalid
	*/
	protected function isValidArrayElement(&$elem)
	{
		$ret = true;
		if(is_numeric($elem) || is_string($elem))
		{
			// Is a number // string
		} else if(is_array($elem))
		{
			// Not a number, but maybe a string
			if(sizeof($elem) != 2)
			{
				// It's not a pair (int => int/string)
				$ret = false;
				throw new ModernException("Invalid array element lenght ( != 2 ) !");
			}
			if(!is_numeric($elem[1]) && !is_string($elem[1]))
			{
				// It's neither number nor string
				$ret = false;
				throw new ModernException("Array element is neither number nor string!");
			}
		} else
		{
			// It's not a valid array element
			$ret = false;
			throw new ModernException("Invalid array element!");
		}
		
		// return the validation status of the element
		return $ret;
	}
	
	/**
	 * Checker - determine if an index is valid, and if an array is valid
	 *
	 * @param int $index - element index in array
	 * @param array &$arrElemArray - a reference to array where we check for element at index
	 * @return bool - true, if both array and index is valid
	 * @throws ModernException - if any array or index is invalid
	*/
	protected function isValidIndexAndArray($index, &$arrElemArray)
	{
		$ret = true;
		// We want to be sure that validator was called before calling this function
		if($this->isValidData())
		{
			// Is is a signed integer?
			if(is_int($index) && $index >= 0)
			{
				// Is there is an element in the array at a specified index
				if(!array_key_exists($index,$arrElemArray))
				{
					$ret = false;
					throw new ModernException("Out of range exception, or element already removed from array");
				}
			} else
			{
				$ret = false;
				throw new ModernException("Index &quot;".htmlentities($index)."&quot; is not a number or negative");
			}
		}
		
		return $ret;
	}
}
?>

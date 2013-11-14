<?php
/**
 * A class to remove duplicating elements from array A if they appear in array B
 *
 * @author - Kestutis ITDev
 * @version - 1.1
 * @release - 2011.06.17
 * @updated - 2011.06.19
 */

/**
 * Class for removing duplicating entries in two lists
 * Derives functionality from data validator
 * Implements MiniDebugger for algorithm testing
 */
class DuplicateRemover extends ArrayDataValidator
{
	/**
	 * A pointer to debugger object
	 *
	 * @see function __construct
	 * @see function __destruct
	 */
	private $debugger = null;
	
	/**
	 * A original array
	 *
	 * @see function setOriginalAndComparingArrays
	 * @see function removeBothExistingElements
	 */
	private $arrOriginal = array();
	
	/**
	 * A comparing array
	 *
	 * @see function setOriginalAndComparingArrays
	 * @see function removeBothExistingElements
	 */
	private $arrComparing = array();


	
	/**
	 * Constructor
	 * Create an instance of MiniDebugger object and attach it to private class member
	 */
	public function __construct()
	{
		// We will use a MiniDebugger class for our algorithm debug, so we must create a new instance of MiniDebugger here
		$this->debugger = new MiniDebugger();
	}
	
	/**
	 * Destructor
	 */
	public function __destruct()
	{
		unset($this->arrOriginal);
		unset($this->arrComparing);
		unset($this->debugger);
	}
	
	/**
	 * Setter (external) - enables debugger
	 */
	public function enableDebug()
	{
		$this->debugger->enable();
	}
	
	/**
	 * Print - prints debugger output
	 * This method should be called after calling 'removeBothExistingElements'
	 */
	public function printDebug()
	{
		$this->debugger->out();
	}
	
	/**
	 * Setter - method for validating and setting private class members
	 *
	 * @param array $arrOriginal - original array (array A)
	 * @param array $arrComparing - array to compare with original (array B)
	 */
	public function setOriginalAndComparingArrays($arrOriginal, $arrComparing)
	{
		// Validate arrays from methods parameters
		$ok = $this->validateArrayList(array(
			$arrOriginal, $arrComparing
		));
		
		if($ok)
		{
			// Assign arrays to private class members
			$this->arrOriginal = $arrOriginal;
			$this->arrComparing = $arrComparing;
		}

		/* ****************** DEBUG: START ******************** */
		$okDebug = $this->debugger->deepDataDump($ok);
		$this->debugger->push(__METHOD__ ." called");
		$this->debugger->push("Result of arrayList validation: {okDebug}");
		/* ******************* DEBUG: END ********************* */		
	}
	
	/**
	 * Function for removing elements from A if they exist in B
	 *
	 * @return array - modified array
	 */
	public function removeBothExistingElements()
	{
		// We want to be sure that validator was called before calling this function
		if($this->isValidData())
		{
			// Iterate through all original array elements
			foreach($this->arrOriginal as &$elem)
			{
				// And check if that element is also in comparing array
				if($this->isElementInArray($elem, $this->arrComparing))
				{
					// (COMPARING) Get an index of element in comparing array
					$elemIndexInComparingArray = $this->getIndexOfElementInArray($elem, $this->arrComparing);
					// (ORIGINAL) Get an index of element in original array
					$elemIndexInOriginalArray = $this->getIndexOfElementInArray($elem, $this->arrOriginal);
						
					/* ****************** DEBUG: START ******************** */					
					$this->debugger->push("Both existing element match found");
					$this->debugger->push($elem, "\$elem =");
					$this->debugger->push($elemIndexInComparingArray, "\$elemIndexInComparingArray =");
					$this->debugger->push($elemIndexInOriginalArray, "\$elemIndexInOriginalArray =");
					/* ******************* DEBUG: END ********************* */
					
					// (COMPARING) Remove that element from comparing array (if bool false was returned this function also take cares that)
					$this->removeElementAtIndexFromArray($elemIndexInComparingArray, $this->arrComparing);
					// (ORIGINAL) Remove that element from original array (if bool false was returned this function also take cares that)
					$this->removeElementAtIndexFromArray($elemIndexInOriginalArray, $this->arrOriginal);

				} else
				{
					/* ****************** DEBUG: START ******************** */	
					$this->debugger->push("Element exist only in original array");
					$this->debugger->push($elem, "\$elem =");
					/* ******************* DEBUG: END ********************* */
				}
				/*DEBUG*/ $this->debugger->pushLineBreak();
			}
		}
		
		return $this->arrOriginal;
	}
	
	/**
	 * Checker - checks if the specified element is in array
	 *
	 * @param $elem - an element to search in array
	 * @param $arrElemArray - an array in where we will be searching for element
	 * @return bool - true if elem is in array
	*/
	private function isElementInArray($elem, $arrElemArray)
	{
		$ret = false;
		
		// We want to be sure that validator was called before calling this function
		if($this->isValidData())
		{
			// We know that it is a number/string OR a pair (A => B)
			if(is_array($elem) && isset($elem[1]))
			{
				// This is a pair (int => int/string)
				$ret = in_array($elem[1], $arrElemArray);
			} else
			{
				// This is a number/string
				$ret = in_array($elem, $arrElemArray);
			}
		}
		
		return $ret;
	}
	
	/**
	 * Getter - function for getting index of specified element in array
	 *
	 * @param array $elem - element to search (might be an integer or an array (A => B)
	 * @param array $arrElemArray - array in which we will search for elem
	 * @return int - element index in array, or false if element is not in array
	 */
	private function getIndexOfElementInArray($elem, $arrElemArray)
	{
		$ret = false;
		
		// We want to be sure that validator was called before calling this function
		if($this->isValidData())
		{
			// We know that it is a number/string OR a pair (A => B)
			if(is_array($elem) && isset($elem[1]))
			{
				// This is a pair (int => int/string)
				$ret = array_search($elem[1], $arrElemArray);
			} else
			{
				// This is a number/string
				$ret = array_search($elem, $arrElemArray);
			}
		}
		
		return $ret;
	}
	
	/**
	 * Cleaner - function for removing element at specified index from array
	 *
	 * @param int $index - an element position in array
	 * @param array &$arrElemArray - a reference to the array from which we will remove an element
	 * @return bool - true on success of remove
	*/
	private function removeElementAtIndexFromArray($index, &$arrElemArray)
	{
		$ret = false;
		
		// We want to be sure that validator was called before calling this function
		if($this->isValidIndexAndArray($index, $arrElemArray))
		{
			// OK
			unset($arrElemArray[$index]);
			$ret = true;
			
			/*DEBUG*/ $this->debugger->push("Element at index &#39;{$index}&#39; removed from array");
		}
		
		return $ret;
	}
}
?>

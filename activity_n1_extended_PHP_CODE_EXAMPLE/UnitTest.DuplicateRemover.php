<?php
/**
 * A unit test for DuplicateRemover class
 *
 * @author - Kestutis Matuliauskas
 * @version - 1.2
 * @release - 2011.06.19
 * @updated - 2011.06.19
 */

/**
 * This class is for testing purposes only.
 * This class must inherit UnitTest class.
 * This class must cover all public methods of 'DuplicateRemover' class.
 */
class DuplicateRemover__UnitTest extends UnitTest
{
	/**
	 * Unit test constructor
	 */
	public function __construct()
	{
		// Pass a class name to UnitTest controller
		$this->setClass(__CLASS__);
		
		// The following block shouldn't (UnitTest should take care that), but might throw an exception
		// if we use direct 'DuplicateRemover' method call and that method is still not be tested
		try
		{
			$this->constructorTest();
			$this->setOriginalAndComparingArraysTest();
			$this->removeBothExistingElementsTest();
			$this->destructorTest();
		} catch (Exception $e)
		{
			// Set testing method test name
			$this->setMethod(__METHOD__);
		
			// We shouldn't get any exception here if our unit test does not have logical problems
			$this->pushResult($e);
		}
		$this->printResults();
	}
	
	// Bellow is list of unit tests for all public methods of DuplicateRemover class
	
	/**
	 * Function for testing 'DuplicateRemover' class constructor(-s)
	 * Be sure not to use debugger & do unit test at the same time
	 */
	public function constructorTest()
	{
		// Set testing method test name
		$this->setMethod(__METHOD__);
		
		// Set callback
		$this->setCallbackMethod("DuplicateRemover");
		
		// All ways to call constructor
		$this->test();
	}
	
	/**
	 * Function for testing 'DuplicateRemover' class destructor
	 * Be sure not to use debugger & do unit test at the same time
	 */
	public function destructorTest()
	{
		// Set testing method test name
		$this->setMethod(__METHOD__);
		
		// Create an instance of testing class
		$objDuplicateRemover = new DuplicateRemover();
		
		// Set callback
		$this->setCallbackMethod(array($objDuplicateRemover, "__destruct"));
		
		// All ways to call destructor
		$this->test();
	}
	
	/**
	 * Function for testing 'setOriginalAndComparingArrays' method
	 * Be sure not to use debugger & do unit test at the same time
	 */
	public function setOriginalAndComparingArraysTest()
	{
		// Set testing method test name
		$this->setMethod(__METHOD__);
		
		// Create an instance of testing class
		$objDuplicateRemover = new DuplicateRemover();
		
		// Set callback
		$this->setCallbackMethod(array($objDuplicateRemover, "setOriginalAndComparingArrays"));
				
		// Test	- should pass
		$arrOfIntA = array(2,3,4,4,4,5,10,11,14);
		$arrOfIntB = array(1,2,3,3,4,4,9,9,10,12);
		$this->test(array($arrOfIntA,$arrOfIntB));
		
		// Test	- should pass	
		$arrOfStringA = array("aaa", "bbb", "eee", "eee", "fff", "ggg");
		$arrOfStringB = array("bbb", "bbb", "ccc", "eee", "fff");
		$this->test(array($arrOfStringA, $arrOfStringB));
		
		// Test	- should pass	
		$arrOfStringA = array(0 => "aaa", 1=> "bbb", 2 => "eee", 3 => "eee", 4 => "fff", 5 => "ggg");
		$arrOfStringB = array(0 => "bbb", 1=> "bbb", 2 => "ccc", 3 => "eee", 4 => "fff");
		$this->test(array($arrOfStringA, $arrOfStringB));

		// Test	- should FAIL
		$arrOfIntA = array();
		$arrOfIntB = array(1,2,3);
		$this->test(array($arrOfIntA,$arrOfIntB));
		
		// Test	- should FAIL
		$arrOfIntA = array(2,new ArrayObject(),3);
		$arrOfIntB = array(1,2,3);
		$this->test(array($arrOfIntA,$arrOfIntB));
				
		// Test	- should FAIL
		$arrOfIntA = array(2,3,4,4);
		$arrOfIntB = array(1,2,null,3);
		$this->test(array($arrOfIntA,$arrOfIntB));
				
		// Test	- should FAIL
		$arrOfIntA = array(2,array(3,4,5),4);
		$arrOfIntB = array(1,2,3,3);
		$this->test(array($arrOfIntA,$arrOfIntB));
		
		// Test	- should FAIL	
		$arrOfStringA = array("aaa", array("bbb", "eee", "eee"), "fff", "ggg");
		$arrOfStringB = array("bbb", "bbb", "ccc", "eee", "fff");
		$this->test(array($arrOfStringA, $arrOfStringB));
	}
	
	/**
	 * Function for testing 'removeBothExistingElementsTest' method
	 * Be sure not to use debugger & do unit test at the same time
	 */
	public function removeBothExistingElementsTest()
	{
		// Set testing method test name
		$this->setMethod(__METHOD__);
		
		// Create an instance of testing class
		$objDuplicateRemover = new DuplicateRemover();
		
		// Set callback
		$this->setCallbackMethod(array($objDuplicateRemover, "removeBothExistingElements"));
		
		// Test	
		$arrOfIntA = array(2,3,4,4,4,5,10,11,14);
		$arrOfIntB = array(1,2,3,3,4,4,9,9,10,12);
		$objDuplicateRemover->setOriginalAndComparingArrays($arrOfIntA, $arrOfIntB);
		$this->test();
		// res 4,5,11,14
		
		// Test	
		$arrOfStringA = array("aaa", "bbb", "eee", "eee", "fff", "ggg");
		$arrOfStringB = array("bbb", "bbb", "ccc", "eee", "fff");
		$objDuplicateRemover->setOriginalAndComparingArrays($arrOfStringA, $arrOfStringB);
		$this->test();
		// res aaa, eee, ggg
	}
}
?>
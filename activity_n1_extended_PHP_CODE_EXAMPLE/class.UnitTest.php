<?php
/**
 * A minimal unit testing framework
 *
 * @author - Kestutis Matuliauskas
 * @version - 1.3
 * @release - 2011.06.19
 * @updated - 2011.06.19
 */

/**
 * This class is for testing purposes only.
 * This abstract class must be used as derived class for a concrete UnitTest class.
 */
abstract class UnitTest
{
	/**
	 * A unit test stack of class methods testing results
	 *
	 * @see function pushResult
	 * @see function getResults
	 */
	private $arrResultStack = array();
	
	/**
	 * A currently testing class name
	 *
	 * @see function setClass
	 */
	private $currClass = "";
	
	/**
	 * A currently testing class method name
	 *
	 * @see function setMethod
	 */
	private $currMethod = "";
	
	/**
	 * An array of (objPointer, "method name") for use in test()
	 *
	 * @see function setCallbackMethod
	 * @see function test
	 */
	private $arrCallbackObjAndMethod = array();
	
	/**
	 * A tests counter for current testing class method
	 *
	 * @see function pushResult
	 */
	private $methodTestsCounter = 0;



	/**
	 * Setter - sets currently testing class name (with '__UnitTest' suffix)
	 *
	 * @param string $className - a testing class name
	 */
	protected function setClass($className)
	{
		$this->currClass = $className;
	}
	
	/**
	 * Setter - sets currently testing class method name (with 'Test' suffix)
	 *
	 * @param string $methodName - a testing class method name
	 */
	protected function setMethod($methodName)
	{
		if($this->currMethod != $methodName)
		{
			$this->methodTestsCounter = 0;
			$this->currMethod = $methodName;
		}
	}
	
	/**
	 * Setter - an array (objPointer, "method name") for use on test() execution
	 *
	 * @param array $arrObjAndMethod - an array (objPointer, "method name")
	 * @see function test
	 */
	protected function setCallbackMethod($arrObjAndMethod)
	{
		$this->arrCallbackObjAndMethod = $arrObjAndMethod;
	}
	
	/**
	 * A function for derived class method execution
	 * This method is allways called from derived class after every testing class method test
	 *
	 * @param array $arrParams - an array of parameters to pass for testing method on call
	 * @exception Exception $e - catch any exception from testing method
	 */
	protected function test($arrParams=array())
	{
		// Method return data
		$returnData = "";
		
		// Start output bufferning
		ob_start();
		
		// Check is it a class constructor or a class method call
		if(!is_string($this->arrCallbackObjAndMethod))
		{
			// Method call
			try
			{
				// if arrCallbackObjAndMethod is an array of ($objMyClassInstance, "someMethod")
				// if $arrParams is empty 			-> same as '$returnData = $objMyClassInstance->someMethod()'
				// if $arrParams is array (a,b,c) 	-> same as '$returnData = $objMyClassInstance->someMethod(a, b, c)'
				$returnData = call_user_func_array($this->arrCallbackObjAndMethod, $arrParams);
			} catch (Exception $e)
			{
				echo $e;
			}
		} else
		{
			// Constructor call
			$className = $this->arrCallbackObjAndMethod;
			try
			{	
				// if $className == 'myNewClass'
				// if $arrParams is empty 			-> same as 'new myNewClass()'
				// if $arrParams is array (a,b,c) 	-> same as 'new myNewClass(a, b, c)'
				call_user_func_array(array(new ReflectionClass($className), 'newInstance'), $arrParams);
			} catch (Exception $e)
			{
				echo $e;
			}
		}
		// Get buffer content and end output buffering
		$output = ob_get_clean();
		
		// Now push the results of method testing to unit test stack
		$this->pushResult($output, $arrParams, $returnData);
	}
	
	/**
	 * Push - push a result of an method test in unit test stack
	 *
	 * @param string $result - any interrupt (exception) data got on method execute
	 * @param array/string $inputData - input data for method testing
	 * @param array/string $returnData - a data, which was returned from method after executing
	 */
	protected function pushResult($result, $inputData = "", $returnData = "")
	{
		$this->methodTestsCounter++;
		$passed = $result ? 0 : 1;
		$this->arrResultStack[] = array(
			"method" => $this->currMethod,
			"counter" => $this->methodTestsCounter,
			"data" => $result,
			"input" => $inputData,
			"return" => $returnData,
			"passed" => $passed
		);
	}
	
	/**
	 * Getter - concatenate all unit test stack elements in one string
	 *
	 * @return string - all unit test stack elements in one formatted string
	 */	
	protected function getResults()
	{
		$ret = "";
		$ret .= "<br /> ================= [". $this->currClass ." UNIT TEST: START] =================";
		foreach($this->arrResultStack AS $result)
		{
			$status = $result['passed'] ? "<span class='passed'>passed</span>" :  "<span class='failed'>failed</span>";
			$exception = !$result['passed'] ? "<strong>Exception:</strong> ". $result['data'] ."<br /><br />" : "";
			$returned = $result['return'] ? "<strong>Method returned:</strong> ". $result['return'] ."<br /><br />" : "";
			ob_start();
			var_dump($result['input']);
			$input = ob_get_clean();
			$ret .= "<br /><br />[". $status ."] ";
			$ret .= "<big>Method &#39;<strong>". $result['method'] ."</strong>&#39; ";
			$ret .= "test # <strong>". $result['counter'] ."</strong></big><br />";
			$ret .= "<strong>Input data:</strong>". $input ."<br />";
			$ret .= $exception;
			$ret .= $returned;
		}
		$ret .= " ================== [". $this->currClass ." UNIT TEST: END] ==================<br />";
		
		return $ret;
	}
	
	/**
	 * Print - print current unit test stack content
	 * This method should be called after all tests in implementing class where UnitTest was derived
	 */	
	public function printResults()
	{
		$results = $this->getResults();
		echo $results;
	}
}
?>
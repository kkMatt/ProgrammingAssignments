<?php
/**
 * A class for debugging algorithms
 *
 * @author - Kestutis ITDev
 * @version - 1.0
 * @release - 2011.06.17
 * @updated - never
 */

/**
 * Algorithm debugger, stack-based
 * has option to enable/disable debugger
 * if debugger is disabled, then any call to object instance of this class is skipped
 */
class MiniDebugger
{		
	/**
	 * A debugger status - enabled/disabled
	 *
	 * @see function enable
	 */
	private $DEBUG = false;
	
	/**
	 * A debugger data stack
	 *
	 * @see function push
	 * @see function pushLineBreak
	 * @see function pop
	 * @see function get
	 */
	private $debugData = array();
	
	/**
	 * A debugger counter (if debugger is enabled)
	 *
	 * @see function __construct
	 * @see function push
	 * @see function pop
	 */
	private $debugCounter = 0;



	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->debugData = array();
		$this->debugCounter = 0;
	}
	
	/**
	 * Setter - enable debugger
	 */
	public function enable()
	{
		$this->DEBUG = true;
	}
	
	/**
	 * Dump - dump an array content by using print_r function
	 *
	 * @param array/string $data - an array to concatenate in one string
	 * @return string - concatenated data
	 */
	public function dataDump($data)
	{
		$ret = "";
		
		// If debugger is enabled
		if($this->DEBUG)
		{
			ob_start();
			print_r($data);
			$ret .= ob_get_clean();
		}
		
		return $ret;
	}
	
	/**
	 * Dump - dump an array content by using var_dump function
	 *
	 * @param array/string $data - an array to concatenate in one string
	 * @return string - concatenated data
	 */
	public function deepDataDump($data)
	{
		$ret = "";
		
		// If debugger is enabled
		if($this->DEBUG)
		{
			ob_start();
			var_dump($data);
			$ret .= ob_get_clean();
		}
		
		return $ret;
	}
	
	/**
	 * Push - push a new data row in debugger stack
	 *
	 * @param array/string $data - an array (will be concatenated) or string to push to debugger stack
	 */
	public function push($data=array(), $dataPrefix="")
	{
		// If debugger is enabled
		if($this->DEBUG)
		{
			// Increment the debugger stack counter
			$this->debugCounter++;
			$debugCounterPrefix = "#{$this->debugCounter}.";
			
			// If data is an array
			if(is_array($data))
			{
				// Then concatenate all that array elements in one string
				$data = $this->dataDump($data);
				// And push that string to debugger stack
				$this->debugData[] = $debugCounterPrefix . $dataPrefix ."\n". $data;
			} else
			{
				// The data is not array, so just push that string to debugger stack
				$this->debugData[] = $debugCounterPrefix ." ". $dataPrefix . " ". $data;
			}
		}
	}

	/**
	 * Push - push a line break in debugger stack
	 */	
	public function pushLineBreak()
	{
		// If debugger is enabled
		if($this->DEBUG)
		{
			// Get size of debugger stack
			$debugStackSize = sizeof($this->debugData);
			// If there is at least one element in debugger stack
			if($debugStackSize > 0)
			{
				// Then append a linebreak symbol to the last inserted debugger stack element
				$this->debugData[$debugStackSize-1] .= "\n";
			}
		}
	}

	/**
	 * Getter - pop last inserted element from stack (head)
	 *
	 * @return string - last inserted debug stack element
	 */	
	public function pop()
	{
		$ret = "";
		
		// If debugger is enabled
		if($this->DEBUG)
		{
			// Get size of debugger stack
			$debugStackSize = sizeof($this->debugData);
			if($debugStackSize > 0)
			{
				// Decrement the debugger counter
				$this->debugCounter--;
				// And pop element from debugger stack
				$ret = $this->debugData[$debugStackSize-1];
				unset($this->debugData[$debugStackSize-1]);
			}
		}
		
		return $ret;
	}
	
	/**
	 * Getter - concatenate all debugger stack elements in one string
	 *
	 * @return string - all debugger stack elements in one formatted string
	 */	
	private function get()
	{
		$ret = "";
		
		// If debugger is enabled
		if($this->DEBUG)
		{
			$debugWord = "<span class='debug_text'>[DEBUG]</span>";
			
			$ret .= "\n ================= [DEBUGGER: START] =================\n";
			// join debug data
			$ret .= "{$debugWord} ".implode("\n{$debugWord} ", $this->debugData);
			$ret .= "\n ================== [DEBUGGER: END] ==================\n";
		}
		
		return $ret;
	}
	
	/**
	 * Print - print current debugger stack content
	 * This method should be called after all methods calls in the implementing class where debugger was used
	 */	
	public function out()
	{
		echo nl2br($this->get());
	}
}
?>

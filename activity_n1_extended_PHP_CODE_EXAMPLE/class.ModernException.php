<?php
/**
 * A nested exception class
 *
 * @author - Kestutis Matuliauskas
 * @version - 1.0
 * @release - 2011.06.17
 * @updated - never
 */

/**
 * Php 5.3.0+ is required to use Nested Exceptions
 * This class is just a smart way to extend basic exception class
 * Overrides object to string method
 */
class ModernException extends Exception
{
	/**
	 * Overriding toString() method inherited from Exception class
	 *
	 * @return - formatted string
	 */
	public function __toString()
	{
		$ret = "";
    	$ret .= "<strong>Caught exception:</strong> &#39;".__CLASS__ ."&#39;\n";
		$ret .= "<strong>Message:</strong> &#39;<span class='red_text'>".$this->getMessage()."</span>&#39;\n";
		$ret .= "<strong>At location (File/line):</strong> ".$this->getFile().": ".$this->getLine()." line\n";
		$ret .= "<strong>Error stack trace:</strong>\n".$this->getTraceAsString()."\n";
		return nl2br($ret);
	}
}
?>
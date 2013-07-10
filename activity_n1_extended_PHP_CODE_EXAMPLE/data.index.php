<?php
/**
 * Remove a both existing elements
 *
 *  1. Given two integer arrays, array A and array B, of random length, remove elements that appear in B from A.
 *	2. Both A and B may contain duplicates.
 *	3. Can you do the same with string arrays?
 *	4. Please comment on your implementation, and the tradeoffs you have chosen.
 *	5. Please provide an ability to test.
 *
 * @author - Kestutis Matuliauskas
 * @version - 1.0
 * @release - 2011.06.17
 * @updated - never
 */
if(!defined('IN_PROGRAM')) die("Access denied");

// Input data
$arrOfIntA = array(2,3,4,4,4,5,10,11,14);
$arrOfIntB = array(1,2,3,3,4,4,9,9,10,12);
$newArrayA = array();
// res 4,5,11,14

// Test implementation [top level] / output data generator


// Create object - instance of class, which will remove some elements from array A - ONLY those who appear in B
$duplicateRemover = new DuplicateRemover();
if(DEBUG_MODE)
{
	$duplicateRemover->enableDebug();
}

// The code bellow may throw exception, so we put that code in try/catch blocks
$EXCEPTION_OUTPUT = "";
try
{	
	$duplicateRemover->setOriginalAndComparingArrays($arrOfIntA, $arrOfIntB);
	$newArrayA = $duplicateRemover->removeBothExistingElements();
} catch (ModernException $e)
{
	$EXCEPTION_OUTPUT = $e;
}
// Output of Debug
ob_start();
$duplicateRemover->printDebug();
$DEBUG_OUTPUT = ob_get_clean();

// Output of Pre-data
ob_start();
print_r($arrOfIntA);
$DATA_BEFORE_PARSING = nl2br(ob_get_clean());

// Output of Post-data
ob_start();
print_r($newArrayA);
$DATA_AFTER_PARSING = nl2br(ob_get_clean());
?>
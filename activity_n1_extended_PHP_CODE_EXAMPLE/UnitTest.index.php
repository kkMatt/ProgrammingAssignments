<?php
/**
 * Unit test entry point
 *
 * @author - Kestutis ITDev
 * @version - 1.1
 * @release - 2011.06.17
 * @modified - 2011.06.18
 */
// Required includes for program
require_once ("class.ModernException.php");
require_once ("class.MiniDebugger.php"); // Will not be used
require_once ("class.ArrayDataValidator.php");
require_once ("class.DuplicateRemover.php"); // Algorithm

// Unit test includes
require_once ("class.UnitTest.php");
require_once ("UnitTest.DuplicateRemover.php"); // Algorithm unit test

// Settings
define("IN_UNITTEST", true);

ob_start();

// Run unit tests
new DuplicateRemover__UnitTest();

$UNIT_TEST_OUTPUT = ob_get_clean();

// Open template
require_once ("template.UnitTest.php");
?>

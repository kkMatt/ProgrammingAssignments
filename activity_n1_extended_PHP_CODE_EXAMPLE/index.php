<?php
/**
 * Program entry point
 *
 * @author - Kestutis Matuliauskas
 * @version - 1.1
 * @release - 2011.06.17
 * @modified - 2011.06.18
*/
// Settings
define("IN_PROGRAM", true);
define("DEBUG_MODE", false);

// Includes
require_once ("class.ModernException.php");
require_once ("class.MiniDebugger.php");
require_once ("class.ArrayDataValidator.php");
require_once ("class.DuplicateRemover.php"); // Algorithm
require_once ("data.index.php");
require_once ("template.index.php");
?>
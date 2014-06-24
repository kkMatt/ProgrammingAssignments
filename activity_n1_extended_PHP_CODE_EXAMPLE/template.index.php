<?php if(!defined('IN_PROGRAM')) die("Access denied"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kestutis - Nor1, programming assignment, #1 - Program</title>
<!-- stylesheets -->
<link rel="stylesheet" href="css/styles.css" type="text/css">
</head>
<body>
<?php print($DEBUG_OUTPUT.$EXCEPTION_OUTPUT) ?>

<u>Before parsing (content of arrayA):</u><br />
<?php print($DATA_BEFORE_PARSING) ?><br /><br />

<u>After parsing (content of arrayA):</u><br />
<?php print($DATA_AFTER_PARSING) ?><br /><br />
</body>
</html>

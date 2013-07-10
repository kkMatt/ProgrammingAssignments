<?php
if(isset($_GET['short']))
    include_once('Templates/index_short.php');
else
    include_once('Templates/index.php');
?>
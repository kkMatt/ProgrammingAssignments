<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <htmlclass="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title>NFQ task by Kestutis. Used flight and initializr - <?php $title; ?></title>
		<meta name="description" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <base href="<?php print Flight::get('BASE'); ?>" target="_self" />
		<link rel="stylesheet" href="<?php print Flight::get('BASE'); ?>/css/normalize.min.css" type="text/css" />
		<link rel="stylesheet" href="<?php print Flight::get('BASE'); ?>/css/main.css" type="text/css" />
		<link rel="stylesheet" href="<?php print Flight::get('BASE'); ?>/css/code.css" type="text/css" />

        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <div class="header-container">
            <header class="wrapper clearfix">
                <h1 class="title">NFQ task by Kestutis</h1>
                <nav>
                    <ul>
                        <li><a href="<?php print Flight::get('BASE'); ?>/">Home</a></li>
                        <li><a href="<?php print Flight::get('BASE'); ?>/diagrams/">Diagrams</a></li>
                        <li><a href="https://github.com/KestutisIT/ProgrammingAssignments/tree/master/NFQ-Challenge" target="_blank">GitHub</a></li>
                        <li><a href="<?php print Flight::get('BASE'); ?>/notes/">Notes</a></li>
                    </ul>
                </nav>
            </header>
        </div>

        <div class="main-container">
            <div class="main wrapper clearfix">

		    <?php echo $body_content; ?>

            </div> <!-- #main -->
        </div> <!-- #main-container -->

        <div class="footer-container">
            <footer class="wrapper">
                <h3>2014 (C) Kestutis IT, Twitter: <a href="#">@KestutisIT</a></h3>
                <p><code><?php printf('Page rendered in %s msecs / Memory usage %s Kibytes',round(1e3*(microtime(TRUE)-Flight::get('id')),2),round(memory_get_usage(TRUE)/1e3,1)); ?></code></p>
            </footer>
        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.1.min.js"><\/script>')</script>

        <script src="js/main.js"></script>
    </body>
</html>

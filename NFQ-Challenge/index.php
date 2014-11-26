<?php
$TIME = microtime(TRUE);
require 'flight/Flight.php';

// Save your variable
Flight::set('TIME', $TIME);

Flight::route('/', function(){
    //echo 'hello world!';
	//Flight::render('body', array('body' => 'World'), 'body_content');
	Flight::render('body-welcome', array(), 'body_content');
	Flight::render('layout', array('title' => 'Home'));
});

Flight::route('/@name/@id', function($name, $id){
    echo "hello, $name ($id)!";
});

Flight::start();
?>

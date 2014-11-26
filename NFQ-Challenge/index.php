<?php
$TIME = microtime(TRUE);
require 'flight/Flight.php';

// Save your variable
Flight::set('TIME', $TIME);
Flight::set('BASE', 'http://localhost/GitHub/ProgrammingAssignments/NFQ-Challenge');

Flight::route('/', function(){
    //echo 'hello world!';
	//Flight::render('body', array('body' => 'World'), 'body_content');
	Flight::render('body-welcome', array(), 'body_content');
	Flight::render('layout', array('title' => 'Home'));
});

Flight::route('/diagrams', function(){
    //echo 'hello world!';
    //Flight::render('body', array('body' => 'World'), 'body_content');
    Flight::render('body-diagrams', array(), 'body_content');
    Flight::render('layout', array('title' => 'Diagrams'));
});

Flight::route('/notes', function(){
    //echo 'hello world!';
    //Flight::render('body', array('body' => 'World'), 'body_content');
    Flight::render('body-notes', array(), 'body_content');
    Flight::render('layout', array('title' => 'Notes'));
});

Flight::route('/@name/@id', function($name, $id){
    echo "hello, $name ($id)!";
});

Flight::start();
?>

<?php
$TIME = microtime(TRUE);
require_once "config.php";
require 'flight/Flight.php';

// Save your variables
Flight::set('TIME', $TIME);
Flight::set('BASE', BASE_URL);

// Database Information
Flight::register('db', 'PDO', array('mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME, DB_USER, DB_PASSWORD), function($db) {
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
});

// Home page
Flight::route('/', function(){
    //echo 'hello world!';
	Flight::render('body-welcome', array(), 'body_content');
	Flight::render('layout', array('title' => 'Home'));
});

// Diagrams page
Flight::route('/diagrams', function(){
    Flight::render('body-diagrams', array(), 'body_content');
    Flight::render('layout', array('title' => 'Diagrams'));
});

// Notes page
Flight::route('/notes', function(){
    Flight::render('body-notes', array(), 'body_content');
    Flight::render('layout', array('title' => 'Notes'));
});

// Api page
Flight::route('/api', function() {
    require_once("include.api.php");
});

// Left just for testing purposes
Flight::route('/@name/@id', function($name, $id){
    echo "hello, $name ($id)!";
});

Flight::start();
?>

<?php

	require 'vendor/autoload.php';
session_start();

	$app = new \Slim\Slim([
		'templates.path' => 'view'
	]);

	$app->get('/', function () use ($app){
	    $app->render('body.php',compact('app'));  
	})-> name('body');

	$app->get('/contact', function () use ($app){
		$name = "hyvan";
	    $app->render('contact.php',compact('name'));
	    $app->flash('success','Bravo!');
	    $app->redirect($app->urlFor('body'));
	})->name('contact');

	$app->render('header.php');
	$app -> run();
	$app->render('footer.php');
?>
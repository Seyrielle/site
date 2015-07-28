<?php
//namespace Slim\Slim;
session_start();


//require
	require 'vendor/autoload.php';
	require 'controller/controllerPages.php';
	require 'controller/controllerUser.php';
	require 'controller/controllerQuestionnaire.php';
	require 'controller/controllerVideo.php';
	require 'controller/controllerAnnot.php';
	include 'config/database.php'; 



//Slim

	$tab = array('templates.path' => 'view');

	$app = new \Slim\Slim($tab);
	$app -> controllerPages = new ControllerPages($app,$app->controllerUser);
	$app -> controllerUser = new ControllerUser($app);
	$app -> controllerQuestionnaire = new controllerQuestionnaire($app);
	$app -> controllerAnnot = new ControllerAnnot($app);
	$app -> controllerVideo = new ControllerVideo($app);
//root
	$app->get('/', function () use ($app){
		$app -> controllerPages-> accueil();
	})-> name('accueil');

	$app->get('/consigne', function () use ($app){
		$app -> controllerPages-> consigne();
	})-> name('consigne');

	$app->get('/inscription', function () use ($app){
		$app -> controllerPages-> inscription();
	})-> name('inscription');

	$app->get('/visionnage', function () use ($app){
		$app -> controllerPages-> visionnage();
	})-> name('visionnage');

	$app->get('/questionnaire', function () use ($app){
		$app -> controllerPages-> questionnaire();
	})-> name('questionnaire');

	$app->get('/remerciement', function () use ($app){
		$app -> controllerPages-> remerciement();
	})-> name('remerciement');

	$app->get('/deconnexion', function () use ($app){
		$app -> controllerUser-> deconnexion();
	})-> name('deconnexion');

	$app->get('/fin', function () use ($app){
		$app -> controllePages-> fin();
	})-> name('fin');

	$app->post("/", function () use ($app){
    	$pseudo = $app->request->post('pseudo');
    	$password = $app->request->post('password');
		$app -> controllerUser -> connexion($password,$pseudo);
	}) -> name('connexion');

	$app->post('/annot', function() use ($app) {
       $req = $app->request();
       $app -> controllerAnnot -> envoyerAnnot($req);
    });

	$app->post("/inscription", function () use ($app){
    	$insc = $app->request->post();
    	$app -> controllerVideo -> newVideo();
		$app -> controllerUser -> inscription($insc);
	});

	$app->post("/questionnaire", function () use ($app){
    	$info = $app->request->post();
    	$_SESSION['page'] = 1;
		$app -> controllerQuestionnaire -> envoyerReponse($info);
	});

// execution Slim
	$app -> render('header.html');
	$app -> run();
?>


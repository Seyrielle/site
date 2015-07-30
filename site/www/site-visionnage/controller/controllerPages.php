<?php
	class ControllerPages{
		private $app;
		private $var;
		public function __construct($app){

			$this->app = $app;
			$this->var = array('app' => $app);
		}
		function nomPage($numPage){
			switch($numPage){
				case 1: return "consigne";
				case 2: return "visionnage";
				case 3: return "questionnaire";
				case 4: return "remerciement";
				case 5: return "fin";
			}
		}
		function estConnecte(){
			if (isset($_SESSION['pseudo'])){
				return true;
			}
			return false;
		}
		function changementPage($numPage){
			$this->app->render('header.html');
			if ($this->estConnecte())
			{
				if(abs($_SESSION['page'] - $numPage) > 1 || ($_SESSION['page'] == 3 && $numPage < 3))
				{

					$this->app->redirect($this->app->urlFor($this->nomPage($_SESSION['page'])));
				}
				else{

					$_SESSION['page']=$numPage;
					$this->app->controllerUser->saveNumPage();
					$this->app->render($this->nomPage($numPage).".html",$this->var);
				}
			}
			else{
				$this->app->flash('etat_co',"Vous n'êtes pas connecté , connectez-vous");
	    		$this->app->redirect($this->app->urlFor('accueil'));
			}	
		}
		function accueil(){
			if (!$this->estConnecte()){
				$this->app->render('header.html');
				$this->app->render('accueil.html',array('app' => $this->app));
			}
			else{
				$this->changementPage($this->nomPage($_SESSION['page']));

			}
		}
		function consigne(){
			$this->changementPage(1);

		}
		function inscription(){
			if (!$this->estConnecte()){
				$this->app->render('header.html');
				$this->app->render('inscription.html',array('app' => $this->app));
			}
			else{
				$this->changementPage($this->nomPage($_SESSION['page']));
			}
		}
		function visionnage(){
			if ($this->estConnecte()){
				$this->var = array('app'=>$this->app,'url'=>$this->app->controllerVideo->urlVideo(),'annot'=>$this->app->controllerAnnot->listeAnnot());				
			}
			$this->changementPage(2);
		}
		function questionnaire(){
			$this->changementPage(3);
		}
		function remerciement(){
			$this->changementPage(4);
		}
		function fin(){
			$this->changementPage(5);
		}
	}

?>
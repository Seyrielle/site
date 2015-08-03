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
				case 0:return "accueil";
				case 1: return "consigne";
				case 2: return "visionnage";
				case 3: return "questionnaire";
				case 4: return "remerciement";
				case 5: return "fin";
				case 6 : return "inscription";
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
				if ($numPage==1 || $numPage==2 || $numPage == 3 || $numPage == $_SESSION['page']){
					$_SESSION['page']=$numPage;
					$this->app->controllerUser->saveNumPage();
					$this->app->render($this->nomPage($numPage).".html",$this->var);
				}
				else{
					$this->app->redirect($this->app->urlFor($this->nomPage($_SESSION['page'])));
				}
			}
			else if(!$this->estConnecte()){
				if ($numPage == 0 || $numPage == 6){
					$this->app->render($this->nomPage($numPage).".html",$this->var);
				}
				else{
					$this->app->flash('etat_co',"Vous n'êtes pas connecté , connectez-vous");
		    		$this->app->redirect($this->app->urlFor('accueil'));
				}	
			}	
		}
		function accueil(){
			$this->changementPage(0);
		}
		function consigne(){
			$this->changementPage(1);

		}
		function inscription(){
				$this->changementPage(6);
		}
		function visionnage(){
			if ($this->estConnecte()){
				$this->var = array('app'=>$this->app,'tab'=>$this->app->controllerVideo->urlVideo(),'annot'=>$this->app->controllerAnnot->listeAnnot());				
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
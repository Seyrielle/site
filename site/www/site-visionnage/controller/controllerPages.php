<?php
	class ControllerPages{
		private $app;
		private $accueil;
		public function __construct($app){

			$this->app = $app;
		}
		function nomPage($numPage){
			switch($numPage){
				case 1: return "consigne";
				case 2: return "visionnage";
				case 3: return "questionnaire";
				case 4: return "remerciement";
			}
		}
		function estConnecte(){
			if (isset($_SESSION['pseudo'])){
				return true;
			}
			return false;
		}
		function changementPage($numPage){
				if ($this->estConnecte())
				{
					if(abs($_SESSION['page'] - $numPage) > 1 || ($_SESSION['page'] == 3 && $numPage < 3))
					{
						$this->app->redirect($this->app->urlFor($this->nomPage($_SESSION['page'])));
					}
					else{
						$_SESSION['page']=$numPage;
						$this->app->render($this->nomPage($numPage).".html",array('app' => $this->app));
					}
				}
				else{
					$this->app->flash('etat_co',"Vous n'êtes pas connecté , connectez-vous");
            		$this->app->redirect($this->app->urlFor('accueil'));
				}	
		}
		function accueil(){
			if (!$this->estConnecte()){
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
				$this->app->render('inscription.html',array('app' => $this->app));
			}
			else{
				$this->changementPage($this->nomPage($_SESSION['page']));
			}
		}
		function visionnage(){
			$this->changementPage(2);
		}
		function questionnaire(){
			$this->changementPage(3);
		}
		function remerciement(){
			$this->changementPage(4);
		}
	}

?>
<?php
	class ControllerPages{
		private $app;
		private $var;
		public function __construct($app){

			$this->app = $app;
			$this->var = array('app' => $app);
		}
		function nomPage($numPage){ // Attribue la bonne route pour les bons numéros
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
		function estConnecte(){ // Permet de savoir si une personne est connecté
			if (isset($_SESSION['pseudo'])){
				return true;
			}
			return false;
		}
		function changementPage($numPage){ // Permet de controller le changement de page fait par l'utilisateur
			$this->app->render('header.html'); // Affiche a chaque fois une entête
			if ($this->estConnecte())
			{
				if ($numPage==1 || $numPage==2 || $numPage == 3 and $_SESSION['page'] != 5){ // en étant connecté l'utilisateur peut naviguer entre les 3 phases (consigne,visionnage,questionnaire) sauf s'il a annoté toutes les vidéos
					$_SESSION['page']=$numPage;
					$this->app->controllerUser->saveNumPage(); // quand un utilisateur change de page on garde la page en mémoire dans la bdd
					$this->app->render($this->nomPage($numPage).".html",$this->var);
				}
				else if($numPage == $_SESSION['page']){ // 
					$this->app->render($this->nomPage($numPage).".html",$this->var);
				}
				else{ // Si il veut faire appel à une autre page il est redirigé vers la page enregistré dans la base de données
					$this->app->redirect($this->app->urlFor($this->nomPage($_SESSION['page'])));
				}
			}
			else{
				if ($numPage == 0 || $numPage == 6){ // si il n'est pas connecté, il est soit dirigé vers l'inscription ou la connexion
					$this->app->render($this->nomPage($numPage).".html",$this->var);
				}
				else{ // Si il tente d'acceder à une page, il est redirigé vers l'accueil
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
		function visionnage(){ // Pour le visionnnage on modifie le tableau de variable à passer à passer à la vue 
			if ($this->estConnecte()){ // Si l'utilisateur est bien connecté on va chercher l'url de la vidéo ainsi que les annotations
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
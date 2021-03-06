<?php
include 'model/user.php';
class ControllerUser
{
	private $app;

 	public function __construct ($app)
 	{
 		$this->app=$app;
 	}
    public function generateHash($password) { // Generer un mot de passer cripté
        if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
            $salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
            return crypt($password, $salt);
        }
    }
    function verify($password, $hashedPassword) { // Verifier le mot de passe
        return crypt($password, $hashedPassword) == $hashedPassword;
    }
    public function connexion($password,$pseudo){ // Connecter une personne
        try {
            $user = User::where('pseudo', $pseudo) ->firstOrFail();   
            if(!$this->verify($password, $user->password)) {
                throw new Exception();
            }
        }catch(\Exception $e){
            $this->app->flash('etat_co',"Mauvais identifiant"); // Une variable flash est crée pour indiquer le message d'erreur dans la vue
            $this->app->redirect($this->app->urlFor('accueil'));
        }
        $_SESSION['pseudo'] = $pseudo; // On charge les différentes variables de session
        $_SESSION['id_user'] = $user->id_user;
        $_SESSION['page'] = $user->num_page;
        $_SESSION['id_video'] = $user->id_video;
        $this->app->redirect($this->app->urlFor('consigne'));
    }
    public function inscription($info){ // Inscription de l'utilisateur
        if ($info['password']==$info['vpassword']){ // Verification de son mot de passe
            $user = User::firstOrNew(array('pseudo' => $info['pseudo'])); // Si le pseudo n'existe pas on crée un nouvel utilisateur
            if(isset($user->password)){ 
                $this->app->flash('etat_co',"Ce pseudo existe déjà !"); 
                $this->app->redirect($this->app->urlFor('inscription'));
            }
            else{
                $hash = $this->generateHash($info['password']) ;
                $user->password = $hash;
                $user->num_page = 1;
                $user -> age = $info['age'];
                $user->id_video = 1;
                $user->save();
                $this->app->flash('etat_co',"Vous êtes inscrit, connectez-vous");
                $this->app->redirect($this->app->urlFor('accueil'));
            }
        }else{
            $this->app->flash('etat_co',"Les mots de passe ne correspondent pas!");
            $this->app->redirect($this->app->urlFor('inscription'));
        }
    }
    public function saveNumPage(){ // Permet de sauvegarder la page sur laquelle se trouve l'utilisateur
        $user = User::find($_SESSION['id_user']);
        $user->num_page = $_SESSION['page'];
        $user->save();
    }
    public function deconnexion(){// Permet à l'utilisateur de se deconnecter
        $this->saveNumPage();
        session_destroy();
        $this->app->redirect($this->app->urlFor('accueil'));
    }
    public function video(){ // Permet de sauvegarder l'id de la vidéo que l'utilisateur regarde
        $user = User::find($_SESSION['id_user']);
        $user->id_video = $_SESSION['id_video'];
        $user -> save();
    }
}

?>
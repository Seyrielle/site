<?php
include 'model/user.php';
class ControllerUser
{
	private $app;

 	public function __construct ($app)
 	{
 		$this->app=$app;
 	}
    public function connexion($password,$pseudo){
        try {
            $user = User::where('pseudo', $pseudo) -> where('password',$password)->firstOrFail();       
        }catch(\Exception $e){
            $this->app->flash('etat_co',"Mauvais identifiant");
            $this->app->redirect($this->app->urlFor('accueil'));
        }
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['id_user'] = $user->id;
            $_SESSION['page'] = 1;
            $this->app->flash('etat_co',"Vous êtes connnecté");
            $this->app->redirect($this->app->urlFor('consigne'));
    }
    public function inscription($info){
        $user = User::firstOrNew(array('pseudo' => $info['pseudo']));
        if(isset($user->password)){
            $this->app->flash('etat_co',"Ce pseudo existe déjà !");
            $this->app->redirect($this->app->urlFor('inscription'));
        }
        else{
            $user->password = $info['password'];
            $user->page = 0;
            $user->save();
            $this->app->flash('etat_co',"Vous êtes inscrit, connectez-vous");
            $this->app->redirect($this->app->urlFor('accueil'));
        }
        
    }
    public function deconnexion(){
        session_destroy();
        $this->app->redirect($this->app->urlFor('accueil'));
    }
}

?>
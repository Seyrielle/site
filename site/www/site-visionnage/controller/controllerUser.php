<?php
include 'model/user.php';
class ControllerUser
{
	private $app;

 	public function __construct ($app)
 	{
 		$this->app=$app;
 	}
    public function generateHash($password) {
        if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
            $salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
            return crypt($password, $salt);
        }
    }
    function verify($password, $hashedPassword) {
        return crypt($password, $hashedPassword) == $hashedPassword;
    }
    public function connexion($password,$pseudo){
        try {
            $user = User::where('pseudo', $pseudo) ->firstOrFail();   
            if(!$this->verify($password, $user->password)) {
                throw new Exception();
            }
        }catch(\Exception $e){
            $this->app->flash('etat_co',"Mauvais identifiant");
            $this->app->redirect($this->app->urlFor('accueil'));
        }
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['id_user'] = $user->id_user;
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
            $hash = $this->generateHash($info['password']) ;
            $user->password = $hash;
            $user->num_page = 0;
            $user -> age = $info['age'];
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
<?php
include 'model/annotation.php';
class Controllerannot
{
	private $app;

 	public function __construct ($app)
 	{
 		$this->app=$app;
 	}
    public function envoyerAnnot($info){ // envoyer une annotation vers la base de données
        try{
            $annotation = annotation::create(array(
            'id_user' => $_SESSION['id_user'],
            'id_video'=> $_SESSION['id_video'],
            'currentTime' => $info->post('currentTime'),
            'name' => $info->post('nom')));       
             echo $annotation->id_annot; // On renvoie l'id pour pouvoir supprimer plus tard l'annotation
        }catch(\Exception $e){
            echo $e;
        }
    }
    public function listeAnnot(){ // Renvoie la liste des annotation en fonction de l'id utilisateur et de l'id de la vidéo
        $tab = "";
        $annotations = annotation::where('id_user',"=",$_SESSION['id_user'])->where('id_video',"=",$_SESSION['id_video'])->orderBy('currentTime')->get();
        foreach ($annotations as $annotation){
            $tab = $tab."<tr><td class='col-xs-4'>".$annotation->name."</td><td class='time col-xs-4'>".$annotation->currentTime."</td><td class='col-xs-4'><bouton id=".$annotation->id_annot." onclick='supprimer(this.id);' type='bouton'class='btn btn-danger'>supprimer</bouton></td></tr>";
        }
        return $tab; // On renvoie le html permettant composé d'un taleau d'annotation
    }
    public function supprimerAnnot($id){ // Supprimer une annotation
        try{  
            $annotation = annotation::find($id->post('id'))->first();
            $annotation -> delete();
        }catch(\Exception $e){
            echo $e;
        }
    }
}

?>
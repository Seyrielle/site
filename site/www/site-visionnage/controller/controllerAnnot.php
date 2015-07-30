<?php
include 'model/annotation.php';
class Controllerannot
{
	private $app;

 	public function __construct ($app)
 	{
 		$this->app=$app;
 	}
    public function envoyerAnnot($info){
        try{
            $annotation = annotation::create(array(
            'id_user' => $_SESSION['id_user'],
            'id_video'=> $_SESSION['id_video'],
            'currentTime' => $info->post('currentTime'),
            'name' => $info->post('nom')));       
            echo $annotation->id;
        }catch(\Exception $e){
            echo $e;
        }
    }
    public function listeAnnot(){
        $tab = "";
        $annotations = annotation::where('id_user',"=",$_SESSION['id_user'])->get();
        foreach ($annotations as $annotation){
            $tab = $tab."<tr><td class='col-xs-4'>".$annotation->name."</td><td class='col-xs-4'>".$annotation->currentTime."</td><td class='col-xs-4'><bouton id=".$annotation->id_annot." onclick='supprimer(this.id);' type='bouton'class='btn btn-danger'>supprimer</bouton></td></tr>";
        }
        return $tab;
    }
    public function supprimerAnnot($info){}
}

?>
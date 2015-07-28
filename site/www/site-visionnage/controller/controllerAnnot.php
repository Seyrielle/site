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
            $annotation = new annotation;
            $annotation->id_user = $_SESSION['id_user'];
            $annotation->id_video= $_SESSION['id_video'];
            $annotation->currentTime = $info->post('currentTime');
            $annotation->name = $info->post('nom');
            $annotation->save();
        }catch(\Exception $e){
            echo $e;
        }
    }
    public function listeAnnot(){
        $tab = "";
        $annotations = annotation::where('id_user',"=",$_SESSION['id_user'])->get();
        foreach ($annotations as $annotation){
            echo 'ok';
            $tab = $tab."<tr><td class='col-xs-4'>".$annotation->name."</td><td class='col-xs-4'>".$annotation->currentTime."</td><td class='col-xs-4'><a type='bouton'class='btn'>supprimer</a></td></tr>";
        }
        echo $tab;
        return $tab;
    }
    public function supprimerAnnot($info){}
}

?>
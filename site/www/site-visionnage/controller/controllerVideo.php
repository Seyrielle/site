<?php
include 'model/video.php';
include 'model/image_solution_video.php';
class Controllervideo
{
	private $app;

 	public function __construct ($app)
 	{
 		$this->app=$app;
 	}
 	public function urlVideo(){ // Cette méthode permet de renvoyer les informations utile concernant une vidéo
 		
 		$video = Video::find($_SESSION['id_video']);
 		$images = Video::find($_SESSION['id_video'])->image; // On cherche les différentes image et leur moment d'apparition dans la video
 		$tab = array();
 		$tab['url']=$video->url; // On stoque dans un tableau url de la vidéo
 		$i = 0;
 		foreach ($images as $image){ // Pour chaque image on stoque dans le tableau son nom et le moment d'apparition de l'image
 			$tab[$i]['nom'] = $image->nom_image;
 			$tab[$i]['temps'] = $image->currentTime;
 			$i++;
 		}
 		return $tab;
 	}
 	public function newVideo(){ // Permet de trouver une nouvelle vidéo à l'utilisateur
 		$videos = Video::all();
 		foreach ($videos as $video) // Pour chaque vidéo, on regarde si elle est lié à un questionnaire et à l'utilisateur connecté
		{
			try{
				$questionnaire = Video::find($video->id_video)->questionnaire()->where('id_user', '=', $_SESSION['id_user'])->firstorFail();
				// Si la vidéo à un questionnaire pour l'utilisateur, on passe à une autre vidéo
			}catch(\Exception $e){ // Si elle n'a pas de vidéo, alors ce sera la prochaine vidéo à annoter
				$_SESSION['id_video'] = $video->id_video;
				$this->app->controllerUser->video(); 
				$_SESSION['page'] = 4; // On dirige la personne vers la page de remerciement pour l'inviter à annoter une nouvelle vidéo
				$this->app->redirect($this->app->urlFor('remerciement'));
			}
		}
		$_SESSION['page'] = 5; // Si toutes les vidéo on été annoté, alors l'utilisateur est dirigé vers une page de fin d'expérience
		$this->app->redirect($this->app->urlFor('fin'));
 		
 	}
}

?>
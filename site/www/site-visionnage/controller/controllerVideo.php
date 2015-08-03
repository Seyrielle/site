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
 	public function urlVideo(){
 		
 		$video = Video::find($_SESSION['id_video']);
 		$images = Video::find($_SESSION['id_video'])->image;
 		$tab = array();
 		$tab['url']=$video->url;
 		$i = 0;
 		foreach ($images as $image){
 			$tab[$i]['nom'] = $image->nom_image;
 			$tab[$i]['temps'] = $image->currentTime;
 			$i++;
 		}
 		return $tab;
 	}
 	public function newVideo(){
 		$videos = Video::all();
 		foreach ($videos as $video)
		{
			try{
				$questionnaire = Video::find($video->id_video)->questionnaire()->where('id_user', '=', $_SESSION['id_user'])->firstorFail();
			}catch(\Exception $e){
				$_SESSION['id_video'] = $video->id_video;
				$this->app->controllerUser->video(); 
				$_SESSION['page'] = 4;
				$this->app->redirect($this->app->urlFor('remerciement'));
			}
		}
		$_SESSION['page'] = 5;
		$this->app->redirect($this->app->urlFor('fin'));
 		
 	}
}

?>
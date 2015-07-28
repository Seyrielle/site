<?php
include 'model/video.php';
//include 'model/questionnaire.php';
class Controllervideo
{
	private $app;

 	public function __construct ($app)
 	{
 		$this->app=$app;
 	}
 	public function urlVideo(){
 		$video = Video::find($_SESSION['id_video']);
 		return $video->url;
 	}
 	public function newVideo(){
 		$videos = Video::all();
 		foreach ($videos as $video)
		{
			try{
				$questionnaire = Video::find($video->id_video)->questionnaire()->where('id_user', '=', $_SESSION['id_user'])->firstorFail();
			}catch(\Exception $e){
				$_SESSION['id_video'] = $video->id_video;
				return true;
			}
		}
		$this->app->redirect($this->app->urlFor('fin'));
 		
 	}
}

?>
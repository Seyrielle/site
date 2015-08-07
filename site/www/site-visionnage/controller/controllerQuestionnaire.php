<?php
include 'model/questionnaire.php';
class ControllerQuestionnaire
{
	private $app;

 	public function __construct ($app)
 	{
 		$this->app=$app;
 	}
    public function envoyerReponse($info){
        $questionnaire = new questionnaire;
        $questionnaire->confiance = $info['confiance'];
        $questionnaire->intelligence = $info['intelligence'];
        $questionnaire->interaction = $info['interaction'];
        $questionnaire->comportement = $info['comportement'];
        $questionnaire->nature_int = $info['nature_int'];
        $questionnaire->interaction_lab = $info['interaction_lab'];

        $questionnaire->sens = $info['sens'];
        $questionnaire->id_user = $_SESSION['id_user'];
        $questionnaire->id_video = $_SESSION['id_video'];
        $questionnaire->agent = $info['agent'];
        $questionnaire->save();
        
    }
}
?>

<?php 

// Create the Books model 
class video extends Illuminate\Database\Eloquent\Model {
    public $timestamps = false;
    public $primaryKey = 'id_video';
    public function questionnaire()
    {
        return $this->hasOne('Questionnaire','id_video','id_video');
    }
}

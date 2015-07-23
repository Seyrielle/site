
<?php 

// Create the Books model 
class questionnaire extends Illuminate\Database\Eloquent\Model {
    public $timestamps = false;
    protected $fillable = array(
		'pseudo',
	); 
}

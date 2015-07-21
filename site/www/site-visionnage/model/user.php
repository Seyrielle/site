

<?php 

// Create the Books model 
class User extends Illuminate\Database\Eloquent\Model {
    public $timestamps = false;
     protected $fillable = array(
		'pseudo',
	); 
}

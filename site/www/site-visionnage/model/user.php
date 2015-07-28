

<?php 

// Create the Books model 
class User extends Illuminate\Database\Eloquent\Model {
    public $timestamps = false;
    public $primaryKey = 'id_user';
     protected $fillable = array(
		'pseudo',
	); 
}

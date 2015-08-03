
<?php 

// Create the Books model 
class annotation extends Illuminate\Database\Eloquent\Model {
    public $timestamps = false;
    protected $guarded = array('id', 'id_annot');
    protected $primaryKey = "id_annot";
}

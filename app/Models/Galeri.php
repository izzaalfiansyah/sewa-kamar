<?php 
namespace App\Models;

class Galeri extends \CodeIgniter\Model {

    protected $table = 'galeri';

    protected $primaryKey = 'id';

    protected $allowedFields = ['foto'];

    protected $rules = [
        'foto' => 'required|trim'
    ];

}

/* End of file Galeri.php */

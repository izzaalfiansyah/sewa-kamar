<?php 
namespace App\Models;

class Ulasan extends \CodeIgniter\Model {

    protected $table = 'ulasan';

    protected $primaryKey = 'id';

    protected $allowedFields = ['email', 'teks'];

    protected $rules = [
        'email' => 'required|trim|valid_email',
        'teks' => 'required|trim'
    ];

}

/* End of file Ulasan.php */

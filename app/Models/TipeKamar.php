<?php 
namespace App\Models;

class TipeKamar extends \CodeIgniter\Model {

    protected $table = 'tipe_kamar';

    protected $primaryKey = 'id';

    protected $allowedFields = ['nama'];

    protected $rules = [
        'nama' => 'required|trim|max_length[50]'
    ];

}

/* End of file TipeKamar.php */

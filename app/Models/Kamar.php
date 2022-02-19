<?php 
namespace App\Models;

class Kamar extends \CodeIgniter\Model {

    protected $table = 'kamar';

    protected $primaryKey = 'id';

    protected $allowedFields = ['nama', 'tipe_id', 'harga', 'foto', 'status'];

    protected $rules = [
        'nama' => 'required|trim|max_length[50]',
        'tipe_id' => 'required|trim|numeric',
        'harga' => 'required|trim|numeric',
        'status' => 'required|trim|in_list[1, 2]'
    ];

}

/* End of file Kamar.php */

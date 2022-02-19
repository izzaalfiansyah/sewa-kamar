<?php 
namespace App\Models;

class User extends \CodeIgniter\Model {

    protected $table = 'user';

    protected $primaryKey = 'id';

    protected $allowedFields = ['username', 'password', 'nama', 'email', 'nomor_telepon', 'level'];

    protected $rules = [
        'username' => 'required|trim|min_length[5]|max_length[50]',
        'nama' => 'required|trim|max_length[100]',
        'email' => 'required|trim|valid_email',
        'nomor_telepon' => 'required|trim|min_length[6]',
        'level' => 'required|trim|in_list[1, 2]'
    ];

}

/* End of file User.php */

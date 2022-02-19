<?php 
namespace App\Models;

class Pesanan extends \CodeIgniter\Model {

    protected $table = 'pesanan';

    protected $primaryKey = 'id';

    protected $allowedFields = ['nama', 'nomor_telepon', 'kamar_id', 'tanggal_mulai', 'tanggal_akhir', 'bayar', 'status'];

    protected $rules = [
        'nama' => 'required|trim|max_length[50]',
        'nomor_telepon' => 'required|trim|min_length[6]',
        'kamar_id' => 'required|trim|numeric',
        'tanggal_mulai' => 'required|trim|valid_date[Y-m-d]',
        'tanggal_akhir' => 'required|trim|valid_date[Y-m-d]'
    ];

}

/* End of file Pesanan.php */

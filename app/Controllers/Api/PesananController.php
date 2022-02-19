<?php 
namespace App\Controllers\Api;

class PesananController extends \CodeIgniter\RESTful\ResourceController {

    function __construct()
    {
        $this->pesanan = new \App\Models\Pesanan();
        $this->kamar = new \App\Models\Kamar();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $get = $this->request->getGet();

        if ($this->request->getMethod() == 'get') {
            if ($get['length']) {
                $this->pesanan->limit((int) $get['length'], (int) $get['start']);
            }

            $like = [];
            if ($get['search']) {
                $like = [
                    'nama' => $get['search'],
                    'tanggal_mulai' => $get['search'],
                    'tanggal_akhir' => $get['search'],
                    'bayar' => $get['search']
                ];
            }
            
            $this->pesanan->orLike($like);

            $result['data'] = $this->pesanan->get()->getResult();
            
            if ($get['length']) {
                $result['recordsTotal'] = count($this->pesanan->findAll());
                $result['recordsFiltered'] = count($this->pesanan->orLike($like)->get()->getResult());
                $result['pagesTotal'] = ceil($result['recordsTotal'] / $get['length']);
                $result['pageNow'] = ($get['length'] + $get['start']) / $get['length'];
            }

            if ($result['data']) {
                foreach ($result['data'] as $key => $item) {
                    $result['data'][$key]->kamar = $this->kamar->find(4);
                }
            }

            return $this->respond($result);
        }
    }

    public function show($id = null)
    {
        if ($this->request->getMethod() == 'get') {
            $result = $id ? $this->pesanan->find($id) : null;
            if ($result) $result['kamar'] = $this->kamar->find($result['kamar_id']);
            return $this->respond($result);
        }
    }

    public function create()
    {
        $input = $this->request->getJSON();

        if ($this->request->getMethod() == 'post') {
            $this->validation->setRules($this->pesanan->rules);

            if ($this->validation->run((array) $input)) {
                $kamar = $this->kamar->find($input->kamar_id);
                if ($kamar['status'] == '1') {
                    $this->pesanan->insert([
                        'nama' => $input->nama,
                        'nomor_telepon' => $input->nomor_telepon,
                        'kamar_id' => $input->kamar_id,
                        'tanggal_mulai' => $input->tanggal_mulai,
                        'tanggal_akhir' => $input->tanggal_akhir,
                        'bayar' => $this->bayar($input->kamar_id, $input->tanggal_mulai, $input->tanggal_akhir),
                        'status' => '1'
                    ]);

                    $this->kamar->update($input->kamar_id, [
                        'status' => "2"
                    ]);
    
                    return $this->respond([
                        'error' => false,
                        'message' => "pesanan successfully created",
                        'data_id' => $this->pesanan->getInsertID()
                    ]);   
                }

                return $this->respond([
                    'error' => true,
                    'message' => 'kamar sudah kosong'
                ]);
            } else {
                foreach ($this->validation->getErrors() as $key => $item) {
                    return $this->respond([
                        'error' => true,
                        'message' => $item,
                        'field' => $key
                    ]);
                }
            }
        }
    }

    public function update($id = null)
    {
        $input = $this->request->getJSON();

        if ($this->request->getMethod() == 'put') {
            $this->validation->setRules(
                array_merge($this->pesanan->rules, ['status' => 'required|trim|in_list[1, 2]'])
            );

            if ($this->validation->run((array) $input)) {
                $this->pesanan->update($id, [
                    'nama' => $input->nama,
                    'nomor_telepon' => $input->nomor_telepon,
                    'kamar_id' => $input->kamar_id,
                    'tanggal_mulai' => $input->tanggal_mulai,
                    'tanggal_akhir' => $input->tanggal_akhir,
                    'bayar' => $this->bayar($input->kamar_id, $input->tanggal_mulai, $input->tanggal_akhir),
                    'status' => $input->status
                ]);

                if ($input->status == '2') {
                    $this->kamar->update($input->kamar_id, [
                        'status' => "1"
                    ]);
                }

                return $this->respond([
                    'error' => false,
                    'message' => "pesanan successfully updated"
                ]);
            } else {
                foreach ($this->validation->getErrors() as $key => $item) {
                    return $this->respond([
                        'error' => true,
                        'message' => $item,
                        'field' => $key
                    ]);
                }
            }
        }
    }

    public function delete($id = null)
    {
        if ($this->request->getMethod() == 'delete') {
            $this->delete($id);
            return $this->respond([
                'error' => false,
                'message' => "pesanan successfully deleted"
            ]);
        }
    }

    private function bayar($kamar_id, $tanggal_mulai, $tanggal_akhir)
    {
        $kamar_harga = $this->kamar->find($kamar_id)['harga'];

        $tanggal_mulai = new \DateTime($tanggal_mulai);
        $tanggal_akhir = new \DateTime($tanggal_akhir);
        $jumlah_hari = $tanggal_mulai->diff($tanggal_akhir)->d;

        $bayar = $kamar_harga * $jumlah_hari;
        return $bayar;
    }

}

/* End of file PesananController.php */

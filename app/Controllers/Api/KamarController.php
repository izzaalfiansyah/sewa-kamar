<?php 
namespace App\Controllers\Api;

class KamarController extends \CodeIgniter\RESTful\ResourceController {
    
    public function __construct()
    {
        $this->kamar = new \App\Models\Kamar();
        $this->tipeKamar = new \App\Models\TipeKamar();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $get = $this->request->getGet();
        
        if ($this->request->getMethod() == 'get') {
            if ($get['search']) {
                $this->kamar->orLike([
                    'nama' => $get['search'],
                    'harga' => $get['search']
                ]);
            }
            $result = $this->kamar->get()->getResult();
            return $this->respond($result);
        }
    }

    public function show($id = null)
    {
        if ($this->request->getMethod() == 'get') {
            $result = $id ? $this->kamar->find($id) : null;
            if ($result) $result['tipe'] = $this->tipeKamar->find($result['tipe_id']);
            return $this->respond($result);
        }
    }

    public function create()
    {
        $input = $this->request->getJSON();

        if ($this->request->getMethod() == 'post') {
            $this->validation->setRules($this->kamar->rules);

            if ($this->validation->run((array) $input)) {
                if ($input->foto) {
                    $foto = explode(';base64,', $input->foto)[1];
                    $foto_nama = substr(bin2hex(random_bytes(32)), 0, 20) . '.png';
                    file_put_contents(FCPATH . '/cdn/kamar/' . $foto_nama, base64_decode($foto));
                    $input->foto = $foto_nama;
                }

                $this->kamar->insert([
                    'nama' => $input->nama,
                    'tipe_id' => $input->tipe_id,
                    'harga' => $input->harga,
                    'foto' => $input->foto,
                    'status' => $input->status
                ]);

                return $this->respond([
                    'error' => false,
                    'message' => "kamar successfully created",
                    'data_id' => $this->kamar->getInsertID()
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
            $this->validation->setRules($this->kamar->rules);

            if ($this->validation->run((array) $input)) {
                if ($input->foto) {
                    $foto = explode(';base64,', $input->foto)[1];
                    $foto_nama = substr(bin2hex(random_bytes(32)), 0, 20) . '.png';
                    file_put_contents(FCPATH . '/cdn/kamar/' . $foto_nama, base64_decode($foto));
                    $input->foto = $foto_nama;

                    if ($kamar_foto = $this->kamar->find($id)['foto']) {
                        unlink(FCPATH . '/cdn/kamar/' . $kamar_foto);
                    }
                }

                $this->kamar->update($id, [
                    'nama' => $input->nama,
                    'tipe_id' => $input->tipe_id,
                    'harga' => $input->harga,
                    'foto' => $input->foto,
                    'status' => $input->status
                ]);

                return $this->respond([
                    'error' => false,
                    'message' => "kamar successfully updated"
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
            if ($kamar_foto = $this->kamar->find($id)['foto']) {
                unlink(FCPATH . '/cdn/kamar/' . $kamar_foto);
            }
            $this->kamar->delete($id);
            return $this->respond([
                'error' => false,
                'message' => 'kamar successfully deleted'
            ]);
        }
    }

}

/* End of file KamarController.php */

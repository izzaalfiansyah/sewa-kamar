<?php 
namespace App\Controllers\Api;

class TipeKamarController extends \CodeIgniter\RESTful\ResourceController {

    public function __construct()
    {
        $this->tipe = new \App\Models\TipeKamar();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        if ($this->request->getMethod() == 'get') {
            $result = $this->tipe->findAll();
            return $this->respond($result);
        }
    }

    public function show($id = null)
    {
        if ($this->request->getMethod() == 'get') {
            $result = $id ? $this->tipe->find($id) : null;
            return $this->respond($result);
        }
    }

    public function create()
    {
        $input = $this->request->getJSON();

        if ($this->request->getMethod() == 'post') {
            $this->validation->setRules($this->tipe->rules);

            if ($this->validation->run((array) $input)) {
                $this->tipe->insert([
                    'nama' => $input->nama
                ]);

                return $this->respond([
                    'error' => false,
                    'message' => 'tipe_kamar successfully created',
                    'data_id' => $this->tipe->getInsertID()
                ]);
            } else {
                return [
                    'error' => true,
                    'message' => $this->validation->getError('nama')
                ];
            }
        }
    }

    public function update($id = null)
    {
        $input = $this->request->getJSON();

        if ($this->request->getMethod() == 'put') {
            $this->validation->setRules($this->tipe->rules);

            if ($this->validation->run((array) $input)) {
                $this->tipe->update($id, [
                    'nama' => $input->nama
                ]);

                return $this->respond([
                    'error' => false,
                    'message' => 'tipe_kamar successfully updated'
                ]);
            } else {
                return [
                    'error' => true,
                    'message' => $this->validation->getError('nama')
                ];
            }
        }
    }

    public function delete($id = null)
    {
        if ($this->request->getMethod() == 'delete') {
            $this->delete($id);
            return $this->respond([
                'error' => false,
                'message' => "tipe_kamar successfully deleted"
            ]);
        }
    }

}

/* End of file TipeKamarController.php */

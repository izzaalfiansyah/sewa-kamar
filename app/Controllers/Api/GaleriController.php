<?php 
namespace App\Controllers\Api;

class GaleriController extends \CodeIgniter\RESTful\ResourceController {

    function __construct()
    {
        $this->galeri = new \App\Models\Galeri();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        if ($this->request->getMethod() == 'get') {
            $result = $this->galeri->findAll();
            return $this->respond($result);
        }
    }

    public function create()
    {
        $input = $this->request->getJSON();

        if ($this->request->getMethod() == 'post') {
            $this->validation->setRules($this->galeri->rules);

            if ($this->validation->run((array) $input)) {
                $foto = explode(';base64,', $input->foto)[1];
                $foto_nama = substr(bin2hex(random_bytes(32)) ,0 , 20) . '.jpg';
                file_put_contents(FCPATH . '/cdn/galeri/' . $foto_nama, base64_decode($foto));

                $this->galeri->insert([
                    'foto' => $foto_nama
                ]);

                return $this->respond([
                    'error' => false,
                    'message' => 'galeri successfully created'
                ]);
            } else {
                return $this->respond([
                    'error' => true,
                    'message' => $this->validation->getError('foto')
                ]);
            }
        }
    }

    public function delete($id = null)
    {
        if ($this->request->getMethod() == 'delete') {
            if ($foto = $this->galeri->find($id)['foto']) {
                unlink(FCPATH . '/cdn/galeri/' . $foto);
            }

            $this->galeri->delete($id);

            return $this->respond([
                'error' => false,
                'message' => "galeri successfully deleted"
            ]);
        }
    }

}

/* End of file GaleriController.php */

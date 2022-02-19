<?php 
namespace App\Controllers\Api;

class UlasanController extends \CodeIgniter\RESTful\ResourceController {

    function __construct()
    {
        $this->ulasan = new \App\Models\Ulasan();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $get = $this->request->getGet();

        if ($this->request->getMethod() == 'get') {
            if ($get['length']) {
                $this->ulasan->limit((int) $get['length'], (int) $get['start']);
            }

            $like = [];
            if ($get['search']) {
                $like = [
                    'email' => $get['search'],
                    'teks' => $get['search']
                ];
            }

            $this->ulasan->orLike($like);

            $result['data'] = $this->ulasan->get()->getResult();

            if ($get['length']) {
                $result['recordsTotal'] = count($this->pesanan->findAll());
                $result['recordsFiltered'] = count($this->pesanan->orLike($like)->get()->getResult());
                $result['pagesTotal'] = ceil($result['recordsTotal'] / $get['length']);
                $result['pageNow'] = ($get['length'] + $get['start']) / $get['length'];
            }

            return $this->respond($result);
        }
    }

    public function create()
    {
        $input = $this->request->getJSON();

        if ($this->request->getMethod() == 'post') {
            $this->validation->setRules($this->ulasan->rules);

            if ($this->validation->run((array) $input)) {
                $this->ulasan->insert([
                    'email' => $input->email,
                    'teks' => $input->teks
                ]);

                return $this->respond([
                    'error' => false,
                    'message' => "ulasan successfully created"
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

}

/* End of file UlasanController.php */

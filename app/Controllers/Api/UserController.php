<?php 
namespace App\Controllers\Api;

class UserController extends \CodeIgniter\RESTful\ResourceController {

    protected $modelName = 'App\Models\User';

    protected $format = 'json';

    function __construct() {
        $this->user = new \App\Models\User();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $get = $this->request->getGet();

        if ($this->request->getMethod() == 'get') {
            if ($get['search']) {
                $this->user->orLike([
                    'username' => $get['search'],
                    'nama' => $get['search']
                ]);
            }
            
            $result = $this->user->get()->getResult();
            return $this->respond($result);
        }
    }

    public function show($id = null)
    {
        if ($this->request->getMethod() == 'get') {
            $result = $id ? $this->user->find($id) : null;
            return $this->respond($result ? $result : []);
        }
    }

    public function create()
    {
        $input = $this->request->getJSON();

        if ($this->request->getMethod() == 'post') {
            $this->validation->setRules(
                array_merge($this->user->rules, ['password' => 'required|trim|min_length[8]|max_length[16]'])
            );

            if ($this->validation->run((array) $input)) {
                if ($this->user->where(['username' => $input->username])->find()) {
                    return $this->respond([
                        'error' => true,
                        'message' => "username already use"
                    ]);
                }

                $this->user->insert([
                    'username' => $input->username,
                    'password' => password_hash($input->password, PASSWORD_DEFAULT),
                    'nama' => $input->nama,
                    'email' => $input->email,
                    'nomor_telepon' => $input->nomor_telepon,
                    'level' => $input->level
                ]);

                return $this->respond([
                    'error' => false,
                    'message' => "user data successfully created",
                    'data_id' => $this->user->getInsertID()
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
            $this->validation->setRules($this->user->rules);

            if ($this->validation->run((array) $input)) {
                if ($this->user->where(['username' => $input->username, 'id <>' => $id])->find()) {
                    return $this->respond([
                        'error' => true,
                        'message' => "username already use"
                    ]);
                }
                $this->user->update($id, [
                    'username' => $input->username, 
                    'nama' => $input->nama,
                    'email' => $input->email,
                    'nomor_telepon' => $input->nomor_telepon,
                    'level' => $input->level
                ]);

                return $this->respond([
                    'error' => false,
                    'message' => "user data successfully updated"
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
            $this->user->delete($id);
            return $this->respond([
                'error' => false,
                'message' => 'user data successfully deleted'
            ]);
        }
    }

    public function login()
    {
        $input = $this->request->getJSON();

        if ($this->request->getMethod() == 'post') {
            $this->validation->setRules([
                'username' => 'required|trim',
                'password' => 'required|trim'
            ]);

            if ($this->validation->run((array) $input)) {
                $user = $this->user->where(['username' => $input->username])->get()->getRow();
                if ($user) {
                    if (password_verify($input->password, $user->password)) {
                        return $this->respond([
                            'error' => false,
                            'message' => "login successfully",
                            'data' => $user
                        ]);
                    } else {
                        return $this->respond([
                            'error' => true,
                            'message' => "wrong password"
                        ]);
                    }
                } else {
                    return $this->respond([
                        'error' => true,
                        'message' => "username not found"
                    ]);
                }
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

/* End of file UserController.php */

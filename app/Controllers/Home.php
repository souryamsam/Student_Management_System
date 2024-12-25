<?php

namespace App\Controllers;
use App\Models\UserModel;
class Home extends BaseController
{
    public function __construct()
    {
        $this->userModel = new UserModel();
        if (!(session()->has('user_id'))) {
            return redirect()->to(base_url('/'));
        }

    }
    public function login_from()
    {
        return view('login_from');
    }
    public function hit_login()
    {
        $rules = [
            'phone' => [
                'label' => 'Phone Number',
                'rules' => 'trim|required|numeric|exact_length[10]'
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'trim|required'
            ],
        ];
        if (!$this->validate($rules)) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->to(base_url('/'))->withInput();
        } else {
            $phon_no = $this->request->getPost('phone');
            $password = $this->request->getPost('password');
            $validate = $this->userModel->login_checked($phon_no, $password);
            // print_r($validate);
            // die;
            if ($validate) {
                session()->set('user_id', $validate);
                session()->setFlashdata('msg', ['status' => '1', 'message' => 'Successfully Logged In']);
                return redirect()->to(base_url('/view'));
            } else {
                session()->setFlashdata('msg', ['status' => '0', 'message' => 'Invalid Credentials!']);
                return redirect()->to(base_url('/'));
            }
        }
    }
    public function logout()
    {
        if (session()->has('user_id')) {
            session()->destroy();
        }
        return redirect()->to(base_url('/'));
    }
    public function view_user()
    {
        $data['user'] = $this->userModel->show_all_data();
        $data['session_data'] = session()->get('user_id');
        // if (session()->has('session_value')) {
        //     session()->remove('session_value');
        //     echo 'session not exit';
        // } else {
        //     echo 'session exit';
        // }
        return view('view_user', $data);
    }
    public function add_user()
    {
        $data['county'] = $this->userModel->pageload_data();
        $mode = $this->request->getPost('mode');
        $user_id = $this->request->getPost('custom_id');
        if (isset($user_id) && $mode == 'edit_user_data') {
            $single_user_data = $this->userModel->get_user_data($user_id);
            $data['user'] = $single_user_data[0];
        }
        return view('add_user', $data);
    }
    public function fatch_state_data()
    {
        $postdata = $this->request->getPost();
        $result = $this->userModel->fetch_state_data($postdata);
        $state = [];
        if (!empty($result)) {
            foreach ($result as $value) {
                $state[] = array(
                    "s_id" => $value["s_id"],
                    "s_name" => $value["s_name"]
                );
            }
        }
        if (!empty($state)) {
            echo json_encode(array('status' => '1', 'message' => 'success', 'data' => $state));
        } else {
            echo json_encode(array('status' => '0', 'message' => 'error'));
        }
    }
    public function fatch_city_data()
    {
        $postdata = $this->request->getPost();
        $result = $this->userModel->fetch_city_data($postdata);
        $city = [];
        if (!empty($result)) {
            foreach ($result as $value) {
                $city[] = array(
                    "d_id" => $value["d_id"],
                    "d_name" => $value["d_name"]
                );
            }
        }
        if (!empty($city)) {
            echo json_encode(array('status' => '1', 'message' => 'success', 'data' => $city));
        } else {
            echo json_encode(array('status' => '0', 'message' => 'error'));
        }
    }
    public function save_user()
    {
        $rules = [
            'name' => [
                'label' => 'Customer Name',
                'rules' => 'trim|required|alpha_space'
            ],
            'c_person' => [
                'label' => 'Contact Person',
                'rules' => 'trim|required|alpha_space'
            ],
            'c_number' => [
                'label' => 'Contact No',
                'rules' => 'trim|required|numeric|exact_length[10]'
            ],
            'email' => [
                'label' => 'Email ID',
                'rules' => 'trim|required|valid_email|regex_match[/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/]'
            ],
            'gender' => [
                'label' => 'Gender',
                'rules' => 'trim|required'
            ],
            'country' => [
                'label' => 'Country',
                'rules' => 'trim|required'
            ],
            'state' => [
                'label' => 'State',
                'rules' => 'trim|required'
            ],
            'city' => [
                'label' => 'City',
                'rules' => 'trim|required'
            ],
            'p_address' => [
                'label' => 'Permanent Address',
                'rules' => 'trim|required'
            ],
            'c_address' => [
                'label' => 'Current Address',
                'rules' => 'trim|required'
            ]
        ];
        if (!$this->validate($rules)) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->to(base_url('/add'))->withInput();
        }
        $postdata = $this->request->getPost();
        // session()->set('session_value', $postdata);
        // session()->set('session', $postdata);
        // return redirect()->to(base_url('/upload'));
        // die;
        $result = $this->userModel->insert_add_user($postdata);
        session()->setFlashdata('msg', $result);
        return redirect()->to(base_url('/add'));
    }
    public function update_status()
    {
        $postdata = $this->request->getPost();
        $result = $this->userModel->update_status($postdata);
        session()->setFlashdata('msg', $result);
        return redirect()->to(base_url('/view'));
    }
    public function from()
    {
        // if (session()->has('session_value')) {
        //     $data['session_data'] = session()->get('session_value');
        // } else {
        //     echo 'Session Not Exit';
        // }
        return view('upload_from');
    }

    public function upload()
    {
        $rules = [
            'name' => [
                'label' => 'Name',
                'rules' => 'trim|required'
            ],
            'address' => [
                'label' => 'Address',
                'rules' => 'trim|required'
            ],
            'upload' => [
                'label' => 'Photo',
                'rules' => 'uploaded[upload]|ext_in[upload,pdf,jpg,png]|max_size[upload,5048]'
            ],
        ];
        if (!$this->validate($rules)) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->to(base_url('upload'))->withInput();
        }
        $file = $this->request->getFile('upload');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newFileName = $_POST['name'] . '_' . time() . '.' . $file->getExtension();
            $file->move(WRITEPATH . 'uploads/', $newFileName);

            $filePath = $newFileName;
            $postData = $this->request->getPost();
            $result = $this->userModel->insert_photo($postData, $filePath);
            session()->setFlashdata('msg', $result);
            return redirect()->to(base_url('upload'));
        } else {
            session()->setFlashdata('msg', 'There was an error uploading the file.');
            return redirect()->to(base_url('upload'))->withInput();
        }
    }



}
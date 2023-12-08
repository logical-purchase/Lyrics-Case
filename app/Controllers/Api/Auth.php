<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Auth extends ResourceController
{
    public function login()
    {
        $validation = $this->validate([
            'username' => 'required|min_length[4]|max_length[50]',
            'password' => 'required|min_length[8]|max_length[255]',
        ]);

        if (!$validation) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $userInfo = $this->model->where('username', $username)->first();

        if (!$userInfo) {
            return $this->failUnauthorized('Username or password incorrect');
        }

        $checkPassword = password_verify($password, $userInfo['user_password']);

        if (!$checkPassword) {
            return $this->failUnauthorized('Username or password incorrect');
        }

        $response = [
            'status' => 200,
            'message' => 'Login successful',
            'userId' => $userInfo['user_id'],
        ];

        return $this->respond($response);
    }
}

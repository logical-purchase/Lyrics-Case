<?php

namespace App\Controllers\Api;

use App\Models\UserModel;
use App\Libraries\Hash;
use App\Models\RoleModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use Config\Services;
use Firebase\JWT\JWT;

class Auth extends ResourceController
{
    use ResponseTrait;
    protected $userModel;
    protected $roleModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
    }

    public function login()
    {
        try {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $validateUser = $this->userModel->where('username', $username)->first();
            
            if (!$validateUser) {
                return $this->failNotFound('Username or password incorrect');
            }

            $checkPassword = Hash::check($password, $validateUser['user_password']);

            if (!$checkPassword) {
                return $this->failNotFound('Username or password incorrect');
            } else {
                $jwt = $this->generateJWT($validateUser);
                return $this->respond(['token' => $jwt], 201);
            }
        } catch (\Exception $e) {
            return $this->failServerError($e);
        }
    }

    protected function signup()
    {
        try {
            $username = $this->request->getPost('username');
            $email    = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $cpassword = $this->request->getPost('cpassword');

            $values = [
                'username'      => $username,
                'user_email'    => $email,
                'user_password' => Hash::make($password)
            ];
            $query = $this->userModel->insert($values);

            if (!$query) {
                //return $this->failValidationErrors();
            } else {
                $id = $this->userModel->getInsertID();
                

                //$jwt = $this->generateJWT($validateUser);
                //return $this->respond(['token' => $jwt], 201);
            }

        } catch (\Exception $e) {
            return $this->failServerError($e);
        }
    }

    protected function generateJWT($user)
    {
        $key = Services::getSecretKey();
        $issuedAtTime = time();
        //$tokenTimeToLive = getenv('JWT_TIME_TO_LIVE');
        //$tokenExpiration = $issuedAtTime + $tokenTimeToLive;

        $roleName = $this->roleModel->where('role_id', $user['id_role'])->first();

        $payload = [
            'aud' => base_url(),
            'iat' => $issuedAtTime,
            //'exp' => $tokenExpiration,
            'data' => [
                'username' => $user['username'],
                'email'    => $user['user_email'],
                'points'   => $user['user_points'],
                'role'     => $user['id_role'],
                'rolename' => $roleName['role_name']
            ]
        ];

        $jwt = JWT::encode($payload, $key, 'HS256');
        return $jwt;
    }
}

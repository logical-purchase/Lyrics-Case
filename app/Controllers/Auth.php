<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Libraries\Hash;
use App\Controllers\BaseController;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();

        helper(['url', 'form']);
    }

    public function index()
    {
        return view('auth/login');
    }

    public function signup()
    {
        return view('auth/signup');
    }

    public function save()
    {
        /*
        // Validar los datos usando las reglas de validación del modelo
        if (!$this->validate($this->userModel->getValidationRules(), $this->userModel->getValidationMessages())) {
            // Si la validación falla, mostrar la vista con los errores
            return view('auth/signup', ['validation' => $this->validator]);
        }
        */
        $validation = $this->validate([
            'username' => [
                'rules'  => 'required|alpha_numeric|is_unique[users.username]|min_length[4]|max_length[50]',
                'errors' => [
                    'required'   => 'Please enter a username.',
                    'alpha_numeric' => 'The username must only use letters and numbers.',
                    'is_unique'  => 'This username is already taken.',
                    'min_length' => 'The username must be at least 4 characters long.',
                    'max_length' => 'The username must not exceed 50 characters.',
                ],
            ],
            'email' => [
                'rules'  => 'required|valid_email|is_unique[users.user_email]|max_length[255]',
                'errors' => [
                    'required'    => 'Please enter an email address.',
                    'valid_email' => 'Please enter a valid email address.',
                    'is_unique'   => 'This email address is already taken.',
                    'max_length'  => 'The email address must not exceed 255 characters.',
                ]

            ],
            'password' => [
                'rules'  => 'required|min_length[8]|max_length[255]',
                'errors' => [
                    'required'   => 'Please enter a password.',
                    'min_length' => 'The password must be at least 8 characters long.',
                    'max_length' => 'The password must not exceed 255 characters.',
                ]

            ],
            'cpassword' => [
                'rules'  => 'required|matches[password]',
                'errors' => [
                    'required' => 'Please confirm the password.',
                    'matches'  => 'The passwords do not match.',
                ]
            ],
        ]);

        if (!$validation) {
            return view('auth/signup', ['validation' => $this->validator]);
        } else {
            $username = $this->request->getPost('username');
            $email    = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $values = [
                'username'      => $username,
                'user_email'    => $email,
                'user_password' => Hash::make($password)
            ];
            $query = $this->userModel->insert($values);

            if (!$query) {
                return redirect()->back()->with('fail', 'Something went wrong');
            } else {
                $lastId = $this->userModel->getInsertID();
                session()->set('loggedUser', $lastId);
                return redirect()->to('/songs');
            }
        }
    }

    public function check()
    {
        $validation = $this->validate([
            'username' => [
                'rules'  => 'required|min_length[4]|max_length[50]',
                'errors' => [
                    'required'      => 'Please, enter the username.',
                    'min_length'    => 'The username must be at least 4 characters in length.',
                    'max_length'    => 'The username must not be more than 12 characters in length.',
                ]
            ],
            'password' => [
                'rules'  => 'required|min_length[8]|max_length[255]',
                'errors' => [
                    'required'   => 'Please, enter the password.',
                    'min_length' => 'The password must be at least 8 characters in length.',
                    'max_length' => 'The password must not be more than 255 characters in length.'
                ]
            ]
        ]);

        if (!$validation) {
            return view('auth/login', ['validation' => $this->validator]);
        } else {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $userInfo = $this->userModel->where('username', $username)->first();
            if (!$userInfo) {
                session()->setFlashdata('fail', 'Username or password incorrect');
                return redirect()->to('/login')->withInput();
            }
            $checkPassword = Hash::check($password, $userInfo['user_password']);

            if (!$checkPassword) {
                session()->setFlashdata('fail', 'Username or password incorrect');
                return redirect()->to('/login')->withInput();
            } else {
                $userId = $userInfo['user_id'];
                session()->set('loggedUser', $userId);
                return redirect()->to('/songs');
            }
        }
    }

    function logout()
    {
        if (session()->has('loggedUser')) {
            $redirectUrl = $this->request->getPost('redirect_url');
            session()->remove('loggedUser');
            return redirect()->to($redirectUrl);
        }
    }
}

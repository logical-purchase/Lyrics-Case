<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;
use App\Models\RoleModel;
use App\Models\RolePermissionModel;
use App\Models\UserModel;

class SettingController extends BaseController
{
    protected $roleModel;
    protected $userModel;

    public function __construct()
    {
        $this->roleModel = new RoleModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $loggedUser = $this->userModel->getUserInfoByLoggedId();

        $excludedRole = 'Visitor';
        $roles = $this->roleModel
            ->select('role_id, role_name')
            ->whereNotIn('role_name', [$excludedRole])
            ->groupBy('role_id')
            ->distinct()
            ->orderBy('role_id', 'ASC')
            ->findAll();

        $title = "Settings - Lyrics Case";
        $data = [
            'title'      => $title,
            'roles'      => $roles,
            'loggedUser' => $loggedUser
        ];

        return view('settings/index', $data);
    }
}

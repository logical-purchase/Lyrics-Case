<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PermissionModel;
use App\Models\RoleModel;
use App\Models\RolePermissionModel;
use App\Models\UserModel;

class SettingController extends BaseController
{
    protected $permissionModel;
    protected $roleModel;
    protected $rolePermissionModel;
    protected $userModel;

    public function __construct()
    {
        $this->permissionModel     = new PermissionModel();
        $this->roleModel           = new RoleModel();
        $this->rolePermissionModel = new RolePermissionModel();
        $this->userModel           = new UserModel();
    }

    public function index()
    {
        $userInfo = $this->getLoggedUserInfo();

        $excludedRole = 'Administrator';
        $roles = $this->roleModel
            ->select('roles.role_id, roles.role_name, GROUP_CONCAT(permissions.permission_id) as permission_ids')
            ->join('role_permissions', 'role_permissions.id_role = roles.role_id', 'left')
            ->join('permissions', 'permissions.permission_id = role_permissions.id_permission', 'left')
            ->whereNotIn('roles.role_name', [$excludedRole])
            ->groupBy('roles.role_id')
            ->distinct()
            ->orderBy('roles.role_id', 'ASC')
            ->findAll();

        $permissions = $this->permissionModel
            ->select('permission_id, permission_name')
            ->findAll();

        foreach ($permissions as &$permission) {
            $permission['camel_case_name'] = lcfirst(str_replace(' ', '', ucwords($permission['permission_name'])));
        }

        $title = "Settings - Lyrics Case";
        $data = [
            'title'       => $title,
            'userInfo'    => $userInfo,
            'roles'       => $roles,
            'permissions' => $permissions
        ];

        return view('settings/index', $data);
    }

    private function getLoggedUserInfo()
    {
        $loggedUserId = session()->get('loggedUser');
        return $this->userModel->find($loggedUserId);
    }
}

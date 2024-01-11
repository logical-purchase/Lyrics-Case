<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RoleModel;
use App\Models\RolePermissionModel;

class RoleController extends BaseController
{
    protected $permissionModel;
    protected $roleModel;
    protected $rolePermissionModel;
    protected $userModel;

    public function __construct()
    {
        $this->roleModel           = new RoleModel();
        $this->rolePermissionModel = new RolePermissionModel();
    }

    public function updatePermissions()
    {
        $roleId = $this->request->getPost('role_id');
        $selectedPermissions = $this->request->getPost('permissions');

        $this->rolePermissionModel->where('id_role', $roleId)->delete();

        if ($selectedPermissions) {
            foreach ($selectedPermissions as $permissionId) {
                $data = [
                    'id_role'       => $roleId,
                    'id_permission' => $permissionId
                ];
                $this->rolePermissionModel->insert($data);
            }
        }

        return redirect()->back();
    }
}

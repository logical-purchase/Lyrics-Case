<?php

use App\Models\RoleModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function validateAccess($roles, $authHeader)
{
    if (!is_array($roles))
        return false;

    $key = Services::getSecretKey();
    $arr = explode(' ', $authHeader);
    $jwt = $arr[1];
    $jwt = JWT::decode($jwt, new Key($key, 'HS256'));

    $roleModel = new RoleModel();
    $role = $roleModel->find($jwt->data->role);

    if ($role == null)
        return false;

    if (!in_array($role['role_name'], $roles))
        return false;

    return true;
}

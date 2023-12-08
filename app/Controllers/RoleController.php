<?php

namespace App\Controllers\API;

use App\Models\RoleModel;
use CodeIgniter\RESTful\ResourceController;

class RoleController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $roleModel = new RoleModel();
        $data['roles'] = $roleModel->findAll();
        return $this->respond($data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $roleModel = new RoleModel();
        $role = $roleModel->getWhere(['role_id' => $id])->getResult();
        if ($role) {
            return $this->respond($role);
        } else {
            return $this->failNotFound('Resource with the ID "' . $id . '" not found');
        }
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $roleModel = new RoleModel();

        $data = [
            'role_name' => $this->request->getVar('role_name')
        ];

        $roleModel->insert($data);

        $response = [
            'status' => 201,
            'error' => null,
            'message' => ['success' => 'Resource stored successfully']
        ];

        return $this->respondCreated($response, 201);
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $roleModel = new RoleModel();

        $requestData = $this->request->getJSON();

        $updateData = [
            'role_name' => $requestData->role_name
        ];

        $roleModel->update($id, $updateData);

        $response = [
            'status' => 200,
            'error' => null,
            'message' => ['success' => 'Resource updated successfully']
        ];

        return $this->respond($response);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $roleModel = new RoleModel();

        $role = $roleModel->find($id);

        if ($role) {
            $roleModel->delete($id);

            $response = [
                'status' => 200,
                'error' => null,
                'message' => ['success' => 'Resource deleted successfully']
            ];

            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('Resource with the ID "' . $id . '" not found');
        }
    }
}

<?php

namespace App\Controllers\Api;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class UserController extends ResourceController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper('access_role');
    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($username = null)
    {
        $user['user'] = $this->userModel
            ->where(['username' => $username])
            ->get()
            ->getRow();

        if ($user['user']) {
            return $this->respond($user);
        }

        return $this->failNotFound('User not found');
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        $song['song'] = $this->userModel->find($id);

        $song['song'] = $this->userModel
            ->select('song_lyrics')
            ->where(['song_id' => $id])
            ->get()
            ->getRow();

        if ($song['song'] != null) {
            return $this->respond($song);
        } 

        return $this->failNotFound('Song not found');
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        try {
            if (!validateAccess(array('Staff', 'Moderator', 'Editor'), $this->request->getServer('HTTP_AUTHORIZATION')))
                return $this->failForbidden('The role does not have access to this resource'); //403

            if ($this->userModel->find($id)) {
                $requestData = $this->request->getJSON();

                $updateData = [
                    'song_lyrics' => $requestData->song_lyrics
                ];
    
                $this->userModel->update($id, $updateData);
    
                $response = [
                    'status' => 200,
                    'error' => null,
                    'message' => ['successfull' => 'Lyrics updated successfully']
                ];

                return $this->respond($response);
            }
            return $this->failNotFound('Song not found');
        } catch (\Exception $e) {
            return $this->failServerError('An error has occurred on the server');
        }
    }
}

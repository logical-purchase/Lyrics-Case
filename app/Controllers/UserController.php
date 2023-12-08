<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ActivityModel;
use App\Models\RoleModel;
use App\Models\UserModel;
use App\Models\UserRoleModel;

class UserController extends BaseController
{
    protected $activityModel;
    protected $roleModel;
    protected $userModel;
    protected $userRoleModel;

    public function __construct()
    {
        $this->activityModel = new ActivityModel();
        $this->roleModel     = new RoleModel();
        $this->userModel     = new UserModel();
        $this->userRoleModel = new UserRoleModel();
    }

    public function index()
    {
    }

    public function show($username = null)
    {
        $userInfo = $this->getLoggedUserInfo();

        //$user = $this->userModel->find($id);
        $user = $this->userModel->where('username', $username)->first();

        if ($user) {
            $roles = $this->roleModel->findAll();

            $userRoles = $this->userRoleModel
                ->select('roles.role_id, roles.role_name, users.username as granter, user_roles.ur_created_at')
                ->join('roles', 'roles.role_id = user_roles.id_role')
                ->join('users', 'users.user_id = user_roles.ur_granter')
                ->where('id_user', $user['user_id'])
                ->orderBy('roles.role_id', 'DESC')
                ->findAll();

            $activities = $this->activityModel
                ->select('activities.*, songs.song_title, GROUP_CONCAT(artists.artist_name SEPARATOR \', \') AS artist_names')
                ->join('songs', 'songs.song_id = activities.id_song')
                ->join('song_artists', 'song_artists.id_song = activities.id_song')
                ->join('artists', 'artists.artist_id = song_artists.id_artist')
                ->where('id_user', $user['user_id'])
                ->groupBy('activities.activity_id')
                ->orderBy('activity_created_at', 'DESC')
                ->findAll();


            $title = "@{$user['username']} - Lyrics Case";
            $data = [
                'title'      => $title,
                'userInfo'   => $userInfo,
                'user'       => $user,
                'userRoles'  => $userRoles,
                'roles'      => $roles,
                'activities' => $activities
            ];

            return view('users/show', $data);
        } else {
            //return redirect()->to('/songs')->with('fail', 'User not found');
            //return view('errors/html/error_404');
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function new()
    {
    }

    public function create()
    {
    }

    public function edit($id = null)
    {
    }

    public function update($id = null)
    {
    }

    public function delete($id = null)
    {
    }

    public function promote()
    {
        $userId = $this->request->getPost('user_id');
        $roleId = $this->request->getPost('role_id');
        $granterId = $this->request->getPost('granter_id');

        // Realiza la inserción en la tabla user_roles
        $data = [
            'id_user' => $userId,
            'id_role' => $roleId,
            'ur_granter' => $granterId
        ];

        $this->userRoleModel->insert($data);

        // Puedes agregar lógica adicional aquí, como redirecciones o mensajes flash

        // Redirige a la página que desees después de realizar la promoción
        return redirect()->back()->with('success', 'User promoted successfully');
    }


    private function getLoggedUserInfo()
    {
        $loggedUserId = session()->get('loggedUser');
        return $this->userModel->find($loggedUserId);
    }
}

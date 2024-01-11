<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ActivityModel;
use App\Models\RoleModel;
use App\Models\UserModel;

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
    }

    public function show($username = null)
    {
        $userInfo = $this->getLoggedUserInfo();

        $user = $this->userModel
            ->select('users.*, roles.role_name')
            ->join('roles', 'roles.role_id = users.id_role')
            ->where('username', $username)
            ->first();

        if ($user) {
            $roles = $this->roleModel->findAll();

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
                'roles'      => $roles,
                'activities' => $activities
            ];

            return view('users/show', $data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function update($id = null)
    {
    }

    public function updateRole($id = null)
    {
        $this->userModel->update($id, ['id_role' => $this->request->getPost('role')]);

        return redirect()->back()->with('success', 'Role updated successfully');
    }

    public function moderate($id = null)
    {
        $this->userModel->update($id, ['user_status' => $this->request->getPost('status')]);

        return redirect()->back()->with('success', 'Status updated successfully');
    }

    private function getLoggedUserInfo()
    {
        $loggedUserId = session()->get('loggedUser');
        return $this->userModel->find($loggedUserId);
    }
}

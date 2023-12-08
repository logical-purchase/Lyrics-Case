<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ActivityModel;
use App\Models\CommentModel;
use App\Models\SongModel;
use App\Models\UserModel;

class CommentController extends BaseController
{
    protected $activityModel;
    protected $commentModel;
    protected $songModel;
    protected $userModel;

    public function __construct()
    {
        $this->activityModel = new ActivityModel();
        $this->commentModel  = new CommentModel();
        $this->songModel     = new SongModel();
        $this->userModel     = new UserModel();
    }

    public function create()
    {
        $userInfo = $this->getLoggedUserInfo();

        $songId = $this->request->getPost('songId');
        $comment = $this->request->getPost('comment');

        $values = [
            'comment_description' => $comment,
            'id_user'             => $userInfo['user_id'],
            'id_song'             => $songId
        ];

        $query = $this->commentModel->insert($values);

        if (!$query) {
            session()->setFlashdata('success', 'Something went wrong');
            return redirect()->back();
        } else {
            $this->logActivity('commented on', $userInfo['user_id'], $songId);

            session()->setFlashdata('success', 'Comment posted successfully');
            return redirect()->to("/songs/$songId");
        }
    }

    private function getLoggedUserInfo()
    {
        $loggedUserId = session()->get('loggedUser');
        return $this->userModel->find($loggedUserId);
    }

    private function logActivity($description, $userId, $songId = null)
    {
        $activityData = [
            'activity_description' => $description,
            'id_user'              => $userId,
            'id_song'              => $songId
        ];
        $this->activityModel->insert($activityData);
    }
}

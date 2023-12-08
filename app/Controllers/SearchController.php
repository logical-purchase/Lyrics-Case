<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ArtistModel;
use App\Models\SongModel;
use App\Models\UserModel;

class SearchController extends BaseController
{
    protected $artistModel;
    protected $songModel;
    protected $userModel;

    public function __construct()
    {
        $this->artistModel = new ArtistModel();
        $this->songModel   = new SongModel();
        $this->userModel   = new UserModel();
    }

    public function index()
    {
        $query = $this->request->getGet('q');

        if (empty(trim($query))) {
            // Si la consulta está vacía, puedes redirigir a la página principal u mostrar un mensaje de error.
            return redirect()->to('/');
        }

        $loggedUserId = session()->get('loggedUser');
        $userInfo = $this->userModel->find($loggedUserId);

        $songResults = $this->songModel->searchSong($query);
        $artistResults = $this->artistModel->searchArtist($query);
        $userResults = $this->userModel->searchUser($query);

        foreach ($songResults as &$songResult) {
            $songResult['formattedViews'] = $this->formatViews($songResult['song_views']);
        }

        $data = [
            'title'    => 'Search results | Lyrics Case',
            'songResults'  => $songResults,
            'artistResults'  => $artistResults,
            'userResults'  => $userResults,
            'userInfo' => $userInfo,
            'query'    => $query,
        ];

        return view('search/index', $data);
    }

    private function formatViews($views)
    {
        if ($views >= 1000000) {
            return number_format($views / 1000000, 1) . 'M';
        } elseif ($views >= 1000) {
            return number_format($views / 1000, 1) . 'K';
        } else {
            return $views;
        }
    }
}

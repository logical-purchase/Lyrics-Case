<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ArtistModel;
use App\Models\UserModel;

class ArtistController extends BaseController
{
    protected $artistModel;
    protected $userModel;

    public function __construct()
    {
        $this->artistModel = new ArtistModel();
        $this->userModel   = new UserModel();
    }

    public function index()
    {
    }

    public function show($uuid = null)
    {
        $loggedUser = $this->userModel->getUserInfoByLoggedId();

        $artist = $this->artistModel->select()->where('artist_uuid', $uuid)->first();

        if ($artist) {

            $title = "{$artist['artist_name']} on Lyrics Case";
            $data = [
                'title'      => $title,
                'artist'     => $artist,
                'loggedUser' => $loggedUser
            ];

            return view('artists/show', $data);
        } else {
            return redirect()->to('/')->with('fail', 'Artist not found');
        }
    }

    public function getArtists()
    {
        $searchTerm = $this->request->getGet('q');

        $artists = $this->artistModel->like('artist_name', $searchTerm)->findAll();

        $data = [];
        foreach ($artists as $artist) {
            $data[] = [
                'id' => $artist['artist_id'],
                'text' => $artist['artist_name'],
                'image' => $artist['artist_image'],
            ];
        }

        return $this->response->setJSON($data);
    }
}

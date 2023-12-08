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
        $this->artistModel     = new ArtistModel();
        $this->userModel       = new UserModel();

        helper(['url', 'form', 'date']);
    }

    public function index()
    {
    }

    public function show($id = null)
    {
        $userInfo = $this->getLoggedUserInfo();

        $artist = $this->artistModel->find($id);

        if ($artist) {
            
            $title = "{$artist['artist_name']} on Lyrics Case";
            $data = [
                'title'      => $title,
                'userInfo'   => $userInfo,
                'artist'       => $artist,
            ];

            return view('artists/show', $data);
        } else {
            return redirect()->to('/')->with('fail', 'Song not found');
        }
    }

    public function getArtists()
    {
        // Lógica para obtener datos de artistas desde la base de datos
        $artists = $this->artistModel->findAll();

        // Formatear datos en formato JSON para Select2
        $data = [];
        foreach ($artists as $artist) {
            $data[] = ['id' => $artist['artist_id'], 'text' => $artist['artist_name']];
        }

        // Enviar datos en formato JSON
        return $this->response->setJSON($data);
    }

    private function getLoggedUserInfo()
    {
        $loggedUserId = session()->get('loggedUser');
        return $this->userModel->find($loggedUserId);
    }
}

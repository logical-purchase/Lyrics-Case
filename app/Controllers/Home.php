<?php

namespace App\Controllers;
use App\Models\SongModel;
use App\Models\UserModel;

class Home extends BaseController
{
    protected $songModel;
    protected $userModel;

    public function __construct()
    {
        $this->songModel = new SongModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $loggedUser = $this->userModel->getUserInfoByLoggedId();

        $songs = $this->songModel
            ->select('songs.song_id, songs.song_artwork, songs.song_title, GROUP_CONCAT(artists.artist_name SEPARATOR \', \') as artist_names, songs.song_views')
            ->join('song_artists', 'song_artists.id_song = songs.song_id')
            ->join('artists', 'artists.artist_id = song_artists.id_artist')
            ->groupBy('songs.song_id')
            ->findAll();
        
        $data = [
            'title'      => 'Lyrics Case',
            'songs'      => $songs,
            'loggedUser' => $loggedUser
        ];

        return view('songs/index', $data);
    }

    public function test()
    {
        $loggedUser = $this->userModel->getUserInfoByLoggedId();

        $data = [
            'title'      => 'Test page',
            'loggedUser' => $loggedUser
        ];

        return view('test', $data);
    }
}

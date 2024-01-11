<?php

namespace App\Controllers;
use App\Models\SongModel;
use App\Models\UserModel;

class Home extends BaseController
{
    public function index()
    {
        $songModel = new SongModel();
        $userModel = new UserModel();
        $loggedUserId = session()->get('loggedUser');
        $userInfo = $userModel->find($loggedUserId);

        $songs = $songModel
            ->select('songs.song_id, songs.song_artwork, songs.song_title, GROUP_CONCAT(artists.artist_name SEPARATOR \', \') as artist_names, songs.song_views')
            ->join('song_artists', 'song_artists.id_song = songs.song_id')
            ->join('artists', 'artists.artist_id = song_artists.id_artist')
            ->groupBy('songs.song_id')
            ->findAll();
        
        $data = [
            'title'    => 'Lyrics Case',
            'userInfo' => $userInfo,
            'songs'    => $songs
        ];
        return view('songs/index', $data);
    }

    public function test()
    {
        $userModel = new UserModel();
        $loggedUserId = session()->get('loggedUser');
        $userInfo = $userModel->find($loggedUserId);

        $data = [
            'title'    => 'Test page - Lyrics Case',
            'userInfo' => $userInfo
        ];

        return view('test', $data);
    }
}

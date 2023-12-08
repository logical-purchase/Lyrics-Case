<?php

namespace App\Controllers\Api;

use App\Models\SongModel;
use CodeIgniter\RESTful\ResourceController;

class SongController extends ResourceController
{
    protected $songModel;

    public function __construct()
    {
        $this->songModel = new SongModel();
    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $songData['songs'] = $this->songModel->select('songs.song_id, songs.song_artwork, songs.song_title, GROUP_CONCAT(artists.artist_name SEPARATOR \', \') as artist_names, songs.song_views')
            ->join('song_artists', 'song_artists.id_song = songs.song_id')
            ->join('artists', 'artists.artist_id = song_artists.id_artist')
            ->groupBy('songs.song_id')
            ->findAll();

        return $this->respond($songData);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $song['song'] = $this->songModel
            ->select('songs.*, GROUP_CONCAT(artists.artist_name SEPARATOR \', \') as artist_names')
            ->join('song_artists', 'song_artists.id_song = songs.song_id')
            ->join('artists', 'artists.artist_id = song_artists.id_artist')
            ->where(['songs.song_id' => $id])
            ->groupBy('songs.song_id')
            ->get()
            ->getRow();

        if ($song) {
            return $this->respond($song);
        } else {
            return $this->failNotFound('Song not found');
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
        //
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
        $requestData = $this->request->getJSON();

        $updateData = [
            'song_lyrics' => $requestData->song_lyrics
        ];

        $this->songModel->update($id, $updateData);

        $response = [
            'status' => 200,
            'error' => null,
            'message' => ['successfull' => 'Song updated successfully']
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
        //
    }
}

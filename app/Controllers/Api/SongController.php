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
        helper('access_role');
    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        try {
            if (!validateAccess(array('Staff', 'Moderator'), $this->request->getServer('HTTP_AUTHORIZATION')))
                return $this->failForbidden('The role does not have access to this resource');

            $songs['songs'] = $this->songModel->select('songs.song_id, songs.song_artwork, songs.song_title, GROUP_CONCAT(artists.artist_name SEPARATOR \', \') as artist_names, songs.song_views')
                ->join('song_artists', 'song_artists.id_song = songs.song_id')
                ->join('artists', 'artists.artist_id = song_artists.id_artist')
                ->groupBy('songs.song_id')
                ->orderBy('songs.song_created_at', 'DESC')
                ->findAll();

            return $this->respond($songs);
        } catch (\Exception $e) {
            return $this->failServerError('An error has occurred on the server');
        }
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

    public function search($term = null)
    {
        if ($term === null) {
            return $this->fail('Search term is required', 400);
        }

        $songData['songs'] = $this->songModel
            ->select('songs.song_id, songs.song_artwork, songs.song_title, GROUP_CONCAT(artists.artist_name SEPARATOR \', \') as artist_names, songs.song_views')
            ->join('song_artists', 'song_artists.id_song = songs.song_id')
            ->join('artists', 'artists.artist_id = song_artists.id_artist')
            ->like('songs.song_title', $term)
            ->orLike('artists.artist_name', $term)
            ->groupBy('songs.song_id')
            ->findAll();

        if ($songData['songs']) {
            return $this->respond($songData);
        } else {
            return $this->failNotFound('No matching songs found');
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
        $song['song'] = $this->songModel->find($id);

        $song['song'] = $this->songModel
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

            if ($this->songModel->find($id)) {
                $requestData = $this->request->getJSON();

                $updateData = [
                    'song_lyrics' => $requestData->song_lyrics
                ];
    
                $this->songModel->update($id, $updateData);
    
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

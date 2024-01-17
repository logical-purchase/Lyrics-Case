<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ActivityModel;
use App\Models\AdditionalCreditArtistModel;
use App\Models\ArtistModel;
use App\Models\CommentModel;
use App\Models\SongArtistModel;
use App\Models\SongModel;
use App\Models\UserModel;

class SongController extends BaseController
{
    protected $activityModel;
    protected $additionalCreditArtistModel;
    protected $artistModel;
    protected $commentModel;
    protected $songModel;
    protected $songArtistModel;
    protected $userModel;

    public function __construct()
    {
        $this->activityModel               = new ActivityModel();
        $this->additionalCreditArtistModel = new AdditionalCreditArtistModel();
        $this->artistModel                 = new ArtistModel();
        $this->commentModel                = new CommentModel();
        $this->songModel                   = new SongModel();
        $this->songArtistModel             = new SongArtistModel();
        $this->userModel                   = new UserModel();

        helper(['url', 'form', 'date']);
    }

    public function index()
    {
        $loggedUser = $this->userModel->getUserInfoByLoggedId();

        $songs = $this->songModel
            ->select('songs.song_id, songs.song_artwork, songs.song_title, songs.song_views, GROUP_CONCAT(artists.artist_name SEPARATOR \', \') as artist_names')
            ->join('song_artists', 'song_artists.id_song = songs.song_id')
            ->join('artists', 'artists.artist_id = song_artists.id_artist')
            ->groupBy('songs.song_id')
            ->orderBy('songs.song_views', 'DESC')
            ->findAll();

        $data = [
            'title'       => 'Song catalogue - Lyrics Case',
            'songs'       => $songs,
            'loggedUser' => $loggedUser
        ];

        return view('songs/index', $data);
    }

    public function show($id = null)
    {
        $loggedUser = $this->userModel->getUserInfoByLoggedId();

        $song = $this->songModel->find($id);

        if ($song) {
            $currentViews = $song['song_views'];
            $newViews = $currentViews + 1;
            $this->songModel->update($id, ['song_views' => $newViews]);
            $formattedViews = $this->formatViews($song['song_views']);
            $videoLink = $song['song_video_link'];
            $videoId = $this->getYoutubeVideoId($videoLink);

            $songArtists = $this->songArtistModel
                ->select('song_artists.*, artists.artist_name')
                ->join('artists', 'artists.artist_id = song_artists.id_artist')
                ->where('id_song', $id)
                ->orderBy('sa_position', 'ASC')
                ->findAll();

            // $featuringArtists = $this->additionalCreditArtistModel
            //     ->select('song_additional_credits.*, artists.artist_name')
            //     ->join('additional_credits', 'additional_credits.artist_id = song_additional_credits.id_artist')
            //     ->join('artists', 'artists.artist_id = song_additional_credits.id_artist')
            //     ->where('id_song', $id)
            //     ->orderBy('sac_position', 'ASC')
            //     ->findAll();

            // $writerArtists = $this->additionalCreditArtistModel
            //     ->select('song_artists.*, artists.artist_name')
            //     ->join('artists', 'artists.artist_id = song_artists.id_artist')
            //     ->where('id_song', $id)
            //     ->orderBy('sa_position', 'ASC')
            //     ->findAll();

            // $producerArtists = $this->additionalCreditArtistModel
            //     ->select('song_artists.*, artists.artist_name')
            //     ->join('artists', 'artists.artist_id = song_artists.id_artist')
            //     ->where('id_song', $id)
            //     ->orderBy('sa_position', 'ASC')
            //     ->findAll();

            $comments = $this->commentModel->getCommentsBySong($id);

            $activities = $this->activityModel
                ->select('activities.*, users.username, users.user_image')
                ->join('users', 'users.user_id = activities.id_user')
                ->where('activities.id_song', $id)
                ->groupBy('activities.activity_id')
                ->orderBy('activity_created_at', 'DESC')
                ->findAll();

            $artistNames = implode(', ', array_column($songArtists, 'artist_name'));

            $title = "{$song['song_title']} - lyrics by {$artistNames} on Lyrics Case";

            $data = [
                'title'          => $title,
                'song'           => $song,
                'songArtists'    => $songArtists,
                'comments'       => $comments,
                'activities'     => $activities,
                'formattedViews' => $formattedViews,
                'videoId'        => $videoId,
                'loggedUser'     => $loggedUser,
            ];

            return view('songs/show', $data);
        } else {
            return redirect()->to('/')->with('fail', 'Song not found');
        }
    }

    public function new()
    {
        $loggedUser = $this->userModel->getUserInfoByLoggedId();

        $data = [
            'title'      => 'Add a song - Lyrics Case',
            'loggedUser' => $loggedUser
        ];

        return view('songs/new', $data);
    }

    // if (!$this->validate($this->songModel->getValidationRules(), $this->songModel->getValidationMessages())) {
    //     return view('songs/new', [
    //         'validation' => $this->validator,
    //         'title'    => 'Add song | Lyrics',
    //         'userInfo' => $userInfo
    //     ]);
    // } else {
    //     
    // }
    public function create()
    {
        $loggedUser = $this->userModel->getUserInfoByLoggedId();

        $title   = $this->request->getPost('title');
        $lyrics  = $this->request->getPost('lyrics');
        $artwork = $this->request->getPost('artwork');
        $date    = $this->request->getPost('date');
        $video   = $this->request->getPost('video');

        $artwork = !empty($artwork) ? $artwork : 'https://mynoota.com/api/images/__default.png';

        $selectedArtists = $this->request->getPost('artist');

        $values = [
            'song_title'      => $title,
            'song_lyrics'     => $lyrics,
            'song_artwork'    => $artwork,
            'song_date'       => $date,
            'song_video_link' => $video
        ];

        $query = $this->songModel->insert($values);

        if (!$query) {
            session()->setFlashdata('success', 'Something went wrong');
            return redirect()->back();
        } else {
            $lastId = $this->songModel->getInsertID();

            if (!empty($selectedArtists)) {
                $songArtists = [];
                $position = 1;

                foreach ($selectedArtists as $artist) {
                    if (is_numeric($artist)) {
                        $songArtists[] = [
                            'id_song' => $lastId,
                            'id_artist' => $artist,
                            'sa_position' => $position,
                        ];
                    } else {
                        $newArtistId = $this->createArtist($artist);
                        if ($newArtistId) {
                            $songArtists[] = [
                                'id_song' => $lastId,
                                'id_artist' => $newArtistId,
                                'sa_position' => $position,
                            ];
                        }
                    }

                    $position++;
                }
                $this->songArtistModel->insertBatch($songArtists);
            }

            $this->logActivity('created', $loggedUser['user_id'], $lastId);

            session()->setFlashdata('success', 'Song created successfully');
            return redirect()->to("/songs/$lastId");
        }
    }

    public function updateLyrics($id = null)
    {
        $loggedUser = $this->userModel->getUserInfoByLoggedId();

        $lyrics = $this->request->getPost('lyrics');
        $cleanLyrics = htmlspecialchars($lyrics, ENT_QUOTES, 'UTF-8');
        $data = ['song_lyrics' => $cleanLyrics];
        $result = $this->songModel->update($id, $data);

        if ($result) {
            $this->logActivity('edited the lyrics of', $loggedUser['user_id'], $id);
            session()->setFlashdata('success', 'Lyrics updated successfully');
        } else {
            session()->setFlashdata('fail', 'Failed to update lyrics');
        }

        return redirect()->back();
    }

    public function updateMetadata($id = null)
    {
        $loggedUser = $this->userModel->getUserInfoByLoggedId();

        $title   = $this->request->getPost('title');
        $artwork = $this->request->getPost('artwork');
        $date    = $this->request->getPost('date');
        $video   = $this->request->getPost('video');

        $selectedArtists = $this->request->getPost('artist');

        $data = [
            'song_title'      => $title,
            'song_artwork'    => $artwork,
            'song_date'       => $date,
            'song_video_link' => $video
        ];
        $result = $this->songModel->update($id, $data);

        if ($result) {
            $this->songArtistModel->where('id_song', $id)->delete();

            // Insertar las nuevas relaciones entre la canción y los artistas seleccionados
            if (!empty($selectedArtists)) {
                $songArtists = [];
                $position = 1;

                foreach ($selectedArtists as $artist) {
                    if (is_numeric($artist)) {
                        $songArtists[] = [
                            'id_song' => $id,
                            'id_artist' => $artist,
                            'sa_position' => $position,
                        ];
                    } else {
                        // $artist is a new artist, create it and get the ID
                        $newArtistId = $this->createArtist($artist);
                        if ($newArtistId) {
                            $songArtists[] = [
                                'id_song' => $id,
                                'id_artist' => $newArtistId,
                                'sa_position' => $position,
                            ];
                        }
                    }
                    $position++;
                }
                $this->songArtistModel->insertBatch($songArtists);
            }

            $this->logActivity('edited the metadata of', $loggedUser['user_id'], $id);
            session()->setFlashdata('success', 'Metadata updated successfully');
        } else {
            session()->setFlashdata('fail', 'Failed to update metadata');
        }

        return redirect()->back();
    }

    public function delete($id = null)
    {
        $loggedUser = $this->userModel->getUserInfoByLoggedId();

        // Verifica si se proporciona un ID de canción válido
        if (!$id) {
            session()->setFlashdata('fail', 'Invalid song ID');
            return redirect()->back();
        }
        // Elimina la canción según el ID
        $this->songModel->delete($id);

        // Registrar la actividad
        $this->logActivity('deleted a song', $loggedUser['user_id']);

        // Redirigir a la página de inicio con un mensaje de éxito
        session()->setFlashdata('success', 'Song deleted successfully');
        return redirect()->to('/songs');
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

    protected function createArtist($artistName)
    {
        $newArtistData = [
            'artist_name' => $artistName,
        ];

        $this->artistModel->insert($newArtistData);
        return $this->artistModel->getInsertID();
    }

    protected function formatViews($views)
    {
        if ($views >= 1000000) {
            return number_format($views / 1000000, 1) . 'M';
        } elseif ($views >= 1000) {
            return number_format($views / 1000, 1) . 'K';
        } else {
            return $views;
        }
    }

    protected function getYoutubeVideoId($url)
    {
        $videoId = '';

        // Patrones de expresiones regulares para extraer el ID del video
        $patterns = [
            '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/',
            '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})&list=.*?index=\d+/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                $videoId = $matches[1];
                break;
            }
        }

        return $videoId;
    }
}

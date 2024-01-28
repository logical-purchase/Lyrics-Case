<?php

namespace App\Models;

use CodeIgniter\Model;

class SongModel extends Model
{
    protected $table            = 'songs';
    protected $primaryKey       = 'song_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'song_uuid',
        'song_title',
        'song_lyrics',
        'song_artwork',
        'song_date',
        'song_video_link',
        'song_views',
        'song_status'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function searchSong($query)
    {
        $matchingSongs = $this->select('songs.song_id, songs.song_uuid, songs.song_title, songs.song_artwork, songs.song_views')
            ->like('songs.song_title', $query)
            ->orLike('artists.artist_name', $query)
            ->join('song_artists', 'song_artists.id_song = songs.song_id')
            ->join('artists', 'artists.artist_id = song_artists.id_artist')
            ->groupBy('songs.song_id') // Agrupa por canción para evitar duplicados
            ->findAll();

        foreach ($matchingSongs as &$song) {
            $artists = $this->select('artists.artist_name')
                ->join('song_artists', 'song_artists.id_song = songs.song_id')
                ->join('artists', 'artists.artist_id = song_artists.id_artist')
                ->where('songs.song_id', $song['song_id'])
                ->findAll();

            $artistNames = array_column($artists, 'artist_name');
            $song['artist_names'] = implode(', ', $artistNames);
        }

        return $matchingSongs;
    }
}

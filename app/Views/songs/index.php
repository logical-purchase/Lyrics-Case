<?= $this->extend('layouts/base_layout'); ?>

<?= $this->section('content'); ?>

<div class="container mt-4 mb-2">
    <?php foreach ($songs as $song) : ?>
        <a class="link-body-emphasis text-decoration-none" href="<?= base_url('songs/' . esc($song['song_id'])); ?>">
            <div class="song-item d-flex bg-body text-truncate rounded-3 shadow-sm mb-3">
                <div class="row g-0 w-100">
                    <div class="col-auto p-2">
                        <img src="<?= esc($song['song_artwork']); ?>" width="63px">
                    </div>
                    <div class="col text-truncate p-2 ps-0">
                        <small>
                            <div class="row">
                                <div class="col text-truncate">
                                    <span class="h6">
                                        <?= esc($song['song_title']); ?>
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-truncate">
                                    <span>
                                        <?= esc($song['artist_names']); ?>
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <span><i class="bi bi-eye me-1"></i><?= esc($song['song_views']); ?></span>
                                </div>
                            </div>
                        </small>
                    </div>
                </div>
            </div>
        </a>
    <?php endforeach ?>
</div>

<?= $this->endSection(); ?>
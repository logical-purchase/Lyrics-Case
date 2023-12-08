<?= $this->extend('layouts/base_layout'); ?>

<?= $this->section('content'); ?>

<div class="container my-3">
    <?php foreach ($songs as $song) : ?>
        <a class="text-decoration-none text-info-emphasis" href="<?= base_url('songs/' . esc($song['song_id'])); ?>">
            <div class="bg-body rounded-4 shadow-sm fw-medium px-3 mb-2 p-2">
                <div class="row g-3">
                    <div class="col-auto">
                        <img src="<?= esc($song['song_artwork']); ?>" width="50px">
                    </div>
                    <div class="col d-flex align-items-center">
                        <span><?= esc($song['artist_names']); ?> - <?= esc($song['song_title']); ?> lyrics</span>
                    </div>
                </div>
            </div>
        </a>
    <?php endforeach ?>
</div>

<?= $this->endSection(); ?>
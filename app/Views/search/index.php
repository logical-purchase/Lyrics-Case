<?= $this->extend('layouts/base_layout'); ?>

<?= $this->section('content'); ?>

<?php
// var_dump($songResults);
// var_dump($userResults);
?>

<div class="container py-5">
    <?php if (!$userResults && !$songResults && !$artistResults) : ?>

        <div class="text-center">
            <h1>No results for "<?= $query ?>"</h1>
            <span>Try again</span>
        </div>

    <?php else : ?>

        <div class="text-center">
            <h1>"<?= $query ?>"</h1>
            <span>All results</span>
        </div>

        <div class="row g-3 mt-3">

            <?php if ($songResults) : ?>
                <div class="col-lg-7">
                    <span class="h6 text-info-emphasis text-uppercase">Songs</span>
                    <?php foreach ($songResults as $songResult) : ?>
                        <a href="<?= base_url('song/' . $songResult['song_uuid']); ?>" class="text-primary-emphasis text-decoration-none">
                            <div class="song-item d-flex bg-body text-truncate rounded-3 shadow-sm my-2">
                                <div class="row g-0 w-100">
                                    <div class="col-auto p-2">
                                        <img src="<?= $songResult['song_artwork']; ?>" width="65px" height="65px">
                                    </div>
                                    <div class="col text-truncate p-2 ps-0">
                                        <small>
                                            <div class="row">
                                                <div class="col text-truncate">
                                                    <span class="h6"><?= $songResult['song_title']; ?></span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col text-truncate">
                                                    <span><?= esc($songResult['artist_names']); ?></span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <span><i class="bi bi-eye me-1"></i><?= esc($songResult['formattedViews']); ?></span>
                                                </div>
                                            </div>
                                        </small>

                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif ?>

            <?php if ($artistResults) : ?>
                <div class="col">
                    <span class="h6 text-info-emphasis text-uppercase">Artists</span>
                    <?php foreach ($artistResults as $artistResult) : ?>
                        <a href="<?= base_url('artist/' . $artistResult['artist_uuid']); ?>" class="text-primary-emphasis text-decoration-none">
                            <div class="d-flex align-items-center bg-body rounded-3 shadow-sm my-2 p-2">
                                <img class="rounded-circle" src="<?= $artistResult['artist_image']; ?>" width="65px" height="65px">
                                <small>
                                    <h6 class="ms-3 mb-0"><?= $artistResult['artist_name']; ?></h6>
                                </small>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif ?>

        </div>

        <div class="row g-3 mt-3">

            <?php if ($songResults) : ?>
                <div class="col-7">
                    <span class="h6 text-info-emphasis text-uppercase">Lyric matches</span>
                    <?php foreach ($songResults as $songResult) : ?>
                        <a href="<?= base_url('songs/' . $songResult['song_id']); ?>" class="text-primary-emphasis text-decoration-none">
                            <div class="d-flex bg-body rounded-pill shadow-sm mt-2 mb-3">
                                <img src="<?= $songResult['song_artwork']; ?>" width="80px" height="80px">
                                <div class="d-flex flex-column p-2">
                                    <small>
                                        <h6 class="mb-0"><?= $songResult['song_title']; ?></h6>
                                        <span><?= esc($songResult['artist_names']); ?></span>
                                    </small>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif ?>

            <?php if ($userResults) : ?>
                <div class="col">
                    <span class="h6 text-info-emphasis text-uppercase">Users</span>
                    <?php foreach ($userResults as $userResult) : ?>
                        <a href="<?= base_url('user/' . $userResult['username']); ?>" class="text-primary-emphasis text-decoration-none">
                            <div class="d-flex align-items-center bg-body rounded-pill shadow-sm mt-2 mb-3 p-2">
                                <img class="rounded-circle" src="<?= $userResult['user_image']; ?>" width="65px" height="65px">
                                <small>
                                    <h6 class="ms-3 mb-0"><?= $userResult['username']; ?></h6>
                                </small>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif ?>

        </div>

    <?php endif ?>
</div>

<?= $this->endSection(); ?>
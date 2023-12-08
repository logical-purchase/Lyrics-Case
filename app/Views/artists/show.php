<?= $this->extend('layouts/base_layout'); ?>

<?= $this->section('content'); ?>

<div class="bg-dark p-4">
    <div class="container">
        <div class="row">
            <div class="col-4 text-center">
                <img src="<?= $artist['artist_image']; ?>" class="img-thumbnail rounded-circle mx-auto" width="230" height="230">
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row mt-4">
        <div class="col-4">
            <div class="user-info mb-4">
                <div class="d-flex flex-column">
                    <div class="d-flex align-items-center justify-content-center">
                        <h1 class="fw-bold"><?= $artist['artist_name'] ?></h1>
                    </div>
                </div>

                <?php if (session()->has('loggedUser')) : ?>
                    <div class="edit-info text-center mt-3">
                        <button type="button" class="btn btn-primary rounded-pill fw-medium px-3">
                            <i class="bi bi-pencil me-2"></i>Edit
                        </button>
                    </div>
                <?php endif ?>

                <?php if ($artist['artist_bio']) : ?>
                    <div class="bg-white rounded-3 p-4 mt-3">
                        <p class="mb-0"><?= $artist['artist_bio'] ?></p>
                    </div>
                <?php endif ?>
            </div>
        </div>

        <div class="col">
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
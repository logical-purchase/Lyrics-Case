<?= $this->extend('layouts/base_layout'); ?>

<?= $this->section('content'); ?>

<?php
// var_dump($userInfo);
// var_dump($song);
// var_dump($videoId);
// var_dump($comments);
?>

<div class="bg-image p-4" style="background-image: url('<?= $song['song_artwork']; ?>');">
    <div class="bg-overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-auto">
                <img src="<?= $song['song_artwork']; ?>" width="250px" alt="">
            </div>
            <div class="col">
                <div class="d-flex flex-column h-100">
                    <h1 class="text-white"><?= $song['song_title']; ?></h1>
                    <?php
                    $artistLinks = [];
                    foreach ($songArtists as $artist) {
                        $artistLinks[] = '<a class="text-info link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="' . base_url("artists/{$artist['id_artist']}") . '">' . esc($artist['artist_name']) . '</a>';
                    }
                    $artistsString = implode(', ', $artistLinks);
                    ?>
                    <h4 class="text-info fw-normal"><?= $artistsString; ?></h4>

                    <small class="text-white mt-auto">
                        <?php if (esc($song['song_date']) != '0000-00-00') : ?>
                            <span class="me-2">
                                <i class="bi bi-calendar4"></i>
                                <?php
                                $formattedDate = date_create($song['song_date'])->format('M. j, Y');
                                echo $formattedDate;
                                ?>
                            </span>
                        <?php endif ?>
                        <span>
                            <i class="bi bi-eye"></i>
                            <?= esc($formattedViews); ?> views
                        </span>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container px-4">

    <div class="d-flex my-3">
        <?php if (session()->has('loggedUser')) : ?>
            <button class="btn btn-primary btn-sm rounded-pill shadow-sm px-3 me-2" data-bs-toggle="modal" data-bs-target="#lyricsModal">Edit lyrics</button>
            <button class="btn btn-primary btn-sm rounded-pill shadow-sm px-3 me-2" data-bs-toggle="modal" data-bs-target="#creditsModal">Edit metadata</button>
            <div class="dropdown">
                <a class="btn btn-primary btn-sm rounded-pill dropdown-toggle shadow-sm px-3" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Admin</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-eye-slash me-2"></i>Hide</a></li>
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#deleteSongModal"><i class="bi bi-x-lg me-2"></i>Delete</a></li>
                </ul>
            </div>
        <?php endif; ?>
    </div>

    <div class="row bg-body rounded-4 mb-3">
        <div class="col-lg-7 p-4 pb-0">
            <div class="d-flex">
                <small>
                    <span class="me-4"><span class="me-1"><?= $song['song_title']; ?></span>lyrics</span>
                    <a class="text-body link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="" data-bs-toggle="modal" data-bs-target="#historyModal"><i class="bi bi-people-fill me-1"></i>Contributions</a>
                </small>
            </div>
            <div style="white-space: pre-line;">
                <p class="mb-0"><?= $song['song_lyrics']; ?></p>
            </div>
        </div>
        <div class="col-lg-auto ms-lg-auto p-4">
            <div class="song-info fw-medium mb-4">
                <span class="text-uppercase">"<?= esc($song['song_title']); ?>" song info</span>
                <div class="row g-0 border-top mt-1">
                    <?php if (esc($song['song_date']) != '0000-00-00') : ?>
                        <div class="col-auto text-info-emphasis me-2">Release date</div>
                        <?php $formattedDate = date_create($formattedDate)->format('F j, Y'); ?>
                        <div class="col"><?php echo $formattedDate; ?></div>
                    <?php endif ?>
                </div>
            </div>
            <?php if ($videoId) : ?>
                <div class="music-video d-flex flex-column border rounded-4 pt-2 pb-3 px-3">
                    <span>
                        <small class="text-uppercase fw-medium">Music video</small>
                    </span>
                    <iframe class="mt-2" src="https://www.youtube.com/embed/<?= esc($videoId) ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
            <?php endif ?>
        </div>
    </div>

    <div class="row my-5">
        <div class="col-lg-7">
            <h1 class="text-center">Comments</h1>
            <div class="d-flex mt-5 mb-4 px-4">
                <?php if (session()->has('loggedUser')) : ?>
                    <img class="rounded-circle me-3" src="<?= esc($userInfo['user_image']); ?>" width="40px" height="40px">
                    <form class="w-100" action="<?= base_url('comments'); ?>" method="post" id="commentForm" autocomplete="off">
                        <input type="hidden" name="songId" value="<?= esc($song['song_id']) ?>">
                        <textarea class="form-control rounded-4 border-0" name="comment" id="commentInput" rows="4" placeholder="Add a comment" style="resize: none; height: fit-content;"></textarea>
                        <button type="submit" class="btn btn-primary btn-sm rounded-pill shadow-sm fw-medium mt-3 px-3" id="submitBtn" hidden>Submit</button>
                        <button class="btn btn-outline-primary btn-sm rounded-pill shadow-sm fw-medium mt-3 px-3" id="cancelBtn" hidden>Cancel</button>
                    </form>
                <?php else : ?>
                    <div class="mx-auto text-uppercase mb-5">
                        <a class="btn btn-primary fw-medium rounded-4" href="<?= base_url('signup'); ?>">Sign up to comment</a>
                    </div>
                <?php endif; ?>
            </div>
            <?php if ($comments) : ?>
                <?php foreach ($comments as $comment) : ?>
                    <div class="comment bg-body rounded-4 mb-4 py-3 px-4">
                        <div class="d-flex align-items-center">
                            <a class="text-decoration-none text-primary-emphasis fw-medium" href="<?= base_url('user/' . $comment['username']); ?>">
                                <img class="rounded-circle me-2" src="<?= esc($comment['user_image']); ?>" width="40px" height="40px">
                                <span>@<?= esc($comment['username']); ?></span>
                            </a>
                            <span class="ms-auto">
                                <small><?= esc($comment['created_at']); ?></small>
                            </span>
                        </div>
                        <div class="comment-content mt-3">
                            <p><?= esc($comment['comment_description']); ?></p>
                        </div>
                        <div class="votes d-flex align-items-center">
                            <button class="btn p-0"><i class="bi bi-hand-thumbs-up"></i></button>
                            <span class="mx-3">13</span>
                            <button class="btn p-0"><i class="bi bi-hand-thumbs-down"></i></button>
                            <?php if (session()->has('loggedUser') && $userInfo['user_id'] === $comment['id_user']) : ?>
                                <button class="btn ms-auto p-0"><i class="bi bi-trash"></i></button>
                            <?php endif ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="no-comments d-flex flex-column text-center fw-medium fs-5">
                    <span>Be the first to comment</span>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>

<div class="modal fade" id="lyricsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= base_url('updateLyrics/' . $song['song_id']); ?>" method="post">
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-header bg-primary-subtle">
                    <h5 class="modal-title text-primary-emphasis">EDIT LYRICS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-info-subtle">
                    <input type="hidden" name="song_id" value="<?= $song['song_id']; ?>">
                    <textarea class="form-control" rows="19" name="lyrics" id="lyricsTextarea" style="resize: none; height: auto;"><?= $song['song_lyrics']; ?></textarea>
                </div>
                <div class="modal-footer bg-info-subtle">
                    <button type="button" class="btn btn-outline-primary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4" id="saveLyricsButton" disabled>Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="creditsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= base_url('updateMetadata/' . $song['song_id']); ?>" method="post" autocomplete="off">
                <div class="modal-header bg-primary-subtle">
                    <h5 class="modal-title text-primary-emphasis">EDIT METADATA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-info-subtle">

                    <input type="hidden" name="_method" value="PUT">

                    <div class="row">
                        <div class="col">
                            <label for="titleInput" class="form-label text-uppercase" style="font-size: smaller;">Title<span class="text-danger ms-1">*</span></label>
                            <input type="text" class="form-control mb-3" name="title" id="titleInput" placeholder="Title" value="<?= $song['song_title']; ?>">
                        </div>
                        <div class="col">
                            <label for="artistInput" class="form-label text-uppercase" style="font-size: smaller;">Artist<span class="text-danger ms-1">*</span></label>
                            <!-- AQUÍ EL SELECT2 CON LOS ARTISTAS -->
                            <select class="form-control" name="artist[]" id="artistInput" multiple="multiple">
                                <?php foreach ($songArtists as $artist) : ?>
                                    <option value="<?= $artist['id_artist']; ?>" selected><?= $artist['artist_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <div class="col-auto">
                                    <img src="<?= $song['song_artwork']; ?>" id="artworkPreview" class="img-thumbnail mb-3" width="100px" alt="">
                                </div>
                                <div class="col">
                                    <label for="artworkInput" class="form-label text-uppercase" style="font-size: smaller;">Artwork</label>
                                    <input type="url" class="form-control" name="artwork" id="artworkInput" placeholder="Enter a URL" value="<?= $song['song_artwork']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <label for="dateInput" class="form-label text-uppercase" style="font-size: smaller;">Release date</label>
                            <input type="date" class="form-control" name="date" id="dateInput" value="<?= $song['song_date']; ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="videoInput" class="form-label text-uppercase" style="font-size: smaller;">YouTube URL</label>
                            <input type="url" class="form-control" name="video" id="videoInput" placeholder="Enter a URL" value="<?= $song['song_video_link']; ?>">
                        </div>
                        <div class="col"></div>
                    </div>

                </div>
                <div class="modal-footer bg-info-subtle">
                    <button type="button" class="btn btn-outline-primary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4" id="saveButton">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="historyModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-body-secondary">
            <div class="modal-header bg-primary-subtle">
                <h5 class="modal-title">CONTRIBUTIONS</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-info-subtle rounded-bottom px-4">
                <h2 class="text-center mt-3 mb-4">Activity history</h2>
                <?php foreach ($activities as $activity) : ?>
                    <?php
                    $createdAt = new \CodeIgniter\I18n\Time($activity['activity_created_at']);
                    $formattedCreatedAt = $createdAt->format('M d, Y h:i:s A');
                    ?>
                    <div class="activity-content bg-body py-2 px-3 mb-2 rounded-3">
                        <div class="row">
                            <div class="col-auto d-flex align-items-center">
                                <?php if ($activity['activity_description'] === 'created') : ?>
                                    <i class="bi bi-file-plus h3 text-body-tertiary mb-0 me-3"></i>
                                <?php elseif ($activity['activity_description'] === 'edited the metadata of' || $activity['activity_description'] === 'edited the lyrics of') : ?>
                                    <i class="bi bi-pencil h3 text-body-tertiary mb-0 me-3"></i>
                                <?php endif ?>
                                <img src="<?= $activity['user_image']; ?>" width="32" height="32" class="rounded-circle">
                            </div>
                            <div class="col">
                                <div class="activity-header d-flex">
                                    <span><?= $activity['username'] . ' ' . $activity['activity_description'];  ?></span>
                                    <div class="ms-auto text-body-tertiary">
                                        <small><?= $formattedCreatedAt; ?></small>
                                    </div>
                                </div>
                                <div class="activity-body">
                                    <h6><?= $song['song_title']; ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade p-4 py-md-5" id="deleteSongModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3 shadow">
            <div class="modal-body p-4 text-center">
                <h4><i class="bi bi-exclamation-triangle text-warning me-2"></i>Confirm deletion</h4>
                <p class="mb-0">Are you absolutely sure you want to delete this song? This cannot be undone</p>
            </div>
            <form action="<?= base_url('songs/' . $song['song_id']); ?>" method="post">
                <input type="hidden" name="_method" value="DELETE">
                <div class="modal-footer flex-nowrap p-0">
                    <button type="button" class="btn btn-lg btn-link link-secondary fs-6 text-decoration-none col-6 py-3 m-0 rounded-0 border-end" data-bs-dismiss="modal">No thanks</button>
                    <button type="submit" class="btn btn-lg btn-link link-danger fs-6 text-decoration-none col-6 py-3 m-0 rounded-0"><strong>I know what I'm doing</strong></button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
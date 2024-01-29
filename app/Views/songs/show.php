<?= $this->extend('layouts/base_layout'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row g-0 mt-4 mb-3">
        <div class="col-auto">
            <img src="<?= $song['song_artwork']; ?>" width="200px" height="200px" class="rounded-3 shadow">
        </div>
        <div class="col text-truncate d-flex flex-column ms-4">
            <div class="d-flex flex-column justify-content-center h-100">
                <h4 class="fw-bold text-truncate"><?= $song['song_title']; ?></h4>
                <?php
                $artistLinks = [];
                foreach ($songArtists as $artist) {
                    $artistLinks[] = '<a class="link-primary link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="' . base_url("artist/{$artist['artist_uuid']}") . '">' . esc($artist['artist_name']) . '</a>';
                }
                $artistsString = implode(', ', $artistLinks);
                ?>
                <span class="fs-5 text-primary text-truncate mb-1"><?= $artistsString; ?></span>
            </div>
            <div class="d-flex">
                <?php if (esc($song['song_date']) != '0000-00-00') : ?>
                    <span class="me-3">
                        <i class="bi bi-calendar4"></i>
                        <?php
                        $formattedDate = date_create($song['song_date'])->format('M. j, Y');
                        echo $formattedDate;
                        ?>
                    </span>
                <?php endif ?>
                <span class="me-3">
                    <i class="bi bi-eye"></i>
                    <?= esc($formattedViews); ?> views
                </span>
                <span class="me-3">
                    <a href="#" class="link-body-emphasis link-underline link-underline-opacity-0 link-underline-opacity-75-hover" data-bs-toggle="modal" data-bs-target="#historyModal">
                        <i class="bi bi-people"></i>
                        Contributions
                    </a>
                </span>
                <?php if (session()->has('_logged_user_id')) : ?>
                    <span class="d-flex">
                        <div class="dropup-center dropup">
                            <a href="#" class="link-body-emphasis link-underline link-underline-opacity-0 link-underline-opacity-75-hover dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-toggles"></i>
                                Manage
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item fw-medium" href="#"><i class="bi bi-eye-slash me-2"></i>Hide</a></li>
                                <li><a class="dropdown-item link-danger fw-medium" href="#" data-bs-toggle="modal" data-bs-target="#deleteSongModal"><i class="bi bi-x-lg me-2"></i>Delete</a></li>
                            </ul>
                        </div>
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-8">
            <div class="bg-body rounded-3 shadow-sm px-3 py-4">
                <div class="d-flex align-items-center">
                    <h5 class="fw-bold mb-0 me-1">Lyrics</h5>
                    <?php if (session()->has('_logged_user_id')) : ?>
                        <button class="btn px-2 py-0" data-bs-toggle="modal" data-bs-target="#lyricsModal">
                            <i class="bi bi-pencil"></i>
                        </button>
                    <?php endif; ?>
                </div>
                <p class="mb-0" style="white-space: pre-line;">
                    <?= $song['song_lyrics']; ?>
                </p>
            </div>
        </div>
        <div class="col-4">
            <div class="bg-body rounded-3 shadow-sm px-3 py-4">
                <div class="song-info fw-medium mb-4">
                    <div class="d-flex align-items-center">
                        <h5 class="fw-bold mb-0 me-1">Info</h5>
                        <?php if (session()->has('_logged_user_id')) : ?>
                            <button class="btn px-2 py-0" data-bs-toggle="modal" data-bs-target="#creditsModal">
                                <i class="bi bi-pencil"></i>
                            </button>
                        <?php endif; ?>
                    </div>

                    <div class="row g-0 border-top mt-1">
                        <?php if (esc($song['song_date']) != '0000-00-00') : ?>
                            <div class="col-auto text-info-emphasis me-2">Release date</div>
                            <?php $formattedDate = date_create($formattedDate)->format('F j, Y'); ?>
                            <div class="col"><?php echo $formattedDate; ?></div>
                        <?php endif ?>
                    </div>
                </div>
                <?php if ($videoId) : ?>
                    <h5 class="fw-bold me-3">Music video</h5>
                    <div class="music-video d-flex flex-column border rounded-3 pt-2 pb-3 px-3">
                        <iframe class="mt-2" src="https://www.youtube.com/embed/<?= esc($videoId) ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>

<div class="container px-4">

    <div class="row my-5">
        <div class="col-lg-7">
            <h1 class="text-center">Comments</h1>
            <div class="d-flex mt-5 mb-4 px-4">
                <?php if (session()->has('_logged_user_id')) : ?>
                    <img class="rounded-circle me-3" src="<?= esc($loggedUser['user_image']); ?>" width="40px" height="40px">
                    <form class="w-100" action="<?= base_url('comments'); ?>" method="post" id="commentForm" autocomplete="off">
                        <input type="hidden" name="songId" value="<?= esc($song['song_id']) ?>">
                        <textarea class="form-control rounded-4 border-0" name="comment" id="commentInput" rows="4" placeholder="Add a comment" style="resize: none; height: fit-content;"></textarea>
                        <button type="submit" class="btn btn-primary btn-sm rounded-pill shadow-sm fw-medium mt-3 px-3" id="submitBtn" hidden>Submit</button>
                        <button class="btn btn-outline-primary btn-sm rounded-pill shadow-sm fw-medium mt-3 px-3" id="cancelBtn" hidden>Cancel</button>
                    </form>
                <?php else : ?>
                    <div class="mx-auto text-uppercase mb-5">
                        <a class="btn btn-primary fw-medium" href="<?= base_url('signup'); ?>">Sign up to comment</a>
                    </div>
                <?php endif; ?>
            </div>
            <?php if ($comments) : ?>
                <?php foreach ($comments as $comment) : ?>
                    <div class="comment bg-body rounded-3 shadow-sm mb-3 py-3 px-4">
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
                            <?php if (session()->has('_logged_user_id') && $loggedUser['user_id'] === $comment['id_user']) : ?>
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
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit lyrics</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="song_id" value="<?= $song['song_id']; ?>">
                    <textarea class="form-control" rows="19" name="lyrics" id="lyricsTextarea" style="resize: none; height: auto;"><?= $song['song_lyrics']; ?></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light fw-medium" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary fw-medium" id="saveLyricsButton" disabled>Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="creditsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= base_url('updateMetadata/' . $song['song_id']); ?>" method="post" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="_method" value="PUT">

                    <div class="title-artists-section mb-4">
                        <h5 class="text-center fw-bold">Title & Credits</h5>
                        <div class="row g-3 mb-3">
                            <div class="col-lg">
                                <label for="titleInput" class="form-label fw-medium">Title<span class="text-danger ms-1">*</span></label>
                                <input type="text" class="form-control mb-3" name="title" id="titleInput" placeholder="Title" value="<?= $song['song_title']; ?>">
                            </div>
                            <div class="col">
                                <label for="artistInput" class="form-label fw-medium">Artist<span class="text-danger ms-1">*</span></label>
                                <!-- AQUÍ EL SELECT2 CON LOS ARTISTAS -->
                                <select class="form-control" name="artist[]" id="artistInput" multiple="multiple">
                                    <?php foreach ($songArtists as $artist) : ?>
                                        <option value="<?= $artist['id_artist']; ?>" selected><?= $artist['artist_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-lg">
                                <label for="featuringInput" class="form-label fw-medium">Featuring</label>
                                <select class="form-control" name="featuring[]" id="featuringInput" multiple="multiple">
                                    <!--  -->
                                </select>
                            </div>
                            <div class="col">
                                <label for="writerInput" class="form-label fw-medium">Writer</label>
                                <select class="form-control" name="writer[]" id="writerInput" multiple="multiple">
                                    <!--  -->
                                </select>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-lg">
                                <label for="producerInput" class="form-label fw-medium">Producer</label>
                                <select class="form-control" name="producer[]" id="producerInput" multiple="multiple">
                                    <!--  -->
                                </select>
                            </div>
                            <div class="col"></div>
                        </div>
                    </div>

                    <div class="media-section mb-4">
                        <h5 class="text-center fw-bold">Media</h5>
                        <div class="row g-3">
                            <div class="col-lg">
                                <div class="row">
                                    <div class="col-auto">
                                        <img src="<?= $song['song_artwork']; ?>" id="artworkPreview" class="img-thumbnail mb-3" width="100px" alt="">
                                    </div>
                                    <div class="col">
                                        <label for="artworkInput" class="form-label fw-medium">Artwork</label>
                                        <input type="url" class="form-control" name="artwork" id="artworkInput" placeholder="Enter a URL" value="<?= $song['song_artwork']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <label for="videoInput" class="form-label fw-medium">YouTube URL</label>
                                <input type="url" class="form-control" name="video" id="videoInput" placeholder="Enter a URL" value="<?= $song['song_video_link']; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="metadata-section mb-4">
                        <h5 class="text-center fw-bold">Metadata</h5>
                        <div class="row g-3">
                            <div class="col-lg">
                                <label for="dateInput" class="form-label fw-medium">Release date</label>
                                <input type="date" class="form-control" name="date" id="dateInput" value="<?= $song['song_date']; ?>">
                            </div>
                            <div class="col"></div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light fw-medium" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary fw-medium" id="saveButton">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="historyModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Contributions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-body-secondary rounded-bottom px-4">
                <h2 class="text-center mt-3 mb-4">Activity history</h2>
                <?php foreach ($activities as $activity) : ?>
                    <?php
                    $createdAt = new \CodeIgniter\I18n\Time($activity['activity_created_at']);
                    $formattedCreatedAt = $createdAt->format('M d, Y h:i:s A');
                    ?>
                    <div class="activity-content bg-body py-2 px-3 mb-2 rounded-3">
                        <div class="row">
                            <div class="col-auto d-flex align-items-center">
                                <img src="<?= $activity['user_image']; ?>" width="32" height="32" class="rounded-circle me-3">
                                <?php if ($activity['activity_description'] === 'created') : ?>
                                    <i class="bi bi-file-plus h3 text-body-tertiary mb-0"></i>
                                <?php elseif ($activity['activity_description'] === 'edited the metadata of' || $activity['activity_description'] === 'edited the lyrics of') : ?>
                                    <i class="bi bi-pencil h3 text-body-tertiary mb-0"></i>
                                <?php endif ?>
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

<!-- ACTIVAR BOTÓN MODAL LETRAS -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var lyricsTextarea = document.getElementById('lyricsTextarea');
        var saveLyricsButton = document.getElementById('saveLyricsButton');

        var initialLyricsValue = lyricsTextarea.value;

        function checkLyricsChanges() {
            var lyricsChanged = lyricsTextarea.value !== initialLyricsValue;

            saveLyricsButton.disabled = !lyricsChanged;
        }

        lyricsTextarea.addEventListener('input', checkLyricsChanges);
    });
</script>

<!-- SELECT ARTISTS -->
<script>
    $(document).ready(function() {
        $('#artistInput').select2({
            theme: 'bootstrap-5',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            tags: true,
            minimumInputLength: 2,
            ajax: {
                url: '<?= base_url('getartists'); ?>',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                    };
                },
                processResults: function(data) {
                    return {
                        results: data,
                    };
                },
                cache: true
            },
            insertTag: function(data, tag) {
                data.push(tag);
            },
            templateResult: formatArtist,
            placeholder: "Search the primary artist"
        });

        $('#featuringInput').select2({
            theme: 'bootstrap-5',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            tags: true,
            minimumInputLength: 2,
            ajax: {
                url: '<?= base_url('getartists'); ?>',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                    };
                },
                processResults: function(data) {
                    return {
                        results: data,
                    };
                },
                cache: true
            },
            insertTag: function(data, tag) {
                data.push(tag);
            },
            templateResult: formatArtist,
            placeholder: "Search featured artists"
        });

        $('#writerInput').select2({
            theme: 'bootstrap-5',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            tags: true,
            minimumInputLength: 2,
            ajax: {
                url: '<?= base_url('getartists'); ?>',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                    };
                },
                processResults: function(data) {
                    return {
                        results: data,
                    };
                },
                cache: true
            },
            insertTag: function(data, tag) {
                data.push(tag);
            },
            templateResult: formatArtist,
            placeholder: "Search song writers"
        });

        $('#producerInput').select2({
            theme: 'bootstrap-5',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            tags: true,
            minimumInputLength: 2,
            ajax: {
                url: '<?= base_url('getartists'); ?>',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                    };
                },
                processResults: function(data) {
                    return {
                        results: data,
                    };
                },
                cache: true
            },
            insertTag: function(data, tag) {
                data.push(tag);
            },
            templateResult: formatArtist,
            placeholder: "Search song producers"
        });

        function formatArtist(artist) {
            var $result = $(
                '<span>' +
                (artist.image ? '<img class="artist-image rounded-circle me-2" src="' + artist.image + '" width="30px" />' : '') +
                artist.text +
                '</span>'
            );

            return $result;
        }
    });
</script>

<!-- ACTUALIZAR PREVIEW DEL ARTWORK -->
<script>
    function updateArtworkPreview() {
        // Obtiene la URL del campo de entrada
        var artworkUrl = document.getElementById('artworkInput').value;

        // Actualiza la vista previa de la imagen
        var artworkPreview = document.getElementById('artworkPreview');
        artworkPreview.src = artworkUrl;
    }

    // Agrega el evento onpaste al campo de entrada
    document.getElementById('artworkInput').addEventListener('paste', function(event) {
        // Espera un breve momento para que el valor se actualice después de pegar
        setTimeout(updateArtworkPreview, 100);
    });
</script>

<!-- EVITAR COMENTARIOS VACÍOS -->
<script>
    document.getElementById('commentForm').addEventListener('submit', function(event) {
        // Obtén el valor del input de búsqueda
        var query = document.getElementById('commentInput').value;

        // Verifica si la consulta contiene solo espacios en blanco
        if (query.trim() === '') {
            // Evita que el formulario se envíe
            event.preventDefault();
        }
    });
</script>

<!-- MOSTRAR/OCULTAR BOTONES DE COMENTARIOS -->
<script>
    $(document).ready(function() {
        // Al hacer clic en el textarea, muestra los botones
        $('#commentInput').on('focus', function() {
            $('#submitBtn, #cancelBtn').removeAttr('hidden');
        });

        // Al hacer clic en Cancel, oculta los botones y limpia el contenido del textarea
        $('#cancelBtn').on('click', function(e) {
            e.preventDefault();
            $('#submitBtn, #cancelBtn').attr('hidden', 'hidden');
            $('#commentInput').val('');
        });
    });
</script>

<?= $this->endSection(); ?>
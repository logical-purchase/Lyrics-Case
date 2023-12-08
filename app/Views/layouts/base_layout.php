<!DOCTYPE html>
<html lang="en" data-bs-theme="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
    <style>
        .bg-image {
            filter: brightness(100%);
            background-size: cover;
            background-position: center;
        }

        .bg-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: -1;
        }
    </style>
</head>

<body class="bg-info-subtle d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg bg-primary-subtle sticky-top rounded-bottom-4">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold user-select-none" href="<?= base_url('songs') ?>"><i class="bi bi-chat-square-quote mx-2"></i>LYRICS CASE</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php if (session()->has('loggedUser')) : ?>
                        <li class="nav-item">
                            <a class="nav-link fw-bold" aria-current="page" href="<?= base_url('/new') ?>">ADD A SONG</a>
                        </li>
                    <?php endif; ?>
                </ul>
                <form class="d-flex" id="searchForm" action="<?= base_url('search'); ?>" method="get" role="search" autocomplete="off">
                    <input class="form-control rounded-pill border-0 focus-ring focus-ring-secondary me-2" type="search" name="q" id="searchInput" placeholder="Search lyrics" aria-label="Search" value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>" required>
                </form>
                <?php if (session()->has('loggedUser')) : ?>
                    <div class="dropdown text-end">
                        <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?= $userInfo['user_image']; ?>" width="32" height="32" class="rounded-circle">
                            <span class="ms-2 fw-bold" style="font-size: smaller;"><?= $userInfo['user_points']; ?></span>
                            <span class="fw-bold" style="font-size: smaller;">PTS</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end text-small">
                            <li>
                                <a class="dropdown-item" href="<?= base_url('user/' . $userInfo['username']); ?>"><i class="bi bi-person-circle me-2"></i>View profile</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#"><i class="bi bi-gear-fill me-2"></i>Settings</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="<?= base_url('logout'); ?>" method="post">
                                    <input type="hidden" name="redirect_url" value="<?= current_url(); ?>">
                                    <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                <?php else : ?>
                    <div class="text-end text-uppercase">
                        <a class="btn btn-outline-primary btn-sm fw-medium mx-1" href="<?= base_url('login'); ?>">Sign in</a>
                        <a class="btn btn-primary btn-sm fw-medium me-2" href="<?= base_url('signup'); ?>">Sign up</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <?= $this->renderSection('content') ?>
    <footer class="bg-black py-3 mt-auto">
        <div class="container">
            <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                <li class="nav-item">
                    <a href="<?= base_url('songs') ?>" class="nav-link px-2 text-white">Home</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link px-2 text-white">Guidelines</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link px-2 text-white">FAQs</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link px-2 text-white">About</a>
                </li>
            </ul>
            <p class="text-center text-white">
                &copy; 2023 Lyrics Case
            </p>
        </div>
    </footer>

    <div class="modal fade" id="loginModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">SIGN IN</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>

    <div class="toast-container position-fixed top-0 end-0 p-3">
        <?php if (!empty(session()->getFlashdata('success'))) : ?>
            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
                <div class="toast-header">
                    <small class="me-auto">Just now</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body h5">
                    <i class="bi bi-check-circle text-success me-2"></i>
                    <?= session()->getFlashdata('success'); ?>
                </div>
            </div>
        <?php endif ?>
    </div>

    <!-- BOOTSTRAP -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- JQUERY UI -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js" integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>

    <!-- SELECT2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- LIVE TOAST -->
    <?php if (!empty(session()->getFlashdata('success'))) : ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var myToast = new bootstrap.Toast(document.getElementById('liveToast'));
                myToast.show();
            });
        </script>
    <?php endif ?>

    <!-- EVITAR BUSQUEDAS VACÍAS -->
    <script>
        document.getElementById('searchForm').addEventListener('submit', function(event) {
            // Obtén el valor del input de búsqueda
            var query = document.getElementById('searchInput').value;

            // Verifica si la consulta contiene solo espacios en blanco
            if (query.trim() === '') {
                // Evita que el formulario se envíe
                event.preventDefault();
            }
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
            $('#artistSelect').select2({
                tags: true,
                tokenSeparators: [','],
                ajax: {
                    url: '<?= base_url('getartists'); ?>',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });

            $('#artistInput').select2({
                tags: true,
                tokenSeparators: [','],
                dropdownParent: '#creditsModal',
                ajax: {
                    url: '<?= base_url('getartists'); ?>',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });
        });
    </script>

</body>

</html>
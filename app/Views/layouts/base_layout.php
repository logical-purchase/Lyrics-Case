<!DOCTYPE html>
<html lang="en" data-bs-theme="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <!-- STYLES -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js" integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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

        .select2-selection__choice {
            background-color: var(--bs-gray-200);
            border: none !important;
            font-size: 12px;
            font-size: 0.85rem !important;
        }
    </style>
</head>

<body class="bg-body-secondary d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg bg-body sticky-top shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-primary user-select-none py-0" href="<?= base_url() ?>">
                <div class="d-flex align-items-center text-uppercase">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 600 600" version="1.1" class="mx-2">
                        <path d="M 263.112 127.581 C 254.139 129.994, 246.186 137.287, 243.027 146 C 242.329 147.925, 241.532 155.881, 241.255 163.679 L 240.752 177.859 188.626 178.200 C 138.078 178.531, 136.325 178.607, 130.725 180.704 C 119.277 184.991, 111.027 193.247, 106.661 204.787 C 104.510 210.473, 104.499 210.947, 104.216 303.877 C 104.048 359.008, 104.320 400.058, 104.880 404.100 C 106.808 418.010, 114.780 429.305, 126.874 435.259 L 133.458 438.500 300 438.500 L 466.542 438.500 473.126 435.259 C 485.220 429.305, 493.192 418.010, 495.120 404.100 C 495.680 400.058, 495.952 359.008, 495.784 303.877 C 495.500 210.660, 495.496 210.490, 493.317 204.725 C 488.973 193.233, 480.708 184.989, 469.213 180.682 C 463.690 178.612, 461.759 178.530, 411.250 178.199 L 359 177.858 359 166.139 C 359 152.309, 357.293 144.628, 352.843 138.431 C 348.871 132.901, 343.541 129.376, 336.294 127.488 C 328.193 125.378, 271.033 125.451, 263.112 127.581 M 263.923 148.923 L 261 151.846 261 164.923 L 261 178 300 178 L 339 178 339 164.923 L 339 151.846 336.077 148.923 L 333.154 146 300 146 L 266.846 146 263.923 148.923 M 166 309 L 166 420 175.500 420 L 185 420 185 309 L 185 198 175.500 198 L 166 198 166 309 M 415 309 L 415 420 424.500 420 L 434 420 434 309 L 434 198 424.500 198 L 415 198 415 309 M 213 271.500 L 213 308 238 308 L 263 308 263 311.790 C 263 313.874, 262.302 318.260, 261.449 321.535 C 256.351 341.106, 239.150 355.963, 218.621 358.528 L 213 359.230 213 371.115 C 213 377.754, 213.409 383, 213.928 383 C 214.438 383, 218.375 382.512, 222.678 381.915 C 251.627 377.902, 274.621 358.283, 284.111 329.500 C 286.353 322.698, 286.429 321.262, 286.775 278.750 L 287.132 235 250.066 235 L 213 235 213 271.500 M 313 271.483 L 313 307.965 337.750 308.233 L 362.500 308.500 362.240 313.500 C 361.632 325.201, 354.034 339.741, 344.608 347.244 C 337.848 352.625, 328.656 356.722, 320.024 358.203 L 313 359.407 313 371.204 C 313 377.692, 313.192 383, 313.428 383 C 313.663 383, 317.375 382.529, 321.678 381.953 C 339.173 379.611, 351.739 373.316, 364.500 360.503 C 374.788 350.172, 380.578 340.422, 384.165 327.385 C 386.197 320.002, 386.361 316.812, 386.735 277.250 L 387.136 235 350.068 235 L 313 235 313 271.483" stroke="none" fill="#fafbfb" fill-rule="evenodd" />
                        <path d="M 277 0.589 C 275.075 0.810, 269.225 1.478, 264 2.073 C 209.484 8.280, 156.162 30.872, 111 66.896 C 98.674 76.729, 76.622 98.816, 66.487 111.481 C 48.308 134.200, 29.844 166.190, 19.550 192.804 C 11.887 212.619, 5.330 238.986, 1.845 264 C 0.072 276.723, 0.072 323.277, 1.845 336 C 9.961 394.255, 31.249 444.483, 66.487 488.519 C 76.731 501.319, 98.681 523.269, 111.481 533.513 C 148.594 563.211, 194.322 584.855, 239.109 593.921 C 274.891 601.164, 313.896 601.855, 350 595.887 C 478.823 574.589, 580.189 469.559, 597.506 339.435 C 598.306 333.421, 598.970 326.363, 598.980 323.750 C 598.991 321.137, 599.450 319, 600 319 C 600.634 319, 600.994 311.594, 600.985 298.750 C 600.975 285.306, 600.644 279.004, 600 280 C 599.298 281.086, 599.026 280.204, 599.015 276.801 C 598.992 269.701, 596.223 250, 593.426 237.040 C 574.041 147.202, 514.852 71.428, 432.500 31.022 C 401.160 15.646, 375.518 7.721, 340 2.436 C 330.021 0.951, 285.270 -0.361, 277 0.589 M 263.112 127.581 C 254.139 129.994, 246.186 137.287, 243.027 146 C 242.329 147.925, 241.532 155.881, 241.255 163.679 L 240.752 177.859 188.626 178.200 C 138.078 178.531, 136.325 178.607, 130.725 180.704 C 119.277 184.991, 111.027 193.247, 106.661 204.787 C 104.510 210.473, 104.499 210.947, 104.216 303.877 C 104.048 359.008, 104.320 400.058, 104.880 404.100 C 106.808 418.010, 114.780 429.305, 126.874 435.259 L 133.458 438.500 300 438.500 L 466.542 438.500 473.126 435.259 C 485.220 429.305, 493.192 418.010, 495.120 404.100 C 495.680 400.058, 495.952 359.008, 495.784 303.877 C 495.500 210.660, 495.496 210.490, 493.317 204.725 C 488.973 193.233, 480.708 184.989, 469.213 180.682 C 463.690 178.612, 461.759 178.530, 411.250 178.199 L 359 177.858 359 166.139 C 359 152.309, 357.293 144.628, 352.843 138.431 C 348.871 132.901, 343.541 129.376, 336.294 127.488 C 328.193 125.378, 271.033 125.451, 263.112 127.581 M 263.923 148.923 L 261 151.846 261 164.923 L 261 178 300 178 L 339 178 339 164.923 L 339 151.846 336.077 148.923 L 333.154 146 300 146 L 266.846 146 263.923 148.923 M 166 309 L 166 420 175.500 420 L 185 420 185 309 L 185 198 175.500 198 L 166 198 166 309 M 415 309 L 415 420 424.500 420 L 434 420 434 309 L 434 198 424.500 198 L 415 198 415 309 M 213 271.500 L 213 308 238 308 L 263 308 263 311.790 C 263 313.874, 262.302 318.260, 261.449 321.535 C 256.351 341.106, 239.150 355.963, 218.621 358.528 L 213 359.230 213 371.115 C 213 377.754, 213.409 383, 213.928 383 C 214.438 383, 218.375 382.512, 222.678 381.915 C 251.627 377.902, 274.621 358.283, 284.111 329.500 C 286.353 322.698, 286.429 321.262, 286.775 278.750 L 287.132 235 250.066 235 L 213 235 213 271.500 M 313 271.483 L 313 307.965 337.750 308.233 L 362.500 308.500 362.240 313.500 C 361.632 325.201, 354.034 339.741, 344.608 347.244 C 337.848 352.625, 328.656 356.722, 320.024 358.203 L 313 359.407 313 371.204 C 313 377.692, 313.192 383, 313.428 383 C 313.663 383, 317.375 382.529, 321.678 381.953 C 339.173 379.611, 351.739 373.316, 364.500 360.503 C 374.788 350.172, 380.578 340.422, 384.165 327.385 C 386.197 320.002, 386.361 316.812, 386.735 277.250 L 387.136 235 350.068 235 L 313 235 313 271.483 M 0.422 300 C 0.422 311.275, 0.568 315.887, 0.746 310.250 C 0.924 304.613, 0.924 295.387, 0.746 289.750 C 0.568 284.113, 0.422 288.725, 0.422 300" stroke="none" fill="#0c6cfb" fill-rule="evenodd" />
                    </svg>
                    Lyrics Case
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php if (session()->has('loggedUser')) : ?>
                        <?php if ($userInfo['id_role'] == 5) : ?>
                            <li class="nav-item">
                                <a class="nav-link fw-bold" aria-current="page" href="<?= base_url('/new') ?>">ADD A SONG</a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
                <form class="d-flex" id="searchForm" action="<?= base_url('search'); ?>" method="get" role="search" autocomplete="off">

                    <input class="form-control bg-body-secondary rounded-pill border-0 focus-ring focus-ring-light me-2" type="search" name="q" id="searchInput" placeholder="Search lyrics" aria-label="Search" value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>" required>

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
                                <a class="dropdown-item" href="<?= base_url('settings'); ?>"><i class="bi bi-gear me-2"></i>Settings</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= base_url('test'); ?>"><i class="bi bi-columns-gap me-2"></i>Test page</a>
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
                        <a class="btn btn-outline-primary btn-sm fw-medium mx-1" href="<?= base_url('login'); ?>">Log in</a>
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


</body>

</html>
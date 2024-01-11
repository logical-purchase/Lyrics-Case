<?= $this->extend('layouts/base_layout'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row g-0 mt-4 mb-3">
        <div class="col-auto">
            <img src="https://is1-ssl.mzstatic.com/image/thumb/Music124/v4/81/89/01/81890194-5686-d230-1979-110978d253da/195497370757.jpg/1000x1000bb.png" width="200px" height="200px" class="rounded-3 shadow">
        </div>
        <div class="col text-truncate d-flex flex-column ms-4">
            <div class="d-flex flex-column justify-content-center h-100">
                <h4 class="fw-bold text-truncate">Los Jefes - Banda Sonora de la Película (feat. Sonido Caballero, Big Man & Campa) [Gift Track]</h4>
                <span class="fs-5 text-primary text-truncate mb-1">E. Dávalos, R. Rodríguez, M. Soria, Cartel de Santa, Millonario, Millonario & W. Corona, Draw</span>
            </div>
            <div class="d-flex">
                <span class="me-3">
                    <i class="bi bi-calendar4"></i>
                    <span>Jun. 17, 2016</span>
                </span>
                <span class="me-3">
                    <i class="bi bi-eye"></i>
                    <span>403 views</span>
                </span>
                <span>
                    <i class="bi bi-people"></i>
                    <span>Contributions</span>
                </span>
            </div>
        </div>
    </div>
    <div class="row g-3">
        <div class="col-8">
            <div class="bg-body rounded-3 shadow-sm px-3 py-4">
                <h1 class="mb-0">Hola 3</h1>
            </div>
        </div>
        <div class="col">
            <div class="bg-body rounded-3 shadow-sm px-3 py-4">
                <h1 class="mb-0">Hola 4</h1>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
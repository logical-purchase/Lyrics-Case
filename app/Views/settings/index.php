<?= $this->extend('layouts/base_layout'); ?>

<?= $this->section('content'); ?>

<div class="row g-0">
    <div class="col-auto">
        <div class="bg-body p-4">
            <h3 class="fw-bold mb-4">Settings & preferences</h3>
            <ul class="nav nav-pills flex-column fw-medium">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Account</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Roles</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="col p-4">
        <div class="bg-body rounded-3 shadow-sm p-4">
            <h4>Roles</h4>
            <ul class="nav nav-tabs nav-fill my-3" id="rolesTab" role="tablist">
                <?php $firstIteration = true;
                foreach ($roles as $role) :
                    $isActive = $firstIteration ? 'active' : ''; ?>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?= esc($isActive) ?>" id="<?= esc($role['role_name']) ?>-tab" data-bs-toggle="tab" data-bs-target="#<?= esc($role['role_name']) ?>-tab-pane" type="button" role="tab" aria-controls="<?= esc($role['role_name']) ?>-tab-pane"><?= esc($role['role_name']) ?></button>
                    </li>
                <?php $firstIteration = false;
                endforeach ?>
            </ul>
            <div class="tab-content" id="rolesTabContent">
                <?php $firstIteration = true;
                foreach ($roles as $role) :
                    $isActive = $firstIteration ? 'show active' : ''; ?>
                    <div class="tab-pane fade <?= esc($isActive) ?>" id="<?= esc($role['role_name']) ?>-tab-pane" role="tabpanel" aria-labelledby="<?= esc($role['role_name']) ?>-tab" tabindex="0">
                    </div>
                <?php $firstIteration = false;
                endforeach ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
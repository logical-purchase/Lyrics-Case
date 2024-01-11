<?= $this->extend('layouts/base_layout'); ?>

<?= $this->section('content'); ?>

<?php
//var_dump($roles);
//var_dump($permissions);
?>

<div class="row g-0">
    <div class="col-auto">
        <div class="bg-body vh-100 p-4">
            <h3 class="fw-bold">Settings & preferences</h3>
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="#">Roles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item mb-auto">
                    <a class="nav-link" href="#">Link</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="col p-4">
        <div class="bg-body rounded-3 shadow-sm p-4">
            <h4>Role permissions</h4>
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
                        <form action="<?= base_url('roles/updatePermissions'); ?>" method="post">
                            <input type="hidden" name="role_id" value="<?= esc($role['role_id']); ?>">
                            <?php $permissionIds = explode(',', $role['permission_ids']); ?>
                            <?php foreach ($permissions as $permission) :
                                $isChecked = in_array($permission['permission_id'], $permissionIds) ? 'checked' : ''; ?>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="<?= esc($permission['permission_id']); ?>" role="switch" id="<?= esc($permission['camel_case_name']); ?>" <?= esc($isChecked); ?>>
                                    <label class="form-check-label" for="<?= esc($permission['camel_case_name']); ?>"><?= esc($permission['permission_name']); ?></label>
                                </div>
                            <?php endforeach ?>
                            <button type="submit" class="btn btn-primary fw-medium mt-3">Save changes</button>
                        </form>
                    </div>
                <?php $firstIteration = false;
                endforeach ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
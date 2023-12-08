<?= $this->extend('layouts/base_layout'); ?>

<?= $this->section('content'); ?>

<?php
// var_dump($userInfo);
// var_dump($user);
// var_dump($userRoles);
// var_dump($roles);
// var_dump($activities);
?>

<div class="bg-dark p-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 text-center">
                <img src="<?= $user['user_image']; ?>" class="img-thumbnail rounded-circle mx-auto" width="200" height="200">
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row mt-4">
        <div class="col-lg-4">
            <div class="user-info mb-4">
                <div class="d-flex flex-column">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <h4 class="me-2 mb-0">@<?= $user['username'] ?></h4>
                        <span class="badge text-bg-primary"><?= $user['user_points'] ?></span>
                    </div>
                    <?php if ($userRoles) : ?>
                        <div class="dropdown text-center">
                            <span class="dropdown-toggle text-info-emphasis fw-medium" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                <?php if (!empty($userRoles)) : ?>
                                    <?= esc($userRoles[0]['role_name']); ?>
                                <?php else : ?>
                                    No roles
                                <?php endif; ?>
                            </span>
                            <ul class="dropdown-menu">
                                <?php foreach ($userRoles as $userRole) : ?>
                                    <li class="dropdown-item-text fw-medium"><?= esc($userRole['role_name']); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif ?>
                </div>

                <?php if (session()->has('loggedUser')) : ?>
                    <div class="edit-info text-center mt-3">
                        <?php if ($userInfo['user_id'] === $user['user_id']) : ?>
                            <button type="button" class="btn btn-primary rounded-pill shadow-sm fw-medium px-3">
                                <i class="bi bi-pencil me-2"></i>Edit profile
                            </button>
                        <?php endif ?>
                    </div>
                <?php endif ?>

                <div class="bg-body rounded-3 p-4 mt-3">
                    <?php if ($user['user_bio']) : ?>
                        <p class="mb-0"><?= $user['user_bio'] ?></p>
                    <?php else : ?>
                        <p class="mb-0"><?= $user['username'] ?> is keeping quiet for now.</p>
                    <?php endif ?>
                </div>
            </div>

            <?php if (session()->has('loggedUser')) : ?>
                <div class="manage-role mb-4">
                    <span class="h6 text-info-emphasis text-uppercase user-select-none">Manage roles</span>
                    <div class="bg-body rounded-3 mt-2 p-4 fw-medium">

                        <?php foreach ($roles as $role) : ?>
                            <?php $userHasRole = false; ?>
                            <?php foreach ($userRoles as $userRole) : ?>
                                <?php if ($userRole['role_name'] === $role['role_name']) : ?>
                                    <?php
                                    $createdAt = new \CodeIgniter\I18n\Time($userRole['ur_created_at']);
                                    $formattedCreatedAt = $createdAt->format('M d, Y h:i:s A');
                                    ?>
                                    <?php $userHasRole = true; ?>
                                    <div class="role-info mb-3">
                                        <div class="d-flex align-items-center">
                                            <p class="mb-0"><?= esc($role['role_name']); ?></p>
                                            <button type="button" class="btn btn-outline-primary rounded-pill fw-medium text-start ms-auto px-3" data-bs-toggle="modal" data-bs-target="#removeRoleModal">
                                                Remove role
                                            </button>
                                        </div>
                                        <p class="fw-normal mt-1 mb-0"><a href="<?= base_url($userRole['granter']); ?>"><?= esc($userRole['granter']); ?></a> granted <?= esc($user['username']); ?> the <?= esc($role['role_name']); ?> role at <?= $formattedCreatedAt; ?>.</p>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>

                            <?php if (!$userHasRole) : ?>
                                <button type="button" class="btn btn-primary rounded-pill fw-medium mb-3 w-100" data-bs-toggle="modal" data-bs-target="#grantRoleModal" data-role-id="<?= esc($role['role_id']); ?>">
                                    Grant <?= esc($user['username']); ?> the <?= esc($role['role_name']); ?> role
                                </button>
                            <?php endif; ?>
                        <?php endforeach; ?>

                    </div>
                </div>

                <?php if ($userInfo['user_id'] != $user['user_id']) : ?>
                    <div class="moderation mb-4">
                        <span class="h6 text-info-emphasis text-uppercase">Moderation</span>
                        <div class="bg-white rounded-3 p-4 mt-2 fw-medium">
                            <a class="link-danger text-uppercase text-decoration-none" href=""><i class="bi bi-exclamation-triangle me-1"></i>Ban @<?= $user['username'] ?></a>
                        </div>
                    </div>
                <?php endif ?>
            <?php endif ?>
        </div>

        <div class="col">
            <?php if (!$activities) : ?>
                <div class="activity-content d-flex justify-content-center">
                    <span class="h6 text-uppercase user-select-none"><?= $user['username'] ?> has no contributions</span>
                </div>
            <?php else : ?>
                <span class="h6 text-info-emphasis text-uppercase">@<?= $user['username'] ?>'s contributions</span>
                <?php foreach ($activities as $activity) : ?>
                    <?php
                    $createdAt = new \CodeIgniter\I18n\Time($activity['activity_created_at']);
                    $formattedCreatedAt = $createdAt->format('M d, Y h:i:s A');
                    ?>
                    <div class="activity-content bg-body py-2 px-3 my-2 rounded-3">
                        <div class="row">
                            <div class="col-auto d-flex align-items-center">
                                <?php if ($activity['activity_description'] === 'created') : ?>
                                    <i class="bi bi-file-plus h3 text-body-tertiary ms-2 mb-0"></i>
                                <?php elseif ($activity['activity_description'] === 'edited the metadata of' || $activity['activity_description'] === 'edited the lyrics of') : ?>
                                    <i class="bi bi-pencil h3 text-body-tertiary ms-2 mb-0"></i>
                                <?php elseif ($activity['activity_description'] === 'commented on') : ?>
                                    <i class="bi bi-chat-left-text h3 text-body-tertiary ms-2 mb-0"></i>
                                <?php endif ?>
                            </div>
                            <div class="col">
                                <div class="activity-header d-flex">
                                    <span><?= $user['username'] . ' ' . $activity['activity_description'];  ?></span>
                                    <div class="ms-auto text-body-tertiary">
                                        <small><?= $formattedCreatedAt; ?></small>
                                    </div>
                                </div>
                                <div class="activity-body">
                                    <h6><?= $activity['artist_names']; ?> - <?= $activity['song_title']; ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php endif ?>
        </div>
    </div>
</div>

<?php if (session()->has('loggedUser')) : ?>
    <div class="modal fade p-4 py-md-5" id="grantRoleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 shadow">
                <div class="modal-body p-4 text-center">
                    <h4><i class="bi bi-exclamation-triangle text-warning me-2"></i>Confirm promotion</h4>
                    <p class="mb-0">Are you sure you want to promote this user?</p>
                </div>
                <form action="<?= base_url('promote'); ?>" method="post">
                    <input type="hidden" name="user_id" id="userIdInput" value="<?= esc($user['user_id']); ?>">
                    <input type="hidden" name="role_id" id="roleIdInput" value="">
                    <input type="hidden" name="granter_id" id="granterIdInput" value="<?= esc($userInfo['user_id']); ?>">
                    <div class="modal-footer flex-nowrap p-0">
                        <button type="button" class="btn btn-lg btn-link link-secondary fs-6 text-decoration-none col-6 py-3 m-0 rounded-0 border-end" data-bs-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-lg btn-link link-primary fs-6 text-decoration-none col-6 py-3 m-0 rounded-0"><strong>Yes</strong></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade p-4 py-md-5" id="removeRoleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 shadow">
                <div class="modal-body p-4 text-center">
                    <h4><i class="bi bi-exclamation-triangle text-warning me-2"></i>Confirm demotion</h4>
                    <p class="mb-0">Are you sure you want to demote this user?</p>
                </div>
                <form action="" method="post">
                    <input type="hidden" name="_method" value="DELETE">
                    <div class="modal-footer flex-nowrap p-0">
                        <button type="button" class="btn btn-lg btn-link link-secondary fs-6 text-decoration-none col-6 py-3 m-0 rounded-0 border-end" data-bs-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-lg btn-link link-warning fs-6 text-decoration-none col-6 py-3 m-0 rounded-0"><strong>Yes</strong></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var grantRoleModal = new bootstrap.Modal(document.getElementById('grantRoleModal'));

        var grantRoleButtons = document.querySelectorAll('[data-bs-target="#grantRoleModal"]');
        var grantRoleIdInput = document.getElementById('roleIdInput');

        grantRoleButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var roleId = button.getAttribute('data-role-id');
                grantRoleIdInput.value = roleId;
                grantRoleModal.show();
            });
        });
    });
</script>

<?= $this->endSection(); ?>
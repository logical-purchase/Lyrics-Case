<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in! Lyrics Case</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body class="bg-info-subtle d-flex justify-content-center my-3">
    <div class="card bg-body shadow-sm w-lg-50">
        <div class="card-body">
            <main class="form-signin mt-5 px-4">
                <h2 class="fw-bolder text-center mb-5"><i class="bi bi-chat-square-quote mx-2"></i><span class="text-primary">LYRICS</span>CASE</h2>
                <form action="<?= base_url('check'); ?>" method="post" autocomplete="off">
                    <?= csrf_field(); ?>

                    <?php if (!empty(session()->getFlashdata('fail'))) : ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
                    <?php endif ?>

                    <input type="text" class="form-control" name="username" placeholder="Username" value="<?= set_value('username'); ?>">
                    <span class="text-danger"><?= isset($validation) ? $validation->getError('username') : '' ?></span>

                    <input type="password" class="form-control mt-3" name="password" placeholder="Password" value="<?= set_value('password'); ?>">
                    <span class="text-danger"><?= isset($validation) ? $validation->getError('password') : '' ?></span>

                    <button class="btn btn-primary rounded-pill fw-medium mt-3 w-100" type="submit">Sign in</button>

                    <p class="my-3">Don't have an account? <a class="link-primary text-decoration-none fw-medium" href="<?= base_url('signup'); ?>">Sign up here</a></p>

                    <p class="text-body-secondary fw-medium">&copy; 2023 Lyrics Case</p>
                </form>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
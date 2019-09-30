<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Siwalidi | Login</title>
    <link rel="shortcut icon" href="<?= base_url('public/img/logo-dki.png') ?>" type="image/x-icon">
    <!-- Icons-->
    <link href="<?= base_url() ?>node_modules/@coreui/icons/css/coreui-icons.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>node_modules/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>node_modules/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>node_modules/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
    <!-- Main styles for this application-->
    <link href="<?= base_url('public') ?>/css/style.css" rel="stylesheet">
    <link href="<?= base_url('public') ?>/vendors/pace-progress/css/pace.min.css" rel="stylesheet">
  </head>
  <body class="app flex-row align-items-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card-group">
            <div class="card p-4">
              <div class="card-body">
                <h1>Login</h1>
                <p class="text-muted">Masuk akun anda</p>
                <?= $this->session->flashdata('message'); ?>
                <form method="post" action="<?= base_url('auth') ?>">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="icon-user"></i>
                    </span>
                  </div>
                  <input class="form-control <?= (form_error('username') ? 'is-invalid' : '')?>" type="text" placeholder="Username" name="username" value="<?= set_value('username') ?>" required autofocus>
                  <?= form_error('username', '<div class="invalid-feedback">', '</div>') ?>
                </div>
                <div class="input-group mb-4">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="icon-lock"></i>
                    </span>
                  </div>
                  <input class="form-control <?= (form_error('password') ? 'is-invalid' : '')?>" type="password" placeholder="Password" name="password">
                  <?= form_error('password', '<div class="invalid-feedback">', '</div>') ?>
                </div>
                <div class="row">
                  <div class="col-6">
                    <button class="btn btn-primary px-4" type="submit">Login</button>
                  </div>
                </div>
                </form>
              </div>
            </div>
            <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
              <div class="card-body text-center">
                <div>
                  <img src="<?= base_url('public') ?>/img/logo-dki.png" width="100px">
                  <p>Selamat datang di Admin Panel, Silahkan Masukan username dan password untuk login ke halaman administrator.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="<?= base_url() ?>node_modules/jquery/dist/jquery.min.js"></script>
    <script src="<?= base_url() ?>node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?= base_url() ?>node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>node_modules/pace-progress/pace.min.js"></script>
    <script src="<?= base_url() ?>node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
    <script src="<?= base_url() ?>node_modules/@coreui/coreui/dist/js/coreui.min.js"></script>
  </body>
</html>

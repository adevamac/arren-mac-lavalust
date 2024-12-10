<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>RESEND VERIFICATION CODE</title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo BASE_URL . PUBLIC_DIR; ?>/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo BASE_URL . PUBLIC_DIR; ?>/assets/css/sb-admin-2.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div> <!-- Keeps the image -->
                            <div class="col-lg-6">
                                <div class="p-5">
                            
                                    <div class="text-center text-muted mb-4" style="font-size: 20px;">
                                        RESEND VERIFICATION CODE
                                    </div>
                                    <?php flash_alert(); ?>
                                    <form role="form" method="post" action="<?= site_url('resend_token'); ?>">
                                        <div class="text-center mb-3" style="font-size: 12px">
                                            Input your valid and registered email to have a new code.
                                        </div>
                                        <div class="form-group mb-3">
                                            <div class="input-group input-group-merge input-group-alternative">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                </div>
                                                <input class="form-control" id="email" placeholder="" type="text" name="email" style="font-size: 13px;" required>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" name="resend_code" class="btn btn-success my-4">Resend Code</button>
                                        </div>
                                    </form>
                                    <div class="text-center">
                                        <button onclick="location.href='<?= site_url(''); ?>'" class="btn btn-primary btn-sm">Back</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo BASE_URL . PUBLIC_DIR; ?>/assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo BASE_URL . PUBLIC_DIR; ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo BASE_URL . PUBLIC_DIR; ?>/assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo BASE_URL . PUBLIC_DIR; ?>/assets/js/sb-admin-2.min.js"></script>

</body>

</html>

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

    <title>Register</title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo BASE_URL . PUBLIC_DIR; ?>/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,900" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo BASE_URL . PUBLIC_DIR; ?>/assets/css/sb-admin-2.css" rel="stylesheet">

    <style>
        /* Modify background gradient */
        body.bg-gradient-primary {
            background: linear-gradient(135deg, #20c997 0%, #007bff 100%);
        }

        /* Modify card background and text color */
        .card {
            background-color: #ffffff;
        }

        .text-gray-900 {
            color: #343a40 !important;
        }

        /* Modify button styles */
        .btn-primary {
            background-color: #f5a623;
            border-color: #f5a623;
        }

        .btn-primary:hover {
            background-color: #d98a1d;
            border-color: #d98a1d;
        }

        /* Modify link colors */
        .text-center a {
            color: #007bff;
        }

        .text-center a:hover {
            color: #0056b3;
        }

        /* Modify placeholder text color */
        .form-control::placeholder {
            color: #adb5bd;
        }

        /* Styling for gender select dropdown */
        .form-control {
            font-size: 0.8rem;
            border-radius: 10rem;
        }
    </style>
</head>

<body class="bg-gradient-primary">

    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            
                            <?php flash_alert(); ?>
                            <form action="<?= site_url('register'); ?>" method="post" enctype="multipart/form-data" class="user">
                                <div class="form-group row">
                                    <div class="col-sm-3 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" name="firstname"
                                            placeholder="First Name">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-user" name="middlename"
                                            placeholder="Middle Name">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-user" name="lastname"
                                            placeholder="Last Name">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-user" name="suffix"
                                            placeholder="Suffix">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="exampleGender">Gender:<span class="text-danger">*</span></label>
                                        <select class="form-control" name="gender" id="exampleGender">
                                            <option value="" disabled selected>Select Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="fileToUpload">Choose Photo to Upload <span class="text-danger">*</span></label>
                                        <input type="file" name="fileToUpload" class="form-control" id="fileToUpload" required accept="image/*">
                                    </div>
                                    <div class="col-sm-6 mt-2">
                                        <label for="dob">Date of Birth:<span class="text-danger">*</span></label>
                                        <input type="date" class="form-control form-control-user" id="dob" name="dob"
                                            placeholder="Suffix">
                                    </div>
                                    <div class="col-sm-6 mt-2">
                                        <label for="dob">Address:<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-user" id="address" name="address"
                                            placeholder="Address">
                                    </div>

                                </div>

                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" name="email" id="exampleInputEmail"
                                        placeholder="Email Address">
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user" name="password"
                                            id="exampleInputPassword" placeholder="Password">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user" name="repeat_password"
                                            id="exampleRepeatPassword" placeholder="Repeat Password">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Register Account
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="<?= site_url('forgot_password'); ?>">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="<?= site_url(''); ?>">Already have an account? Login!</a>
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
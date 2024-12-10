<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');

// Get the current URI
$current_page = basename($_SERVER['REQUEST_URI']); // This extracts the current page from the URL
// Helper function to set the active class
function isActive($page, $current_page)
{
    return $page === $current_page ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo BASE_URL . PUBLIC_DIR; ?>/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo BASE_URL . PUBLIC_DIR; ?>/assets/css/sb-admin-2.css" rel="stylesheet">
</head>
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>
        <!-- End of Sidebar -->
         
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['f_name'] ?></span>
                                <img class="img-profile rounded-circle" src="<?php echo BASE_URL . PUBLIC_DIR . '/uploads/' . $_SESSION['user_avatar']; ?>">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Barangay Setup</h1>
                    </div>
                    <?php flash_alert(); ?>
                    <div class="container mt-5">
                        <h2 class="text-center">Barangay Information Form</h2>

                        <!-- Form Start -->
                        <form action="<?php echo site_url('save_barangay_info'); ?>" method="POST" enctype="multipart/form-data">
                            <!-- Barangay Name -->
                            <?php if (isset($data) && !empty($data)): ?>
                                <?php foreach ($data as $record): ?>
                                    <div class="mb-3">
                                        <label for="barangay_name" class="form-label">Barangay Name</label>
                                        <input type="text" class="form-control" id="barangay_name" name="barangay_name"
                                            value="<?= $record['barangay_name']; ?>"
                                            required>
                                    </div>

                                    <!-- City/Municipality -->
                                    <div class="mb-3">
                                        <label for="city" class="form-label">City/Municipality</label>
                                        <input type="text" class="form-control" id="city" name="city"
                                            value="<?= $record['city']; ?>" required>
                                    </div>

                                    <!-- Province -->
                                    <div class="mb-3">
                                        <label for="province" class="form-label">Province</label>
                                        <input type="text" class="form-control" id="province" name="province"
                                            value="<?= $record['province']; ?>" required>
                                    </div>

                                    <!-- Zip Code -->
                                    <div class="mb-3">
                                        <label for="zip_code" class="form-label">Zip Code</label>
                                        <input type="text" class="form-control" id="zip_code" name="zip_code"
                                            value="<?= $record['zip_code']; ?>" required>
                                    </div>

                                    <!-- Logo -->
                                    <div class="mb-3">
                                    <input type="hidden" name="existing_logo" value="<?= ($record['logo']) ?>">
                                        <label for="logo" class="form-label">Logo</label>
                                        <!-- If there is an existing logo, display it as a preview -->
                                        <img id="logoPreview" src="<?php echo BASE_URL . PUBLIC_DIR . '/uploads/' . $record['logo']; ?>" alt="Logo Preview" style="max-width: 200px; margin-top: 10px;">
                                        <br>
                                        <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                                    </div>

                                <?php endforeach; ?>
                            <?php else: ?>
                                <!-- If no data, show empty fields -->
                                <div class="mb-3">
                                    <label for="barangay_name" class="form-label">Barangay Name</label>
                                    <input type="text" class="form-control" id="barangay_name" name="barangay_name" required>
                                </div>

                                <!-- City/Municipality -->
                                <div class="mb-3">
                                    <label for="city" class="form-label">City/Municipality</label>
                                    <input type="text" class="form-control" id="city" name="city" required>
                                </div>

                                <!-- Province -->
                                <div class="mb-3">
                                    <label for="province" class="form-label">Province</label>
                                    <input type="text" class="form-control" id="province" name="province" required>
                                </div>

                                <!-- Zip Code -->
                                <div class="mb-3">
                                    <label for="zip_code" class="form-label">Zip Code</label>
                                    <input type="text" class="form-control" id="zip_code" name="zip_code" required>
                                </div>

                                <!-- Logo -->
                                <div class="mb-3">
                                   

                                    <label for="logo" class="form-label">Logo</label>
                                    <!-- If no logo, show an empty preview -->
                                    <img id="logoPreview" src="" alt="Logo Preview" style="max-width: 200px; margin-top: 10px; display: none;">
                                    <br>
                                    <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                                </div>
                            <?php endif; ?>
                            <!-- Submit Button -->
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                        <!-- Form End -->
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Barangay Portal <?php echo date('Y'); ?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?php echo site_url('logout'); ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo BASE_URL . PUBLIC_DIR; ?>/assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo BASE_URL . PUBLIC_DIR; ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
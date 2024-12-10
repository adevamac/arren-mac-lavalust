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
    <!-- Datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.css" />

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
                        <h1 class="h3 mb-0 text-gray-800">PROFILING</h1>
                    </div>

                    <!-- Requestable Papers Section -->
                    <div class="container-fluid mt--6">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card" style="box-shadow: 2px 2px 2px 3px #888888">
                                    <div class="card-header py-3">
                                        <div class="row">
                                            <div class="col">
                                                <div class="col" align="right">
                                                    <button type="button" class="btn btn-success btn-circle btn-sm" data-toggle="modal" data-target="#addResidentModal">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <?php flash_alert(); ?>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered " id="user_table" width="100%"
                                                        cellspacing="0">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center ">ID</th>
                                                                <th class="text-center ">FULLNAME</th>

                                                                <th class="text-center">GENDER</th>
                                                                <th class="text-center">DATE OF BIRTH</th>
                                                                <th class="text-center">AGE</th>
                                                                <th class="text-center">CIVIL STATUS</th>
                                                                <th class="text-center">STREET / SITIO</th>
                                                                <th class="text-center">OCCUPATION STATUS</th>
                                                                <th class="text-center">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($data as $record): ?>
                                                                <tr id="user_<?php echo $record['id']; ?>">
                                                                    <td class="text-center"><?php echo $record['id']; ?></td>
                                                                    <td class="text-center"><?php echo $record['f_name']; ?> <?php echo $record['m_name']; ?> <?php echo $record['l_name']; ?> <?php echo $record['suffix']; ?></td>
                                                                    <td class="text-center"><?php echo $record['gender']; ?></td>
                                                                    <td class="text-center"><?php echo $record['dob']; ?></td>
                                                                    <td class="text-center"><?php echo $record['age']; ?></td>
                                                                    <td class="text-center"><?php echo $record['civil_status']; ?></td>
                                                                    <td class="text-center"><?php echo $record['street_sitio']; ?></td>
                                                                    <td class="text-center"><?php echo $record['occupation_status']; ?></td>
                                                                    <td class="text-center">
                                                                        <button onclick="location.href='<?php echo site_url('edit_users/' . $record['id']); ?>'" type="button" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->



            <!-- Add Resident Modal -->
            <div class="modal fade" id="addResidentModal" tabindex="-1" role="dialog" aria-labelledby="addResidentLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addResidentLabel">Add New Resident Profile</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" action="<?php echo site_url('add_resident'); ?>">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="f_name">First Name</label>
                                    <input type="text" class="form-control" id="f_name" name="f_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="m_name">Middle Name</label>
                                    <input type="text" class="form-control" id="m_name" name="m_name">
                                </div>
                                <div class="form-group">
                                    <label for="l_name">Last Name</label>
                                    <input type="text" class="form-control" id="l_name" name="l_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="suffix">Suffix</label>
                                    <input type="text" class="form-control" id="suffix" name="suffix">
                                </div>
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select class="form-control" id="gender" name="gender" required>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="dob">Date of Birth</label>
                                    <input type="date" class="form-control" id="dob" name="dob" required>
                                </div>
                                <div class="form-group">
                                    <label for="civil_status">Civil Status</label>
                                    <select class="form-control" id="civil_status" name="civil_status" required>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Widowed">Widowed</option>
                                        <option value="Separated">Separated</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="street_sitio">Street/Sitio</label>
                                    <input type="text" class="form-control" id="street_sitio" name="street_sitio" required>
                                </div>
                                <div class="form-group">
                                    <label for="occupation_status">Occupation Status</label>
                                    <select class="form-control" id="occupation_status" name="occupation_status" required>
                                        <option value="Employed">Employed</option>
                                        <option value="Unemployed">Unemployed</option>
                                        <option value="Student">Student</option>
                                        <option value="Retired">Retired</option>
                                    </select>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Resident</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


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
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#user_table').DataTable(); // Initialize DataTable


        });
    </script>
</body>

</html>
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
                        <h1 class="h3 mb-0 text-gray-800">OFFICIALS</h1>
                    </div>

                    <!-- Requestable Papers Section -->
                    <div class="container-fluid mt--6">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card" style="box-shadow: 2px 2px 2px 3px #888888">
                                    <div class="card-header py-3">
                                        <div class="row">
                                            <div class="col">
                                                <div class="text-right">
                                                    <button type="button" class="btn btn-success btn-circle btn-sm" data-toggle="modal" data-target="#addOfficialModal">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <?php flash_alert(); ?>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered" id="user_table" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">ID</th>
                                                        <th class="text-center">FULL NAME</th>
                                                        <th class="text-center">CONTACT</th>
                                                        <th class="text-center">POSITION</th>
                                                        <th class="text-center">IS SIGNATORY</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($data as $record): ?>
                                                        <tr id="user_<?php echo $record['id']; ?>">
                                                            <td class="text-center"><?php echo $record['id']; ?></td>
                                                            <td class="text-center"><?php echo $record['fullname']; ?> </td>
                                                            <td class="text-center"><?php echo $record['contact']; ?></td>
                                                            <td class="text-center"><?php echo $record['position']; ?></td>
                                                            <td class="text-center">
                                                                <?php echo $record['is_signatory'] == 1 ? 'Yes' : 'No'; ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editOfficialModal"
                                                                    onclick="populateEditModal(<?php echo $record['id']; ?>, '<?php echo addslashes($record['fullname']); ?>', '<?php echo addslashes($record['contact']); ?>', '<?php echo addslashes($record['position']); ?>', <?php echo $record['is_signatory']; ?>)">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
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

                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->


            <!-- Add Official Modal -->
            <div class="modal fade" id="addOfficialModal" tabindex="-1" role="dialog" aria-labelledby="addOfficialLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addOfficialLabel">Add Barangay Official</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" action="<?php echo site_url('add_officials'); ?>">
                            <div class="modal-body">
                                <!-- Full Name and Contact Fields Side-by-Side -->
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="full_name">Full Name</label>
                                        <input type="text" class="form-control" id="full_name" name="full_name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="contact">Contact</label>
                                        <input type="text" class="form-control" id="contact" name="contact" required>
                                    </div>
                                </div>

                                <!-- Position and Is Signatory Fields Side-by-Side -->
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="position">Position</label>
                                        <select class="form-control" id="position" name="position" required>
                                            <option value="" disabled selected>Select Position</option>
                                            <option value="Barangay Captain">Barangay Captain</option>
                                            <option value="Barangay Secretary">Barangay Secretary</option>
                                            <option value="Barangay Treasurer">Barangay Treasurer</option>
                                            <option value="Barangay Kagawad">Barangay Kagawad</option>
                                            <option value="SK Chairman">SK Chairman</option>
                                            <option value="Barangay Tanod">Barangay Tanod</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="is_signatory">Is Signatory</label>
                                        <input type="hidden" name="is_signatory" value="0"> <!-- Hidden field -->
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="is_signatory" name="is_signatory" value="1">
                                            <label class="custom-control-label" for="is_signatory">Yes/No</label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Official</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <!-- Edit Official Modal -->
            <div class="modal fade" id="editOfficialModal" tabindex="-1" role="dialog" aria-labelledby="editOfficialLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editOfficialLabel">Edit Barangay Official</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- Form without a static action URL -->
                        <form method="POST" id="editOfficialForm">
                            <div class="modal-body">
                                <!-- Hidden field to store the ID -->
                                <input type="hidden" id="edit_id" name="id">

                                <!-- Full Name and Contact Fields Side-by-Side -->
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="edit_full_name">Full Name</label>
                                        <input type="text" class="form-control" id="edit_full_name" name="full_name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="edit_contact">Contact</label>
                                        <input type="text" class="form-control" id="edit_contact" name="contact" required>
                                    </div>
                                </div>

                                <!-- Position and Is Signatory Fields Side-by-Side -->
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="edit_position">Position</label>
                                        <select class="form-control" id="edit_position" name="position" required>
                                            <option value="" disabled>Select Position</option>
                                            <option value="Barangay Captain">Barangay Captain</option>
                                            <option value="Barangay Secretary">Barangay Secretary</option>
                                            <option value="Barangay Treasurer">Barangay Treasurer</option>
                                            <option value="Barangay Kagawad">Barangay Kagawad</option>
                                            <option value="SK Chairman">SK Chairman</option>
                                            <option value="Barangay Tanod">Barangay Tanod</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="edit_is_signatory">Is Signatory</label>
                                        <input type="hidden" name="is_signatory" value="0"> <!-- Hidden field -->
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="edit_is_signatory" name="is_signatory" value="1">
                                            <label class="custom-control-label" for="edit_is_signatory">Yes/No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
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
            var table = $('#user_table').DataTable();

            // Handle checkbox change event
            const checkbox = document.getElementById('is_signatory');
            const hiddenInput = document.querySelector('input[name="is_signatory"]');

            checkbox.addEventListener('change', function() {
                hiddenInput.value = checkbox.checked ? '1' : '0';
            });
        });

        function populateEditModal(id, name, contact, position, isSignatory) {
            // Set form action URL dynamically
            document.getElementById('editOfficialForm').action = "<?php echo site_url('edit_officials/'); ?>" + id;

            // Populate form fields
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_full_name').value = name;
            document.getElementById('edit_contact').value = contact;
            document.getElementById('edit_position').value = position;

            // Set checkbox state based on isSignatory
            const checkbox = document.getElementById('edit_is_signatory');
            checkbox.checked = (isSignatory == 1);
        }
    </script>

</body>

</html>
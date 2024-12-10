<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');

$current_page = basename(filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL));

// Helper function for active class
function isActive($page, $current_page)
{
    return strpos($current_page, $page) !== false ? 'active' : '';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard</title>
    <link href="<?php echo BASE_URL . PUBLIC_DIR; ?>/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="<?php echo BASE_URL . PUBLIC_DIR; ?>/assets/css/sb-admin-2.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

    <!-- jQuery -->
    <script src="<?php echo BASE_URL . PUBLIC_DIR; ?>/assets/vendor/jquery/jquery.min.js"></script>

    <!-- Datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.css" />

</head>

<body id="page-top">
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
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['f_name']; ?></span>
                                <img class="img-profile rounded-circle" src="<?php echo BASE_URL . PUBLIC_DIR . '/uploads/' . $_SESSION['user_avatar']; ?>">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout
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
                        <h1 class="h3 mb-0 text-gray-800">REQUEST TABLE</h1>
                    </div>

                    <!-- Requestable Papers Section -->
                    <div class="container-fluid mt--6">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card" style="box-shadow: 2px 2px 2px 3px #888888">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered" id="user_table" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">ID</th>
                                                        <th class="text-center">REQUEST TYPE</th>
                                                        <th class="text-center">STATUS</th>
                                                        <th class="text-center">DATE SUBMITTED</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($data)): ?>
                                                        <?php foreach ($data as $request): ?>
                                                            <tr id="request_<?php echo $request['id']; ?>">
                                                                <td class="text-center"><?php echo htmlspecialchars($request['id']); ?></td>
                                                                <td class="text-center"><?php echo htmlspecialchars($request['request_type']); ?></td>
                                                                <td class="text-center">
                                                                    <?php
                                                                    $status = htmlspecialchars($request['status']);
                                                                    switch ($status) {
                                                                        case 'pending':
                                                                            echo '<span class="badge badge-warning">Pending</span>';
                                                                            break;
                                                                        case 'approved':
                                                                            echo '<span class="badge badge-success">Approved</span>';
                                                                            break;
                                                                        case 'denied':
                                                                            echo '<span class="badge badge-danger">Denied</span>';
                                                                            break;
                                                                        default:
                                                                            echo '<span class="badge badge-secondary">Unknown</span>';
                                                                            break;
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td class="text-center"><?php echo htmlspecialchars($request['created_at']); ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <tr>
                                                            <td colspan="4" class="text-center">No requests found for the current user.</td>
                                                        </tr>
                                                    <?php endif; ?>
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
    </div>
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

    <script src="<?php echo BASE_URL . PUBLIC_DIR; ?>/assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo BASE_URL . PUBLIC_DIR; ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>

    <!-- Initialize DataTable -->
    <script>
        $(document).ready(function() {
            $('#user_table').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "lengthMenu": [10, 25, 50, 100],
                "language": {
                    "emptyTable": "No data available in table"
                }
            });
        });
    </script>
</body>

</html>
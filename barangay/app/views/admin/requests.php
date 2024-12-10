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
    <link href="<?php echo htmlspecialchars(BASE_URL . PUBLIC_DIR); ?>/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="<?php echo htmlspecialchars(BASE_URL . PUBLIC_DIR); ?>/assets/css/sb-admin-2.css" rel="stylesheet">
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
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo htmlspecialchars($_SESSION['f_name']); ?></span>
                                <img class="img-profile rounded-circle" src="<?php echo htmlspecialchars(BASE_URL . PUBLIC_DIR . '/uploads/' . $_SESSION['user_avatar']); ?>">
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
                    <h1 class="h3 mb-4 text-gray-800">All User Requests</h1>
                    <?php flash_alert(); ?>
                    <!-- Card -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">User Requests</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="requests_table" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Request ID</th>
                                            <th class="text-center">User Name</th>
                                            <th class="text-center">Request Type</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Date Submitted</th>
                                            <th class="text-center">Action</th> <!-- Dropdown Action Column -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($all_requests)): ?>
                                            <?php foreach ($all_requests as $request): ?>
                                                <tr>
                                                    <td class="text-center"><?php echo htmlspecialchars($request['id']); ?></td>
                                                    <td class="text-center">
                                                        <?php echo htmlspecialchars($request['f_name'] . ' ' . $request['m_name'] . ' ' . $request['l_name'] . ' ' . $request['suffix']); ?>
                                                    </td>
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
                                                    <td class="text-center">
                                                        <!-- Dropdown Menu -->
                                                        <form method="post" action="<?php echo htmlspecialchars(BASE_URL . 'update_request_status'); ?>" class="d-inline">
                                                            <input type="hidden" name="request_id" value="<?php echo htmlspecialchars($request['id']); ?>">
                                                            <select name="action" class="form-control form-control-sm d-inline" style="width: auto;" onchange="this.form.submit()">
                                                                <option value="">Select Action</option>
                                                                <option value="approve">Approve</option>
                                                                <option value="disapprove">Disapprove</option>
                                                            </select>
                                                        </form>
                                                        <!-- Print Button -->
                                                        <?php if ($request['status'] === 'approved'): ?>
                                                            <button type="button" class="btn btn-sm btn-primary" onclick="openSignatoryModal(<?php echo htmlspecialchars($request['id']); ?>, '<?php echo htmlspecialchars($request['request_type']); ?>')">
                                                                Print
                                                            </button>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center">No requests found.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- End of Card -->
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


    <!-- Signatory Modal -->
    <div class="modal fade" id="signatoryModal" tabindex="-1" aria-labelledby="signatoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="signatoryModalLabel">Select Signatory</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="signatoryForm">
                        <input type="hidden" name="request_id" id="modalRequestId">
                        <input type="hidden" name="request_type" id="modalRequestType">
                        <div class="form-group">
                            <label for="signatory">Select Signatory:</label>
                            <select name="signatory_id" id="signatory" class="form-control" required>
                                <option value="">Select...</option>
                                <?php foreach ($officials as $official): ?>
                                    <?php if ($official['is_signatory'] == 1): ?>
                                        <option value="<?php echo htmlspecialchars($official['id']); ?>">
                                            <?php echo htmlspecialchars($official['fullname']); ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="generateClearance()">Generate</button>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo BASE_URL . PUBLIC_DIR; ?>/assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo BASE_URL . PUBLIC_DIR; ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>
    <script>
        function openSignatoryModal(requestId, requestType) {
            $('#modalRequestId').val(requestId);
            $('#modalRequestType').val(requestType);
            $('#signatoryModal').modal('show');
        }

        function generateClearance() {
            const requestId = $('#modalRequestId').val();
            const requestType = $('#modalRequestType').val();
            const signatoryId = $('#signatory').val(); // Get the selected signatory ID

            if (!signatoryId) {
                alert('Please select a signatory.');
                return;
            }

            $.ajax({
                type: 'POST',
                url: '<?php echo BASE_URL . "generate_certificate"; ?>',
                data: {
                    request_id: requestId,
                    request_type: requestType,
                    signatory_id: signatoryId // Include the signatory ID
                },
                success: function(response) {
                    // Open the certificate in a new tab
                    const newWindow = window.open();
                    newWindow.document.open();
                    newWindow.document.write(response);
                    newWindow.document.close();
                },
                error: function(xhr, status, error) {
                    alert('Error generating certificate: ' + error);
                }
            });
        }
        // Ensure the DOM is fully loaded before initializing DataTables
        $(document).ready(function() {
            $('#requests_table').DataTable();
        });
    </script>
</body>

</html>
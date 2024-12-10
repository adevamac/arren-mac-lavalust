<!-- Barangay Clearance Modal -->
<div class="modal fade" id="barangayClearanceModal" tabindex="-1" aria-labelledby="barangayClearanceLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo BASE_URL; ?>/submit_barangay_clearance" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="barangayClearanceLabel">Barangay Clearance Form</h5>
                   <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="fullName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="fullName" name="full_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="mb-3">
                        <label for="purpose" class="form-label">Purpose</label>
                        <textarea class="form-control" id="purpose" name="purpose" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Certificate of Indigency Modal -->
<div class="modal fade" id="indigencyModal" tabindex="-1" aria-labelledby="indigencyLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo BASE_URL; ?>/submit_indigency" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="indigencyLabel">Certificate of Indigency Form</h5>
                    <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="fullNameIndigency" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="fullNameIndigency" name="full_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason for Request</label>
                        <textarea class="form-control" id="reason" name="reason" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Business Clearance Modal -->
<div class="modal fade" id="businessClearanceModal" tabindex="-1" aria-labelledby="businessClearanceLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo BASE_URL; ?>/submit_business_clearance" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="businessClearanceLabel">Business Clearance Form</h5>
                    <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="businessName" class="form-label">Business Name</label>
                        <input type="text" class="form-control" id="businessName" name="business_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="ownerName" class="form-label">Owner's Name</label>
                        <input type="text" class="form-control" id="ownerName" name="owner_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="businessAddress" class="form-label">Business Address</label>
                        <input type="text" class="form-control" id="businessAddress" name="business_address" required>
                    </div>
                    <div class="mb-3">
                        <label for="natureOfBusiness" class="form-label">Nature of Business</label>
                        <input type="text" class="form-control" id="natureOfBusiness" name="nature_of_business" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Residency Certificate Modal -->
<div class="modal fade" id="residencyModal" tabindex="-1" aria-labelledby="residencyLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo BASE_URL; ?>submit_residency_certificate" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="residencyLabel">Residency Certificate Form</h5>
                    <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="residentName" class="form-label">Resident's Name</label>
                        <input type="text" class="form-control" id="residentName" name="resident_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="yearsOfResidency" class="form-label">Years of Residency</label>
                        <input type="number" class="form-control" id="yearsOfResidency" name="years_of_residency" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
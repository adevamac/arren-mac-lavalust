<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');

class Client extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->call->helper(array('form', 'alert'));
        $this->call->model(array('client_model'));
        $this->call->library('form_validation');
    }

    public function submit_barangay_clearance()
    {
        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate form fields
            $this->form_validation
                ->name('full_name')->required('Submission failed! Full name is required.')
                ->name('address')->required('Submission failed! Address is required.')
                ->name('purpose')->required('Submission failed! Purpose is required.');

            if ($this->form_validation->run()) {
                // Get POST data
                $full_name = $this->io->post('full_name', TRUE);
                $address = $this->io->post('address', TRUE);
                $purpose = $this->io->post('purpose', TRUE);
                $submitted_by = $_SESSION['id'];
                $request_data = array(
                    'full_name' => $full_name,
                    'address' => $address,
                    'purpose' => $purpose,
                );
                $request_data = array(
                    'full_name' => $full_name,
                    'address' => $address,
                    'purpose' => $purpose,
                );
                
                // Attempt to save the form data
                if ($this->client_model->add_barangay_clearance(
                    $full_name,
                    $address,
                    $purpose,
                    $submitted_by,
                    $request_data
                )) {
                    set_flash_alert('success', 'Barangay Clearance submitted successfully!');
                    redirect('/dashboard');
                } else {
                    set_flash_alert('danger', 'Failed to submit Barangay Clearance.');
                    redirect('/dashboard');
                }
            } else {
                // Validation errors response
                set_flash_alert('danger', $this->form_validation->errors());
                redirect('/dashboard');
            }
        }
        exit;
    }



    public function submit_indigency()
    {
        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate form inputs
            $this->form_validation
                ->name('full_name')->required('Full Name is required.')
                ->name('reason')->required('Reason is required.');

            if ($this->form_validation->run()) {
                // Get POST data
                $full_name = $this->io->post('full_name', TRUE);
                $reason = $this->io->post('reason', TRUE);
                $submitted_by = $_SESSION['id']; // Assuming the logged-in user ID is stored in session

                // Prepare request data for `requests` table
                $request_data = array(
                    'full_name' => $full_name,
                    'reason' => $reason,
                );

                // Attempt to save the form data
                if ($this->client_model->add_certificate_of_indigency(
                    $full_name,
                    $reason,
                    $submitted_by,
                    $request_data // Pass the request data for logging
                )) {
                    set_flash_alert('success', 'Certificate of Indigency submitted successfully!');
                    redirect('/dashboard');
                } else {
                    set_flash_alert('danger', 'Failed to submit Certificate of Indigency.');
                    redirect('/dashboard');
                }
            } else {
                // Handle validation errors
                set_flash_alert('danger', $this->form_validation->errors());
                redirect('/dashboard');
            }
        } else {
            // If not a POST request, redirect to dashboard
            redirect('/dashboard');
        }
        exit;
    }

    public function submit_business_clearance()
    {
        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate form inputs
            $this->form_validation
                ->name('business_name')->required('Business Name is required.')
                ->name('owner_name')->required('Owner\'s Name is required.')
                ->name('business_address')->required('Business Address is required.')
                ->name('nature_of_business')->required('Nature of Business is required.');

            if ($this->form_validation->run()) {
                // Get POST data
                $business_name = $this->io->post('business_name', TRUE);
                $owner_name = $this->io->post('owner_name', TRUE);
                $business_address = $this->io->post('business_address', TRUE);
                $nature_of_business = $this->io->post('nature_of_business', TRUE);
                $submitted_by = $_SESSION['id']; // Assuming the logged-in user ID is stored in session

                // Prepare request data for `requests` table
                $request_data = array(
                    'business_name' => $business_name,
                    'owner_name' => $owner_name,
                    'business_address' => $business_address,
                    'nature_of_business' => $nature_of_business,
                );

                // Attempt to save the form data
                if ($this->client_model->add_business_clearance(
                    $business_name,
                    $owner_name,
                    $business_address,
                    $nature_of_business,
                    $submitted_by,
                    $request_data // Pass the request data for logging
                )) {
                    set_flash_alert('success', 'Business Clearance submitted successfully!');
                    redirect('/dashboard');
                } else {
                    set_flash_alert('danger', 'Failed to submit Business Clearance.');
                    redirect('/dashboard');
                }
            } else {
                // Handle validation errors
                set_flash_alert('danger', $this->form_validation->errors());
                redirect('/dashboard');
            }
        } else {
            // If not a POST request, redirect to dashboard
            redirect('/dashboard');
        }
        exit;
    }


    public function submit_residency_certificate()
    {
        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate form inputs
            $this->form_validation
                ->name('resident_name')->required('Resident\'s Name is required.')
                ->name('years_of_residency')->required('Years of Residency is required.');

            if ($this->form_validation->run()) {
                // Get POST data
                $resident_name = $this->io->post('resident_name', TRUE);
                $years_of_residency = $this->io->post('years_of_residency', TRUE);
                $submitted_by = $_SESSION['id']; // Assuming the logged-in user's ID is stored in session

                // Prepare request data for `requests` table
                $request_data = array(
                    'resident_name' => $resident_name,
                    'years_of_residency' => $years_of_residency,
                );

                // Attempt to save the form data
                if ($this->client_model->add_residency_certificate(
                    $resident_name,
                    $years_of_residency,
                    $submitted_by,
                    $request_data // Pass the request data for logging
                )) {
                    set_flash_alert('success', 'Residency Certificate submitted successfully!');
                    redirect('/dashboard');
                } else {
                    set_flash_alert('danger', 'Failed to submit Residency Certificate.');
                    redirect('/dashboard');
                }
            } else {
                // Handle validation errors
                set_flash_alert('danger', $this->form_validation->errors());
                redirect('/dashboard');
            }
        } else {
            // If not a POST request, redirect to dashboard
            redirect('/dashboard');
        }
        exit;
    }



    public function requests()
    {
        // Assuming user ID is stored in the session
        $user_id = $_SESSION['id'];

        // Fetch requests from the database for the current user
        $data = $this->client_model->get_user_requests($user_id);

        // Pass the data to the view
        $this->call->view('client/requests', $data);
    }
}

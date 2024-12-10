<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');

class Admin extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->call->helper(array('form', 'alert'));
        $this->call->model(array('admin_model'));
        $this->call->library('form_validation');
    }


    public function profiling()
    {
        // Get all resident profiles from the model
        $data = $this->admin_model->get_all_res_profile();

        // Check if there are any data records
        if (!empty($data)) {
            // Loop through each record and calculate the age
            foreach ($data as &$record) {
                // Calculate the age for each resident using their 'dob'
                $dobDate = new DateTime($record['dob']);
                $currentDate = new DateTime();
                $ageInterval = $dobDate->diff($currentDate);
                $record['age'] = $ageInterval->y;  // Set the calculated age in the record
            }
        } else {
            // If no data, set a default message or empty array
            $data = [];
        }

        // Pass the data to the view
        $this->call->view('admin/profiling', $data);
    }



    public function add_resident()
    {
        // Check if form is submitted
        if ($this->form_validation->submitted()) {
            // Validate form fields
            $this->form_validation
                ->name('f_name')->required('Resident not added! First name is required.')
                ->name('m_name')->required('Resident not added! Middle name is required.')
                ->name('l_name')->required('Resident not added! Last name is required.')
                ->name('gender')->required('Resident not added! Gender is required.')
                ->name('dob')->required('Resident not added! Date of birth is required.')
                ->name('civil_status')->required('Resident not added! Civil status is required.')
                ->name('street_sitio')->required('Resident not added! Street Sitio is required.')
                ->name('occupation_status')->required('Resident not added! Occupation status is required.');

            if ($this->form_validation->run()) {
                // Get POST data
                $f_name = $this->io->post('f_name', TRUE);
                $m_name = $this->io->post('m_name', TRUE);
                $l_name = $this->io->post('l_name', TRUE);
                $suffix = $this->io->post('suffix', TRUE);
                $gender = $this->io->post('gender', TRUE);
                $dob = $this->io->post('dob', TRUE);
                $civil_status = $this->io->post('civil_status', TRUE);
                $street_sitio = $this->io->post('street_sitio', TRUE);
                $occupation_status = $this->io->post('occupation_status', TRUE);
                // Attempt to add the resident
                if ($this->admin_model->add_resident(
                    $f_name,
                    $m_name,
                    $l_name,
                    $suffix,
                    $gender,
                    $dob,
                    $civil_status,
                    $street_sitio,
                    $occupation_status,
                ) == true) {
                    set_flash_alert('success',  'New resident added successfully!');
                    redirect('/profiling');
                } else {

                    set_flash_alert('danger',  'Failed to add resident.');
                    redirect('/profiling');
                }
            } else {
                // Validation errors response (AJAX)
                set_flash_alert('danger', $this->form_validation->errors());
                redirect('/profiling');
            }
            exit;
            redirect('/profiling');
        }
    }


    public function barangay_info()
    {
        // Get Barangay info from the model
        $data = $this->admin_model->get_barangay_info();
        // Pass the data to the view
        $this->call->view('admin/barangay_info', $data);
    }


    public function save_barangay_info()
    {
        // Check if form is submitted
        if ($this->form_validation->submitted()) {
            // Validate form fields
            $this->form_validation
                ->name('barangay_name')->required('Barangay name is required.')
                ->name('city')->required('City/Municipality is required.')
                ->name('province')->required('Province is required.')
                ->name('zip_code')->required('Zip code is required.');

            if ($this->form_validation->run()) {
                // Get POST data
                $barangay_name = $this->io->post('barangay_name', TRUE);
                $city = $this->io->post('city', TRUE);
                $province = $this->io->post('province', TRUE);
                $zip_code = $this->io->post('zip_code', TRUE);

                // File upload logic for logo
                $logo_name = null;
                if (isset($_FILES["logo"]) && $_FILES["logo"]["error"] == 0) {
                    $this->call->library('upload', $_FILES["logo"]);
                    $this->upload
                        ->set_dir('public/uploads')
                        ->allowed_extensions(array('jpg', 'jpeg'))
                        ->allowed_mimes(array('image/jpeg'))
                        ->is_image()
                        ->encrypt_name();

                    if ($this->upload->do_upload()) {
                        // Get the uploaded logo filename
                        $logo_name = $this->upload->get_filename();
                    } else {
                        // Handle failure in file upload
                        set_flash_alert('danger', 'Failed to upload logo.');
                        redirect('/barangay_info');
                        exit; // Exit to stop further execution
                    }
                } else {
                    $logo_name = $this->io->post('existing_logo', TRUE); // Assuming this comes from a hidden field or database
                }

                // Attempt to add/update the Barangay info
                if ($this->admin_model->save_barangay_info(
                    $barangay_name,
                    $city,
                    $province,
                    $zip_code,
                    $logo_name
                ) == true) {
                    // Set success message and redirect to barangay info page
                    set_flash_alert('success', 'Barangay info updated successfully!');
                    redirect('/barangay_info');
                } else {
                    // Set failure message if saving the info fails
                    set_flash_alert('danger', 'Failed to update barangay info.');
                    redirect('/barangay_info');
                }
            } else {
                // Validation errors
                set_flash_alert('danger', $this->form_validation->errors());
                redirect('/barangay_info');
            }
            exit; // exit after redirection to prevent further execution
        }
    }


    public function officials()
    {
        // Get all resident profiles from the model
        $data = $this->admin_model->get_all_officials();
        // Pass the data to the view
        $this->call->view('admin/officials', $data);
    }


    public function add_officials()
    {
        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate form fields
            $this->form_validation
                ->name('full_name')->required('Official not added! Fullname is required.')
                ->name('contact')->required('Official not added! Contact is required.')
                ->name('position')->required('Official not added! Position is required.');

            if ($this->form_validation->run()) {
                // Get POST data
                $full_name = $this->io->post('full_name', TRUE);
                $contact = $this->io->post('contact', TRUE);
                $position = $this->io->post('position', TRUE);
                $is_signatory = $this->io->post('is_signatory', TRUE);
                // Attempt to add the official
                if ($this->admin_model->add_officials(
                    $full_name,
                    $contact,
                    $position,
                    $is_signatory
                )) {
                    set_flash_alert('success', 'New official added successfully!');
                    redirect('/officials');
                } else {
                    set_flash_alert('danger', 'Failed to add official.');
                    redirect('/officials');
                }
            } else {
                // Validation errors response (AJAX)
                set_flash_alert('danger', $this->form_validation->errors());
                redirect('/officials');
            }
        }
        exit;
    }

    public function edit_officials($id)
    {
        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate form fields
            $this->form_validation
                ->name('id')->required('Official not updated! ID is required.')
                ->name('full_name')->required('Official not updated! Full name is required.')
                ->name('contact')->required('Official not updated! Contact is required.')
                ->name('position')->required('Official not updated! Position is required.');

            if ($this->form_validation->run()) {
                // Get POST data
                $full_name = $this->io->post('full_name', TRUE);
                $contact = $this->io->post('contact', TRUE);
                $position = $this->io->post('position', TRUE);
                $is_signatory = $this->io->post('is_signatory', TRUE);
                // Attempt to update the official
                if ($this->admin_model->update_officials(
                    $id,
                    $full_name,
                    $contact,
                    $position,
                    $is_signatory
                )) {
                    set_flash_alert('success', 'Official updated successfully!');
                    redirect('/officials');
                } else {
                    set_flash_alert('danger', 'Failed to update official.');
                    redirect('/officials');
                }
            } else {
                // Validation errors response (AJAX)
                set_flash_alert('danger', $this->form_validation->errors());
                redirect('/officials');
            }
        }
        exit;
    }

    public function requests()
    {
        $data['all_requests'] = $this->admin_model->get_all_requests();
        $data['officials'] = $this->admin_model->get_all_officials();
        $this->call->view('admin/requests', $data);
    }

    public function update_request_status()
    {
        $request_id = $this->io->post('request_id');
        $action = $this->io->post('action'); // "approve" or "disapprove"

        if ($action === 'approve' || $action === 'disapprove') {
            $status = ($action === 'approve') ? 'approved' : 'denied';
            $update_result = $this->admin_model->update_request_status($request_id, $status);
            if ($update_result) {
                $this->session->set_flashdata('success', 'Request status updated successfully!');
            } else {
                $this->session->set_flashdata('error', 'Failed to update request status.');
            }
        } else {
            $this->session->set_flashdata('error', 'Invalid action selected.');
        }

        redirect('all_requests');
    }

    public function generate_certificate()
    {
        // Get data from POST request
        $request_id = $this->io->post('request_id');
        $request_type = $this->io->post('request_type');
        $signatory_id = $this->io->post('signatory_id'); // Capture the signatory ID

        if (empty($request_id) || empty($request_type) || empty($signatory_id)) {
            echo 'Invalid input';
            return;
        }

        // Fetch request details from the database
        $request = $this->admin_model->get_request_by_id($request_id);
        if (!$request) {
            echo 'Request not found';
            return;
        }

        // Fetch signatory details from the database
        $signatory = $this->admin_model->get_official_by_id($signatory_id);
        if (!$signatory) {
            echo 'Signatory not found';
            return;
        }

        // Set the appropriate HTML template based on the request type
        switch ($request_type) {
            case 'barangay_clearance':
                $html = $this->generate_barangay_clearance($request, $signatory);
                break;
            case 'indigency':
                $html = $this->generate_indigency_certificate($request, $signatory);
                break;
            case 'business_clearance':
                $html = $this->generate_business_clearance($request, $signatory);
                break;
            case 'residency_certificate':
                $html = $this->generate_residency_certificate($request, $signatory);
                break;
            default:
                echo 'Invalid request type';
                return;
        }

        // Set the content type to HTML
        header('Content-Type: text/html; charset=UTF-8');

        // Output the certificate HTML
        echo $html;
    }


    private function generate_barangay_clearance($request, $signatory)
    {
        $request_data_string = $request['request_data'];

        // Decode the JSON string to get the associative array
        $request_data = json_decode($request_data_string, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            die('Error decoding JSON: ' . json_last_error_msg());
        }

        // Access data safely
        $full_name = isset($request_data['full_name']) ? htmlspecialchars($request_data['full_name']) : 'Unknown';
        $address = isset($request_data['address']) ? htmlspecialchars($request_data['address']) : 'Unknown';

        // Fetch barangay information
        $barangay_info = $this->admin_model->get_barangay();
        $barangay_name = htmlspecialchars($barangay_info['barangay_name']);
        $city = htmlspecialchars($barangay_info['city']);
        $province = htmlspecialchars($barangay_info['province']);
        $logo = htmlspecialchars(BASE_URL . PUBLIC_DIR . '/uploads/' . $barangay_info['logo']);

        $signatory_name = htmlspecialchars($signatory['fullname']);
        $signatory_position = htmlspecialchars($signatory['position']);

        // Generate the clearance HTML
        return "
<!DOCTYPE html>
<html>
<head>
    <title>Barangay Clearance</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .certificate-container {
            width: 210mm;
            height: 297mm;
            margin: 0 auto;
            padding: 30mm 20mm;
            border: 10px double #000;
            box-sizing: border-box;
            position: relative;
        }
        .certificate-header {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin-bottom: 20px;
        }
        .certificate-header img {
            max-width: 100px;
            margin-right: 20px;
        }
        .certificate-header h1 {
            font-size: 2.5em;
            margin: 0;
        }
        .certificate-body {
            text-align: justify;
            font-size: 1.2em;
            line-height: 1.6;
            margin-top: 30px;
        }
        .certificate-footer {
            position: absolute;
            bottom: 50mm;
            right: 30mm;
            text-align: center;
        }
        .certificate-footer p {
            margin: 0;
            font-size: 1.2em;
        }
    </style>
</head>
<body>
    <div class='certificate-container'>
        <div class='certificate-header'>
            <img src='$logo' alt='Barangay Logo'>
            <h1>Barangay Clearance</h1>
        </div>
        <div class='certificate-body'>
            <p>This is to certify that <strong>$full_name</strong>, a resident of 
            <strong>$address, $barangay_name, $city, $province</strong>, has been granted this clearance 
            based on compliance with barangay policies.</p>
            <p>Issued this <strong>" . date('F d, Y') . "</strong> at Barangay $barangay_name, $city, $province.</p>
        </div>
        <div class='certificate-footer'>
            <p>__________________________</p>
            <p><strong>$signatory_name</strong></p>
            <p>$signatory_position</p>
        </div>
    </div>
</body>
</html>";
    }

    private function generate_indigency_certificate($request, $signatory)
    {
        $request_data_string = $request['request_data'];

        // Decode the JSON string to get the associative array
        $request_data = json_decode($request_data_string, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            die('Error decoding JSON: ' . json_last_error_msg());
        }

        // Access data safely
        $full_name = isset($request_data['full_name']) ? htmlspecialchars($request_data['full_name']) : 'Unknown';
        $reason = isset($request_data['reason']) ? htmlspecialchars($request_data['reason']) : 'Unknown';

        // Fetch barangay information
        $barangay_info = $this->admin_model->get_barangay();
        $barangay_name = htmlspecialchars($barangay_info['barangay_name']);
        $city = htmlspecialchars($barangay_info['city']);
        $province = htmlspecialchars($barangay_info['province']);
        $logo = htmlspecialchars(BASE_URL . PUBLIC_DIR . '/uploads/' . $barangay_info['logo']);

        $signatory_name = htmlspecialchars($signatory['fullname']);
        $signatory_position = htmlspecialchars($signatory['position']);

        // Generate the indigency certificate HTML
        return "
    <!DOCTYPE html>
    <html>
    <head>
        <title>Certificate of Indigency</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
            }
            .certificate-container {
                width: 210mm;
                height: 297mm;
                margin: 0 auto;
                padding: 30mm 20mm;
                border: 10px double #000;
                box-sizing: border-box;
                position: relative;
            }
            .certificate-header {
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
                margin-bottom: 20px;
            }
            .certificate-header img {
                max-width: 100px;
                margin-right: 20px;
            }
            .certificate-header h1 {
                font-size: 2.5em;
                margin: 0;
            }
            .certificate-body {
                text-align: justify;
                font-size: 1.2em;
                line-height: 1.6;
                margin-top: 30px;
            }
            .certificate-footer {
                position: absolute;
                bottom: 50mm;
                right: 30mm;
                text-align: center;
            }
            .certificate-footer p {
                margin: 0;
                font-size: 1.2em;
            }
        </style>
    </head>
    <body>
        <div class='certificate-container'>
            <div class='certificate-header'>
                <img src='$logo' alt='Barangay Logo'>
                <h1>Certificate of Indigency</h1>
            </div>
            <div class='certificate-body'>
                <p>This is to certify that <strong>$full_name</strong>, a resident of Barangay 
                <strong>$barangay_name, $city, $province</strong>, is hereby recognized as an indigent member of our community.</p>
                <p>This certification is issued upon request for the purpose of <strong>$reason</strong>.</p>
                <p>Issued this <strong>" . date('F d, Y') . "</strong> at Barangay $barangay_name, $city, $province.</p>
            </div>
            <div class='certificate-footer'>
                <p>__________________________</p>
            <p><strong>$signatory_name</strong></p>
            <p>$signatory_position</p>
            </div>
        </div>
    </body>
    </html>";
    }


    private function generate_business_clearance($request, $signatory)
    {
        $request_data_string = $request['request_data'];

        // Decode the JSON string to get the associative array
        $request_data = json_decode($request_data_string, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            die('Error decoding JSON: ' . json_last_error_msg());
        }

        // Access data safely
        $business_name = isset($request_data['business_name']) ? htmlspecialchars($request_data['business_name']) : 'Unknown';
        $owner_name = isset($request_data['owner_name']) ? htmlspecialchars($request_data['owner_name']) : 'Unknown';
        $business_address = isset($request_data['business_address']) ? htmlspecialchars($request_data['business_address']) : 'Unknown';
        $nature_of_business = isset($request_data['nature_of_business']) ? htmlspecialchars($request_data['nature_of_business']) : 'Unknown';

        // Fetch barangay information
        $barangay_info = $this->admin_model->get_barangay();
        $barangay_name = htmlspecialchars($barangay_info['barangay_name']);
        $city = htmlspecialchars($barangay_info['city']);
        $province = htmlspecialchars($barangay_info['province']);
        $logo = htmlspecialchars(BASE_URL . PUBLIC_DIR . '/uploads/' . $barangay_info['logo']);

        // Signatory information
        $signatory_name = htmlspecialchars($signatory['fullname']);
        $signatory_position = htmlspecialchars($signatory['position']);

        // Generate the business clearance HTML
        return "
    <!DOCTYPE html>
    <html>
    <head>
        <title>Business Clearance</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
            }
            .certificate-container {
                width: 210mm;
                height: 297mm;
                margin: 0 auto;
                padding: 30mm 20mm;
                border: 10px double #000;
                box-sizing: border-box;
                position: relative;
            }
            .certificate-header {
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
                margin-bottom: 20px;
            }
            .certificate-header img {
                max-width: 100px;
                margin-right: 20px;
            }
            .certificate-header h1 {
                font-size: 2.5em;
                margin: 0;
            }
            .certificate-body {
                text-align: justify;
                font-size: 1.2em;
                line-height: 1.6;
                margin-top: 30px;
            }
            .certificate-footer {
                position: absolute;
                bottom: 50mm;
                right: 30mm;
                text-align: center;
            }
            .certificate-footer p {
                margin: 0;
                font-size: 1.2em;
            }
        </style>
    </head>
    <body>
        <div class='certificate-container'>
            <div class='certificate-header'>
                <img src='$logo' alt='Barangay Logo'>
                <h1>Business Clearance</h1>
            </div>
            <div class='certificate-body'>
                <p>This is to certify that the business <strong>$business_name</strong>, owned by 
                <strong>$owner_name</strong>, and located at <strong>$business_address</strong> in Barangay 
                <strong>$barangay_name, $city, $province</strong>, is duly cleared to operate based on barangay policies.</p>
                <p>Nature of Business: <strong>$nature_of_business</strong>.</p>
                <p>This certification is issued for business purposes and is valid until revoked by competent authority.</p>
                <p>Issued this <strong>" . date('F d, Y') . "</strong> at Barangay $barangay_name, $city, $province.</p>
            </div>
            <div class='certificate-footer'>
                <p>__________________________</p>
                <p><strong>$signatory_name</strong></p>
                <p>$signatory_position</p>
            </div>
        </div>
    </body>
    </html>";
    }


    private function generate_residency_certificate($request, $signatory)
    {
        $request_data_string = $request['request_data'];

        // Decode the JSON string to get the associative array
        $request_data = json_decode($request_data_string, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            die('Error decoding JSON: ' . json_last_error_msg());
        }

        // Access data safely
        $resident_name = isset($request_data['resident_name']) ? htmlspecialchars($request_data['resident_name']) : 'Unknown';
        $years_of_residency = isset($request_data['years_of_residency']) ? htmlspecialchars($request_data['years_of_residency']) : 'Unknown';

        // Fetch barangay information
        $barangay_info = $this->admin_model->get_barangay();
        $barangay_name = htmlspecialchars($barangay_info['barangay_name']);
        $city = htmlspecialchars($barangay_info['city']);
        $province = htmlspecialchars($barangay_info['province']);
        $logo = htmlspecialchars(BASE_URL . PUBLIC_DIR . '/uploads/' . $barangay_info['logo']);

        // Signatory information
        $signatory_name = htmlspecialchars($signatory['fullname']);
        $signatory_position = htmlspecialchars($signatory['position']);

        // Generate the residency certificate HTML
        return "
<!DOCTYPE html>
<html>
<head>
    <title>Residency Certificate</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .certificate-container {
            width: 210mm;
            height: 297mm;
            margin: 0 auto;
            padding: 30mm 20mm;
            border: 10px double #000;
            box-sizing: border-box;
            position: relative;
        }
        .certificate-header {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin-bottom: 20px;
        }
        .certificate-header img {
            max-width: 100px;
            margin-right: 20px;
        }
        .certificate-header h1 {
            font-size: 2.5em;
            margin: 0;
        }
        .certificate-body {
            text-align: justify;
            font-size: 1.2em;
            line-height: 1.6;
            margin-top: 30px;
        }
        .certificate-footer {
            position: absolute;
            bottom: 50mm;
            right: 30mm;
            text-align: center;
        }
        .certificate-footer p {
            margin: 0;
            font-size: 1.2em;
        }
    </style>
</head>
<body>
    <div class='certificate-container'>
        <div class='certificate-header'>
            <img src='$logo' alt='Barangay Logo'>
            <h1>Residency Certificate</h1>
        </div>
        <div class='certificate-body'>
            <p>This is to certify that <strong>$resident_name</strong>, a resident of Barangay 
            <strong>$barangay_name</strong> in the city of <strong>$city, $province</strong>, has been living in this barangay 
            for a period of <strong>$years_of_residency year(s)</strong>.</p>
            <p>This certification is issued upon request for whatever legal purpose it may serve.</p>
            <p>Issued this <strong>" . date('F d, Y') . "</strong> at Barangay $barangay_name, $city, $province.</p>
        </div>
        <div class='certificate-footer'>
            <p>__________________________</p>
            <p><strong>$signatory_name</strong></p>
            <p>$signatory_position</p>
        </div>
    </div>
</body>
</html>";
    }
}

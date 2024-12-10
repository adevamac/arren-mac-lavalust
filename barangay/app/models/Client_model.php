<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');
class Client_model extends Model
{

  public function add_barangay_clearance(
    $full_name,
    $address,
    $purpose,
    $submitted_by,
    $request_data
  ) {
    try {
      // Insert into `barangay_clearance` table
      $barangay_clearance_data = array(
        'full_name' => $full_name,
        'address' => $address,
        'purpose' => $purpose,
        'submitted_by' => $submitted_by,
      );

      if (!$this->db->table('barangay_clearance')->insert($barangay_clearance_data)) {
        throw new Exception('Failed to insert into barangay_clearance table.');
      }

      // Insert into `requests` table
      $requests_data = array(
        'user_id' => $submitted_by,
        'request_type' => 'barangay_clearance',
        'request_data' => json_encode($request_data),
        'status' => 'pending', // Default status
      );

      if (!$this->db->table('requests')->insert($requests_data)) {
        throw new Exception('Failed to insert into requests table.');
      }

      $this->db->commit();
      return true;
    } catch (Exception $e) {

      $this->db->rollback();
      return false;
    }
  }


  public function add_certificate_of_indigency(
    $full_name,
    $reason,
    $submitted_by,
    $request_data
  ) {

    try {
      // Insert into `certificate_of_indigency` table
      $certificate_data = array(
        'full_name' => $full_name,
        'reason' => $reason,
        'submitted_by' => $submitted_by,
      );

      if (!$this->db->table('certificate_of_indigency')->insert($certificate_data)) {
        throw new Exception('Failed to insert into certificate_of_indigency table.');
      }

      // Insert into `requests` table
      $requests_data = array(
        'user_id' => $submitted_by,
        'request_type' => 'indigency',
        'request_data' => json_encode($request_data), // Encode as JSON
        'status' => 'pending', // Default status
      );

      if (!$this->db->table('requests')->insert($requests_data)) {
        throw new Exception('Failed to insert into requests table.');
      }

      // Commit transaction if both inserts succeed
      $this->db->commit();
      return true;
    } catch (Exception $e) {
      // Rollback transaction in case of failure
      $this->db->rollback();
      return false;
    }
  }




  public function add_business_clearance(
    $business_name,
    $owner_name,
    $business_address,
    $nature_of_business,
    $submitted_by,
    $request_data
  ) {

    try {
      // Insert into `business_clearance` table
      $business_clearance_data = array(
        'business_name' => $business_name,
        'owner_name' => $owner_name,
        'business_address' => $business_address,
        'nature_of_business' => $nature_of_business,
        'submitted_by' => $submitted_by,
      );

      if (!$this->db->table('business_clearance')->insert($business_clearance_data)) {
        throw new Exception('Failed to insert into business_clearance table.');
      }

      // Insert into `requests` table
      $requests_data = array(
        'user_id' => $submitted_by,
        'request_type' => 'business_clearance',
        'request_data' => json_encode($request_data), // Encode as JSON
        'status' => 'pending', // Default status
        
      );

      if (!$this->db->table('requests')->insert($requests_data)) {
        throw new Exception('Failed to insert into requests table.');
      }

      // Commit transaction if both inserts succeed
      $this->db->commit();
      return true;
    } catch (Exception $e) {
      // Rollback transaction in case of failure
      $this->db->rollback();
      return false;
    }
  }


  public function add_residency_certificate(
    $resident_name,
    $years_of_residency,
    $submitted_by,
    $request_data
  ) {

    try {
      // Insert into `residency_certificate` table
      $residency_certificate_data = array(
        'resident_name' => $resident_name,
        'years_of_residency' => $years_of_residency,
        'submitted_by' => $submitted_by,
      );

      if (!$this->db->table('residency_certificate')->insert($residency_certificate_data)) {
        throw new Exception('Failed to insert into residency_certificate table.');
      }

      // Insert into `requests` table
      $requests_data = array(
        'user_id' => $submitted_by,
        'request_type' => 'residency_certificate',
        'request_data' => json_encode($request_data), // Encode as JSON
        'status' => 'pending', // Default status
        
      );

      if (!$this->db->table('requests')->insert($requests_data)) {
        throw new Exception('Failed to insert into requests table.');
      }

      // Commit transaction if both inserts succeed
      $this->db->commit();
      return true;
    } catch (Exception $e) {
      // Rollback transaction in case of failure
      $this->db->rollback();
      return false;
    }
  }


  public function get_user_requests($user_id)
  {
    return $this->db->table('requests')
      ->where('user_id', $user_id)
      ->get_all();
  }
}

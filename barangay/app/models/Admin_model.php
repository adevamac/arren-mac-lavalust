<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');
class Admin_model extends Model
{

  public function get_all_res_profile()
  {
    return $this->db->table('profiling')
      ->get_all();
  }
  public function add_resident(
    $f_name,
    $m_name,
    $l_name,
    $suffix,
    $gender,
    $dob,
    $civil_status,
    $street_sitio,
    $occupation_status,
  ) {
    // Prepare data for insertion
    $data = array(
      'f_name' => $f_name,
      'm_name' => $m_name,
      'l_name' => $l_name,
      'suffix' => $suffix,
      'dob' => $dob,
      'gender' => $gender,
      'civil_status' => $civil_status,
      'street_sitio' => $street_sitio,
      'occupation_status' => $occupation_status,
    );
    if ($this->db->table('profiling')->insert($data)) {
      return true;
    } else {
      return false;
    }
  }
  public function save_barangay_info($barangay_name, $city, $province, $zip_code, $logo_name)
  {
    // Prepare the data array
    $data = [
      'barangay_name' => $barangay_name,
      'city' => $city,
      'province' => $province,
      'zip_code' => $zip_code,
      'logo' => $logo_name
    ];

    // Check if a record already exists in the database (assuming there's only one record)
    $existing_record = $this->db->table('barangay_info')->get();  // Adjust if needed to match the method for retrieving records

    if ($existing_record) {
      // If a record exists, update it
      $update = $this->db->table('barangay_info')->where('id', $existing_record['id'])->update($data);

      if ($update) {
        return true;
      } else {
        return false;
      }
    } else {
      // If no record exists, insert a new one
      $insert = $this->db->table('barangay_info')->insert($data);

      if ($insert) {
        return true;
      } else {
        return false;
      }
    }
  }



  public function get_barangay_info()
  {
    return $this->db->table('barangay_info')
      ->get_all();
  }

  public function add_officials(
    $full_name,
    $contact,
    $position,
    $is_signatory,
  ) {
    // Prepare data for insertion
    $data = array(
      'fullname' => $full_name,
      'contact' => $contact,
      'position' => $position,
      'is_signatory' => $is_signatory,
    );
    if ($this->db->table('officials')->insert($data)) {
      return true;
    } else {
      return false;
    }
  }
  public function get_all_officials()
  {
    return $this->db->table('officials')
      ->get_all();
  }

  public function update_officials($id, $full_name, $contact, $position, $is_signatory)
  {
    // Check if the ID and data are provided
    if (empty($id) || empty($full_name) || empty($contact) || empty($position)) {
      return false; // Return false if any required field is missing
    }
    // Prepare the data array for the update query
    $data = [
      'fullname' => $full_name,
      'contact' => $contact,
      'position' => $position,
      'is_signatory' => $is_signatory ? 1 : 0 // Ensure it's stored as an integer in the database
    ];

    // Update the database record based on the ID
    $update = $this->db->table('officials')->where('id', $id)->update($data);

    if ($update) {
      return true;
    } else {
      return false;
    }
  }



  //--------------------------datavisual-----------------------------//

  public function get_gender_distribution()
  {
    $query = $this->db->table('profiling')
      ->select('gender')
      ->select_count('gender', 'count')
      ->group_by('gender')
      ->get_all();
    return $query;
  }

  public function get_civil_status_distribution()
  {
    $query = $this->db->table('profiling')
      ->select('civil_status')
      ->select_count('civil_status', 'count')
      ->group_by('civil_status')
      ->get_all();

    return $query;
  }

  public function get_age_distribution()
  {
    // Query to fetch ages
    $query = $this->db->table('profiling')
      ->select('FLOOR(DATEDIFF(CURDATE(), dob) / 365) AS age')
      ->get_all();

    // Initialize age groups
    $age_groups = [
      'Infant (0-1)' => 0,
      'Toddler (2-4)' => 0,
      'Child (5-12)' => 0,
      'Teen (13-19)' => 0,
      'Adult (20-59)' => 0,
      'Senior Adult (60+)' => 0
    ];

    // Categorize each age into its group
    foreach ($query as $row) {
      $age = (int)$row['age'];

      if ($age >= 0 && $age <= 1) {
        $age_groups['Infant (0-1)']++;
      } elseif ($age >= 2 && $age <= 4) {
        $age_groups['Toddler (2-4)']++;
      } elseif ($age >= 5 && $age <= 12) {
        $age_groups['Child (5-12)']++;
      } elseif ($age >= 13 && $age <= 19) {
        $age_groups['Teen (13-19)']++;
      } elseif ($age >= 20 && $age <= 59) {
        $age_groups['Adult (20-59)']++;
      } elseif ($age >= 60) {
        $age_groups['Senior Adult (60+)']++;
      }
    }

    // Convert to an array format suitable for the view
    $result = [];
    foreach ($age_groups as $age_range => $count) {
      $result[] = [
        'age_range' => $age_range,
        'count' => $count
      ];
    }

    return $result;
  }


  public function get_occupation_status_distribution()
  {
    // Query to count the number of users for each occupation status
    $query = $this->db->table('profiling')
      ->select('occupation_status, COUNT(*) as count')
      ->group_by('occupation_status')
      ->order_by('count', 'DESC')
      ->get_all();
    return $query;
  }

  public function get_street_sitio_distribution()
  {
    $query = $this->db->table('profiling')
      ->select('street_sitio, COUNT(*) AS count')
      ->group_by('street_sitio')
      ->order_by('count', 'DESC')
      ->get_all();
    return $query;
  }

  public function get_age_civil_status_distribution()
  {
    $query = $this->db->table('profiling')
      ->select("FLOOR(DATEDIFF(CURDATE(), dob) / 365) DIV 10 * 10 AS age_group, civil_status, COUNT(*) AS count")
      ->group_by("age_group, civil_status")
      ->order_by('age_group', 'ASC')
      ->get_all();
    return $query;
  }





  public function get_all_requests()
  {
    return $this->db->table('requests')
      ->select('requests.*, users.f_name, users.m_name, users.l_name, users.suffix')
      ->join('users', 'users.id = requests.user_id')
      ->get_all();
  }

  public function update_request_status($request_id, $status)
  {
    return $this->db->table('requests')
      ->where('id', $request_id)
      ->update(['status' => $status]);
  }

  public function get_request_by_id($request_id)
  {
    return $this->db->table('requests')
      ->where('id', $request_id)
      ->get();
  }

  public function get_barangay()
  {
    return $this->db->table('barangay_info')
      ->get();
  }

  public function get_official_by_id($signatory_id)
  {
    return $this->db->table('officials')
      ->where('id', $signatory_id)
      ->get();
  }
}

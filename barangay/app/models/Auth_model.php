<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');
class Auth_model extends Model
{

  private function passwordhash($password)
  {
    $options = array(
      'cost' => 12,
    );
    return password_hash($password, PASSWORD_BCRYPT, $options);
  }


  public function register(
    $f_name,
    $m_name,
    $l_name,
    $suffix,
    $address,
    $dob,
    $gender,
    $email,
    $password,
    $verification_token,
    $user_avatar
  ) {
    // Prepare data for insertion
    $data = array(
      'f_name' => $f_name,
      'm_name' => $m_name,
      'l_name' => $l_name,
      'suffix' => $suffix,
      'address' => $address,
      'dob' => $dob,
      'gender' => $gender,
      'email' => $email,
      'password' => $this->passwordhash($password),
      'verification_token' => $verification_token,
      'user_avatar' => $user_avatar,
    );

    $query = $this->db->table('users')
      ->where('email', $email)
      ->get();
    if ($query) {
      return false; // User already exists
    }
    try {
      return $this->db->table('users')->insert($data) ? true : false;
    } catch (PDOException $err) {
      return false;
    }
  }


  public function login($email, $password)
  {
    $row = $this->db->table('users')
      ->where('email', $email)
      ->get();

    if ($row) {
      if (password_verify($password, $row['password'])) {
        $data = array(
          'id' => $row['id'],
          'f_name' => $row['f_name'],
          'user_avatar' => $row['user_avatar'],
          'user_type' => $row['user_type']
        );
        return $data;
      } else {
        return false;
      }
    } else {
      return "none";
    }
  }

  public function check_validation_status($email)
  {
    $row = $this->db->table('users')
      ->where('email', $email)
      ->get_all();
    if ($row) {
      if ($row[0]['verification_status'] == 0) {
        return $row[0]['email'];
      } else {
        return false;
      }
    }
  }


  public function set_logged_in_session($id, $f_name, $user_avatar,$user_type)
  {
    return
      $this->session->set_userdata(array(
        'id' => $id,
        'f_name' => $f_name,
        'user_avatar' => $user_avatar,
        'user_type' => $user_type,
        'loggedin' => 1
      ));
  }

  public function is_logged_in()
  {
    if ($this->session->userdata('loggedin') == 1)
      return true;
  }



  public function verify_account($email, $code)
  {
    $row = $this->db->table('users')
      ->where('email', $email)
      ->get();

    if ($row) {
      $where = [
        'email' => $email,
        'verification_token' => $code,
      ];

      $data = array(
        'verification_status' => 1,
        'verification_token' => $code,
      );
      $result = $this->db->table('users')->where($where)->update($data);
      if ($result) {
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  public function is_user_registered($email, $code)
  {
    // Check if the user exists
    $row = $this->db->table('users')
      ->where('email', $email)
      ->get_all();
    // If user exists
    if ($row) {
      // Check if the user is not verified
      if ($row[0]['verification_status'] == 0) {
        // Prepare data for updating the verification token
        $data = array(
          'verification_token' => $code,
        );
        // Update the user's verification token
        $updateResult = $this->db->table('users')
          ->where('email', $email)
          ->update($data);
        return $updateResult ? 1 : 'error';
      } else {
        // User already verified
        return 'error';
      }
    } else {
      // No record found
      return 'noRecord';
    }
  }

  public function user_change_password($email)
  {
    $row = $this->db->table('users')
      ->where('email', $email)
      ->get();

    if ($row) {
      $data = array(
        'email' => $row['email'],
        'verify_token' => $row['verification_token']
      );
      return $data;
    } else {
      return false;
    }
  }

  public function complete_change_password($token, $password)
  {
    $new_token = mt_rand(111111111, 999999999);
    $data = array(
      'password' => $this->passwordhash($password),
      'verification_token' => $new_token,
    );
    $result = $this->db->table('users')
      ->where(array('verification_token' => $token))
      ->update($data);
    if ($result) {
      return true;
    } else {
      return false;
    }
  }
}

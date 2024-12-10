<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');
/**
 * ------------------------------------------------------------------
 * LavaLust - an opensource lightweight PHP MVC Framework
 * ------------------------------------------------------------------
 *
 * MIT License
 *
 * Copyright (c) 2020 Ronald M. Marasigan
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package LavaLust
 * @author Ronald M. Marasigan <ronald.marasigan@yahoo.com>
 * @since Version 1
 * @link https://github.com/ronmarasigan/LavaLust
 * @license https://opensource.org/licenses/MIT MIT License
 */

/*
| -------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------
| Here is where you can register web routes for your application.
|
|
*/

$router->get('/', 'Auth::index');
$router->match('/login', 'Auth::login', array('POST'));
$router->get('/signup', 'Auth::signup');
$router->match('/register', 'Auth::register', array('POST'));
$router->match('/verify', 'Auth::verify_account', array('POST'));
$router->match('/resend_token', 'Auth::resend_verification_token', array('POST', 'GET'));
$router->match('/forgot_password', 'Auth::forgot_password', array('POST', 'GET'));
$router->match('/change_password/{id}', 'Auth::change_password', array('POST', 'GET'));
$router->get('/dashboard', 'Auth::page');
$router->match('/profiling', 'Admin::profiling', array('POST', 'GET'));
$router->match('/add_resident', 'Admin::add_resident', array('POST', 'GET'));
$router->match('/barangay_info', 'Admin::barangay_info', array('POST', 'GET'));
$router->match('/save_barangay_info', 'Admin::save_barangay_info', array('POST', 'GET'));
$router->match('/officials', 'Admin::officials', array('POST', 'GET'));
$router->match('/add_officials', 'Admin::add_officials', array('POST', 'GET'));
$router->match('/edit_officials/{id}', 'Admin::edit_officials', array('POST', 'GET'));
$router->match('/submit_barangay_clearance', 'Client::submit_barangay_clearance', array('POST', 'GET'));
$router->match('/submit_indigency', 'Client::submit_indigency', array('POST', 'GET'));
$router->match('/submit_business_clearance', 'Client::submit_business_clearance', array('POST', 'GET'));
$router->match('/submit_residency_certificate', 'Client::submit_residency_certificate', array('POST', 'GET'));
$router->match('/requests', 'Client::requests', array('POST', 'GET'));
$router->match('/all_requests', 'Admin::requests', array('POST', 'GET'));
$router->match('/update_request_status', 'Admin::update_request_status', array('POST', 'GET'));
$router->match('/generate_certificate', 'Admin::generate_certificate', array('POST', 'GET'));
$router->get('/logout', 'Auth::logout');


//$router->match('/add_users', 'Users::add_users', array('POST', 'GET'));
//$router->match('/edit_users/{id}', 'Users::edit_users', array('POST', 'GET'));
//$router->match('/delete_users/{id}', 'Users::delete_users', array('POST', 'GET'));

<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #dddddd;
            border-radius: 10px;
        }
        .header {
            text-align: center;
            background-color: #4CAF50;
            color: #ffffff;
            padding: 10px 0;
        }
        .content {
            margin-top: 20px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #888888;
        }
        a.button {
            display: inline-block;
            padding: 10px 15px;
            background-color: #4CAF50;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        @media only screen and (max-width: 600px) {
            .container {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h2>Account Verification</h2>
        </div>
        <div class='content'>
            <p>Hello! <strong></strong>,</p>
            <p>Thank you for using our system. Please take note of your account details below:</p>
       
            <p><strong>Verification Code:</strong> <?= $code ?></p>
            <p>Use the given code to verify your account. Simply click the button below to complete the process:</p>
            <p><a href='#' class='button'>Verify Account</a></p>
        </div>
        <div class='footer'>
            <p>&copy; 2024 Masipit. All rights reserved.</p>
        </div>
    </div>
</body>
</html>

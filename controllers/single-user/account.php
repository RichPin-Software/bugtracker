<?php
/**
 *      Author: Richard Pinegar
 *      Date: 11/29/2020
 * 
 *      Controller for account information.
 *
 */
include('../../includes/init.php');
include('../../includes/database.php');
/*
    form variables
*/
$pass_confirm_key = 'input_pass_confirm';
$err_key_pass_confirm = 'error_pass_confirm';
$pass_key = 'input_pass';
$err_key_pass = 'error_pass';
$error = '*required field!';
/*
    set variable for user database
*/
$db_user_table = $_SESSION['user'];

if(isset($_SESSION['currentUser']))
{
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $username = $_POST['username'];
        $new_password = $_POST['password'];
        $password_confirm = $_POST['password_confirm'];

        if($Template->formValidate($pass_key, $new_password, $err_key_pass, $pass_confirm_key, $password_confirm, $err_key_pass_confirm, $error))
        {
            if($new_password != $password_confirm)
            {
                $Template->setData($err_key_pass, '*passwords do not match!');
                $Template->setData($err_key_pass_confirm, '*passwords do not match!');
                $Template->load('../../views/single-user/v_account.php');
            }
            else if(strlen($new_password) > 0 && strlen($new_password) < 8)
            {
                $Template->setData($err_key_pass, '*password must be at least 8 characters!');
                $Template->load('../../views/single-user/v_account.php');
            }
            else
            {
                $password = $Template->getData($pass_key);

                $Auth->changePassword($username, $password);
                $Template->setAlert('Password changed successfully!', 'success');
                $Template->redirect('account.php');
            }
        }
        else
        {
            $Template->load('../../views/single-user/v_account.php');
        }
    }
    else
    {
        $Template->load('../../views/single-user/v_account.php');
    }
}
else
{
    $Template->setAlert('Access Denied!', 'error');
    $Template->redirect('../../login.php');
}
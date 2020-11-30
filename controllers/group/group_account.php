<?php
/**
 *      Author: Richard Pinegar
 *      Date: 11/29/2020
 * 
 *      Controller for group account information.
 *
 */
include('../../includes/init.php');
include('../../includes/database.php');
/*
    form variables
*/
$pass_key = 'input_pass';
$err_key_pass = 'error_pass';
$error = '*required field!';
/*
    set variable for user database
*/
$db_user_table = $_SESSION['user'];

if(isset($_SESSION['currentUser']))
{
    $Template->load('../../views/group/v_group_account.php');
}
else
{
    $Template->setAlert('Access Denied!', 'error');
    $Template->redirect('../../login.php');
}
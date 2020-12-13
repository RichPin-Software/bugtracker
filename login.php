<?php
/**
 *      Author: Richard Pinegar
 *      Date: 11/19/2020
 * 
 *      Controller for login.
 * 
 *      - User Login
 *      - Form Validation
 *      - Display Login
 *
 */
include('includes/init.php');
include('includes/database.php');
/*
    form variables
*/
$user_key = 'input_user';
$pass_key = 'input_pass';
$err_key_user = 'error_user';
$err_key_pass = 'error_pass';
$error = '*required field!';
$error2 = "*invalid username or password!";
/*
    if user submits login form
*/
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    if($Template->formValidate($user_key, $username, $err_key_user, $pass_key, $password, $err_key_pass, $error))
    {
        $username = $Template->getData($user_key);
        $password = $Template->getData($pass_key);

        if($Auth->validateLogin($username, $password))
        {
            $_SESSION['login_successful'] = true;
            $Auth->setUserInformation($username, $password);
            $_SESSION['user'] = $Auth->getUserInformation('username');
            /*
                group redirect
            */
            if($Auth->getUserInformation('groupname') != "")
            {
                $_SESSION['groupname'] = $Auth->getUserInformation('groupname');
                $_SESSION['group_table'] = $Auth->assignDatabase($username, $password);

                $Template->redirect('controllers/group/group_all_tasks.php');
            }
            /*
                single user redirect
            */
            else
            {
                $Template->redirect('controllers/single-user/all_tasks.php');
            }
        }
        else
        {
            $Template->setData($err_key_user, $error2);
            $Template->setData($err_key_pass, $error2);
            $Template->load('views/v_login.php');
        }
    }
    else
    {
        $Template->load('views/v_login.php');
    }
}
/*
    display login form
*/
else
{
    $Template->load('views/v_login.php');
}
<?php
/**
 *      Author: Richard Pinegar
 *      Date: 11/19/2020
 * 
 *      Controller for functions of login and logout.
 * 
 *      - User Login/Logout
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
            /*
                group redirect
            */
            if(preg_match("/@/", $username)===1)
            {
                $pos = strpos($username, '@') + 1;
                $groupname = substr($username, $pos);

                $_SESSION['user'] = $Template->getData($user_key);
                $_SESSION['groupname'] = $groupname;
                $_SESSION['group_table'] = "group_$groupname";
                $Template->redirect('group_users.php');
            }
            /*
                regular user - no group redirect
            */
            else
            {
                $_SESSION['user'] = $Template->getData($user_key);
                $Template->redirect('users.php');
            }
        }
        else
        {
            $Template->setAlert('Invalid username or password!','error');
            $Template->load('views/v_login.php');
        }
    }
    else
    {
        $Template->setAlert('Must complete required fields', 'error');
        $Template->load('views/v_login.php');
    }
}
/*
    if user logs out
*/
else if(isset($_GET['logout']))
{
    session_unset();
    session_destroy();

    $Template->setAlert('Logout Successful', 'success');
    $Template->load('views/v_login.php');
}
/*
    display login form
*/
else
{
    $Template->load('views/v_login.php');
}
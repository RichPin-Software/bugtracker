<?php
/**
 *      Author: Richard Pinegar
 *      Date: 11/19/2020
 * 
 *      Controller for functions to create a new user account
 *      or group.
 * 
 *      - Create New Username and Password
 *      - Form Validation
 *      - Display New User Form
 *
 */
include('includes/init.php');
include('includes/database.php');

$group_key = 'new_group';
$user_key = 'new_user';
$pass_key = 'newuser_pass';
$err_key_group = 'error_group';
$err_key_user = 'error_user';
$err_key_pass = 'error_pass';
$error = '*required field!';
/*
    display new user form
*/
if(isset($_GET['signup']))
{
    if(isset($_SESSION['group']))
    {
        unset($_SESSION['group']);
    }

    $Template->load('views/v_new_user.php');
}
/*
    display new user group form
*/
else if(isset($_GET['group']))
{
    $_SESSION['group'] = true;
    $Template->load('views/v_group_new_user.php');
}
/*
    if user submits new user group form
*/
else if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['group']))
{
    $groupname = $_POST['groupname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $special_char = '/\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\-|\+|\=|\]|\[|\}|\{|\"|\'|\:|\;|\?|\/|\>|\<|\,|\./';
    
    if($Template->groupFormValidate($user_key, $username, $err_key_user, $pass_key, $password, $err_key_pass, $group_key, $groupname, $err_key_group, $error))
    {
        if((strlen($username) > 0 && strlen($username) < 8) || (preg_match($special_char, $username)===1) || (strlen($password) > 0 && strlen($password) < 8) || (strlen($groupname) > 0 && strlen($groupname) < 2) || (preg_match($special_char, $groupname)===1))
        {
            if(strlen($username) < 8)
            {
                $Template->setData($err_key_user, '*must be at least 8 characters');
            }
            if((preg_match($special_char, $username)===1))
            {
                $Template->setData($err_key_user, "*letters, numbers and underscore only!");
            }
            if(strlen($password) < 8)
            {
                $Template->setData($err_key_pass, '*must be at least 8 characters');
            }
            if(strlen($groupname) < 2)
            {
                $Template->setData($err_key_group, '*must be at least 2 characters');
            }
            if((preg_match($special_char, $groupname)===1))
            {
                $Template->setData($err_key_group, "*letters, numbers and underscore only!");
            }
            
            $Template->load('views/v_group_new_user.php');
        }
        else if(!$Auth->validateNewUsername($username))
        {
            $Template->setData($err_key_user, '*username already exists!');
            $Template->load('views/v_group_new_user.php');
        }
        else if(!$Auth->validateNewGroupname($groupname))
        {
            $Template->setData($err_key_group, '*group name already exists!');
            $Template->load('views/v_group_new_user.php');
        }
        /*
            create new user group account and table
        */
        else
        {
            $Template->setData($group_key, $_POST['groupname']);
            $Template->setData($user_key, $_POST['username']);
            $Template->setData($pass_key, $_POST['password']);
            $new_group = $Template->getData($group_key);
            $new_user = $Template->getData($user_key);
            $new_password = $Template->getData($pass_key);

            $Auth->addNewUserGroup($new_user, $new_group, $new_password);
            $Template->setAlert("Welcome $new_user! Please sign in with your new username and password!", 'success');
            $Template->redirect("login.php");
        }
    }
    else
    {
        $Template->setAlert('Must complete required fields', 'error');
        $Template->load('views/v_group_new_user.php');
    }
}
/*
    if user submits new user form
*/
else if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $username = $_POST['username'];
    $password = $_POST['password'];
    $special_char = '/\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\-|\+|\=|\]|\[|\}|\{|\"|\'|\:|\;|\?|\/|\>|\<|\,|\./';
    
    if($Template->formValidate($user_key, $username, $err_key_user, $pass_key, $password, $err_key_pass, $error))
    {
        if((strlen($username) > 0 && strlen($username) < 8) || (preg_match($special_char, $username)===1) || (strlen($password) > 0 && strlen($password) < 8))
        {
            if(strlen($username) < 8)
            {
                $Template->setData($err_key_user, '*must be at least 8 characters');
            }
            if(preg_match($special_char, $username)===1)
            {
                $Template->setData($err_key_user, "*letters, numbers and underscore only!");
            }
            if(strlen($password) < 8)
            {
                $Template->setData($err_key_pass, '*must be at least 8 characters');
            }
            
            $Template->load('views/v_new_user.php');
        }
        else if(!$Auth->validateNewUsername($username))
        {
            $Template->setData($err_key_user, '*username already exists!');
            $Template->load('views/v_new_user.php');
        }
        /*
            create new user account
        */
        else
        {
            $Template->setData($user_key, $_POST['username']);
            $Template->setData($pass_key, $_POST['password']);
            $new_user = $Template->getData($user_key);
            $new_password = $Template->getData($pass_key);

            $Auth->addNewUser($new_user, $new_password);

            $Template->setAlert("Welcome $new_user! Please sign in with your new username and password!", 'success');
            $Template->redirect("login.php");
        }
    }
    else
    {
        $Template->setAlert('Must complete required fields', 'error');
        $Template->load('views/v_new_user.php');
    }
}
else
{
    die("Error: page did not load properly");
}
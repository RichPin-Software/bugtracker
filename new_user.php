<?php
include('includes/init.php');
include('includes/database.php');

if(isset($_GET['signup']))
{
    $Template->load('views/v_new_user.php');
}
else if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if($_POST['username']=='' || $_POST['password']=='')
    {
        if($_POST['username']=='')
        {
            $Template->setData('error_user', '*required!');
        }
        if($_POST['password']=='')
        {
            $Template->setData('error_pass', '*required!');
        }
        $Template->setAlert('Must complete required fields', 'error');
        $Template->load('views/v_new_user.php');
    }
    else
    {
        // create new user account
        $Template->setData('new_user', $_POST['username']);
        $Template->setData('newuser_pass', $_POST['password']);
        $new_user = $Template->getData('new_user');
        $new_password = $Template->getData('newuser_pass');

        $Auth->addNewUser($new_user, $new_password);
        $Template->setAlert("Welcome $new_user! Please sign in with your new username and password!", 'success');
        $Template->redirect("login.php");
    }
}
else
{
    die("Error: page did not load properly");
}
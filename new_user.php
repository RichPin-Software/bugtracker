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
        // show error
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
        // new member created
        $member = $_POST['username'];
        $Template->setAlert("Welcome $member! Please sign in with your new username and password!", 'success');
        $Template->redirect('login.php');
    }
}
<?php
    include('includes/init.php');
    include('includes/database.php');

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $Template->setData('input_user', $_POST['username']);
        $Template->setData('input_pass', $_POST['password']);

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
            $Template->load('views/v_login.php');
        }
        else
        {
            // successful login
            $_SESSION['userLoggedIn'] = true;
            $Template->redirect('members.php');
        }
    }
    else
    {
        if(isset($_GET['userLoggedOut']))
        {
            $Template->setAlert('Successfully Logged Out', 'success');
        }

        $Template->load('views/v_login.php');
    }
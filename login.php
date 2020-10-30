<?php
    include('includes/init.php');
    include('includes/database.php');
    // IF USER SUBMITS LOGIN FORM
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $Template->setData('input_user', $_POST['username']);
        $Template->setData('input_pass', $_POST['password']);

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
            $Template->load('views/v_login.php');
        }
        else
        {
            if($Auth->validateLogin($Template->getData('input_user'), $Template->getData('input_pass')) == false)
            {
                $Template->setAlert('Invalid username or password!','error');
                $Template->load('views/v_login.php');
            }
            else
            {
                $_SESSION['userLoggedIn'] = true;
                $_SESSION['user'] = $Template->getData('input_user');
                $Template->redirect('users.php');
            }
        }
    }
    else
    {   // IF USER LOGS OUT
        if(isset($_GET['logout']))
        {
            if($_SESSION['userLoggedIn'])
            {
                session_unset();
                session_destroy();

                $Template->setAlert('Logout Successful', 'success');
                $Template->load('views/v_login.php');
            }
        }
        // DISPLAY LOGIN FORM
        $Template->load('views/v_login.php');
    }
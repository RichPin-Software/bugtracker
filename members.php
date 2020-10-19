<?php
    include('includes/init.php');
    include('includes/database.php');

    if($_SESSION['userLoggedIn'] && !isset($_SESSION['currentUser']))
    {
        $Template->setAlert('Login Successful!', 'success');
        $_SESSION['currentUser'] = true;
        $Template->load('views/v_members.php');
    }
    else
    {
        if($_SESSION['currentUser'])
        {
            if(isset($_GET['addTask']))
            {
                $Template->load('views/v_tasks.php');
            }
            else
            {
                $Template->load('views/v_members.php');
            }
        }
        else
        {
            $Template->load('views/v_login.php');
        }
    }

    
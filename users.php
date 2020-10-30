<?php
    include('includes/init.php');
    include('includes/database.php');

    if($_SESSION['login_successful'] && !isset($_SESSION['currentUser']))
    {
        $Template->setAlert('Login Successful!', 'success');
        $_SESSION['currentUser'] = true;
        $Template->load('views/v_users.php');
    }
    else
    {
        if(isset($_GET['id']))
        {
            $_SESSION['id'] = $_GET['id'];
            $Template->load('views/v_task.php');
        }
        // DELETE TASK
        else if(isset($_GET['deletetask']))
        {
            $id = $_SESSION['id'];
            $Auth->deleteTask($id);

            unset($_SESSION['id']);
            $Template->setAlert("BUG-$id Deleted Successfully", 'success');
            $Template->redirect('users.php');
        }
        else
        {
            if($_SESSION['currentUser'])
            {
                $Template->load('views/v_users.php');
            }
            else
            {
                $Template->load('views/v_login.php');
            }
        }
    }
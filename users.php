<?php
include('includes/init.php');
include('includes/database.php');
/*
    Form variables
*/
$title_key = 'input_title';
$desc_key = 'input_description';
$err_key_title = 'error_title';
$err_key_desc = 'error_description';
$error = '*required field!';

if(isset($_SESSION['login_successful']))
{
    /*
        Display main page with login welcome message
    */
    if(!isset($_SESSION['currentUser']))
    {
        $Template->setAlert('Welcome '.$_SESSION['user'].'!', 'success');
        $_SESSION['currentUser'] = true;
        $Template->load('views/v_users.php');
    }
    else
    {
        /*
            Set session variable for selected task
        */
        if(isset($_GET['id']))
        {
            $_SESSION['id'] = $_GET['id'];
            $Template->redirect('users.php');
        }
        /*
            If 'Back' button pressed unset id and reload
        */
        else if(isset($_GET['back']))
        {
            unset($_SESSION['id']);
            $Template->redirect('users.php');
        }
        /*
            If 'Add Task' button pressed unset id and load add task form
        */
        else if(isset($_GET['addtask']))
        {
            if(isset($_SESSION['id'])) 
            { 
                unset($_SESSION['id']);
                $Template->load('views/v_addtask.php');
            }
            else
            {
                $Template->load('views/v_addtask.php');
            }
        }
        /*
            If on selected task
        */
        else if(isset($_SESSION['id']))
        {
            $id = $_SESSION['id'];
            /*
                Delete
            */
            if(isset($_GET['deletetask']))
            {
                $Auth->deleteTask($id);

                $Template->setAlert("BUG-$id Deleted Successfully", 'success');
                unset($_SESSION['id']);
                $Template->load('views/v_users.php');
            }
            else if(isset($_GET['edittask']))
            {
                $Template->load('views/v_edittask.php');
            }
            /*
                Update
            */
            else if($_SERVER["REQUEST_METHOD"] == "POST")
            {
                $title = $_POST['task-title'];
                $description = $_POST['task-description'];

                if($Template->formValidate($title_key, $title, $err_key_title, $desc_key, $description, $err_key_desc, $error))
                {
                    $title = $Template->getData($title_key);
                    $status = "TODO";
                    $description = $Template->getData($desc_key);

                    $Auth->updateTask($id, $title, $status, $description);
                    $Template->load('views/v_task.php');
                }
                else
                {
                    $Template->load('views/v_edittask.php');
                }
            }
            /*
                Display selected task
            */
            else
            {
                $Template->load('views/v_task.php');
            }
        }
        /*
            Add new task
        */
        else if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $title = $_POST['task-title'];
            $description = $_POST['task-description'];

            if($Template->formValidate($title_key, $title, $err_key_title, $desc_key, $description, $err_key_desc, $error))
            {
                $title = $Template->getData($title_key);
                $status = "TODO";
                $author = $_SESSION['user'];
                $description = $Template->getData($desc_key);

                $Auth->addTask($title, $status, $author, $description);
                $Template->redirect('users.php');
            }
            else
            {
                $Template->load('views/v_addtask.php');
            }
        }
        /*
            Display main page
        */
        else
        {
            $Template->load('views/v_users.php');
        }
    }
}
else
{
    $Template->setAlert('Access Denied!', 'error');
    $Template->load('views/v_login.php');
}
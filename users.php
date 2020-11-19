<?php
/**
 *      Author: Richard Pinegar
 *      Date: 11/19/2020
 * 
 *      Controller for functions of all tasks and filter tasks views
 *      as well as 'Back' button functionality and new task form.
 * 
 *      - Display All Tasks
 *      - Display Filtered Tasks by Status
 *      - Add New Task
 *      - Back Button
 *
 */
include('includes/init.php');
include('includes/database.php');
/*
    form variables
*/
$title_key = 'input_title';
$desc_key = 'input_description';
$err_key_title = 'error_title';
$err_key_desc = 'error_description';
$error = '*required field!';

if(isset($_SESSION['login_successful']))
{
    /*
        display main page with login welcome message
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
            if 'Back' button pressed unset id and reload
        */
        if(isset($_GET['back']))
        {
            unset($_SESSION['id']);
            $Template->redirect('users.php');
        }
        /*
            navigation
        */
        else if(isset($_GET['filtertasks']) && !isset($_GET['page']))
        {
            $tasks = $_GET['filtertasks'];

            switch($tasks)
            {
                case 'onhold': 
                    $_SESSION['filtertasks'] = 'On-hold';
                    $Template->load('views/v_filtertasks.php');
                    break;

                case 'todo': 
                    $_SESSION['filtertasks'] = 'TODO';
                    $Template->load('views/v_filtertasks.php');
                    break;

                case 'inprogress': 
                    $_SESSION['filtertasks'] = 'In Progress';
                    $Template->load('views/v_filtertasks.php');
                    break;

                case 'resolved': 
                    $_SESSION['filtertasks'] = 'Resolved';
                    $Template->load('views/v_filtertasks.php');
                    break;

                default: 
                    $Template->load('views/v_users.php');
            }
        }
        /*
            if 'Add Task' button pressed unset id and load add task form
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
            add new task
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
            display main page
        */
        else
        {
            $Template->load('views/v_users.php');

            /*
                show 8 results per page - filter results by status (TODO, On-hold, In Progress, Resolved)
            */
            if(isset($_GET['page']) && isset($_GET['filtertasks']))
            {
                $tasks = $_GET['filtertasks'];

                $_SESSION['offset'] = 8 * ($_GET['page'] - 1);
                $Template->redirect("users.php?filtertasks=$tasks");
            }
            /*
                show 8 results per page - all tasks
            */
            else if(isset($_GET['page']) && !isset($_GET['filtertasks']))
            {
                $_SESSION['offset'] = 8 * ($_GET['page'] - 1);
                $Template->redirect('users.php');
            }
        }
    }
}
else
{
    $Template->setAlert('Access Denied!', 'error');
    $Template->redirect('login.php');
}
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
include('../../includes/init.php');
include('../../includes/database.php');
/*
    form variables
*/
$title_key = 'input_title';
$desc_key = 'input_description';
$err_key_title = 'error_title';
$err_key_desc = 'error_description';
$error = '*required field!';
/*
    set variable for user database
*/
$db_user_table = $_SESSION['user'];

if(isset($_SESSION['login_successful']))
{
    /*
        display main page with login welcome message
    */
    if(!isset($_SESSION['currentUser']))
    {
        $Template->setAlert('Welcome '.$_SESSION['user'].'!', 'success');
        $_SESSION['currentUser'] = true;
        $Template->load('../../views/single-user/v_all_tasks.php');
    }
    else
    {
        /*
            if 'Back' button pressed unset id and reload
        */
        if(isset($_GET['back']))
        {
            unset($_SESSION['id']);
            $Template->redirect('all_tasks.php');
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
                    $Template->load('../../views/single-user/v_filtertasks.php');
                    break;

                case 'todo': 
                    $_SESSION['filtertasks'] = 'TODO';
                    $Template->load('../../views/single-user/v_filtertasks.php');
                    break;

                case 'inprogress': 
                    $_SESSION['filtertasks'] = 'In Progress';
                    $Template->load('../../views/single-user/v_filtertasks.php');
                    break;

                case 'resolved': 
                    $_SESSION['filtertasks'] = 'Resolved';
                    $Template->load('../../views/single-user/v_filtertasks.php');
                    break;

                default: 
                    $Template->load('../../views/single-user/v_all_tasks.php');
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
                $Template->load('../../views/single-user/v_addtask.php');
            }
            else
            {
                $Template->load('../../views/single-user/v_addtask.php');
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

                $Auth->addTask($db_user_table, $title, $status, $author, $description);
                $Template->redirect('all_tasks.php');
            }
            else
            {
                $Template->load('../../views/single-user/v_addtask.php');
            }
        }
        /*
            Pagination - display 8 results per page
        */
        else if(isset($_GET['page']))
        {
            if(isset($_GET['filtertasks']))
            {
                $tasks = $_GET['filtertasks'];

                $_SESSION['offset'] = 8 * ($_GET['page'] - 1);
                $Template->redirect("all_tasks.php?filtertasks=$tasks");
            }
            else
            {
                $_SESSION['offset'] = 8 * ($_GET['page'] - 1);
                $Template->redirect('all_tasks.php');
            }
        }
        /*
            display main page
        */
        else
        {
            $Template->load('../../views/single-user/v_all_tasks.php');
        }
    }
}
else
{
    $Template->setAlert('Access Denied!', 'error');
    $Template->redirect('login.php');
}
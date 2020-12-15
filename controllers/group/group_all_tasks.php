<?php
/**
 *      Author: Richard Pinegar
 *      Date: 11/24/2020
 * 
 *      Controller for functions of all group tasks and filter tasks views
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
    set variable for group database
*/
$db_user_table = $_SESSION['group_table'];

if(isset($_SESSION['login_successful']))
{
    /*
        display main page with login welcome message
    */
    if(!isset($_SESSION['currentUser']))
    {
        $Template->setAlert('Welcome '.$_SESSION['user'].'!', 'success');
        $_SESSION['currentUser'] = true;
        $Template->load('../../views/group/v_group_all_tasks.php');
    }
    else
    {
        /*
            if 'Back' button pressed unset id and reload
        */
        if(isset($_GET['back']))
        {
            unset($_SESSION['id']);
            $Template->redirect('group_all_tasks.php');
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
                    $Template->load('../../views/group/v_group_filtertasks.php');
                    break;

                case 'todo': 
                    $_SESSION['filtertasks'] = 'TODO';
                    $Template->load('../../views/group/v_group_filtertasks.php');
                    break;

                case 'inprogress': 
                    $_SESSION['filtertasks'] = 'In Progress';
                    $Template->load('../../views/group/v_group_filtertasks.php');
                    break;

                case 'resolved': 
                    $_SESSION['filtertasks'] = 'Resolved';
                    $Template->load('../../views/group/v_group_filtertasks.php');
                    break;

                default: 
                    $Template->load('../../views/group/v_group_all_tasks.php');
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
                $Template->load('../../views/group/v_group_addtask.php');
            }
            else
            {
                $Template->load('../../views/group/v_group_addtask.php');
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
                if(strlen($title) > 70)
                {
                    $Template->setData($err_key_title, "*title is too long! 70 character maximum!");
                    $Template->load('../../views/group/v_group_addtask.php');
                }
                else
                {
                    $title = $Template->getData($title_key);
                    $status = "TODO";
                    $author = $_SESSION['user'];
                    $description = $Template->getData($desc_key);

                    $Auth->addTask($db_user_table, $title, $status, $author, $description);
                    $Template->redirect('group_all_tasks.php');
                }
            }
            else
            {
                $Template->load('../../views/group/v_group_addtask.php');
            }
        }
        /*
            Pagination
        */
        else if(isset($_GET['page']))
        {
            if(isset($_GET['filtertasks']))
            {
                $tasks = $_GET['filtertasks'];

                if(isset($_SESSION['results']))
                {
                    $_SESSION['offset'] = $_SESSION['results'] * ($_GET['page'] - 1);
                    $Template->redirect("group_all_tasks.php?filtertasks=$tasks");
                }
            }
            else
            {
                if(isset($_SESSION['results']))
                {
                    $_SESSION['offset'] = $_SESSION['results'] * ($_GET['page'] - 1);
                    $Template->redirect('group_all_tasks.php');
                }
            }
        }
        /*
            display main page
        */
        else
        {
            $Template->load('../../views/group/v_group_all_tasks.php');
        }
    }
}
else
{
    $Template->redirect('../../login.php');
}
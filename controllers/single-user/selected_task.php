<?php
/**
 *      Author: Richard Pinegar
 *      Date: 11/19/2020
 * 
 *      Controller for all functions of a selected task.
 * 
 *      - Display Task
 *      - Edit/Update Task
 *      - Delete Task
 *
 */
include('../../includes/init.php');
include('../../includes/database.php');
/*
    identifies selected task
*/
$id;
/*
    set variable for user database
*/
$db_user_table = $_SESSION['user'];
/*
    form variables
*/
$title_key = 'input_title';
$desc_key = 'input_description';
$err_key_title = 'error_title';
$err_key_desc = 'error_description';
$error = '*required field!';
/*
    set id session variable
*/
if(isset($_GET['id'])) { $_SESSION['id'] = $_GET['id']; }
/*
    selected task controller
*/
if(isset($_SESSION['id']))
{
    $id = $_SESSION['id'];
    /*
        delete selected task
    */
    if(isset($_GET['deletetask']))
    {
        $Auth->deleteTask($db_user_table, $id);

        $Template->setAlert("BUG-$id Deleted Successfully", 'success');
        unset($_SESSION['id']);
        $Template->redirect('all_tasks.php');
    }
    /*
        edit selected task
    */
    else if(isset($_GET['edittask']))
    {
        $Template->load('../../views/single-user/v_edittask.php');
    }
    /*
        edit selected task form submitted
    */
    else if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $title = $_POST['task-title'];
        $description = $_POST['task-description'];
        
        $status = $_POST['task-status'];

        if($Template->formValidate($title_key, $title, $err_key_title, $desc_key, $description, $err_key_desc, $error))
        {
            $title = $Template->getData($title_key);
            $description = $Template->getData($desc_key);

            $Auth->updateTask($db_user_table, $id, $title, $status, $description);
            $Template->load('../../views/single-user/v_selected_task.php');
        }
        else
        {
            $Template->load('../../views/single-user/v_edittask.php');
        }
    }
    /*
        set status of selected task
    */
    else if(isset($_GET['status']))
    {
        $status = '';

        switch($_GET['status'])
        {
            case 'onhold': 
                $status = "On-hold";
                break;
            case 'inprogress': 
                $status = "In Progress";
                break;
            case 'todo':
                $status = "TODO";
                break;
            case 'resolved':
                $status = "Resolved";
                break;
            default:
                $status = "TODO";
        }

        if($stmt = $conn->prepare("UPDATE $db_user_table SET status=? WHERE id=?"))
        {
            $stmt->bind_param("si", $status, $id);
            $stmt->execute();
            $stmt->close();
            $conn->close();
        }
        else
        {
            die("Error: could not prepare MySQLi statement");
        }
        $Template->redirect('selected_task.php');
    }
    /*
        set assignee for selected task
    */
    else if(isset($_GET['assign']))
    {
        $assignee = $_GET['assign'];

        if($stmt = $conn->prepare("UPDATE $db_user_table SET assignee=? WHERE id=?"))
        {
            $stmt->bind_param("si", $assignee, $id);
            $stmt->execute();
            $stmt->close();
            $conn->close();
        }
        else
        {
            die("Error: could not prepare MySQLi statement");
        }
        $Template->redirect('selected_task.php');
    }
    /*
        display selected task
    */
    else
    {
        $Template->load('../../views/single-user/v_selected_task.php');
    }
}
else
{
    die("Error: no task id found");
}
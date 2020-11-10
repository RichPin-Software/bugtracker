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
            Navigation
        */
        else if(isset($_GET['filtertasks']))
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
                Delete selected task
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
                Update status of selected task
            */
            else if(isset($_GET['status']))
            {
                $id = $_SESSION['id'];
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

                if($stmt = $conn->prepare("UPDATE tasks SET status=? WHERE id=?"))
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
                $Template->redirect('users.php');
            }
            /*
                Assign selected task
            */
            else if(isset($_GET['assign']))
            {
                $id = $_SESSION['id'];
                $assignee = $_GET['assign'];

                if($stmt = $conn->prepare("UPDATE tasks SET assignee=? WHERE id=?"))
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
                $Template->redirect('users.php');
            }
            /*
                Update selected task
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

            /*
                Show 8 results per page
            */
            if(isset($_GET['page']))
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
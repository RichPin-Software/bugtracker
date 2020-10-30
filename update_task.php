<?php
    include('includes/init.php');
    include('includes/database.php');
    // IF CURRENT USER
    if($_SESSION['currentUser'])
    {
        // IF USER SUBMITS UPDATE TASK FORM
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $Template->setData('input_title', $_POST['task-title']);
            $Template->setData('input_description', $_POST['task-description']);

            if($_POST['task-title']=='' || $_POST['task-description']=='')
            {
                if($_POST['task-title']=='')
                {
                    $Template->setData('error_title', '*required!');
                }
                if($_POST['task-description']=='')
                {
                    $Template->setData('error_description', '*required!');
                }
                $Template->setAlert('Must complete required fields', 'error');
                $Template->load('views/v_edittask.php');
            }
            else
            {
                // UPDATE TASK
                $id = $_SESSION['id'];
                $title = $Template->getData('input_title');
                $status = "TODO";
                $description = $Template->getData('input_description');

                $Auth->updateTask($id, $title, $status, $description);
                $Template->load('views/v_task.php');
            }
        }
        else
        {
            // DISPLAY UPDATE TASK FORM
            $Template->load('views/v_edittask.php');
        }
    }
    else
    {
        // IF NOT LOGGED IN
        $Template->setAlert('Access Denied!', 'error');
        $Template->redirect('login.php');
    }
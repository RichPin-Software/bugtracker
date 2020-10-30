<?php
    include('includes/init.php');
    include('includes/database.php');
    // IF CURRENT USER
    if($_SESSION['currentUser'])
    {
        // IF USER SUBMITS ADD TASK FORM
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
                $Template->load('views/v_addtask.php');
            }
            else
            {
                // ADD TASK
                $title = $Template->getData('input_title');
                $status = "TODO";
                $author = $_SESSION['user'];
                $description = $Template->getData('input_description');

                $Auth->addTask($title, $status, $author, $description);
                $Template->redirect('users.php');
            }
        }
        else
        {
            // DISPLAY ADD TASK FORM
            $Template->load('views/v_addtask.php');
        }
    }
    else
    {
        // IF NOT LOGGED IN
        $Template->setAlert('Access Denied!', 'error');
        $Template->redirect('login.php');
    }
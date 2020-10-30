<?php
    include('includes/init.php');
    include('includes/database.php');

    $key_1 = 'input_title';
    $key_2 = 'input_description';
    $err_key_1 = 'error_title';
    $err_key_2 = 'error_description';
    $error = '*required field!';
    /*
        If logged in as current user
    */
    if($_SESSION['currentUser'])
    {
        /*
            If user submits update task form
        */
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $title = $_POST['task-title'];
            $description = $_POST['task-description'];

            if($Template->formValidate($key_1, $title, $err_key_1, $key_2, $description, $err_key_2, $error))
            {
                /*
                    Update task
                */
                $id = $_SESSION['id'];
                $title = $Template->getData($key_1);
                $status = "TODO";
                $description = $Template->getData($key_2);

                $Auth->updateTask($id, $title, $status, $description);
                $Template->load('views/v_task.php');
            }
            else
            {
                $Template->load('views/v_edittask.php');
            }
        }
        else
        {
            /*
                Display update task form
            */
            $Template->load('views/v_edittask.php');
        }
    }
    else
    {
        /*
            If not logged in
        */
        $Template->setAlert('Access Denied!', 'error');
        $Template->redirect('login.php');
    }
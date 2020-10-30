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
            If user submits add task form
        */
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $title = $_POST['task-title'];
            $description = $_POST['task-description'];

            if($Template->formValidate($key_1, $title, $err_key_1, $key_2, $description, $err_key_2, $error))
            {
                /*
                    Add task
                */
                $title = $Template->getData($key_1);
                $status = "TODO";
                $author = $_SESSION['user'];
                $description = $Template->getData($key_2);

                $Auth->addTask($title, $status, $author, $description);
                $Template->redirect('users.php');
            }
            else
            {
                $Template->load('views/v_addtask.php');
            }
        }
        else
        {
            /*
                Display add task form
            */
            $Template->load('views/v_addtask.php');
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
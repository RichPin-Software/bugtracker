<?php
    include('includes/init.php');
    include('includes/database.php');

    if($_SESSION['userLoggedIn'] && !isset($_SESSION['currentUser']))
    {
        $Template->setAlert('Login Successful!', 'success');
        $_SESSION['currentUser'] = true;
        $Template->load('views/v_members.php');
    }
    else
    {
        if(isset($_GET['id']))
        {
            $_SESSION['id'] = $_GET['id'];
            $Template->load('views/v_tasks.php');
        }
        else if(isset($_GET['addtask']))
        {
            $Template->load('views/v_addtask.php');
        }
        else
        {
            if($_SESSION['currentUser'])
            {
                if($_SERVER["REQUEST_METHOD"] == "POST")
                {
                    $Template->setData('input_title', $_POST['task-title']);
                    $Template->setData('input_user', $_POST['task-author']);
                    $Template->setData('input_description', $_POST['task-description']);

                    if($_POST['task-title']=='' || $_POST['task-author']=='' || $_POST['task-description']=='')
                    {
                        // show error
                        if($_POST['task-title']=='')
                        {
                            $Template->setData('error_title', '*required!');
                        }
                        if($_POST['task-author']=='')
                        {
                            $Template->setData('error_user', '*required!');
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
                        $title = $Template->getData('input_title');
                        $author = $Template->getData('input_user');
                        $status = "TODO";
                        $description = $Template->getData('input_description');
                        // insert sql
                        if($stmt = $conn->prepare("INSERT INTO tasks (title, author, status, description) VALUES (?,?,?,?)"))
                        {
                            $stmt->bind_param("ssss", $title, $author, $status, $description);
                            $stmt->execute();

                            $stmt->close();
                            $conn->close();

                            $Template->load('views/v_members.php');
                        }
                        else
                        {
                            echo "Error: cannot complete query";
                        }
                    }
                }
                else
                {
                    $Template->load('views/v_members.php');
                }
            }
            else
            {
                $Template->load('views/v_login.php');
            }
        }
    }
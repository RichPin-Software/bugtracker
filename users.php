<?php
    include('includes/init.php');
    include('includes/database.php');

    if($_SESSION['userLoggedIn'] && !isset($_SESSION['currentUser']))
    {
        $Template->setAlert('Login Successful!', 'success');
        $_SESSION['currentUser'] = true;
        $Template->load('views/v_users.php');
    }
    else
    {
        if(isset($_GET['id']))
        {
            $_SESSION['id'] = $_GET['id'];
            $Template->load('views/v_task.php');
        }
        /*
        else if(isset($_GET['addtask']))
        {
            if(isset($_SESSION['id']))
            {
                unset($_SESSION['id']);
            }
            $Template->load('views/v_addtask.php');
        }
        */
        // DELETE TASK
        else if(isset($_GET['deletetask']))
        {
            $id = $_SESSION['id'];
            $Auth->deleteTask($id);

            unset($_SESSION['id']);
            $Template->setAlert("BUG-$id Deleted Successfully", 'success');
            $Template->redirect('users.php');



            /* if($stmt = $conn->prepare("DELETE FROM tasks WHERE id=?"))
            {
                $stmt->bind_param("i", $id);
                $id = $_SESSION['id'];
                $stmt->execute();

                $stmt->close();
                $conn->close();

                $Template->setAlert("BUG-$id Deleted Successfully", 'success');
                unset($_SESSION['id']);
                $Template->load('views/v_users.php');
            } */
        }
        else
        {
            if($_SESSION['currentUser'])
            {
                $Template->load('views/v_users.php');
            }
            else
            {
                $Template->load('views/v_login.php');
            }
        }
    }
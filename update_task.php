<?php
    include('includes/init.php');
    include('includes/database.php');
    // Verify is Current User
    if($_SESSION['currentUser'])
    {
        if(isset($_GET['edittask']))
        {
            $Template->load('views/v_edittask.php');
        }
        else if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $Template->setData('input_title', $_POST['task-title']);
            $Template->setData('input_description', $_POST['task-description']);

            // VALIDATE FORM
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
            // EDIT TASK
            else
            {
                $id = $_SESSION['id'];
                $title = $Template->getData('input_title');
                $status = "TODO";
                $description = $Template->getData('input_description');
                
                if($stmt = $conn->prepare("UPDATE tasks SET title=?, status=?, description=? WHERE id=?"))
                {
                    $stmt->bind_param("sssi", $title, $status, $description, $id);
                    $stmt->execute();

                    $stmt->close();
                    $conn->close();

                    $Template->load('views/v_task.php');
                }
                else
                {
                    echo "Error: cannot complete query";
                }
            }
        }
        else
        {
            $Template->redirect('users.php');
        }
    }
    else
    {
        $Template->setAlert('Access Denied!', 'error');
        $Template->redirect('login.php');
    }
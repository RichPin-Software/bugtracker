<?php
class Templates
{
    private $data;
    private $alertTypes;
    /*
        Constructor
    */
    function __construct() {}

    /*
        Functions
    */
    function load($url)
    {
        include($url);
    }

    function redirect($url)
    {
        header("Location: $url");
    }

    /*
        Set/Get Data
    */
    function setData($name, $value)
    {
        $this->data[$name] = htmlentities($value, ENT_QUOTES);
    }

    function getData($name)
    {
        $output = '';
        if(isset($this->data[$name]))
        {
            $output = $this->data[$name];
        }

        return $output;
    }

    /*
        Set/Get Alerts
    */
    function setAlertType($type)
    {
        $this->alertTypes = $type;
    }

    function setAlert($alert, $type = null)
    {
        if($type == '')
        {
            $type = $this->alertTypes[0];
        }
        $_SESSION[$type][] = $alert;
    }

    function getAlerts()
    {
        $data = '';
        foreach($this->alertTypes as $alert)
        {
            if(isset($_SESSION[$alert]))
            {
                foreach($_SESSION[$alert] as $value)
                {
                    $data .= "<li class='$alert'>$value</li>";
                }
                unset($_SESSION[$alert]);
            }
        }
        return $data;
    }

    /*
        Forms and Alerts
    */
    function addTaskForm()
    {
        $form = <<<FORM
        <div class="add-task-form" id="addtask-form">
        <form action="" method="POST">
        <input type="text" name="task-title" cols="100" id="task-title" placeholder="New Task Title">
        <div class="error"></div><br>
        <input type="text" name="task-author" id="task-author" placeholder="Created by">
        <div class="error"></div><br>
        <textarea name="task-description" id="task-description" cols="100" rows="20"></textarea><br>
        <input type="button" name="cancel" id="cancel" value="Cancel">
        <input type="submit" class="submit" value="Submit">
        </form>
        </div>
        FORM;

        return $form;
    }

    function displayAlert()
    {
        $alert = $this->getAlerts();
        if($alert != '')
        {
            $showAlert = <<<ALERT
            <ul class="alerts">$alert</ul>
            <script>
            setTimeout(()=>{
            document.querySelector('.alerts').style.display='none';
            },3000);
            </script>
            ALERT;

            return $showAlert;
        }
        else
        {
            return $alert;
        }
    }
}
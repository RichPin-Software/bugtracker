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
    function formValidate($key_1, $input_1, $err_key_1, $key_2, $input_2, $err_key_2, $error)
    {
        $this->setData($key_1, $input_1);
        $this->setData($key_2, $input_2);

        $validate;

        if($input_1=='' || $input_2=='')
        {
            if($input_1=='') { $this->setData($err_key_1, $error); }
            if($input_2=='') { $this->setData($err_key_2, $error); }

            $validate = false;
        }
        else
        {
            $validate = true;
        }

        return $validate;
    }

    function displayAlert()
    {
        $alert = $this->getAlerts();
        if($alert != '')
        {
            $displayAlert = <<<ALERT
            <ul class="alerts">$alert</ul>
            <script>
            setTimeout(()=>{
            document.querySelector('.alerts').style.display='none';
            },3000);
            </script>
            ALERT;
        }
        else
        {
            $displayAlert = '';
        }
        
        return $displayAlert;
    }
}
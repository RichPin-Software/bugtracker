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
        TEST Functions
    */
    function getAlertTypes()
    {
        if(isset($this->alertTypes))
        {
            print_r($this->alertTypes);
        }
        else
        {
            echo "\$alertTypes is not set";
        }
    }
}
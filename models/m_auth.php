<?php
class Auth
{
    private $salt = 'j4H97e021_d';
    /*
        Constructor
    */
    function __construct() {}
    /*
        Functions
    */
    function validateLogin($username, $password)
    {
        global $conn;
        $secure_password = md5($password.$this->salt);

        if($stmt = $conn->prepare("SELECT * FROM users_login WHERE username = ? AND password = ?"))
        {
            $result;

            $stmt->bind_param("ss", $username, $secure_password);
            $stmt->execute();
            $stmt->store_result();

            if($stmt->num_rows > 0)
            {
                $stmt->close();
                $result = true;
            }
            else
            {
                $stmt->close();
                $result = false;
            }

            return $result;
        }
        else
        {
            die("Error: Could not prepare MySQLi statement");
        }
    }

    function addNewUser($username, $password)
    {
        global $conn;
        $secure_password = md5($password.$this->salt);

        if($stmt = $conn->prepare("INSERT INTO users_login (username, password) VALUES (?, ?)"))
        {
            $stmt->bind_param("ss", $username, $secure_password);
            $stmt->execute();
            $stmt->close();
            $conn->close();
        }
        else
        {
            die("Error: could not prepare MySQLi statement");
        }
    }

    function addTask($title, $status, $author, $description)
    {
        global $conn;

        if($stmt = $conn->prepare("INSERT INTO tasks (title, author, status, description) VALUES (?,?,?,?)"))
        {
            $stmt->bind_param("ssss", $title, $author, $status, $description);
            $stmt->execute();

            $stmt->close();
            $conn->close();
        }
        else
        {
            die("Error: could not prepare MySQLi statement");
        }
    }

    function updateTask($id, $title, $status, $description)
    {
        global $conn;

        if($stmt = $conn->prepare("UPDATE tasks SET title=?, status=?, description=? WHERE id=?"))
        {
            $stmt->bind_param("sssi", $title, $status, $description, $id);
            $stmt->execute();

            $stmt->close();
            $conn->close();
        }
        else
        {
            die("Error: could not prepare MySQLi statement");
        }
    }

    function deleteTask($id)
    {
        global $conn;

        if($stmt = $conn->prepare("DELETE FROM tasks WHERE id=?"))
        {
            $stmt->bind_param("i", $id);
            $stmt->execute();

            $stmt->close();
            $conn->close();
        }
        else
        {
            die("Error: could not prepare MySQLi statement");
        }
    }
}
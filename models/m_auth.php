<?php
/**
 *      Author: Richard Pinegar
 *      Date: 11/19/2020
 * 
 *      Auth file contains login validation, password protection
 *      and functions to add, remove, and update the database.
 *
 */
class Auth
{
    private $salt = 'j4H97e021_d';
    /*
        Constructor
    */
    function __construct() {}
    /*
        Login Validation
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
    /*
        Username Validation to Prevent Duplicate Usernames
    */
    function validateNewUsername($username)
    {
        global $conn;

        if($stmt = $conn->prepare("SELECT username FROM users_login WHERE username = ?"))
        {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if($stmt->num_rows > 0)
            {
                $stmt->close();
                $result = false;
            }
            else
            {
                $stmt->close();
                $result = true;
            }

            return $result;
        }
        else
        {
            die("Error: Could not prepare MySQLi statement");
        }
    }
    /*
        Username Validation to Prevent Duplicate Usernames
    */
    function validateNewGroupname($groupname)
    {
        global $conn;

        if($stmt = $conn->prepare("SELECT groupname FROM users_login WHERE groupname = ?"))
        {
            $stmt->bind_param("s", $groupname);
            $stmt->execute();
            $stmt->store_result();

            if($stmt->num_rows > 0)
            {
                $stmt->close();
                $result = false;
            }
            else
            {
                $stmt->close();
                $result = true;
            }

            return $result;
        }
        else
        {
            die("Error: Could not prepare MySQLi statement");
        }
    }
    /*
        Prepared Statements - Add New User
    */
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

    function addNewUserGroup($username, $groupname, $password)
    {
        global $conn;
        $secure_password = md5($password.$this->salt);

        if($stmt = $conn->prepare("INSERT INTO users_login (username, groupname, password) VALUES (?, ?, ?)"))
        {
            $stmt->bind_param("sss", $username, $groupname, $secure_password);
            $stmt->execute();
            $stmt->close();
            $conn->close();
        }
        else
        {
            die("Error: could not prepare MySQLi statement");
        }
    }
    /*
        Prepared Statements - Add Task
    */
    function addTask($title, $status, $author, $description)
    {
        global $conn;
        $assignee = "unassigned";

        if($stmt = $conn->prepare("INSERT INTO tasks (title, author, assignee, status, description) VALUES (?,?,?,?,?)"))
        {
            $stmt->bind_param("sssss", $title, $author, $assignee, $status, $description);
            $stmt->execute();

            $stmt->close();
            $conn->close();
        }
        else
        {
            die("Error: could not prepare MySQLi statement");
        }
    }
    /*
        Prepared Statements - Edit/Update Selected Task
    */
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
    /*
        Prepared Statements - Delete Selected Task
    */
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
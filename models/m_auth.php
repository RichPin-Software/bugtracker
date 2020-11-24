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
        /*
            add new username and password to table 'users_login'
        */
        if($stmt = $conn->prepare("INSERT INTO users_login (username, password) VALUES (?, ?)"))
        {
            $stmt->bind_param("ss", $username, $secure_password);
            $stmt->execute();
            $stmt->close();
            /*
                create new table for new user account
            */
            $sql = "CREATE TABLE $username (
                id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                title varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                author varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                assignee varchar(255) COLLATE utf8_unicode_ci NULL,
                status varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                description text COLLATE utf8_unicode_ci NOT NULL
                )";

            echo ($conn->query($sql)===TRUE) ? : "Error: $conn->error";

            $conn->close();
        }
        else
        {
            die("Error: could not prepare MySQLi statement::username and password");
        }
    }

    function addNewUserGroup($username, $groupname, $password)
    {
        global $conn;
        $secure_password = md5($password.$this->salt);
        $admin = 'yes';
        /*
            add new username, groupname and password to table 'users_login'
        */
        if($stmt = $conn->prepare("INSERT INTO users_login (username, groupname, password, admin) VALUES (?, ?, ?, ?)"))
        {
            $stmt->bind_param("ssss", $username, $groupname, $secure_password, $admin);
            $stmt->execute();
            $stmt->close();
            /*
                create new table for new user account
            */
            $sql = "CREATE TABLE $username (
                id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                title varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                author varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                assignee varchar(255) COLLATE utf8_unicode_ci NULL,
                status varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                description text COLLATE utf8_unicode_ci NOT NULL
                )";

            echo ($conn->query($sql)===TRUE) ? : "Error: $conn->error";
            /*
                create new table for group
            */
            $sql = "CREATE TABLE group_$groupname (
                id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                title varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                author varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                assignee varchar(255) COLLATE utf8_unicode_ci NULL,
                status varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                description text COLLATE utf8_unicode_ci NOT NULL
                )";

            echo ($conn->query($sql)===TRUE) ? : "Error: $conn->error";

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
    function addTask($db_table, $title, $status, $author, $description)
    {
        global $conn;
        $assignee = "unassigned";

        if($stmt = $conn->prepare("INSERT INTO $db_table (title, author, assignee, status, description) VALUES (?,?,?,?,?)"))
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
    function updateTask($db_table, $id, $title, $status, $description)
    {
        global $conn;

        if($stmt = $conn->prepare("UPDATE $db_table SET title=?, status=?, description=? WHERE id=?"))
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
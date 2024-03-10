<?php

class App
{

    public $host = HOST;
    public $username = USERNAME;
    public $password = PASSWORD;
    public $dbname = DBNAME;

    public $link;
    public $register_status;
    public $login_status;

    public function __construct()
    {
        $this->connect();
    }

    public function connect()
    {
        $this->link = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname . "", $this->username, $this->password);

        if ($this->link) {
            // echo "Connected Successfully";
        } else {
            echo "Error connecting data base" . $this->link->errorInfo()[2] . "";
        }
    }

    public function startingSession()
    {
        session_start();
    }
    public function selectEmail($q, $param)
    {
        $selectEmails = $this->link->prepare($q);
        $selectEmails->execute($param);

        $selectEmail = $selectEmails->fetchAll(PDO::FETCH_OBJ);

        if (count($selectEmail) > 0) {
            return "Email Already Exist";
        }
    }

    public function loginUser($query, $arr, $password, $path)
    {
        $selectEmails = $this->link->prepare($query);
        $selectEmails->execute($arr);

        $selectEmail = $selectEmails->fetch(PDO::FETCH_OBJ);

        if ($selectEmail) {
            $password = password_verify($password, $selectEmail->password);

            if ($password) {
                $this->setSession($selectEmail);
                header("location:" . $path . "");
            } else {
                $this->login_status = "Password Incorrect";
            }
        } else {
            $this->login_status = "Email Incorrect";
        }
    }

    public function register($query, $arr, $path, $q, $param)
    {
        $selectEmails = $this->selectEmail($q, $param);

        if ($selectEmails == "Email Already Exist") {
            $this->register_status = "Email Already Exist";
        } else {
            if (in_array("", $arr)) {
                $this->register_status = "Failed";
            } else {
                $insert = $this->link->prepare($query);
                $insert->execute($arr);

                if ($insert) {
                    $this->register_status = "Success";
                    header("location:" . $path . "");
                } else {
                    $this->register_status = "Failed";
                }
            }
        }
    }

    public function logoutUser()
    {
        if (isset($_SESSION['user_id'])) {
            session_unset();
            session_destroy();
            header("location:" . APPURL . "");
        } else {
            header("location:" . APPURL . "");
        }
    }

    public function setSession($selectEmail)
    {
        $_SESSION['user_id'] = $selectEmail->id;
        $_SESSION['username'] = $selectEmail->username;
        $_SESSION['email'] = $selectEmail->email;
    }

    public function redirect()
    {
        if (isset($_SESSION['user_id'])) {
            header("location:" . APPURL . "");
        }
    }
}
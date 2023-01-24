<?php

class LoginContr extends Login
{

    // Properties
    private $Email;
    private $Password;

    // Constructor
    public function __construct($Email, $Password)
    {
        $this->Email = $Email;
        $this->Password = $Password;
    }

    public function loginUser()
    {
        if ($this->emptyInput() == false) {
            header("location: ../register.php?error=emptyinput");
            exit();
        }

        $this->getUser($this->Email, $this->Password);
    }

    private function emptyInput()
    {
        if (empty($this->Email) || empty($this->Password)) {
            return false;
        } else {
            return true;
        }
    }
}
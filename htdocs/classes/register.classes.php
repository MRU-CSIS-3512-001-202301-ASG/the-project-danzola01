<?php

class Register extends Dbh
{

    // Create user
    public function createUser($FirstName, $LastName, $Address, $City, $Region, $Country, $Postal, $Phone, $Email, $Password)
    {
        header($FirstName . $LastName . $Address . $City . $Region . $Country . $Postal . $Phone . $Email . $Password);
        $stmt = $this->connect()->prepare("INSERT INTO users (FirstName, LastName, Address, City, Region, Country, Postal, Phone, Email, Password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $hashedPwd = password_hash($Password, PASSWORD_DEFAULT);

        if (!$stmt->execute([$FirstName, $LastName, $Address, $City, $Region, $Country, $Postal, $Phone, $Email, $hashedPwd])) {
            $stmt = null;
            header("location: ../register.php?error=stmtfailed");
            exit();
        }

        $stmt = null;
        header("location: ../register.php?error=none");
        exit();
    }

    // Check if user already exists
    function checkEmail($email)
    {
        $stmt = $this->connect()->prepare("SELECT * FROM users WHERE Email = ?");

        if (!$stmt->execute([$email])) {
            $stmt = null;
            header("location: ../register.php?error=stmtfailed");
            exit();
        }

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
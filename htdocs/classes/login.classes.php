<?php

class Login extends Dbh
{

    public function getUser($Email, $Password)
    {
        $stmt = $this->connect()->prepare("SELECT Password FROM users WHERE Email = ?");

        if (!$stmt->execute([$Email, $Password])) {
            $stmt = null;
            header("location: ../register.php?error=stmtfailed");
            exit();
        }

        if ($stmt->rowCount() > 0) {
            $stmt = null;
            header("location: ../register.php?error=none");
            exit();
        } else {
            $stmt = null;
            header("location: ../register.php?error=wronglogin");
            exit();
        }

        $pwdHashed  = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $checkPwd   = password_verify($Password, $pwdHashed[0]['Password']);

        if ($checkPwd == false) {
            $stmt = null;
            header("location: ../register.php?error=wronglogin");
            exit();
        } else if ($checkPwd == true) {
            session_start();
            $_SESSION['Email'] = $Email;
            $_SESSION['Password'] = $Password;
            $stmt = null;
            header("location: ../register.php?error=none");
            exit();
        }

        $stmt = null;
        header("location: ../register.php?error=none");
        exit();
    }
}
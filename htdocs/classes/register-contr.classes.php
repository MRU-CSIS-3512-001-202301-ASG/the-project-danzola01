<?php

class RegisterController extends Register
{

    // Properties
    private $FirstName;
    private $LastName;
    private $Address;
    private $City;
    private $Region;
    private $Country;
    private $Postal;
    private $Phone;
    private $Email;
    private $Password;
    private $PasswordRepeat;

    // Constructor
    public function __construct($FirstName, $LastName, $Address, $City, $Region, $Country, $Postal, $Phone, $Email, $Password, $PasswordRepeat)
    {
        $this->FirstName = $FirstName;
        $this->LastName = $LastName;
        $this->Address = $Address;
        $this->City = $City;
        $this->Region = $Region;
        $this->Country = $Country;
        $this->Postal = $Postal;
        $this->Phone = $Phone;
        $this->Email = $Email;
        $this->Password = $Password;
        $this->PasswordRepeat = $PasswordRepeat;
    }

    public function registerUser()
    {
        if ($this->emptyInput() == false) {
            header("location: ../register.php?error=emptyinput");
            exit();
        }

        if ($this->invalidEmail() == false) {
            header("location: ../register.php?error=invalidemail");
            exit();
        }

        if ($this->passwordMatch() == false) {
            header("location: ../register.php?error=passwordmissmatch");
            exit();
        }

        if ($this->emailTakenCheck() == false) {
            header("location: ../register.php?error=dupliacteemail");
            exit();
        }

        $this->createUser($this->FirstName, $this->LastName, $this->Address, $this->City, $this->Region, $this->Country, $this->Postal, $this->Phone, $this->Email, $this->Password);
    }

    // Methods
    private function emptyInput()
    {
        if (empty($this->FirstName) || empty($this->LastName) || empty($this->Address) || empty($this->City) || empty($this->Region) || empty($this->Country) || empty($this->Postal) || empty($this->Phone) || empty($this->Email) || empty($this->Password) || empty($this->PasswordRepeat)) {
            return false;
        } else {
            return true;
        }
        // if (empty($this->FirstName)) {
        //     return false;
        //     header("location: ../register.php?error=emptyFirstName");
        // }
        // if (empty($this->LastName)) {
        //     return false;
        //     header("location: ../register.php?error=emptyLastName");
        // }
        // if (empty($this->Address)) {
        //     return false;
        //     header("location: ../register.php?error=emptyAddress");
        // }
        // if (empty($this->City)) {
        //     return false;
        //     header("location: ../register.php?error=emptyCity");
        // }
        // if (empty($this->Region)) {
        //     return false;
        //     header("location: ../register.php?error=emptyRegion");
        // }
        // if (empty($this->Country)) {
        //     return false;
        //     header("location: ../register.php?error=emptyCountry");
        // }
        // if (empty($this->Postal)) {
        //     return false;
        //     header("location: ../register.php?error=emptyPostal");
        // }
        // if (empty($this->Phone)) {
        //     return false;
        //     header("location: ../register.php?error=emptyPhone");
        // }
        // if (empty($this->Email)) {
        //     return false;
        //     header("location: ../register.php?error=emptyEmail");
        // }
        // if (empty($this->Password)) {
        //     return false;
        //     header("location: ../register.php?error=emptyPassword");
        // }
        // if (empty($this->PasswordRepeat)) {
        //     return false;
        //     header("location: ../register.php?error=emptyPasswordRepeat");
        // } else {
        //     return true;
        // }
    }

    private function invalidEmail()
    {
        if (!filter_var($this->Email, FILTER_VALIDATE_EMAIL)) {
            return false;
        } else {
            return true;
        }
    }

    private function passwordMatch()
    {
        if ($this->Password !== $this->PasswordRepeat) {
            return false;
        } else {
            return true;
        }
    }

    private function emailTakenCheck()
    {
        if ($this->checkEmail($this->Email) == false) {
            return true;
        } else {
            return false;
        }
    }
}
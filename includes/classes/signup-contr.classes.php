<?php

class SignupContr extends Signup
{

    private $pwd;
    private $pwdRepeat;
    private $email;
    private $fullName;
    private $corp;

    public function __construct($pwd, $pwdRepeat, $email, $fullName, $corp)
    {
        $this->pwd = $pwd;
        $this->pwdRepeat = $pwdRepeat;
        $this->email = $email;
        $this->fullName = $fullName;
        $this->corp = $corp;
    }

    public function signupUser()
    {
        if ($this->emptyInput() == false) {
            // echo "Empty input!";
            $prev_url = $_SERVER['HTTP_REFERER'];
            $query_string = http_build_query(array('error' => 'emptyinput'));
            $prev_url .= '?' . $query_string;
            header("Location: $prev_url");
            exit();
        }
        if ($this->invalidEmail() == false) {
            // echo "Invalid email!";
            $prev_url = $_SERVER['HTTP_REFERER'];
            $query_string = http_build_query(array('error' => 'invalidemail'));
            $prev_url .= '?' . $query_string;
            header("Location: $prev_url");
            exit();
        }
        if ($this->pwdMatch() == false) {
            // echo "Passwords don't match!";
            $prev_url = $_SERVER['HTTP_REFERER'];
            $query_string = http_build_query(array('error' => 'passwordsdontmatch'));
            $prev_url .= '?' . $query_string;
            header("Location: $prev_url");
            exit();
        }
        if ($this->emailTakenCheck() == false) {
            // echo "Username or email taken!";
            $prev_url = $_SERVER['HTTP_REFERER'];
            $query_string = http_build_query(array('error' => 'emailtaken'));
            $prev_url .= '?' . $query_string;
            header("Location: $prev_url");
            exit();
        }

        $this->setUser($this->pwd, $this->email, $this->fullName, $this->corp);
    }

    private function emptyInput()
    {
        $result = false;
        if (empty($this->pwd) || empty($this->pwdRepeat) || empty($this->email)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    private function invalidEmail()
    {
        $result = false;
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    private function pwdMatch()
    {
        $result = false;
        if ($this->pwd !== $this->pwdRepeat) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    private function emailTakenCheck()
    {
        $result = false;
        if (!$this->checkUser($this->email)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }
}

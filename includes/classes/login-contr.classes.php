<?php

class loginContr extends Login
{

    private $email;
    private $pwd;

    public function __construct($email, $pwd)
    {
        $this->email = $email;
        $this->pwd = $pwd;
    }

    public function loginUser()
    {
        if ($this->emptyInput() == false) {
            // echo "Empty input!";
            $prev_url = $_SERVER['HTTP_REFERER'];
            $query_string = http_build_query(array('error' => 'emptyinput'));
            $prev_url .= '?' . $query_string;
            header("Location: $prev_url");
            exit();
        }

        $this->getUser($this->email, $this->pwd);
    }

    private function emptyInput()
    {
        $result = false;
        if (empty($this->email) || empty($this->pwd)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }
}

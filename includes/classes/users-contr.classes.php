<?php

class UsersContr extends Users
{

    private $email;

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function updateUser($user_id, $current_email, $new_email, $current_password, $new_password, $new_password_repeat)
    {
        if ($this->checkPassword($this->email, $current_password) == false) {
            // echo "Wrong password!";
            header("location: ../pages/editprofile.php?error=wrongpassword");
            exit();
        }

        $this->deleteEmail($current_email);


        if ($this->emptyInput($current_password, $new_password, $new_password_repeat, $new_email) == false) {
            // echo "Empty input!";
            $prev_url = $_SERVER['HTTP_REFERER'];
            $query_string = http_build_query(array('error' => 'emptyinput'));
            $prev_url .= '?' . $query_string;
            header("Location: $prev_url");
            exit();
        }
        if ($this->pwdMatch($new_password, $new_password_repeat) == false) {
            // echo "Passwords don't match!";
            $prev_url = $_SERVER['HTTP_REFERER'];
            $query_string = http_build_query(array('error' => 'passwordsdontmatch'));
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
        if ($this->emailTakenCheck() == false) {
            // echo "Username or email taken!";
            $prev_url = $_SERVER['HTTP_REFERER'];
            $query_string = http_build_query(array('error' => 'emailtaken'));
            $prev_url .= '?' . $query_string;
            header("Location: $prev_url");
            exit();
        }
        $this->updatePassword($user_id, $new_password);
        $this->updateEmail($user_id, $new_email);

        session_start();
        $_SESSION["useremail"] = $new_email;
    }

    //get all users from a specific corporation using the corp of the user
    public function getUserEmployees($email)
    {
        $user = $this->getUserData($email);
        $userRole = $user['role'];
        $corp = $user['corps_id'];

        if ($userRole == 1) {
            $result = $this->getCorpUsers($corp);
        } else {
            $result = "";
        }
        return $result;
    }

    //get user data of a specific user by id
    public function getUserDataById($id)
    {
        $result = $this->getDataUserId($id);
        return $result;
    }

    private function emptyInput($old_pwd, $pwd, $pwdRepeat, $email)
    {
        $result = false;
        if (empty($old_pwd) || empty($pwd) || empty($pwdRepeat) || empty($email)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    //register user work hours
    public function registerWorkHours($user_id, $corps_id, $date, $from, $to, $hours)
    {

        $this->registerHours($user_id, $corps_id, $date, $from, $to, $hours);
    }


    //error handling functions
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

    private function pwdMatch($pwd, $pwdRepeat)
    {
        $result = false;
        if ($pwd !== $pwdRepeat) {
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

    private function matchPassword($email, $current_password)
    {
        $result = false;
        if (!$this->checkPassword($email, $current_password)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }
}

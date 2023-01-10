<?php

class Signup extends Dbh
{

    protected function setUser($pwd, $email, $fullName, $corp)
    {
        $stmt = $this->connect()->prepare('INSERT INTO users (users_pwd, users_email, full_name, corp) VALUES (?, ?, ?, ?);');

        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

        if (!$stmt->execute(array($hashedPwd, $email, $fullName, $corp))) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        $stmt = null;
    }

    protected function checkUser($email)
    {
        $stmt = $this->connect()->prepare('SELECT users_email FROM users WHERE users_email = ?;');

        if (!$stmt->execute(array($email))) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        $resultCheck = false;
        if ($stmt->rowCount() > 0) {
            $resultCheck = false;
        } else {
            $resultCheck = true;
        }

        return $resultCheck;
    }
}

<?php
class Users extends Dbh
{

    // change user password
    function updatePassword($user_id, $new_password)
    {
        //Sanitize
        $user_id = htmlspecialchars(strip_tags($user_id));
        $new_password = htmlspecialchars(strip_tags($new_password));

        // update query
        $query = "UPDATE users SET users_pwd = :new_password WHERE users_id = :users_id";

        // prepare query statement
        $stmt = $this->connect()->prepare($query);

        // sanitize
        $user_id = htmlspecialchars(strip_tags($user_id));
        $users_password = htmlspecialchars(strip_tags($new_password));

        //hash password
        $users_password = password_hash($users_password, PASSWORD_DEFAULT);

        // bind new values
        $stmt->bindParam(':users_id', $user_id);
        $stmt->bindParam(':new_password', $users_password);

        // execute the query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // change user email
    function updateEmail($user_id, $new_email)
    {
        //sanitize
        $user_id = htmlspecialchars(strip_tags($user_id));
        $new_email = htmlspecialchars(strip_tags($new_email));

        // update query
        $query = "UPDATE users SET users_email = :new_email WHERE users_id = :user_id";

        // prepare query statement
        $stmt = $this->connect()->prepare($query);

        // sanitize
        $current_email = htmlspecialchars(strip_tags($user_id));
        $new_email = htmlspecialchars(strip_tags($new_email));

        // bind new values
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':new_email', $new_email);

        // execute the query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }


    // check if user email exists
    protected function checkUser($email)
    {
        //sanitize
        $email = htmlspecialchars(strip_tags($email));
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

    // check if password is correct
    function checkPassword($email, $password)
    {
        //sanitize
        $email = htmlspecialchars(strip_tags($email));
        $stmt = $this->connect()->prepare('SELECT users_pwd FROM users WHERE users_email = ?;');

        if (!$stmt->execute(array($email))) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $result['users_pwd'])) {
            return true;
        } else {
            return false;
        }
    }

    // funtion to get user data from database without password

    function getUserData($email)
    {
        //sanitize
        $email = htmlspecialchars(strip_tags($email));

        $stmt = $this->connect()->prepare('SELECT * FROM users WHERE users_email = ?;');
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    // get user data from database using user_id
    function getDataUserId($user_id)
    {
        //sanitize
        $user_id = htmlspecialchars(strip_tags($user_id));

        $pdo = $this->connect();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE users_id = ?');
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    //set users email to nothing 
    function deleteEmail($email)
    {
        //sanitize
        $email = htmlspecialchars(strip_tags($email));

        $stmt = $this->connect()->prepare('UPDATE users SET users_email = "" WHERE users_email = ?;');
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    //get all users based on corp
    function getCorpUsers($corp)
    {
        //sanitize
        $corp = htmlspecialchars(strip_tags($corp));

        $stmt = $this->connect()->prepare('SELECT * FROM users WHERE corps_id = ? ORDER BY IsActive DESC;');
        $stmt->execute([$corp]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //set users IsActive to 0 based on user_id
    function deleteUser($user_id)
    {
        //sanitize
        $user_id = htmlspecialchars(strip_tags($user_id));

        $stmt = $this->connect()->prepare('UPDATE users SET IsActive = 0 WHERE users_id = ?;');
        $stmt->execute([$user_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    //register user hours 
    function registerHours($user_id, $corps_id, $date, $from, $to, $hours)
    {
        //Sanitize
        $user_id = htmlspecialchars(strip_tags($user_id));
        $hours = htmlspecialchars(strip_tags($hours));
        $date = htmlspecialchars(strip_tags($date));
        $corps_id = htmlspecialchars(strip_tags($corps_id));

        // Connect to the database
        $pdo = $this->connect();

        // Prepare the INSERT statement
        $stmt = $pdo->prepare('INSERT INTO hours (users_id, corps_id, date, from_hour, to_hour, hours) VALUES (?, ?, ?, ?, ?, ?)');

        // Execute the statement with the sanitized parameters
        $stmt->execute([$user_id, $corps_id, $date, $from, $to, $hours]);

        // Return the number of rows affected by the INSERT statement
        return $stmt->rowCount();
    }

    //get all hours based on user_id
    function getHours($user_id)
    {
        //sanitize
        $user_id = htmlspecialchars(strip_tags($user_id));

        $stmt = $this->connect()->prepare('SELECT * FROM hours WHERE users_id = ? ORDER BY date DESC;');
        $stmt->execute([$user_id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //get all hours based on user_id and date range
    function getHoursDateRange($user_id, $from, $to)
    {
        //sanitize
        $user_id = htmlspecialchars(strip_tags($user_id));
        $from = htmlspecialchars(strip_tags($from));
        $to = htmlspecialchars(strip_tags($to));

        $stmt = $this->connect()->prepare('SELECT * FROM hours WHERE users_id = ? AND date BETWEEN ? AND ? ORDER BY date DESC;');
        $stmt->execute([$user_id, $from, $to]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function deleteHourById($hour_id)
    {
        //sanitize
        $hour_id = htmlspecialchars(strip_tags($hour_id));
        $stmt = $this->connect()->prepare('DELETE FROM hours WHERE id = ?;');
        $result = $stmt->execute([$hour_id]);
        return $result;
    }
}

<?php


extension_loaded('imagick');
class Files extends Dbh
{

    //get users contract
    function getUsersContract($user_id)
    {
        // Connect to the database
        $pdo = $this->connect();

        // Prepare the SELECT statement
        $stmt = $pdo->prepare('SELECT * FROM files WHERE users_id = ? AND file_type = "contract"');

        // Execute the statement with the user's ID as the parameter
        $stmt->execute([$user_id]);

        // Fetch and return the results
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //upload contract only allow pdf
    function updateContract($user_id, $file_name, $corps_id, $file_type)
    {
        //Sanitize
        $user_id = htmlspecialchars(strip_tags($user_id));
        $file_name = htmlspecialchars(strip_tags($file_name));
        $corps_id = htmlspecialchars(strip_tags($corps_id));
        $file_type = htmlspecialchars(strip_tags($file_type));

        // Connect to the database
        $pdo = $this->connect();

        // Prepare the INSERT statement
        $stmt = $pdo->prepare('INSERT INTO files (users_id, file_name, corps_id, file_type) VALUES (?, ?, ?, ?)');

        // Execute the statement with the user's ID as the parameter
        $stmt->execute([$user_id, $file_name, $corps_id, $file_type]);

        // Fetch and return the results
        return $stmt->rowCount();
    }

    //upload contract only allow pdf
    function updateReciept($user_id, $file_name, $corps_id, $file_type, $info)
    {
        //Sanitize
        $user_id = htmlspecialchars(strip_tags($user_id));
        $file_name = htmlspecialchars(strip_tags($file_name));
        $corps_id = htmlspecialchars(strip_tags($corps_id));
        $file_type = htmlspecialchars(strip_tags($file_type));
        $info = htmlspecialchars(strip_tags($info));

        // Connect to the database
        $pdo = $this->connect();

        // Prepare the INSERT statement
        $stmt = $pdo->prepare('INSERT INTO files (users_id, file_name, corps_id, file_type, info) VALUES (?, ?, ?, ?, ?)');

        // Execute the statement with the user's ID as the parameter
        $stmt->execute([$user_id, $file_name, $corps_id, $file_type, $info]);

        // Fetch and return the results
        return $stmt->rowCount();
    }

    // delete contract
    function deleteContract($user_id)
    {
        // Connect to the database
        $pdo = $this->connect();

        // Prepare the SELECT statement
        $stmt = $pdo->prepare('DELETE FROM files WHERE users_id = ? AND file_type = "contract"');

        // Execute the statement with the user's ID as the parameter
        $stmt->execute([$user_id]);

        // Fetch and return the results
        return $stmt->rowCount();
    }

    //get users receipts

    function getUsersReceipts($user_id)
    {
        // Connect to the database
        $pdo = $this->connect();

        // Prepare the SELECT statement
        $stmt = $pdo->prepare('SELECT * FROM files WHERE users_id = ? AND file_type = "reciept"');

        // Execute the statement with the user's ID as the parameter
        $stmt->execute([$user_id]);

        // Fetch and return the results
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

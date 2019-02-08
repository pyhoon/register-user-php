<?php
    require 'db.php';
    try
    {
        if (!isset($_GET['Action']) || empty($_GET['Action']) || 
            !isset($_GET['Email']) || empty($_GET['Email']))
        {
            print json_encode("Parameter Error");
            exit;
        }
        $action = $mysqli->escape_string($_GET["Action"]);
        $email = $mysqli->escape_string($_GET["Email"]);

        switch ($action)
        {
            case "RequestPassword":        
                $sql = "SELECT user_name, pass_word";
                $sql .= " FROM tbl_member";
                $sql .= " WHERE email = '" . $email . "'";
                $result = $mysqli->query($sql);
                if ($mysqli->errno)
                {
                    print json_encode("MySQL_Error");
                    echo "<br />" . $mysqli->error;
                    exit;
                }
                $count = $result->num_rows;
                if ($count == 0)
                {
                    print json_encode("InvalidEmail");
                }
                else
                {
                    $row = $result->fetch_row();
                    $to      = $email;
                    $subject = 'Your Password';
                    $username = $row[0];
                    $password = $row[1];
                    $message = "Hi " . $username . ",\r\n";
                    $message .= "This is your password as requested.\r\n";
                    $message .= "Password: " . $password;
                    $message = wordwrap($message, 70, "\r\n");
                    $headers = "From: no-reply@computerise.my" . "\r\n";
                    $headers .= "Reply-To: no-reply@computerise.my\r\n";
                    $headers .= "X-Mailer: PHP/" . phpversion();
                    mail($to, $subject, $message, $headers);
                    print json_encode("ValidEmail");
                }
            break;
            default:
                echo("Unauthorized action! Please use the app to register.");
        }
    }
    catch (Exception $e)
    {
        print json_encode("Failed");
        echo '<br />Caught exception: '.$e->getMessage()."\n";
    }    
?>

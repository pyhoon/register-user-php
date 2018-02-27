<?php
$host = "mysql16.000webhost.com";
$db = "a1438837_db";
$user = "a1438837_id";
$pw = "a1438837";

$con = mysql_connect($host,$user,$pw) or die(mysql_error());
mysql_select_db($db) or die(mysql_error());
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET NAMES 'utf8'");

$action = $_GET["Action"];
switch ($action) {
    case "RequestPasswordReset":
        $email = mysql_real_escape_string($_GET["Mail"]);
        $sql = "SELECT user_name FROM tbl_member WHERE email = '" . $email . "'";
        $res = mysql_query($sql);
        if (!$res) {
            print json_encode("MySQL_Error");
            echo "<br />MySQL_Error: " . mysql_error();
            exit;
        }
        $count = mysql_num_rows($res);            
        if ($count == 0) {
            print json_encode("InvalidEmail");
            exit;
        }
        else {
            // Generate a random code and update to reg_no
            $verify_code = mt_rand(100000, 999999);
            $row = mysql_fetch_row($res);
            $username = $row[0];
            $sql = "UPDATE tbl_member SET reg_no = '" . $verify_code . "' WHERE email = '" . $email . "'";
            $res = mysql_query($sql);
            if (!$res) {
                print json_encode("MySQL_Error");
                echo "<br />MySQL_Error: " . mysql_error();
                exit;
            }
            // Send email to user to confirm the reset
            $to      = $email;
            $subject = 'Request to reset your password';
            $message = "Hi " . $username . ",\r\n";
            $message .= "We have received a request from you to reset your password.\r\n";
            $message .= "If this action is not requested by you, please ignore this email.\r\n";
            $message .= "Otherwise, click the link below:\r\n";
            $message .= "http://kbase.herobo.com/reset-password.php?Action=ConfirmPasswordReset&Mail=" . $email . "&Code=" . $verify_code . "\r\n\r\n";
            $message .= "If not working, please copy the link to your browser.\r\n\r\n";
            $message .= "Regards,\r\n";
            $message .= "Aeric";
            $message = wordwrap($message, 70, "\r\n");
            $headers = "From: no-reply@kbase.herobo.com" . "\r\n";
            $headers .= "Reply-To: no-reply@kbase.herobo.com\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();
            mail($to, $subject, $message, $headers);
            print json_encode("ValidEmail");
        }
        break;
    case "ConfirmPasswordReset":
        $email = mysql_real_escape_string($_GET["Mail"]);
        $code = mysql_real_escape_string($_GET["Code"]);
        $sql = "SELECT user_name FROM tbl_member WHERE email = '" . $email . "' AND reg_no = " . $code;
        $res = mysql_query($sql);
        if (!$res) {
            print json_encode("MySQL_Error");
            echo "<br />MySQL_Error: " . mysql_error();
            exit;
        }
        $count = mysql_num_rows($res);            
        if ($count == 0) {
            print json_encode("InvalidEmailOrCode");
            exit;
        }
            // Generate a default password randomly (e.g. pw1234)
            // You may use other method to generate a more complex password with alphanumeric
            $rand_number = mt_rand(1000, 9999);
            $default = "pw" . $rand_number;
            $row = mysql_fetch_row($res);
            $username = $row[0];
            $sql = "UPDATE tbl_member SET pass_word = '" . $default . "' WHERE email = '" . $email . "'";
            $res = mysql_query($sql);
            if (!$res) {
                print json_encode("MySQL_Error");
                echo "<br />MySQL_Error: " . mysql_error();
                exit;
            }
            $to      = $email;
            $subject = 'Your New Password';
            $message = "Hi " . $username . ",\r\n";
            $message .= "Your password has been reset. Please use your new password to log in.\r\n";
            $message .= "Password: " . $default;
            $message = wordwrap($message, 70, "\r\n");
            $headers = "From: no-reply@kbase.herobo.com" . "\r\n";
            $headers .= "Reply-To: no-reply@kbase.herobo.com\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();
            mail($to, $subject, $message, $headers);
            //print json_encode("PasswordChanged");
            echo "Your password has been reset.<br />Your new password is sent to $email.";
        break;
    default:
            echo("Unauthorized action! Please use the app to reset your password.");
}
?>

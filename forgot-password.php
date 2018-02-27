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
$email = mysql_real_escape_string($_GET["Email"]);

switch ($action) {
    case "RequestPassword":        
        $sql = "SELECT user_name, pass_word FROM tbl_member WHERE email = '" . $email . "'";
        $res = mysql_query($sql);
        if (!$res) {
            print json_encode("MySQL_Error");
            echo "<br />" . mysql_error();
            exit;
        }
        $count = mysql_num_rows($res);            
        if ($count == 0) {
            print json_encode("InvalidEmail");
        }
        else {
            $row = mysql_fetch_row($res);
            $to      = $email;
            $subject = 'Your Password';
            $username = $row[0];
            $password = $row[1];
            $message = "Hi " . $username . ",\r\n";
            $message .= "This is your password as requested.\r\n";
            $message .= "Password: " . $password;
            $message = wordwrap($message, 70, "\r\n");
            $headers = "From: no-reply@kbase.herobo.com" . "\r\n";
            $headers .= "Reply-To: no-reply@kbase.herobo.com\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();
            mail($to, $subject, $message, $headers);
            print json_encode ("ValidEmail");
        }
        break;
    default:
            echo("Unauthorized action! Please use the app to register.");
}
?>

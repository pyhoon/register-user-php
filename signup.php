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
    case "Register":
        $user = mysql_real_escape_string($_GET["UserID"]);
        $email = mysql_real_escape_string($_GET["Email"]);
        $password = mysql_real_escape_string($_GET["Password"]);
        $fullname = mysql_real_escape_string($_GET["FullName"]);
        $location = mysql_real_escape_string($_GET["Location"]);
      
        $q = mysql_query("SELECT * FROM tbl_member WHERE email = '$email' or user_id = '$user'");
        $count = mysql_num_rows($q);
            
        if ($count == 0)
            {          
            $randomnumber = mt_rand(111111, 999999);
            $res = mysql_query("INSERT INTO tbl_member (user_id, user_name, pass_word, email, location, status, reg_no, online) VALUES ('$user', '$fullname', '$password', '$email', '$location', 'M', $randomnumber, 'N')");

            $to      = $email;
            $subject = 'Your registration';
            $message = 'Hi ' . $user . ',' . "\r\n" . 'Please click on this link to finish the registration process: http://kbase.herobo.com/signup.php?Action=Mail&Mail=' . $email . '&RegNo=' . $randomnumber;
            $message = wordwrap($message, 70, "\r\n");
            $headers = 'From: register@kbase.herobo.com' . "\r\n" . 'Reply-To: register@kbase.herobo.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion();

            mail($to, $subject, $message, $headers);
            // Notify me of new sign up
            mail('register@kbase.herobo.com', 'New member', 'New member (' . $user . ') has signed up using our demo app.', $headers);
            print json_encode ("Mail");
            }          
        else
            print json_encode ("MailInUse");      
            break;

    case "Mail":
        $regno = $_GET["RegNo"];
        $mail=$_GET["Mail"];
      
        $q = mysql_query("SELECT * FROM tbl_member WHERE email = '$mail' and reg_no = $regno and status = 'M'");
        $count=mysql_num_rows($q);
      
        if ($count == 0)
            {
            print json_encode ("This registration is not valid / mail address is already registered");
            }          
        else {
            $res=mysql_query("UPDATE tbl_member SET status = 'R' WHERE email = '$mail' and reg_no =$regno");
            echo("$mail is registered now :-)");
            }
        break;
    default:
            echo("Unauthorized action! Please use the app to register.");
}
?>
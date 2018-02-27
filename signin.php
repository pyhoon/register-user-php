<?
$host = "mysql16.000webhost.com";
$db = "a1438837_db";
$user = "a1438837_id";
$pw = "a1438837";

$con = mysql_connect($host, $user, $pw) or die(mysql_error());
mysql_select_db($db) or die(mysql_error());
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET NAMES 'utf8'");

$uid = mysql_real_escape_string($_GET["user_id"]);
$pwd = mysql_real_escape_string($_GET["password"]);

$res = mysql_query("SELECT user_name, reg_status FROM tbl_member WHERE user_id = '$uid' AND pass_word = '$pwd'");
if (!$res) {
    print json_encode("Error");
    echo "<br />" . mysql_error();
    exit;
}
else {
    if (mysql_num_rows($res) == 0) {
        print json_encode("Not Found");
        exit;
    }
    $row = mysql_fetch_row($res);
    if ($row[1] == "M") {
        print json_encode("Not Activated");
    }
    else {    
        print json_encode($row[0]);
        $res = mysql_query("UPDATE tbl_member SET Online = 'N' WHERE now()-time_stamp > 60");
        $res = mysql_query("UPDATE tbl_member SET logins = logins + 1, Online = 'Y', time_stamp = now() WHERE user_id = '$uid'");    
    }
}
?>				
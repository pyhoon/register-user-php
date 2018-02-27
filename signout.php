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

$res = mysql_query("SELECT online FROM tbl_member WHERE user_id = '$uid'");
$count = mysql_num_rows($res);

if ($count == 0) {
  print json_encode ("NotMember");
}
else {
    $res = mysql_query("UPDATE tbl_member SET online = 'N' WHERE user_id = '$uid'");
    print json_encode ("LoggedOut");
}
?>
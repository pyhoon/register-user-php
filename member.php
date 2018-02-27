<?php
$host = "mysql16.000webhost.com";
$db = "a1438837_db";
$user = "a1438837_id";
$pw = "a1438837";

$con = mysql_connect($host,$user,$pw) or die(mysql_error());
mysql_select_db($db) or die(mysql_error());
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET NAMES 'utf8'");
     
$sql = "SELECT user_id, location, online FROM tbl_member ORDER BY id DESC";
$res = mysql_query($sql);

if (mysql_errno()) {
    header("HTTP/1.1 500 Internal Server Error");
    echo $query.'\n';
    echo mysql_error();
}
else
{
    $rows = array();
    while($r = mysql_fetch_assoc($res)) {
        $rows[] = $r;
    }
    print json_encode($rows);
}
?>
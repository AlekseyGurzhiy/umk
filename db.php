<?
	//Указываем всем браузерам, что кодировка должна быть UTF-8
	header("Content-Type: text/html; charset=utf-8");  
	
	//Подключаемся к базе
	$db = mysql_connect("localhost","root","");
	mysql_select_db('storage',$db);
	mysql_query('SET names "utf8"');
?>
<!DOCTYPE html>
<html>
	<head>
		<title> Скрипты для работы с базой </title>
	</head>
	<body>
<?
/*$query_in = mysql_query("SELECT * FROM `hb_table(delete)` WHERE `group_people` != 0");
$i = 0;
while($row_in = mysql_fetch_assoc($query_in)){
	$elements = explode(" ",$row_in['FIO']);
	$group = $row_in['group_people']+1;
	mysql_query("INSERT INTO `birthday` (`surname`,`name`,`fathername`,`date`,`group_people`,`id_range`,`id_range_employ`,`work_position`) VALUE ('".$elements[0]."','".$elements[1]."','".$elements[2]."','".$row_in['date']."','".$group."','".$row_in['work_range']."','".$row_in['work_range_sluzhba']."','".$row_in['work_position']."')");
}*/
//$query_out = mysql_query("DELETE FROM `birthday` WHERE id!=0");
?>
	</body>
</html>
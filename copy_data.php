<?
	//Указываем всем браузерам, что кодировка должна быть UTF-8
	header("Content-Type: text/html; charset=utf-8");  
	
	//Подключаемся к базе
	$db = mysql_connect("localhost","root","");
	mysql_select_db('portal',$db);
	mysql_query('SET names "utf8"');
?>
<!DOCTYPE html>
<html>
	<head>
		<title> Копирование данных в базе </title>
	</head>
	<body>
<?
$query_in = mysql_query("SELECT date,name_date FROM hb_table WHERE group_date=1");

$db1 = mysql_connect("localhost","root","");
	   mysql_select_db('storage',$db1);

while ( $row_in = mysql_fetch_assoc($query_in) ){
	mysql_query("INSERT INTO memory_date (name,date) VALUES ('".$row_in["name_date"]."','".$row_in['date']."')");
}

?>
	</body>
</html>
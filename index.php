<?php
	//Указываем всем браузерам, что кодировка должна быть UTF-8
	header("Content-Type: text/html; charset=utf-8");  
	//Подключаемся к базе
	$db = mysqli_connect("beta.mtw.ru","pianogd1","Zsdcawedq23","db?pianogd1");
	mysqli_query($db,'SET names "utf8"');

	//Переменные, используемые в процессе работы программы
	$page_umk = 'active_page';
	$number = -1;
	$hide = "style='display:none;'";
	$show = "style='display:block;'";
	$show_cell = "style='display:table-cell;'";
	$number_result = 0;
	$filter = false;
	$sort_load = "";
	$sort_date = "button_active";
	$sort_section = ""; 
	
	//Запускаем глобальную переменную "Сессия". 
	session_start();
	
	//Если нажата кнопка "Выход", то уничтожаем сессию
	if(isset($_POST['out'])){
		$_SESSION['slogin'] = '';
		$_SESSION['sname'] = '';
		$_SESSION['ssurname'] = '';
		$_SESSION['sfathername'] = '';
		$_SESSION['skaf'] = '';
		$_SESSION['srools'] = '';
		session_destroy();
		$result_query = mysqli_query($db,"SELECT * FROM file_table ORDER BY date_load desc LIMIT 50"); // Список загруженных файлов для неавторизованного
	}

	// Если нажата клавиша "Скачать файл", то сохраняем его
	if( isset($_POST["download_file"]) ){
		$full_path_file = $_POST["download_filename"];
		$path_file = explode("/",$full_path_file);
		$id_file = explode(".",$path_file[1]);

		mysqli_query($db,"UPDATE file_table SET download_number=download_number+1 WHERE id='".$id_file[0]."'");
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.basename($_POST["download_newname"]).'"');
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Content-Length: ' . filesize($full_path_file));
		header('Pragma: public');
		ob_clean();
		flush();
		readfile($full_path_file);
		exit;
	}
	
	//Если нажата кнопка авторизации
	if(isset($_POST["autoriz_submit"])){
		$autorization_login = $_POST["autoriz_login"];
		$autorization_password = $_POST["autoriz_password"];
		
		$query = mysqli_query($db,"SELECT * FROM users WHERE `login`='".$autorization_login."'");
		$number = mysqli_num_rows($query);
		
		if($number!=0) $rows = mysqli_fetch_assoc($query);
		
		if($number == 1){
			$login = true;
			if($autorization_password == $rows["password"]){
				$autorization = true;
				$_SESSION['slogin'] = $autorization_login;
				$_SESSION['sname'] = $rows["name"];
				$_SESSION['ssurname'] = $rows["surname"];
				$_SESSION['sfathername'] = $rows["fathername"];
				$_SESSION['skaf'] = $rows["otdel"];
				$_SESSION['srools'] = $rows["rools"];
			} else {
				$autorization = false;
			}
		}
	}

	/* Если нажата кнопка "Удалить" */
	if( isset($_POST['delete_yes']) ){
		array_map("unlink", glob($_POST['download_filename']));
		mysqli_query($db,"DELETE FROM file_table WHERE id='".$_POST['download_fileid']."'");
		mysqli_query($db,"INSERT INTO logs (type_event, name_file, date_event, person_event, ip_event,for_proga) VALUES ('del','".$_POST['download_newname']."','".date("Y-m-d H:i:s")."','".$_SESSION['ssurname']." ".$_SESSION['sname']." ".$_SESSION['sfathername']."','".$_SERVER['REMOTE_ADDR']."','0')");
	}

	// Если нажата кнопка "Редактировать"
	if( isset($_POST['reload_value']) ){
			mysqli_query($db,"UPDATE `file_table` SET `filename`='".$_POST['edit_area_input_name']."',`facultet`='".$_POST['edit_area_select_fac']."',`speciality`='".$_POST['edit_area_select_spec']."',`profile`='".$_POST['edit_area_select_prof']."',`job_category`='".$_POST['edit_area_select_job']."',`year`='".$_POST['edit_area_select_year']."',`section`='".$_POST['edit_area_select_razdel']."' WHERE `id`=".$_POST['hidden_id_name']);
	}

	// Если файл загружен, то...
	$tmp_filename = $_FILES["add_file_real"]["tmp_name"];
	if(is_uploaded_file($tmp_filename)){
		$filename = $_POST["add_file_name"];
		$filetype = substr($_FILES["add_file_real"]["name"], strrpos($_FILES["add_file_real"]["name"], '.')+1);
		
		$id_mass = explode(";",$_POST["add_file_autors_h"]);
		$i = 0;
		while($id_mass[$i]){
			$id_mass[$i] = "|".$id_mass[$i];
			$i++;
		}
		
		$id_mass_keywords = explode(";",$_POST["add_file_keywords_h"]);
		$i = 0;
		while($id_mass_keywords[$i]){
			$id_mass_keywords[$i] = "|".$id_mass_keywords[$i];
			$i++;
		}
		
		$last_id = $id_mass[0];
		$last_id_keywords = $id_mass_keywords[0];
		unset($id_mass[0]);
		unset($id_mass_keywords[0]);
		$id_string = implode(";",$id_mass);
		$id_string_keywords = implode(";",$id_mass_keywords);
		$j_keywords = 0;
		$j = 0;
		
		for($i=1;$i<=count($id_mass);$i++){
			if($last_id < $id_mass[$i]){
				$id_add_autors[$j] = $i;
				$j++;
			}
		}
		for($i=1;$i<=count($id_mass_keywords);$i++){
			if($last_id_keywords < $id_mass_keywords[$i]){
				$id_add_keywords[$j_keywords] = $i;
				$j_keywords++;
			}
		}

		$mass_add_autors   = explode(";",$_POST["text_autors_h"]);
		$mass_add_keywords = explode(";",$_POST["text_keywords_h"]);
		$j = 0;
		$j_keywords = 0;
		for($i=0;$i<count($id_add_autors);$i++){
			$text_add_autors[$i] = $mass_add_autors[$id_add_autors[$j]-1];
			$j++;
		}
		for($i=0;$i<count($id_add_keywords);$i++){
			$text_add_keywords[$i] = $mass_add_keywords[$id_add_keywords[$j_keywords]-1];
			$j_keywords++;
		}
		
		if($_SESSION['srools'] == "user"){
			$kaf = $_SESSION['skaf'];
		} else {
			$kaf = $_POST['add_file_kafedra_s'];
		}
		mysqli_query($db,"INSERT INTO `file_table` (`filename`,`filetype`,`filesize`,`date_load`,`user`,`autors`,`keywords`,`pulpit`,`facultet`,`speciality`,`profile`,`job_category`,`year`,`section`) VALUES ('".$filename."', '".$filetype."','".$_FILES["add_file_real"]["size"]."','".date("Y-m-d G:i:s")."', '".$_SESSION['slogin']."', '".$id_string."', '".$id_string_keywords."', '".$kaf."', '".$_POST['add_file_facultet_s']."', '".$_POST['add_file_speciality_s']."', '".$_POST['add_file_profile_s']."', '".$_POST['add_file_job_s']."', '".$_POST['add_file_year_s']."', '".$_POST['add_file_section_s']."' )");
		$query_id = mysqli_query($db,"SELECT id FROM file_table WHERE `filename`='".$filename."'");
		$row_file = mysqli_fetch_assoc($query_id);
		$id_file = $row_file["id"];
		$full_filename = $_SERVER['DOCUMENT_ROOT']."/storage/files/".$id_file.".".$filetype;
		move_uploaded_file($tmp_filename, $full_filename);
		
		for($i=0;$i<count($text_add_autors);$i++){
			if($text_add_autors[$i] != ''){
				mysqli_query($db,"INSERT INTO `autors` (`name`,`who_add`) VALUES ('".ucfirst($text_add_autors[$i])."','".$_SESSION['slogin']."') ");
			}
		}
		for($i=0;$i<count($text_add_keywords);$i++){
			if($text_add_keywords[$i] != ''){
				mysqli_query($db,"INSERT INTO `keywords` (`title`,`who_add`) VALUES ('".$text_add_keywords[$i]."','".$_SESSION['slogin']."') ");
			}
		}
		header( 'Location: http://gurzhiy.info/umk/');
	}
	if($_SESSION['srools'] == 'admin'){
		$result_query = mysqli_query($db,"SELECT * FROM file_table ORDER BY date_load desc LIMIT 50"); // Список загруженных файлов для админа
	} else if($_SESSION['srools'] == 'user'){
		$result_query = mysqli_query($db,"SELECT * FROM file_table WHERE pulpit=".$_SESSION['skaf']." ORDER BY date_load desc LIMIT 50"); // Список загруженных файлов для юзера
	} else if($_SESSION['srools'] == ''){
		$result_query = mysqli_query($db,"SELECT * FROM file_table ORDER BY date_load desc LIMIT 50"); // Список загруженных файлов для неавторизованного
	}
	
	if(isset($_POST['top_10_load']) ){
		if($_SESSION['srools'] == 'admin'){
			$result_query = mysqli_query($db,"SELECT * FROM file_table ORDER BY download_number desc LIMIT 50"); // Список загруженных файлов для админа
		} else if($_SESSION['srools'] == 'user'){
			$result_query = mysqli_query($db,"SELECT * FROM file_table WHERE pulpit=".$_SESSION['skaf']." ORDER BY download_number desc LIMIT 50"); // Список загруженных файлов для юзера
		} else if($_SESSION['srools'] == ''){
			$result_query = mysqli_query($db,"SELECT * FROM file_table ORDER BY download_number desc LIMIT 50"); // Список загруженных файлов для неавторизованного
		}
		$sort_load = "button_active";
		$sort_date = "";
		$sort_section = "";
	}
	if(isset($_POST['top_10_date']) ){
		if($_SESSION['srools'] == 'admin'){
			$result_query = mysqli_query($db,"SELECT * FROM file_table ORDER BY date_load desc LIMIT 50"); // Список загруженных файлов для админа
		} else if($_SESSION['srools'] == 'user'){
			$result_query = mysqli_query($db,"SELECT * FROM file_table WHERE pulpit=".$_SESSION['skaf']." ORDER BY date_load desc LIMIT 50"); // Список загруженных файлов для юзера
		} else if($_SESSION['srools'] == ''){
			$result_query = mysqli_query($db,"SELECT * FROM file_table ORDER BY date_load desc LIMIT 50"); // Список загруженных файлов для неавторизованного
		}
		$sort_load = "";
		$sort_date = "button_active";
		$sort_section = "";
	}
	if(isset($_POST['top_10_section']) ){
		if($_SESSION['srools'] == 'admin'){
			$result_query = mysqli_query($db,"SELECT * FROM file_table ORDER BY section desc LIMIT 50"); // Список загруженных файлов для админа
		} else if($_SESSION['srools'] == 'user'){
			$result_query = mysqli_query($db,"SELECT * FROM file_table WHERE pulpit=".$_SESSION['skaf']." ORDER BY section desc LIMIT 50"); // Список загруженных файлов для юзера
		} else if($_SESSION['srools'] == ''){
			$result_query = mysqli_query($db,"SELECT * FROM file_table ORDER BY section desc LIMIT 50"); // Список загруженных файлов для неавторизованного
		}
		$sort_load = "";
		$sort_date = "";
		$sort_section = "button_active";
	}
	
	//Если нажата клавиша поиска
	if(isset($_POST["search_submit"])){
		$where_flag = false;
		$filter = true;
		/* Если текстовое поле не пустое */
		if($_POST["search_text"] != ""){
			$flag_search = 0;
			$query_text = "SELECT * FROM file_table WHERE (LOCATE('".$_POST['search_text']."',filename) != 0)";
			/* Проверяем ввод поля "Кафедра" */
			if($_POST["filter_area_kafedra"] != 0){
				$query_text.=" AND pulpit=".$_POST["filter_area_kafedra"];
			}
			/* Проверяем ввод поля "Факультет" */
			if($_POST["filter_area_facultet"] != 0){
				$query_text.=" AND facultet=".$_POST["filter_area_facultet"];
			}
			/* Проверяем ввод поля "Год" */
			if($_POST["filter_area_year"] != 0){
				$query_text.=" AND year=".$_POST["filter_area_year"];
			}
			/* Проверяем ввод поля "Раздел" */
			if($_POST["filter_area_razdel"] != 0){
				$query_text.=" AND section=".$_POST["filter_area_razdel"];
			}
			/* Проверяем ввод поля "Авторы" */
			if($_POST["filter_area_autors"] != 0){
				$query_text.=" AND (LOCATE('|".$_POST["filter_area_autors"].";',autors) != 0)";
			}
			/* Проверяем ввод поля "Ключевые слова" */
			if($_POST["filter_area_keywords"] != 0){
				$query_text.=" AND (LOCATE('|".$_POST["filter_area_keywords"].";',keywords) != 0)";
			}
		} else {
			$flag_search = 1;
			$result_title = "Результаты поиска";
			$query_text = "SELECT * FROM file_table";
			if($_POST["filter_area_kafedra"] != 0){
				$query_text.=" WHERE pulpit=".$_POST["filter_area_kafedra"];
				$where_flag = true;
			}
			if($_POST["filter_area_facultet"] != 0 && $where_flag){
				$query_text.=" AND facultet=".$_POST["filter_area_facultet"];
			}
			if($_POST["filter_area_facultet"] != 0 && !$where_flag){
				$query_text.=" WHERE facultet=".$_POST["filter_area_facultet"];
				$where_flag = true;
			}
			if($_POST["filter_area_job"] != 0){
				$query_text.=" AND speciality=".$_POST["filter_area_job"];
			}
			if($_POST["filter_area_profile"] != 0){
				$query_text.=" AND profile=".$_POST["filter_area_profile"];
			}
			if($_POST["filter_area_category"] != 0){
				$query_text.=" AND job_category=".$_POST["filter_area_category"];
			}
			/* Проверяем ввод поля "Год", при условии, что предыдущее(-ие) поле(-я) введено(-ы) */
			if($_POST["filter_area_year"] != 0 && $where_flag){
				$query_text.=" AND year=".$_POST["filter_area_year"];
			}
			/* Проверяем ввод поля "Год", при условии, что другого поля не введено */
			if($_POST["filter_area_year"] != 0 && !$where_flag){
				$query_text.=" WHERE year=".$_POST["filter_area_year"];
				$where_flag = true;
			}
			/* Проверяем ввод поля "Раздел", при условии, что предыдущее(-ие) поле(-я) введено(-ы) */
			if($_POST["filter_area_razdel"] != 0 && $where_flag){
				$query_text.=" AND section=".$_POST["filter_area_razdel"];
			}
			/* Проверяем ввод поля "Раздел", при условии, что другого поля не введено */
			if($_POST["filter_area_razdel"] != 0 && !$where_flag){
				$query_text.=" WHERE section=".$_POST["filter_area_razdel"];
				$where_flag = true;
			}
			/* Проверяем ввод поля "Авторы", при условии, что предыдущее(-ие) поле(-я) введено(-ы) */
			if($_POST["filter_area_autors"] != 0 && $where_flag){
				$query_text.=" AND (LOCATE('|".$_POST["filter_area_autors"].";',autors) != 0)";
			}
			/* Проверяем ввод поля "Авторы", при условии, что другого поля не введено */
			if($_POST["filter_area_autors"] != 0 && !$where_flag){
				$query_text.=" WHERE (LOCATE('|".$_POST["filter_area_autors"].";',autors) != 0)";
				$where_flag = true;
			}
			/* Проверяем ввод поля "Ключевые слова", при условии, что предыдущее(-ие) поле(-я) введено(-ы) */
			if($_POST["filter_area_keywords"] != 0 && $where_flag){
				$query_text.=" AND (LOCATE('|".$_POST["filter_area_keywords"].";',keywords) != 0)";
			}
			/* Проверяем ввод поля "Ключевые слова", при условии, что другого поля не введено */
			if($_POST["filter_area_keywords"] != 0 && !$where_flag){
				$query_text.=" WHERE (LOCATE('|".$_POST["filter_area_keywords"].";',keywords) != 0)";
				$where_flag = true;
			}
		}
		$query_text.=" ORDER BY id desc";
		$result_query = mysqli_query($db,$query_text);
	}
	
	//Если нажата кнопка авторизации "Выход" 
	if(isset($_POST["out"])){
		$autorization = false;
	}
	
	$this_year = date("Y");
	//Список запросов к базе:
	$query_autors = mysqli_query($db,"SELECT * FROM autors ORDER BY id");		// Авторы
	$query_keywords = mysqli_query($db,"SELECT * FROM keywords ORDER BY id"); // Ключевые слова
	$query_pulpit = mysqli_query($db,"SELECT * FROM pulpit WHERE type=2");   	// Список кафедр
	$query_spec = mysqli_query($db,"SELECT * FROM speciality");   				// Список специальностей
	$query_profile = mysqli_query($db,"SELECT * FROM profile");   				// Перечень профильной подготовки
	$query_facultet = mysqli_query($db,"SELECT * FROM facultet"); 				// Список факультетов
	$query_job = mysqli_query($db,"SELECT * FROM job_category");  				// Список категорий работы
	$query_section = mysqli_query($db,"SELECT * FROM section ORDER BY name");  	// Группы, секции
	$query_file_info = mysqli_query($db,"SELECT * FROM file_table");				// Информация о загруженных файлах
	$query_log = mysqli_query($db,"SELECT * FROM logs WHERE for_proga=0 ORDER BY date_event desc");// Логи
?>
<!-- Далее внешний вид страницы, с подключенными модулями -->
<!DOCTYPE html>
<html>
	<head>
	<?php
		include_once("design/head.php"); 									// Подключаем содержимое тега head
	?>
	<script src="js/flowplayer.js"></script>
	<script src="js/for_player.js"></script>
	<link rel="stylesheet" href="skin/functional.css">
	</head>
	
	<body lang="ru">
	<?php //Подключаем модули:
		include_once("design/body_absolute_element.php"); 					// ..абсолютные элементы страницы
		include_once("design/body_header.php");           					// ..тег header и его содержимое (черная строка вверху экрана) 
		include_once("design/body_section_search.php");   					// ..тег section - поиск файлов
		include_once("design/body_section_add_file.php"); 					// ..тег section - загрузка файлов
		include_once("design/body_section_stat.php");     					// ..тег section - статистика
		include_once("design/body_section_log.php");     						// ..тег section - логгирование
		include_once("design/body_footer.php");           					// ..тег footer - подвал сайта
	?>
	</body>
</html>
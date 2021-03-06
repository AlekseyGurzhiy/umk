<?php
	header("Content-Type: text/html; charset=utf-8");
	$db = mysqli_connect("beta.mtw.ru","pianogd1","Zsdcawedq23","db?pianogd1");
	mysqli_query($db,'SET names "utf8"');
	
	//Запрос для поиска фамилии, имени и отчества пользователя
	$query_name = mysqli_query($db,"SELECT * FROM users WHERE login='".$_POST['name_login']."'");
	$row_name = mysqli_fetch_assoc($query_name);
	$full_name = $row_name["surname"]." ".$row_name["name"]." ".$row_name["fathername"]; //Сформировали фамилию, имя и отчество
	
	$autors_mass_ids = explode(";",$_POST['name_autors']);
	$i = 0;
	$autors_name = array();
	//Запрос, вытягивающий фамилии авторов по их id
	while($autors_mass_ids[$i]){
		$autors_mass_ids[$i] = explode("|",$autors_mass_ids[$i]);
		$query_autors = mysqli_query($db,"SELECT * FROM autors WHERE id='".$autors_mass_ids[$i][1]."'");
		$row_autors = mysqli_fetch_assoc($query_autors);
		$autors_name[$i] = $row_autors["name"];
		$i++;
	}
	$autors_string = implode(", ",$autors_name); //Сформировали строку авторов
	
	$keywords_mass_id = explode(";",$_POST['name_keywords']);
	$i = 0;
	$keywords_name = array();
	while($keywords_mass_id[$i]){
		$keywords_mass_id[$i] = explode("|",$keywords_mass_id[$i]);
		$query_keywords = mysqli_query($db,"SELECT * FROM keywords WHERE id='".$keywords_mass_id[$i][1]."'");
		$row_keywords = mysqli_fetch_assoc($query_keywords);
		$keywords_name[$i] = $row_keywords["title"];
		$i++;
	}
	$keywords_string = implode(", ",$keywords_name); //Сформировали строку ключевых слов
	
	$query_pulpit = mysqli_query($db,"SELECT * FROM pulpit WHERE id='".$_POST['name_pulpit']."'");
	$row_pulpit = mysqli_fetch_assoc($query_pulpit);
	$kafedra = $row_pulpit["name"]; //Сформировали наименование кафедры для вывода на экран
	
	$query_facultet = mysqli_query($db,"SELECT * FROM facultet WHERE id='".$_POST['name_facultet']."'");
	$row_facultet = mysqli_fetch_assoc($query_facultet);
	$facultet = $row_facultet["name"]; //Сформировали наименование факультета для вывода на экран
	
	$query_speciality = mysqli_query($db,"SELECT * FROM speciality WHERE id='".$_POST['name_speciality']."'");
	$row_speciality = mysqli_fetch_assoc($query_speciality);
	$speciality = $row_speciality["name_spec"]; //Сформировали наименование специальности для вывода на экран
	
	$query_profile = mysqli_query($db,"SELECT * FROM profile WHERE id='".$_POST['name_profile']."'");
	$row_profile = mysqli_fetch_assoc($query_profile);
	$profile = $row_profile["name"]; //Сформировали наименование профиля для вывода на экран
	
	$query_job = mysqli_query($db,"SELECT * FROM job_category WHERE id='".$_POST['name_job']."'");
	$row_job = mysqli_fetch_assoc($query_job);
	$job = $row_job["name"]; //Сформировали наименование профиля для вывода на экран
	
	$query_section = mysqli_query($db,"SELECT * FROM section WHERE id='".$_POST['name_section']."'");
	$row_section = mysqli_fetch_assoc($query_section);
	$section = $row_section["name"]; //Сформировали наименование профиля для вывода на экран

	echo json_encode(array($full_name,$autors_string,$keywords_string,$kafedra,$facultet,$speciality,$profile,$job,$section));
?>
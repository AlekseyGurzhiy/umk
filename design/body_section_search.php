<section class="section_search">
<!-- Клавиша "Новый поиск" -->	
<?php if($filter){ ?>
	<div class="load_file"><a href="http://gurzhiy.info/umk/">Новый поиск</a></div>
<?php } ?>

	<h1 class="UMK_h1">Электронный УМК : Поиск файлов</h1>
	<div class="search">
		<form id="searchFile" action="" method="post">
			<input type="text" name="search_text" class="search_text" placeholder="Введите наименование искомого файла..." autocomplete="off">
			<input type="hidden" name="search_flag" class="search_flag" value="<?=$flag_search;?>">
			<input type="submit" name="search_submit" class="search_submit <?= $filter?'search_button':'' ?>" value="Найти">
			<div class="search_filter">Фильтр</div>
	</div>
	<div class="filter_area">
	<table class="filter_area_table">
		<tr class="filter_area_record">
			<td class="filter_area_title"> Кафедра </td>
			<td class="filter_area_result">
				<select class="filter_area_kafedra" name="filter_area_kafedra">
					<option value="0"> Любая кафедра </option>
					<?php mysqli_data_seek($query_pulpit, 0); ?>
					<?php while($row_kaf_filter = mysqli_fetch_assoc($query_pulpit)){ ?>
					<option value="<?php echo $row_kaf_filter["id"];?>"><?php echo $row_kaf_filter["name"];?></option>	
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr class="filter_area_record">
			<td class="filter_area_title"> Факультет </td>
			<td class="filter_area_result">
				<select class="filter_area_facultet" name="filter_area_facultet">
					<option value="0"> Любой факультет </option>
					<?php mysqli_data_seek($query_facultet, 0); ?>
					<?php while($row_facultet_filter = mysqli_fetch_assoc($query_facultet)){ ?>
					<option value="<?php echo $row_facultet_filter["id"];?>"><?php echo $row_facultet_filter["name"];?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr class="filter_area_record search_job">
			<td class="filter_area_title"> Специальность / Направление подготовки </td>
			<td class="filter_area_result">
				<select class="filter_area_job" name="filter_area_job">
					<option value="0"> Любое направление </option>
					<?php mysqli_data_seek($query_spec, 0); ?>
					<?php while($row_spec = mysqli_fetch_assoc($query_spec)){ ?>
					<option class="fac-<?php echo $row_spec["id_facultet"]?>" value="<?php echo $row_spec["id"];?>"><?php echo $row_spec["name_spec"];?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr class="filter_area_record search_profile">
			<td class="filter_area_title"> Специализация / Профиль подготовки </td>
			<td class="filter_area_result">
				<select class="filter_area_profile" name="filter_area_profile">
					<option value="0"> Любой профиль </option>
					<?php mysqli_data_seek($query_profile, 0); ?>
					<?php while($row_profile = mysqli_fetch_assoc($query_profile)){ ?>
					<option class="fac-<?php echo $row_profile["id_facultet"]?>" value="<?php echo $row_profile["id"]?>"><?php echo $row_profile["name"]?> </option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr class="filter_area_record search_category">
			<td class="filter_area_title"> Должностная категория </td>
			<td class="filter_area_result">
				<select class="filter_area_category" name="filter_area_category">
					<option value="0"> Любая должность </option>
					<?php mysqli_data_seek($query_job, 0); ?>
					<?php while($row_job = mysqli_fetch_assoc($query_job)){ ?>
					<option class="fac-<?php echo $row_job["id_kafedra"]?>" value="<?php echo $row_job["id"]?>"> <?php echo $row_job["name"]?> </option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr class="filter_area_record">
			<td class="filter_area_title"> Год </td>
			<td class="filter_area_result">
				<select class="filter_area_year" name="filter_area_year">
					<option value="0"> Любой год </option>
					<?php for($i=0;$i<30;$i++){ ?>
					<option value="<?php echo $this_year-$i?>"> <?php echo $this_year-$i?> </option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr class="filter_area_record">
			<td class="filter_area_title"> Раздел </td>
			<td class="filter_area_result">
				<select class="filter_area_razdel" name="filter_area_razdel">
					<option value="0"> Любой раздел </option>
					<?php mysqli_data_seek($query_section, 0); ?>
					<?php while($row_section = mysqli_fetch_assoc($query_section)){ ?>
					<option value="<?php echo $row_section["id"]?>"> <?php echo $row_section["name"]?> </option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr class="filter_area_record">
			<td class="filter_area_title"> Автор </td>
			<td class="filter_area_result">
				<select class="filter_area_autors" name="filter_area_autors">
					<option value="0"> Все авторы </option>
					<?php mysqli_data_seek($query_autors, 0); ?>
					<?php while($row_autors = mysqli_fetch_assoc($query_autors)){ ?>
					<option value="<?php echo $row_autors["id"]?>"> <?php echo $row_autors["name"]?> </option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr class="filter_area_record">
			<td class="filter_area_title"> Ключевое слово </td>
			<td class="filter_area_result">
				<select class="filter_area_keywords" name="filter_area_keywords">
					<option value="0"> Все слова </option>
					<?php mysqli_data_seek($query_keywords, 0); ?>
					<?php while($row_keywords = mysqli_fetch_assoc($query_keywords)){ ?>
					<option value="<?php echo $row_keywords["id"]?>"> <?php echo $row_keywords["title"]?> </option>
					<?php } ?>
				</select>
			</td>
		</tr>
		</form>
	</table>
	</div>
	<div class="search_result">
		<form action="" method="post">
			Сортировка: 
			<input type="submit" name="top_10_section" class="search_result-button <?=$sort_section?>" value="По разделам">
			<input type="submit" name="top_10_load" class="search_result-button <?=$sort_load?>" value="По популярности">
			<input type="submit" name="top_10_date" class="search_result-button <?=$sort_date?>" value="По дате">
		</form>
	</div>
	<div class="content">
		<table class="table_result">

<?php	while($row_result = mysqli_fetch_assoc($result_query)){ 
		$number_result++;
		if($row_result["filesize"] < 1024){
			$filesize = floor($row_result["filesize"]) ;
			$str = "б";
		} else if($row_result["filesize"]>1024 && $row_result["filesize"]<1024000){
			$filesize = round($row_result["filesize"]/1024,2);
			$str = "Кб";
		} else if($row_result["filesize"]>1024000){
			$filesize = round($row_result["filesize"]/1024/1024,2);
			$str = "Мб";
		}
		$url = "files/".$row_result["id"].".".$row_result["filetype"];
		switch($row_result["filetype"]){
			case "docx" : $class_type="word"; break;
			case "doc"  : $class_type="word"; break;
			case "DOC"  : $class_type="word"; break;
			case "mp4"  : $class_type="video"; break;
			case "avi"  : $class_type="video"; break;
			case "AVI"  : $class_type="video"; break;
			case "MP4"  : $class_type="video"; break;
			case "wmv"  : $class_type="video"; break;
			case "WMV"  : $class_type="video"; break;
			case "mpg"  : $class_type="video"; break;
			case "flv"  : $class_type="video"; break;
			case "FLV"  : $class_type="video"; break;
			case "pps"  : $class_type="pp"; break;
			case "PPS"  : $class_type="pp"; break;
			case "rtf"  : $class_type="word"; break;
			case "xls"  : $class_type="excel"; break;
			case "jpeg" : $class_type="jpg"; break;
			case "jpg"  : $class_type="jpg"; break;
			case "JPG"  : $class_type="jpg"; break;
			case "png"  : $class_type="png"; break;
			case "PNG"  : $class_type="png"; break;
			case "pdf"  : $class_type="pdf"; break;
			case "PDF"  : $class_type="pdf"; break;
			case "rar"  : $class_type="rar"; break;
			case "RAR"  : $class_type="rar"; break;
			default: $class_type="default";
		}
?>
		<tr>
			<td width="5%"> <?php echo $number_result;?> </td>
			<td class="<?php echo $class_type;?> click-info" id="rec-<?php echo $row_result["id"];?>"><?php echo $row_result["filename"];?></td>
			<td width="19%" class="download_number"> Количество <br> скачиваний: <span class="download_number_<?php echo $row_result["id"];?>"><?php echo $row_result["download_number"];?></span></td> 
		</tr>
		<tr class="info" id="info-<?php echo $row_result["id"]?>">
			<td colspan="2" class="info_colspan2"> 
				<table class="info_one_table">
					<tr class="info_one_record">
						<td class="info_file_title"> Полное имя файла: </td>
						<td class="info_file_result"> <?php echo $row_result["filename"].".".$row_result["filetype"]?> </td>
					</tr>
					<tr class="info_one_record">
						<td class="info_file_title"> Размер файла: </td>
						<td class="info_file_result"> <?php echo $filesize." ".$str;?> </td>
					</tr>
					<tr class="info_one_record">
						<td class="info_file_title"> Дата загрузки на сервер: </td>
						<td class="info_file_result"> <?php echo $row_result["date_load"]?> </td>
					</tr>
					<?php if( $_SESSION['slogin']!='' ){ ?>
					<tr class="info_one_record">
						<td class="info_file_title"> Кто загрузил файл: </td>
						<td class="info_file_result"> <span class="user_login_class" title="<?php echo $row_result["user"]?>"></span> </td>
					</tr>
					<?php } ?>
					<tr class="info_one_record">
						<td class="info_file_title"> Авторы файла: </td>
						<td class="info_file_result"> <span class="user_autors_class" title="<?php echo $row_result["autors"]?>"></span> </td>
					</tr>
					<tr class="info_one_record">
						<td class="info_file_title"> Ключевые слова: </td>
						<td class="info_file_result"> <span class="user_keywords_class" title="<?php echo $row_result["keywords"]?>"></span> </td>
					</tr>
					<tr class="info_one_record">
						<td class="info_file_title"> Кафедра: </td>
						<td class="info_file_result"> <span class="user_kafedra_class kaf-<?php echo $row_result['id']?>" title="<?php echo $row_result["pulpit"]?>"></span> </td>
					</tr>
					<tr class="info_one_record">
						<td class="info_file_title"> Факультет: </td>
						<td class="info_file_result"> <span class="user_facultet_class fak-<?php echo $row_result['id']?>" title="<?php echo $row_result["facultet"]?>"></span> </td>
					</tr class="info_one_record">
					<tr class="info_one_record">
						<td class="info_file_title"> Специальность: </td>
						<td class="info_file_result"> <span class="user_speciality_class spec-<?php echo $row_result['id']?>" title="<?php echo $row_result["speciality"]?>"></span> </td>
					</tr class="info_one_record">
					<tr class="info_one_record">
						<td class="info_file_title"> Профиль: </td>
						<td class="info_file_result"> <div class="user_profile_class prof-<?php echo $row_result['id']?>" title="<?php echo $row_result["profile"]?>"></div> </td>
					</tr>
					<tr class="info_one_record">
						<td class="info_file_title"> Рабочая категория: </td>
						<td class="info_file_result"> <span class="user_job_class job-<?php echo $row_result['id']?>" title="<?php echo $row_result["job_category"]?>"></span> </td>
					</tr>
					<tr class="info_one_record">
						<td class="info_file_title"> Год издания: </td>
						<td class="info_file_result year-<?php echo $row_result['id']?>"> <?php echo $row_result["year"]?> </td>
					</tr>
					<tr class="info_one_record">
						<td class="info_file_title"> Раздел: </td>
						<td class="info_file_result"> <span class="user_section_class razdel-<?php echo $row_result['id']?>" title="<?php echo $row_result["section"]?>"></span></td>
					</tr>
				</table>
				</td>
			<form method="post" action="" id="form_delete_file" name="form_delete_file">
			<td>
				<?php if( $row_result["filetype"] == "mp4" || $row_result["filetype"] == "MP4"){ ?>
					<span class="view_class video_class" title="<?=$row_result["id"];?>"> Просмотр </span>
				<?php } ?>
				<?php if( $class_type == "jpg" || $class_type == "png"){ ?>
					<a href="<?=$url;?>" class="view_class jpg_class"> Просмотр </a>
				<?php } ?>
				<?php if( $class_type == "pdf" ){ ?>
					<a href="<?php echo $url;?>" data-fancybox-type="iframe" class="view_class pdf_class"> Просмотр </a>
				<?php } ?>
				<input type="submit" class="download_class" title="<?php echo $row_result["id"];?>" name="download_file" value="Скачать">
				<?php if( ($_SESSION['srools'] == 'user' && $_SESSION['skaf'] == $row_result["pulpit"]) || $_SESSION['srools'] == 'admin' ){ ?>
					<input type="button" class="edit_class" title="<?php echo $row_result["id"];?>" name="edit_class" value="Редактор">
					<div class="delete_class"> Удалить </div>
				<?php } ?>

					<div class="player_canvas player_<?=$row_result["id"]?>">
						<div class="myplayer">
							<video>
								<source src='files/<?php echo $row_result["id"]?>.mp4' type="video/mp4; codecs=&quot;theora, vorbis&quot;" />
								<source src='files/<?php echo $row_result["id"]?>.mp4' type="video/mp4; codecs=&quot;avc1.42E01E, mp4a.40.2, vorbis&quot;" />
							</video>
						</div>
					</div>

					<div class="delete_question">
						<div class="delete_question-text">Вы действительно хотите удалить этот файл?</div>
						<div class="delete_question-button delete_question-no"> Нет </div>
						<input type="submit" class="delete_question-button delete_question-yes" name="delete_yes" value="Да">
					</div>

				<input type="hidden" name="download_fileid" value="<?php echo $row_result["id"];?>">
				<input type="hidden" class="download_filename_<?php echo $row_result["id"];?>" name="download_filename" value="<?php echo $url;?>">
				<input type="hidden" class="download_newname_<?php echo $row_result["id"];?>" name="download_newname" value="<?php echo $row_result["filename"].".".$row_result["filetype"]?>">
			</td>
			</form>
		</tr>

<?php		}	?>
		</table>
	</div>
</section>